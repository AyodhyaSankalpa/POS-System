<?php
/**
 * AI Report API Endpoint
 * Queries the POS database and sends data to Claude API for report generation
 */

require '../config/dbcon.php';

header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$input       = json_decode(file_get_contents('php://input'), true);
$report_type = $input['report_type'] ?? 'sales_summary';
$date_from   = $input['date_from']   ?? date('Y-m-01');
$date_to     = $input['date_to']     ?? date('Y-m-d');

// ─── 1. Gather stats from DB ─────────────────────────────────────────────────

// Total revenue & orders in date range
$sql = "SELECT 
            COUNT(*) AS total_orders,
            SUM(total_amount) AS total_revenue,
            COUNT(DISTINCT customer_id) AS unique_customers
        FROM orders
        WHERE order_date BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $date_from, $date_to);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

// Items sold in date range
$sql2 = "SELECT SUM(oi.quantity) AS total_items
          FROM order_items oi
          JOIN orders o ON o.id = oi.order_id
          WHERE o.order_date BETWEEN ? AND ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('ss', $date_from, $date_to);
$stmt2->execute();
$itemStats = $stmt2->get_result()->fetch_assoc();
$summary['total_items'] = $itemStats['total_items'] ?? 0;

// ─── 2. Collect detailed data for AI ─────────────────────────────────────────

// Orders per day
$sql3 = "SELECT order_date, COUNT(*) AS orders, SUM(total_amount) AS revenue
          FROM orders
          WHERE order_date BETWEEN ? AND ?
          GROUP BY order_date ORDER BY order_date";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('ss', $date_from, $date_to);
$stmt3->execute();
$dailySales = $stmt3->get_result()->fetch_all(MYSQLI_ASSOC);

// Payment mode breakdown
$sql4 = "SELECT payment_mode, COUNT(*) AS count, SUM(total_amount) AS total
          FROM orders
          WHERE order_date BETWEEN ? AND ?
          GROUP BY payment_mode";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('ss', $date_from, $date_to);
$stmt4->execute();
$paymentBreakdown = $stmt4->get_result()->fetch_all(MYSQLI_ASSOC);

// Top products
$sql5 = "SELECT p.name, SUM(oi.quantity) AS qty_sold, SUM(oi.price * oi.quantity) AS revenue
          FROM order_items oi
          JOIN orders o ON o.id = oi.order_id
          JOIN products p ON p.id = oi.product_id
          WHERE o.order_date BETWEEN ? AND ?
          GROUP BY oi.product_id ORDER BY revenue DESC LIMIT 10";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('ss', $date_from, $date_to);
$stmt5->execute();
$topProducts = $stmt5->get_result()->fetch_all(MYSQLI_ASSOC);

// Customer spending
$sql6 = "SELECT c.name, COUNT(o.id) AS orders, SUM(o.total_amount) AS spent
          FROM orders o
          JOIN customers c ON c.id = o.customer_id
          WHERE o.order_date BETWEEN ? AND ?
          GROUP BY o.customer_id ORDER BY spent DESC LIMIT 10";
$stmt6 = $conn->prepare($sql6);
$stmt6->bind_param('ss', $date_from, $date_to);
$stmt6->execute();
$topCustomers = $stmt6->get_result()->fetch_all(MYSQLI_ASSOC);

// Product stock levels
$sql7 = "SELECT name, quantity, price FROM products WHERE status = 0 ORDER BY quantity ASC";
$stockData = $conn->query($sql7)->fetch_all(MYSQLI_ASSOC);

// ─── 3. Build prompt ─────────────────────────────────────────────────────────

$reportLabels = [
    'sales_summary'    => 'Sales Summary Report',
    'top_products'     => 'Top Products Report',
    'customer_insights'=> 'Customer Insights Report',
    'payment_analysis' => 'Payment Mode Analysis Report',
    'full_report'      => 'Full Business Report',
];
$reportLabel = $reportLabels[$report_type] ?? 'Business Report';

$dataJson = json_encode([
    'report_type'       => $report_type,
    'period'            => ['from' => $date_from, 'to' => $date_to],
    'summary'           => $summary,
    'daily_sales'       => $dailySales,
    'payment_breakdown' => $paymentBreakdown,
    'top_products'      => $topProducts,
    'top_customers'     => $topCustomers,
    'current_stock'     => $stockData,
], JSON_PRETTY_PRINT);

$focusInstructions = [
    'sales_summary'     => 'Focus on overall revenue trends, daily performance, and key totals.',
    'top_products'      => 'Focus deeply on product performance, best-sellers, revenue per product, and stock warnings.',
    'customer_insights' => 'Focus on customer behavior, top spenders, loyalty patterns, and customer recommendations.',
    'payment_analysis'  => 'Focus on payment mode usage, preferences, and any patterns or recommendations.',
    'full_report'       => 'Provide a comprehensive analysis covering all aspects: sales, products, customers, payments, and inventory.',
];
$focus = $focusInstructions[$report_type] ?? '';

$prompt = <<<PROMPT
You are an expert business analyst for a Point of Sale (POS) system. Analyze the following sales data and generate a professional **{$reportLabel}** for the period {$date_from} to {$date_to}.

{$focus}

Here is the data (in JSON format):
{$dataJson}

Please generate a well-structured report using markdown formatting with:
- Clear ## section headings
- **Bold** for key numbers and highlights
- Bullet points for lists
- Specific numbers and percentages where relevant
- Actionable insights and recommendations at the end
- Keep the tone professional but easy to understand

Do not include any preamble or explanation — start directly with the report content.
PROMPT;

// ─── 4. Call Gemini API ───────────────────────────────────────────────────────

$GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY'; // Replace with your actual key from aistudio.google.com
$GEMINI_MODEL   = 'gemini-flash-latest';
$GEMINI_URL     = "https://generativelanguage.googleapis.com/v1beta/models/{$GEMINI_MODEL}:generateContent?key={$GEMINI_API_KEY}";

$apiPayload = json_encode([
    'contents' => [
        [
            'parts' => [
                ['text' => $prompt]
            ]
        ]
    ],
    'generationConfig' => [
        'maxOutputTokens' => 1500,
        'temperature'     => 0.7,
    ]
]);

$ch = curl_init($GEMINI_URL);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $apiPayload,
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
    ],
    CURLOPT_TIMEOUT        => 60,
]);

$response  = curl_exec($ch);
$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo json_encode(['error' => 'API connection error: ' . $curlError]);
    exit;
}

$apiData = json_decode($response, true);

if ($httpCode !== 200 || empty($apiData['candidates'][0]['content']['parts'][0]['text'])) {
    $errMsg = $apiData['error']['message'] ?? 'Unknown Gemini API error';
    echo json_encode(['error' => 'AI API error: ' . $errMsg]);
    exit;
}

$reportText = $apiData['candidates'][0]['content']['parts'][0]['text'];

// ─── 5. Return result ─────────────────────────────────────────────────────────

echo json_encode([
    'report' => $reportText,
    'stats'  => $summary,
]);