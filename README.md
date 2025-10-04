# Mini E-commerce (PHP + MySQL)

## Requirements
- PHP 7.4+ (with PDO MySQL)
- MySQL / MariaDB
- phpMyAdmin (optional) to manage/inspect the database
- Web server (Apache, Nginx) or built-in PHP server: `php -S localhost:8000`

## Setup
1. Put the project folder in your web root (e.g., `htdocs`).
2. Create the database and tables:
   - Open phpMyAdmin, import `db.sql`.
   - IMPORTANT: Update the owner password hash in `users` table, or create a new owner user:
     - In PHP run `echo password_hash('yourpassword', PASSWORD_DEFAULT);` and paste the hash into `users.password_hash`.
3. Edit `config.php` DB credentials (DB_USER, DB_PASS).
4. Start server: `php -S localhost:8000` (or use Apache).
5. Visit `http://localhost:8000/` in your browser.

## Admin
- Login at `/login.php` with the owner credentials you created.
- Admin panel at `/admin/admin_panel.php` lets you add/edit/delete products.

## Notes
- This is a simplified demo. For production, add:
  - CSRF protection.
  - Strong input validation and sanitation as needed.
  - HTTPS, better session management, and proper user accounts.
  - Real payment gateway integration (Stripe/PayPal).
