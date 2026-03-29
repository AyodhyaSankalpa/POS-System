# 🛒 POS System

A web-based Point of Sale (POS) system built with PHP and MySQL, featuring an AI-powered report generation module using the Google Gemini API.

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Database](#database)
- [Installation](#installation)
- [Configuration](#configuration)
- [AI Report Module](#ai-report-module)
- [Screenshots](#screenshots)

---

## ✨ Features

- **Order Management** — Create and manage customer orders with tracking numbers and invoices
- **Product Management** — Add, edit, delete products with category support and image uploads
- **Category Management** — Organize products into categories
- **Customer Management** — Maintain a customer database with contact details
- **User Management** — Admin and standard user roles with ban support
- **Payment Modes** — Supports Cash, Card, and Online payments
- **History / Soft Delete** — Deleted records are archived in history tables
- **AI Report Generation** — Generate intelligent sales and business reports powered by Google Gemini AI
- **Dashboard** — Overview with charts and key stats

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.2 |
| Database | MySQL / MariaDB 10.4 |
| Frontend | HTML5, Bootstrap 5, jQuery |
| Charts | Chart.js |
| Tables | Simple DataTables |
| Alerts | AlertifyJS, SweetAlert |
| PDF Export | jsPDF + html2canvas |
| AI Engine | Google Gemini API (`gemini-2.0-flash`) |
| Server | Apache (XAMPP / WAMP recommended) |

---

## 📁 Project Structure

```
pos/
├── config/
│   ├── dbcon.php           # Database connection settings
│   └── function.php        # Global helper functions
├── admin/
│   ├── index.php           # Admin dashboard
│   ├── orders.php          # Order list
│   ├── order-create.php    # Create new order
│   ├── order-summary.php   # Order summary view
│   ├── products.php        # Product list
│   ├── product-create.php  # Add product
│   ├── product-edit.php    # Edit product
│   ├── categories.php      # Category list
│   ├── customers.php       # Customer list
│   ├── users.php           # User management
│   ├── ai-report.php       # AI Report page (UI)
│   ├── ai-report-api.php   # AI Report API endpoint
│   ├── includes/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── navbar.php
│   │   └── sidebar.php
│   └── assets/
├── assets/
│   └── uploads/products/   # Product image uploads
├── login.php
├── logout.php
└── index.php
```

---

## 🗄 Database

**Database name:** `pos_system`

| Table | Description |
|-------|-------------|
| `users` | Admin and staff accounts |
| `categories` | Product categories |
| `products` | Product catalogue |
| `customers` | Customer records |
| `orders` | Sales orders |
| `order_items` | Line items per order |
| `categories_history` | Deleted category archive |
| `products_history` | Deleted product archive |
| `customers_history` | Deleted customer archive |

---

## ⚙️ Installation

### Requirements

- PHP >= 8.0
- MySQL / MariaDB
- Apache (XAMPP or WAMP recommended)
- cURL extension enabled in PHP

### Steps

1. **Clone or copy** the project into your web server root:
   ```
   htdocs/pos/   (XAMPP)
   www/pos/      (WAMP)
   ```

2. **Import the database:**
   - Open phpMyAdmin
   - Create a new database named `pos_system`
   - Import `pos_system.sql`

3. **Configure the database connection** in `config/dbcon.php`:
   ```php
   define('HOST', 'localhost');
   define('USER', 'root');
   define('PASS', '');          // your MySQL password
   define('DB',   'pos_system');
   ```

4. **Set folder permissions** — ensure `assets/uploads/products/` is writable:
   ```bash
   chmod 755 assets/uploads/products/
   ```

5. **Visit** `http://localhost/pos` in your browser.

---

## 🔧 Configuration

### Database — `config/dbcon.php`

```php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB',   'pos_system');

date_default_timezone_set('Asia/Colombo'); // Change to your timezone
```

### AI Report — `admin/ai-report-api.php`

```php
$GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY'; // Add your key here
$GEMINI_MODEL   = 'gemini-2.0-flash';    // Model to use
```

Get a free API key at: [https://aistudio.google.com](https://aistudio.google.com)

---

## 🤖 AI Report Module

The AI Report module (`admin/ai-report.php`) queries live data from the database and sends it to the Google Gemini API to generate professional business reports.

### Report Types

| Report | Description |
|--------|-------------|
| Sales Summary | Revenue trends, daily performance, key totals |
| Top Products | Best-sellers, revenue per product, stock warnings |
| Customer Insights | Top spenders, loyalty patterns, recommendations |
| Payment Mode Analysis | Breakdown of cash / card / online usage |
| Full Business Report | Comprehensive analysis of all areas |

### How It Works

1. User selects report type and date range
2. `ai-report-api.php` queries the database for orders, products, customers, and stock data
3. Data is formatted and sent to the Gemini API with a structured prompt
4. The AI returns a markdown-formatted report
5. The report is rendered in the browser with a Print option

### Files

| File | Purpose |
|------|---------|
| `admin/ai-report.php` | Frontend UI — filters, stats cards, report display |
| `admin/ai-report-api.php` | Backend — DB queries + Gemini API call |

---

## 📌 Notes

- Product images are stored in `assets/uploads/products/`
- Deleted records are soft-archived in `*_history` tables rather than permanently removed
- The `status` field on products and categories: `0 = visible`, `1 = hidden`
- The `is_admin` field on users: `0 = staff`, `1 = admin`
- Timezone is set to `Asia/Colombo` by default — update in `config/dbcon.php` if needed

---

## 📄 License

This project is for educational and internal use.