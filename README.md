# Web_Project

Laravel e-commerce backend and admin panel for store & food-delivery management.

This repository contains a complete Laravel application in the `store_backend/` directory:

- REST API endpoints for products, orders, and users
- Admin panel for managing products, restaurants, orders, riders, and coupons
- Example migrations, seeders, and frontend assets

## Quickstart

1. Copy `store_backend/.env.example` to `store_backend/.env` and set database credentials.
2. Install PHP dependencies:

	composer install

3. Install frontend dependencies (optional):

	npm install

4. Generate application key and run migrations:

	php artisan key:generate
	php artisan migrate --seed

5. Start the development server:

	php artisan serve --host=127.0.0.1 --port=8000

## Project layout

- `store_backend/` — Laravel application root
- `store_backend/app/Models` — Eloquent models
- `store_backend/app/Http/Controllers` — Controllers (API + web)
- `store_backend/resources/views` — Blade views for admin and storefront

## Notes

- Use the provided `SETUP.bat` in `store_backend/` on Windows to automate environment setup.
- `.gitignore` excludes vendor, node_modules, and environment files.

## Repository

Repository: https://github.com/muhammadabdullah071/Web_Project

If you want the GitHub repository description (the short text shown on GitHub) updated as well, either run `gh auth login` and tell me to apply the edit, or run the `gh repo edit` command locally (I can provide the exact command).

---

If you'd like, I can also add a license, CODEOWNERS, or CI workflow next.
