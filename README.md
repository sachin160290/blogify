# Blogify — Local setup & developer guide

## About Blogify
Welcome! This README shows step-by-step commands and troubleshooting notes to get **Blogify** running locally on a Windows/XAMPP or typical *nix dev machine. It covers cloning, dependencies, DB/migrations/seeders, front-end build (Vite/Tailwind), Git tips, and common fixes you hit during development.

> Target: Laravel app in this repo. These commands assume you run them from the project root (where `composer.json` lives).

---

## Quick checklist (one-shot)
```bash
# in project root
composer install
cp .env.example .env        # edit .env values
php artisan key:generate
# set DB settings in .env (see below)
php artisan migrate:fresh --seed
npm install
npm run dev                 # or: npm run build
php artisan storage:link
php artisan serve           # or open via XAMPP/Apache
```
## 1) Clone the repo
```bash
git clone https://github.com/sachin160290/blogify.git
cd blogify
```

## 2) Install PHP dependencies
```bash
composer install
```
If composer is not in PATH on Windows, use full path or run via Composer installer.

## 3) Copy and update .env
```bash
copy .env.example .env    # Windows (CMD/PowerShell)
# or
cp .env.example .env      # macOS / Linux
```

Important .env values (example for local XAMPP MySQL):

```bash
APP_NAME=Blogify
APP_ENV=local
APP_URL=http://localhost:8000        # or http://localhost/blogify/public if using XAMPP
VITE_DEV_SERVER_URL=http://localhost:5173

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify
DB_USERNAME=root
DB_PASSWORD=
````

Create the database blogify in phpMyAdmin (or mysql CLI) before running migrations.

If you want to use XAMPP + Apache (htdocs), point APP_URL to http://localhost/blogify/public (but Vite dev server will still be at localhost:5173).

## 4) Generate app key
```bash
php artisan key:generate
```

## 5) Migrate database + seed sample data

If you have no important data:
```bash
php artisan migrate:fresh --seed
```

This runs migrations and the seeders (ensure DatabaseSeeder calls BlogifySeeder or run the seeder class directly).

If you want only seeder:

```bash
php artisan db:seed --class=BlogifySeeder
```

Common migration problems & quick fixes

errno: 150 foreign key errors:

Ensure tags and blogs migrations create parent tables before pivot migrations. Filenames (timestamps) control order — rename migration files to enforce order.

Make sure parent IDs use $table->id() (BIGINT UNSIGNED) and pivots use unsignedBigInteger() + matching foreign() references.

Drop leftover partial tables via phpMyAdmin:

```bash
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS blog_tag;
DROP TABLE IF EXISTS blog_category;
DROP TABLE IF EXISTS blogs;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS tags;
SET FOREIGN_KEY_CHECKS = 1;
```

Then run php artisan migrate:fresh.

If php artisan migrate:fresh --seed complains about unknown --class option: use php artisan db:seed --class=BlogifySeeder to run a particular seeder.

If you get Call to undefined method User::factory() or Class Database\Factories\User not found:

Ensure you have database/factories/UserFactory.php and the User model is in App\Models\User.

composer dump-autoload may help to refresh autoload classes.

## 6) Frontend (Node / Vite / Tailwind)

Install node dependencies and run dev server:
```bash
npm install
npm run dev 
```
Production build:

```bash
npm run build
```

If you want Laravel to serve assets built by Vite in production, set APP_URL accordingly and run npm run build.

Note on dev UX

When using npm run dev you’ll access assets via Vite server (e.g., http://localhost:5173). For local dev you can still browse Laravel pages on http://127.0.0.1:8000 (when using php artisan serve) or on Apache if you deployed under htdocs.

## 7) Storage link (for public files)
```bash
php artisan storage:link
```

## 8) Run the app

Option A (artisan dev server):

```bash
php artisan serve
```

## 9) Create API bearer token (for testing APIs)

If you use Laravel Sanctum / personal access tokens, create a token via Tinker for a user:
```bash
php artisan tinker
```
>>> $user = App\Models\User::first();           # or find by email
>>> $token = $user->createToken('api-token')->plainTextToken;
>>> echo $token;


Use that token as Authorization: Bearer <token> for API calls.

## 10) Git & GitHub — push your code

If you already resolved conflicts, commit and push:
```bash
git add .
git commit -m "Resolved merge conflicts, initial commit"
git branch -M main
git remote add origin https://github.com/sachin160290/blogify.git
git push -u origin main
```

## 11) Routes & Navigation checks

List all routes:

```bash
php artisan route:list
```

If you use resourceful controllers, route names are blogs.index, blogs.create, etc.

In navigation Blade, use route('blogs.index') not route('blogs').

## 12) Useful artisan shortcuts
```bash
php artisan migrate:status
php artisan migrate:rollback
php artisan migrate:fresh --seed
php artisan db:seed --class=BlogifySeeder
php artisan route:clear
php artisan view:clear
php artisan cache:clear
composer dump-autoload
```

## 13) Developer notes & conventions used in this project

UI: Tailwind + Breeze x-app-layout components used for admin pages.

Admin routes are behind auth and role:admin middleware (custom middleware assumed).

Blogs: Has relations to categories, tags, and author (User). Pivot tables used: blog_category, blog_tag.

Seeder: BlogifySeeder creates users, blogs, categories, tags and maps relationships (run via migrate:fresh --seed).

## 14) Useful commands you may want to script

Add to your local project README or scripts/dev.sh (Linux) / dev.cmd (Windows):

# Example dev flow (artisan + vite)
```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate:fresh --seed
npm run dev
php artisan serve
```

## 15) Need help?

If something fails, please copy the exact error message and paste here. Useful info to share:

```bash
php artisan route:list

php artisan migrate:status
```

Contents of the migration files that are producing errors (especially pivot & parent table migrations)

composer.json, package.json (if relevant)

