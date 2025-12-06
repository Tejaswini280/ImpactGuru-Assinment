# ImpactGuru Mini CRM – Customer Management System

A comprehensive Customer Relationship Management (CRM) system built with Laravel, designed to manage customers, orders, and user roles with role-based access control.

## 📋 Project Overview

This application helps manage customers, their orders, and access roles (Admin, Staff). The project demonstrates practical experience with Laravel fundamentals, including authentication, routing, Eloquent ORM, Blade templating, file uploads, middleware, notifications, and REST APIs.

## ✨ Features

### 1. Authentication Module
- ✅ User registration and login using Laravel Breeze
- ✅ Password reset functionality
- ✅ Email verification
- ✅ Session-based authentication with `auth` middleware
- ✅ Role-Based Access Control (RBAC) with Admin and Staff roles

### 2. Customer Management Module
- ✅ Full CRUD operations (Create, Read, Update, Delete)
- ✅ Customer model with fields: `name`, `email`, `phone`, `address`, `profile_image`
- ✅ Profile image upload and display
- ✅ Form validation using Form Request classes
- ✅ Pagination for customer listing (10 per page)
- ✅ Soft deletes for safe data removal
- ✅ Search functionality (by name or email)
- ✅ Export to CSV and PDF (Admin only)
- ✅ Access restricted to authenticated users

### 3. Order Management Module
- ✅ Full CRUD operations for orders
- ✅ Order model linked to customers via `customer_id` foreign key
- ✅ Order fields: `order_number`, `amount`, `status`, `order_date`
- ✅ One-to-many relationship (Customer → Orders)
- ✅ Display all orders for each customer
- ✅ Role-based restrictions (Staff can view/add/edit, Admin can delete)
- ✅ Pagination for order lists (10 per page)
- ✅ Status filtering (Pending, Completed, Cancelled)
- ✅ Email notifications for new orders (sent to admins)
- ✅ Export to CSV and PDF (Admin only)

### 4. Search & Filtering
- ✅ Search customers by name or email
- ✅ Filter orders by status (Pending, Completed, Cancelled)
- ✅ Real-time search with form submission

### 5. Dashboard
- ✅ Key statistics display:
  - Total Customers
  - Total Orders
  - Total Revenue (from completed orders)
  - Recent 5 Customers
  - Order status breakdown (Admin only)
- ✅ Role-based dashboard views
- ✅ Uses Blade components and layouts for reusability

### 6. REST API
- ✅ API routes protected with Laravel Sanctum
- ✅ Endpoints:
  - `GET /api/customers` - List all customers
  - `GET /api/customers/{id}` - Get customer details
  - `POST /api/customers` - Create new customer
  - `PUT /api/customers/{id}` - Update customer (Admin only)
  - `DELETE /api/customers/{id}` - Delete customer (Admin only)
- ✅ Role-based access control (only Admin can delete/update via API)
- ✅ JSON responses with proper status codes

### 7. Error Handling & Validation
- ✅ Form Request Validation (`CustomerRequest`, `OrderRequest`)
- ✅ Custom validation error messages
- ✅ Custom 404 error page
- ✅ Custom 500 error page
- ✅ Error logging to `storage/logs/laravel.log`
- ✅ Flash messages for success/error notifications

### 8. Role-Based Access Control (RBAC)

#### Admin Role
- ✅ Full access to all modules (Customers, Orders, Users)
- ✅ Can create, read, update, and delete customers
- ✅ Can create, read, update, and delete orders
- ✅ Can manage users (create, edit, delete)
- ✅ Can export data (CSV/PDF)
- ✅ Can view detailed dashboard statistics

#### Staff Role
- ✅ Can view, add, and edit customers
- ✅ Can view, add, and edit orders
- ❌ Cannot delete customers or orders
- ❌ Cannot export data
- ❌ Cannot access user management
- ✅ Can view basic dashboard statistics

## 🚀 Installation Steps

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL/MariaDB or SQLite
- Git

### Step 1: Clone the Repository
```bash
git clone <repository-url>
cd impactguru-crm
```

### Step 2: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database
Edit `.env` file and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations
```bash
# Run database migrations
php artisan migrate

# (Optional) Seed database with sample data
php artisan db:seed
```

### Step 6: Create Storage Link
```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 7: Build Assets
```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### Step 8: Start Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 📝 Default User Credentials

This project seeds a single Admin user when you run the database seeders. Staff accounts are created via the public registration form (`/register`) and are not seeded by default.

Seeded Admin (after `php artisan db:seed`)

```
Name: Admin User
Email: admin@impactguru.com
Password: password
Role: admin
```

Create the admin user with Tinker (optional)

```bash
php artisan tinker
```

```php
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Hash;

User::firstOrCreate([
  'email' => 'admin@impactguru.com'
], [
  'name' => 'Admin User',
  'password' => Hash::make('password'),
  'role' => 'admin'
]);
```

Example Staff (for testing)

The application does not seed a staff account by default to encourage use of the public registration flow. For convenience during development/testing you can use the following sample staff credentials — create this account via Tinker if you want it immediately available:

```
Email: staff@impactguru.com
Password: password
```

Create the staff user with Tinker (optional)

```bash
php artisan tinker
```

```php
use App\\Models\\User;
use Illuminate\\Support\\Facades\\Hash;

User::firstOrCreate([
  'email' => 'staff@impactguru.com'
], [
  'name' => 'Staff Example',
  'password' => Hash::make('password'),
  'role' => 'staff'
]);
```

Alternative: Register via the web UI at `http://localhost:8000/register` — new registrations are assigned the `staff` role by default.

Security note: there is an optional development helper in the codebase that can automatically allow public staff login behind the `PUBLIC_STAFF_LOGIN` env flag. Do not enable this in production.

## 🔐 Role Permissions Summary

| Feature | Admin | Staff |
|---------|-------|-------|
| View Customers | ✅ | ✅ |
| Add Customer | ✅ | ✅ |
| Edit Customer | ✅ | ✅ |
| Delete Customer | ✅ | ❌ |
| Export Customers | ✅ | ❌ |
| View Orders | ✅ | ✅ |
| Add Order | ✅ | ✅ |
| Edit Order | ✅ | ✅ |
| Delete Order | ✅ | ❌ |
| Export Orders | ✅ | ❌ |
| Manage Users | ✅ | ❌ |
| View Dashboard | ✅ | ✅ |
| Full Dashboard Stats | ✅ | ❌ |

## 🛠️ Technology Stack

- **Backend Framework:** Laravel 12.x
- **Frontend:** Blade Templates, Bootstrap 5, Bootstrap Icons
- **Database:** MySQL/MariaDB (SQLite for development)
- **Authentication:** Laravel Breeze
- **API Authentication:** Laravel Sanctum
- **File Storage:** Laravel Storage (Public Disk)
- **PDF Generation:** DomPDF
- **Notifications:** Laravel Notifications

## 📁 Project Structure

```
impactguru-crm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/          # API Controllers
│   │   │   ├── Auth/         # Authentication Controllers
│   │   │   ├── CustomerController.php
│   │   │   ├── OrderController.php
│   │   │   ├── DashboardController.php
│   │   │   └── UserController.php
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php
│   │   │   └── IsStaff.php
│   │   └── Requests/
│   │       ├── CustomerRequest.php
│   │       └── OrderRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Customer.php
│   │   └── Order.php
│   └── Notifications/
│       └── NewOrderNotification.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── auth/              # Authentication views
│   │   ├── customers/         # Customer views
│   │   ├── orders/            # Order views
│   │   ├── layouts/           # Layout components
│   │   ├── dashboard.blade.php
│   │   └── errors/            # Error pages (404, 500)
│   └── css/
├── routes/
│   ├── web.php                # Web routes
│   ├── api1.php               # API routes
│   └── auth.php               # Authentication routes
└── storage/
    └── logs/                  # Application logs
```

## 🔌 API Usage

### Authentication
All API endpoints require Sanctum authentication. Get your API token by logging in and generating a token:

```bash
POST /api/login
{
    "email": "admin@example.com",
    "password": "password"
}
```

### Example API Requests

**Get All Customers:**
```bash
GET /api/customers
Headers: Authorization: Bearer {token}
```

**Get Single Customer:**
```bash
GET /api/customers/{id}
Headers: Authorization: Bearer {token}
```

**Create Customer:**
```bash
POST /api/customers
Headers: Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "1234567890",
    "address": "123 Main St"
}
```

**Update Customer (Admin only):**
```bash
PUT /api/customers/{id}
Headers: Authorization: Bearer {admin_token}
```

**Delete Customer (Admin only):**
```bash
DELETE /api/customers/{id}
Headers: Authorization: Bearer {admin_token}
```

## 📸 Screenshots

_(Add screenshots of your application here)_

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

ImpactGuru Internship Project

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Breeze
- Bootstrap
- DomPDF

---

**Note:** This is a learning project developed as part of the ImpactGuru internship program to demonstrate proficiency in Laravel development.
