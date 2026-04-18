# 🍕 Pizza Paradizo

A minimalistic PHP pizza ordering web application with Bootstrap 5, secure authentication with MFA, and optimized for performance.

---

## 🗂 Project Structure

```
pizza-php/
├── assets/
│   ├── css/
│   │   ├── variables.css      ← Design tokens (warm minimalistic palette)
│   │   ├── auth.css           ← Auth page styles (login, register, etc.)
│   │   ├── home.css           ← Home page (navbar, hero, menu, about)
│   │   └── app.css            ← Cart, checkout, order styles
│   └── images/                ← Static image assets
├── config/
│   ├── env.php                ← Environment variable loader
│   ├── database.php           ← MySQLi connection with error reporting
│   └── session.php            ← Secure session configuration
├── includes/
│   ├── header.php             ← Shared HTML <head> (app pages)
│   ├── auth_header.php        ← Shared HTML <head> (auth pages)
│   ├── navbar.php             ← Bootstrap navbar
│   ├── footer.php             ← Footer + JS includes
│   └── security.php           ← CSRF, rate limiting, sanitization
├── database/
│   └── loginsys_db.sql        ← Database schema with indexes
├── home.php                   ← Landing page with menu
├── cart.php                   ← Shopping cart + delivery form
├── checkout.php               ← Order review (POST)
├── checkout_process.php       ← Payment processing
├── order.php                  ← Order status
├── login.php                  ← Login form
├── login_process.php          ← Login handler (bcrypt + rate limit)
├── register.php               ← Registration form
├── register_process.php       ← Registration handler
├── mfa.php                    ← Two-factor authentication
├── mfa_process.php            ← MFA verification
├── recover.php                ← Password recovery
├── recover_process.php        ← Recovery handler
├── logout.php                 ← Session destroy
├── script.js                  ← Frontend JavaScript
├── .htaccess                  ← Security headers + caching
├── .env.example               ← Environment variable template
└── .gitignore
```

---

## 🚀 Setup

### Prerequisites
- **PHP 8.0+** — No XAMPP needed! *(Please ensure `extension=mysqli` and `extension=openssl` are enabled in your `php.ini`)*
- **MySQL / MariaDB** — Required for the database

<details>
<summary><b>🛠️ Click here for how to install PHP & MySQL on Windows completely from scratch</b></summary>
<br>

**1. Install PHP:**
1. Download the **VS16 x64 Thread Safe** `.zip` file from [windows.php.net](https://windows.php.net/download/).
2. Extract the folder and move it to `C:\php`.
3. Open `C:\php`, find `php.ini-development`, and rename it to `php.ini`.
4. Open your new `php.ini` in a text editor and **remove the semicolon (`;`)** from the beginning of these three lines to enable them:
   - `extension_dir = "ext"`
   - `extension=mysqli`
   - `extension=openssl`
5. Open your Windows **Environment Variables**, find Path, and add `C:\php`. 

**2. Install MySQL:**
1. Download [MySQL Installer for Windows](https://dev.mysql.com/downloads/installer/).
2. Choose a "Server Only" setup and set a **root password** you will remember.
3. Open Windows **Environment Variables**, find Path, and add `C:\Program Files\MySQL\MySQL Server 8.0\bin`.
</details>

### Installation

**For Windows Users (Automated):**
1. Simply double-click the **`setup.bat`** file in the project folder! It will automatically configure your `.env` file and securely import the SQL database for you.

**Manual Setup (Mac / Linux / Windows):**

1. **Clone the repository:**
   ```bash
   git clone https://github.com/<your-username>/pizza-php.git
   cd pizza-php
   ```

2. **Set up environment:**
   ```bash
   cp .env.example .env
   ```
   **Important:** Open your new `.env` file and fill in `DB_PASS` with your MySQL password. (Even if using PHP built-in server, `.env` is parsed automatically!)

3. **Import the database:**
   ```bash
   mysql -u root -p loginsys_db < database/loginsys_db.sql
   ```

4. **Run with PHP's built-in server:**
   ```bash
   php -S 0.0.0.0:8080
   ```

5. **Open in browser:**
   - **Locally:** `http://localhost:8080`
   - **Over Wi-fi:** `http://[YOUR_IP_ADDRESS]:8080` (e.g. `http://192.168.1.10:8080`)
   - **Over the Internet (Mobile/4G):** Download **Ngrok**, and run `ngrok http 8080` in a new terminal to get a secure public URL!

---

## 🔒 Security Features

| Feature | Implementation |
|---|---|
| Password Hashing | `password_hash()` with bcrypt (auto-upgrades legacy MD5) |
| CSRF Protection | Token-based with `hash_equals()` |
| Rate Limiting | Session-based (5 attempts / 15 min for login) |
| Secure Sessions | `httponly`, `secure`, `samesite=Strict`, strict mode |
| Data Encryption | AES-256-CBC with proper IV handling for card data |
| HMAC Integrity | `hash_hmac('sha256')` with env-based key |
| Security Headers | `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy` |
| Sensitive Data | Checkout uses POST (card data never in URLs) |
| Directory Protection | `.htaccess` blocks `config/`, `includes/` |

---

## ⚡ Performance

- Static asset caching via `.htaccess`
- Gzip compression for HTML, CSS, JS
- Database indexes on `users.user_name` (UNIQUE) and `cart.user_id`
- Prepared statements for all queries

---

## 📝 License

MIT
