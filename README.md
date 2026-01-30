# Manila FAME Registration Portal

A multi-step registration system built with Laravel 12 and Vue 3 (Composition API). This application features a robust 3-step wizard with state persistence, file uploads, and transactional database operations.

## Tech Stack

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Vue 3 (Composition API) with Vite
- Database: MySQL
- Styling: Bootstrap 5.3

## Key Features

- User input persists between steps using shared state in the parent Vue component.
- User and company records are created inside a single database transaction. If one insert fails, nothing is saved.
- All inputs are validated using Laravel Form Requests to keep the API consistent and secure.
- Companies can upload a brochure file that is stored securely and linked to their record.

## Installation

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js and pnpm
- MySQL

## Backend setup

Clone the repository and install dependencies:
```    
    git clone https://github.com/xLalice/citem-test.git
    cd citem-app
    composer install
```

Create the environment file and generate the app key:
```   
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=citem_app
    DB_USERNAME=root
    DB_PASSWORD=your_password
```

Run migrations and link storage:
```
php artisan migrate
php artisan storage:link

```

## Frontend setup

Install dependencies and build assets:
```    
    pnpm install
    pnpm run build
```
Run the app:
```    
    php artisan serve
```

Open http://127.0.0.1:8000 in your browser.