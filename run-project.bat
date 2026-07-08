@echo off
cd /d "%~dp0"
echo Starting Asif Raza Perfumes on http://127.0.0.1:8000
C:\xampp\php\php.exe -d max_execution_time=0 -d extension=zip -S 127.0.0.1:8000 -t public
pause
