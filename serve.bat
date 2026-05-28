@echo off
REM Laravel KIAS - Quick Serve Script
REM Uses PHP 8.2.27 from Laragon
REM
REM Usage: double-click serve.bat or run from terminal

echo Starting Laravel KIAS on http://127.0.0.1:8007
echo.
echo Press Ctrl+C to stop the server
echo.

C:\laragon\bin\php\php-8.2.27-nts-Win32-vs16-x64\php.exe artisan serve --port=8007

pause
