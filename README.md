# Hospital Appointment Management System

A premium, modern hospital management system built with HTML, CSS, PHP, and SQL Server.

## 🚀 Features
- **Modern UI/UX**: Glassmorphism design, dark mode, and responsive layout.
- **Patient Portal**: Registration, login, and dashboard key features.
- **Appointment Booking**: View doctors and book appointments easily.
- **Management**: View appointment status and doctor schedules.

## 🛠️ Setup Instructions

### 1. Prerequisites
- **PHP**: Make sure PHP 7.4+ is installed.
- **SQL Server**: You need a running instance of SQL Server (Express or Developer).
- **Web Server**: Apache or built-in PHP server.
- **Drivers**: Ensure the `sqlsrv` and `pdo_sqlsrv` drivers are enabled in your `php.ini`.

### 2. Database Setup
1. Open **SQL Server Management Studio (SSMS)**.
2. Open the file `database/setup.sql`.
3. Execute the script to create the `HospitalDB` database and tables.

### 3. Connection Configuration
1. Open `includes/db_connect.php`.
2. Update the `$serverName` variable if your SQL Server instance has a specific name (e.g., `DESKTOP-XYZ\SQLEXPRESS`).
3. If using SQL Authentication, update `$username` and `$password`.

### 4. Running the Application
Open a terminal in this folder and run:
```bash
php -S localhost:8000
```
Then open [http://localhost:8000](http://localhost:8000) in your browser.

## 📁 Project Structure
- `assets/` - CSS, JS, and Image resources.
- `database/` - SQL scripts.
- `includes/` - Reusable PHP components (Header, Footer, DB Connection).
- `*.php` - Main application pages.
