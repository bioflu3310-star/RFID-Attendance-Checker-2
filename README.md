# NodeMCU RC522 RFID with MySQL

A PHP web dashboard for managing RFID card registrations using a **NodeMCU V3 ESP8266** and **RC522 RFID reader**, with a **MySQL** backend.

---

## Features

- 📋 View all registered RFID cards in a user data table
- ➕ Register new cards by tapping them on the reader
- ✏️ Edit and 🗑️ delete user records
- 📡 Live tag detection — scanned UID auto-appears in the browser via polling
- 🔒 Credentials kept out of version control via `config.php`

---

## Requirements

| Requirement | Version |
|---|---|
| PHP | 7.4 or higher |
| MySQL / MariaDB | 5.7 or higher |
| Web server | Apache / Nginx (or XAMPP / WAMP locally) |
| NodeMCU V3 ESP8266 | with RC522 RFID module |

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```

### 2. Set up the database

Import the included SQL schema:

```bash
mysql -u root -p < database.sql
```

Or open `database.sql` in **phpMyAdmin → Import**.

### 3. Configure your credentials

```bash
cp config.example.php config.php
```

Then open `config.php` and fill in your database details:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'nodemcu_sbca_rfid_mysql');
define('DB_USER', 'root');
define('DB_PASS', '');
```

> ⚠️ `config.php` is listed in `.gitignore` and will never be committed.

### 4. Place files on your web server

Copy the project folder into your web server's root:
- **XAMPP**: `C:/xampp/htdocs/NodeMCU_RC522_Mysql/`
- **WAMP**: `C:/wamp64/www/NodeMCU_RC522_Mysql/`
- **Linux**: `/var/www/html/NodeMCU_RC522_Mysql/`

Then visit: `http://localhost/NodeMCU_RC522_Mysql/home.php`

---

## NodeMCU Setup

In your Arduino sketch, set the server URL to point to `getUID.php`:

```cpp
const char* host = "192.168.x.x";  // Your PC/server local IP
const char* url  = "/NodeMCU_RC522_Mysql/getUID.php";
```

The sketch should send a POST request with field `UIDresult=<card_uid>` whenever a card is scanned.

---

## File Structure

```
NodeMCU_RC522_Mysql/
├── config.example.php       ← Copy to config.php and add your credentials
├── config.php               ← ⚠️ NOT committed (in .gitignore)
├── database.php             ← PDO singleton connection class
├── database.sql             ← Run once to create DB and table
│
├── home.php                 ← Landing page
├── registration.php         ← Register a new RFID card
├── insertDB.php             ← Handles registration form POST
│
├── user_data.php            ← Lists all registered users
├── user_data_edit.php       ← Edit user form
├── user_data_edit_save.php  ← Handles edit form POST
├── user_data_delete.php     ← Delete confirmation + handler
│
├── read_tag.php             ← Live tag reader page
├── read_tag_data.php        ← AJAX partial: returns user data for a UID
│
├── getUID.php               ← Endpoint: NodeMCU posts scanned UIDs here
├── UIDContainer.php         ← Auto-generated runtime file (gitignored)
├── testUID.php              ← Debug helper: simulates a card scan
│
├── nav.php                  ← Shared navigation bar partial
├── css/
│   ├── style.css            ← Shared custom styles
│   └── bootstrap.min.css
├── js/
│   └── bootstrap.min.js
└── jquery.min.js
```

---

## Testing Without Hardware

Use `testUID.php` to simulate a card scan without a physical NodeMCU:

1. Open `testUID.php` in your browser or run via CLI:
   ```bash
   php testUID.php
   ```
2. It will POST a fake UID to `getUID.php` and show the result.
3. Then open `read_tag.php` to see the live lookup in action.

> ⚠️ Remove or password-protect `testUID.php` before deploying to a public server.

---

## License

MIT — feel free to use, modify, and share.
