<?php include ('includes/header.php'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><i class="fas fa-robot me-2"></i>AI Sales Report</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">AI Report</li>
    </ol>

    <!-- Filter Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-filter me-1"></i> Report Options
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Report Type</label>
                    <select id="reportType" class="form-select">
                        <option value="sales_summary">Sales Summary</option>
                        <option value="top_products">Top Products</option>
                        <option value="customer_insights">Customer Insights</option>
                        <option value="payment_analysis">Payment Mode Analysis</option>
                        <option value="full_report">Full Business Report</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" id="dateFrom" class="form-control" value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" id="dateTo" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3">
                    <button id="generateBtn" class="btn btn-primary w-100">
                        <i class="fas fa-magic me-1"></i> Generate AI Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row (populated dynamically) -->
    <div id="statsRow" class="row mb-4" style="display:none!important"></div>

    <!-- AI Report Output -->
    <div class="card shadow-sm mb-4" id="reportCard" style="display:none">
        <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
            <span><i class="fas fa-brain me-2"></i>AI Generated Report</span>
            <!-- <button class="btn btn-sm btn-outline-light" id="printBtn">
                <i class="fas fa-print me-1"></i>Print
            </button> -->
        </div>
        <div class="card-body" id="reportOutput">
            <!-- AI content goes here -->
        </div>
    </div>

    <!-- Loading -->
    <div id="loadingBlock" style="display:none" class="text-center py-5">
        <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;" role="status"></div>
        <p class="text-muted fs-5" id="loadingMsg">Analyzing your sales data...</p>
    </div>
</div>

<style>
    #reportOutput h2 { font-size: 1.3rem; color: #2c3e50; margin-top: 1.5rem; border-bottom: 2px solid #e9ecef; padding-bottom: 6px; }
    #reportOutput h3 { font-size: 1.1rem; color: #34495e; margin-top: 1rem; }
    #reportOutput ul { padding-left: 1.3rem; }
    #reportOutput li { margin-bottom: 4px; }
    #reportOutput strong { color: #1a252f; }
    #reportOutput .ai-badge { display:inline-block; background:#6c3483; color:white; font-size:0.7rem; padding:2px 8px; border-radius:20px; margin-bottom:12px; }
    .stat-card { border-left: 4px solid; }
    .stat-card.green { border-color: #27ae60; }
    .stat-card.blue  { border-color: #2980b9; }
    .stat-card.orange{ border-color: #e67e22; }
    .stat-card.purple{ border-color: #8e44ad; }
</style>

<script>
document.getElementById('generateBtn').addEventListener('click', generateReport);
// document.getElementById('printBtn').addEventListener('click', () => window.print());

const loadingMsgs = [
    "Analyzing your sales data...",
    "Crunching the numbers...",
    "Generating AI insights...",
    "Almost ready..."
];

async function generateReport() {
    const reportType = document.getElementById('reportType').value;
    const dateFrom   = document.getElementById('dateFrom').value;
    const dateTo     = document.getElementById('dateTo').value;

    // Show loading
    document.getElementById('reportCard').style.display = 'none';
    document.getElementById('statsRow').style.cssText = 'display:none!important';
    document.getElementById('loadingBlock').style.display = 'block';
    let msgIdx = 0;
    const msgEl = document.getElementById('loadingMsg');
    const ticker = setInterval(() => { msgEl.textContent = loadingMsgs[msgIdx++ % loadingMsgs.length]; }, 1800);

    try {
        const res = await fetch('ai-report-api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ report_type: reportType, date_from: dateFrom, date_to: dateTo })
        });
        const data = await res.json();

        clearInterval(ticker);
        document.getElementById('loadingBlock').style.display = 'none';

        if (data.error) {
            alertify.error(data.error);
            return;
        }

        // Show stats
        if (data.stats) {
            const s = data.stats;
            document.getElementById('statsRow').style.cssText = '';
            document.getElementById('statsRow').innerHTML = `
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card green p-3">
                        <div class="text-xs text-muted text-uppercase mb-1">Total Revenue</div>
                        <div class="h4 mb-0 fw-bold">LKR ${Number(s.total_revenue||0).toLocaleString()}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card blue p-3">
                        <div class="text-xs text-muted text-uppercase mb-1">Total Orders</div>
                        <div class="h4 mb-0 fw-bold">${s.total_orders||0}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card orange p-3">
                        <div class="text-xs text-muted text-uppercase mb-1">Items Sold</div>
                        <div class="h4 mb-0 fw-bold">${s.total_items||0}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card purple p-3">
                        <div class="text-xs text-muted text-uppercase mb-1">Unique Customers</div>
                        <div class="h4 mb-0 fw-bold">${s.unique_customers||0}</div>
                    </div>
                </div>
            `;
        }

        // Show AI report
        document.getElementById('reportCard').style.display = 'block';
        document.getElementById('reportOutput').innerHTML =
            `<span class="ai-badge"><i class="fas fa-robot me-1"></i>AI Generated</span>` +
            markdownToHtml(data.report);

    } catch(e) {
        clearInterval(ticker);
        document.getElementById('loadingBlock').style.display = 'none';
        alertify.error('Failed to generate report. Please try again.');
    }
}

function markdownToHtml(md) {
    return md
        .replace(/^## (.+)$/gm, '<h2>$1</h2>')
        .replace(/^### (.+)$/gm, '<h3>$1</h3>')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/^- (.+)$/gm, '<li>$1</li>')
        .replace(/(<li>.*<\/li>)/gs, '<ul>$1</ul>')
        .replace(/\n{2,}/g, '<br><br>')
        .replace(/\n/g, '<br>');
}
</script>

<?php include ('includes/footer.php'); ?>