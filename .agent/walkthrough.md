# 🛡️ Laravel Schema Sentinel Guide

**Laravel Schema Sentinel** is a database integrity tool designed to detect and resolve "Schema Drift"—the discrepancies between your migration files and your actual live database.

---

## 🚀 Quick Start (CLI)

The primary way to interact with Sentinel is through Artisan commands.

### 1. Environment Health Check
Before running drift analysis, verify that your environment is ready (requires PDO SQLite and an active DB connection).
```bash
php artisan schema:sentinel-doctor
```

### 2. Detect Schema Drift
Compare your current database state against your migration files. Sentinel simulates your entire migration history in a shadow SQLite database to find gaps.
```bash
php artisan schema:drift
```

### 3. Identify Untracked Changes (Strict Mode)
Find columns or tables in your database that exist but are **not** defined in any migration file.
```bash
php artisan schema:drift --strict
```

### 4. Interactive Fixer
Sentinel can generate a new migration file to bridge the gap. It will prompt you for each change (adding columns, changing types, etc.).
```bash
php artisan schema:drift --fix --interactive
```

---

## ⚙️ Configuration

The configuration file is located at `config/schema-sentinel.php`.

Key settings:
- **`ignore_tables`**: Skip tables from third-party packages or internal Laravel tables (e.g., `migrations`, `failed_jobs`).
- **`shadow_connection`**: Configure the temporary SQLite database used for simulation (defaults to `:memory:`).

---

## 🧩 Programmatic Usage

You can integrate Sentinel into your own controllers or Livewire components using the `Sentinel` facade.

### Check Drift in a Controller
```php
use Sentinel\SchemaSentinel\Facades\Sentinel;

public function check()
{
    $diff = Sentinel::check(strict: true);

    if ($diff->hasDifferences()) {
        return response()->json([
            'status' => 'drift_detected',
            'details' => $diff->toArray()
        ]);
    }

    return response()->json(['status' => 'in_sync']);
}
```

### Blade UI Notice
Add this to your admin dashboard to warn developers of unsynced changes:
```blade
@if(app()->environment('local') && \Sentinel\SchemaSentinel\Facades\Sentinel::check()->hasDifferences())
    <div class="alert alert-warning">
        <strong>🛡️ Sentinel Notice:</strong> Your database schema has drifted. 
        Run <code>php artisan schema:drift</code> to review.
    </div>
@endif
```

---

## ⚠️ Important Note
Sentinel requires your primary database connection to be active (even if just for reading the schema) because it compares the **Live Database** with a **Simulated Migration State**. If you get a "Connection Refused" error, ensure your MySQL/PostgreSQL server is running.
