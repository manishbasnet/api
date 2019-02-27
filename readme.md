# Steps to setup 
1. After cloning, run composer install in the root project.
2. Run cp .env.example .env (if required update database env credentials)
3. Run php artisan key:generate
4. Run php artisan serve --port=9090
5. In browser=> http://localhost:9090/profile?id=123
