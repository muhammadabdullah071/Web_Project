@echo off
REM FoodDash Platform - Setup & Run Script
REM This script will set up and run the FoodDash project

cls
echo.
echo ===============================================
echo    FoodDash - Premium Food Delivery Platform
echo ===============================================
echo.

REM Check if we're in the right directory
if not exist "composer.json" (
    echo ERROR: composer.json not found!
    echo Please run this script from the store_backend directory.
    pause
    exit /b 1
)

echo [1/5] Installing PHP dependencies...
echo.
call composer install
if errorlevel 1 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)

echo.
echo [2/5] Installing JavaScript dependencies...
echo.
call npm install
if errorlevel 1 (
    echo ERROR: npm install failed!
    pause
    exit /b 1
)

echo.
echo [3/5] Generating application key...
echo.
call php artisan key:generate --force

echo.
echo [4/5] Running database migrations...
echo.
call php artisan migrate --force

echo.
echo [5/5] Building assets...
echo.
call npm run production

echo.
echo ===============================================
echo    Setup Complete!
echo ===============================================
echo.
echo Your application is ready to run.
echo.
echo To start the development server, run:
echo    php artisan serve
echo.
echo Then open your browser to:
echo    http://127.0.0.1:8000
echo.
echo ===============================================
echo.

pause
