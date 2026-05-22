@echo off
REM FoodDash - Complete Installation Guide
REM This script will help you install all required dependencies

cls
echo.
echo ===============================================
echo    FoodDash - Complete Installation Guide
echo ===============================================
echo.
echo This guide will help you install:
echo - PHP 8.2
echo - Composer
echo - Laravel Development Environment
echo.
echo ===============================================
echo.

REM Check current installations
echo [CHECK] Verifying existing installations...
echo.

php --version >nul 2>&1
if errorlevel 1 (
    echo [X] PHP NOT INSTALLED - Please install from: https://windows.php.net/download
    echo     OR download this direct link: https://windows.php.net/downloads/releases/php-8.2.31-Win32-vs16-x64.zip
) else (
    echo [OK] PHP is installed
    php --version
)

echo.

composer --version >nul 2>&1
if errorlevel 1 (
    echo [X] Composer NOT INSTALLED - Please install from: https://getcomposer.org/download
    echo     OR use installer: https://getcomposer.org/Composer-Setup.exe
) else (
    echo [OK] Composer is installed
    composer --version
)

echo.

node --version >nul 2>&1
if errorlevel 1 (
    echo [X] Node.js NOT INSTALLED - Please install from: https://nodejs.org/
) else (
    echo [OK] Node.js is installed
    node --version
)

npm --version >nul 2>&1
if errorlevel 1 (
    echo [X] npm NOT INSTALLED
) else (
    echo [OK] npm is installed
    npm --version
)

echo.
echo ===============================================
echo INSTALLATION INSTRUCTIONS
echo ===============================================
echo.

php --version >nul 2>&1
if errorlevel 1 (
    echo 1. Download PHP:
    echo    - Go to: https://windows.php.net/download/
    echo    - Download: php-8.2.31-Win32-vs16-x64.zip
    echo    - Extract to: C:\php
    echo    - OR run: winget install --id PHP.PHP.8.2
    echo.
)

composer --version >nul 2>&1
if errorlevel 1 (
    echo 2. Download Composer:
    echo    - Go to: https://getcomposer.org/download/
    echo    - Download and run: Composer-Setup.exe
    echo    - OR run: winget install --id getcomposer.Composer
    echo.
)

echo 3. After installation, add PHP to Windows PATH:
    echo    - Right-click "This PC" or "My Computer"
    echo    - Select "Properties"
    echo    - Click "Advanced system settings"
    echo    - Click "Environment Variables"
    echo    - Under "System variables", click "New"
    echo    - Variable name: PATH
    echo    - Variable value: C:\php
    echo    - Click OK
    echo    - RESTART YOUR TERMINAL/COMMAND PROMPT
    echo.

echo 4. Verify installations by running:
    echo    - php --version
    echo    - composer --version
    echo    - node --version
    echo.

echo ===============================================
echo QUICK SETUP SCRIPT
echo ===============================================
echo.
echo Once all installations are complete, run:
echo    SETUP.bat (in store_backend folder)
echo.
echo Or manually run these commands:
echo    cd store_backend
echo    composer install
echo    npm install
echo    php artisan migrate
echo    npm run production
echo    php artisan serve
echo.

pause
