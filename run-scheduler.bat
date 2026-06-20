@echo off
cd /d "%~dp0"

:: Interval dalam detik (default: 60 detik = 1 menit)
set INTERVAL=15

echo ========================================
echo Laravel Scheduler - Berjalan setiap %INTERVAL% detik
echo Tekan Ctrl+C untuk berhenti
echo ========================================
echo.

:loop
echo [%date% %time%] Menjalankan scheduler...
php artisan schedule:run
echo [%date% %time%] Selesai. Tunggu %INTERVAL% detik...
echo.
timeout /t %INTERVAL% /nobreak >nul
goto loop
