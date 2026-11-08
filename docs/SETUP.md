# Local setup

1. Install Node.js and PHP 8.1+ CLI with PDO MySQL, and start MySQL 8. Create a database named `db_northwind` with `utf8mb4` (or change `DB_NAME` in `.env`).
2. Import `dbNorthwind.sql` into that database.
3. Copy `.env.example` to `.env`, then set `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, and a unique random `JWT_SECRET`. The local launcher reads `.env`; keep it private. For MAMP, use the MySQL port shown in MAMP; common MAMP setups use `8889`, but use the value shown in your installation.
4. Run `npm.cmd run dev` on Windows (or `npm run dev` elsewhere) from the project directory. Open `http://127.0.0.1:8000`. No `npm install` is needed. This command starts PHP's built-in development server; PHP and MySQL must already be installed and available.
5. The SQL seed includes `admin` / `admin1234`, `admincpe` / `admincpe1234`, `mango` / `magno123`, and `banana` / `banana`. Passwords in the seed are stored as hashes. Change the demo credentials before exposing the site publicly.

For deployment, serve the project directory with Apache and mod_rewrite enabled. The supplied `.htaccess` routes the API. Set the site's document root to this project directory (or deploy the same folder structure beneath the desired URL path), configure the hosting environment variables or `.env`, and import the SQL database.

The API accepts existing plain-text legacy passwords for compatibility and verifies hashed passwords created by PHP `password_hash`. The supplied SQL seed uses password hashes in a `varchar(255)` column. Set a unique `JWT_SECRET` and replace the demo credentials before public deployment. No hosting account or deployment was configured as part of this project.
