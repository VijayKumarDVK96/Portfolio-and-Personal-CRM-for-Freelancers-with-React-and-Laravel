@echo off
cd frontend
start cmd /k "npm run dev"
cd ..\backend
start cmd /k "php artisan serve"