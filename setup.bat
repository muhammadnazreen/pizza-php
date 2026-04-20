@echo off
echo ==============================================
echo    Pizza Paradizo - Windows Setup Script
echo ==============================================
echo.

:: 1. Copy Environment Variables File
if not exist ".env" (
    echo [1/2] Creating .env file...
    copy .env.example .env >nul
    echo       Created .env! Please remember to open it and set DB_PASS.
) else (
    echo [1/2] .env file already exists, skipping...
)
echo.

:: 2. Import Database
echo [2/2] Importing MySQL Database...
set /p DBPASS="Enter your MySQL root password (leave blank if no password): "

if "%DBPASS%"=="" (
    mysql -u root loginsys_db < database\loginsys_db.sql
) else (
    mysql -u root -p%DBPASS% loginsys_db < database\loginsys_db.sql
)
echo.

echo ==============================================
echo Setup Complete!
echo Run 'php -S 0.0.0.0:8080' in your terminal to start the server!
echo ==============================================
pause
