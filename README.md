# CodeIgniter 4 Users CRUD Module

A fully functional **Users CRUD module** built with CodeIgniter 4, including:

- Create, Read, Update, Delete (CRUD)
- Server-side Pagination
- File Upload (image/document)
- CSRF Protection
- Validation & Error Handling
- Password Hashing
- Clean MVC Architecture

---

## 1️⃣ Prerequisites

- XAMPP installed (Apache + MySQL)
- PHP >= 7.4
- Composer (optional for CI4 updates)

---

## 2️⃣ Install CodeIgniter 4

1. Download CodeIgniter 4: [https://www.codeigniter.com/download](https://www.codeigniter.com/download)  
2. Extract the downloaded folder.  
3. Copy it to `xampp/htdocs` and rename to `myproject`.  
4. Start Apache via XAMPP.  

Access the project:


---

## 3️⃣ Set Environment to Development

1. Rename `env` file to `.env`.  
2. Open `.env` and set:

```env
CI_ENVIRONMENT = development
````

-----

## 4️⃣ Database Setup

### A. Create Database

1.  Open **phpMyAdmin** in your browser (`http://localhost/phpmyadmin`).
2.  Create a new database named **`ci`**.

### B. Create `users` Table

Run the following SQL query in the `ci` database:

```sql
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `mobile` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `profile_file` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### C. Configure Connection

Edit your database configuration file: `app/Config/Database.php`.

Update the `$default` array with your credentials:

```php
public array $default = [
    'DSN'          => '',
    'hostname'     => 'localhost',
    'username'     => 'root', // Your MySQL Username
    'password'     => '',     // Your MySQL Password
    'database'     => 'ci',
    'DBDriver'     => 'MySQLi',
    // ... other settings ...
    'charset'      => 'utf8mb4',
    'DBCollat'     => 'utf8mb4_general_ci',
    'port'         => 3306,
];
```

-----

## 5️⃣ Application Configuration

### A. Set Base URL

Edit `app/Config/App.php`:

```php
public string $baseURL = 'http://localhost/myproject/public/';
public string $indexPage = ''; // Remove 'index.php' from URLs
```

### B. Configure `.htaccess`

For cleaner URLs (removing `index.php`), ensure you have the following `.htaccess` file in your **`public`** folder:

```htaccess
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

> **Note:** Ensure **`mod_rewrite`** is enabled in your Apache configuration, and `AllowOverride All` is set for your web root directory.

-----

## 6️⃣ Code Structure (MVC)

### A. Routes

Define the application routes in `app/Config/Routes.php`:

```php
// Basic Routing (remove index.php if configured)
$routes->get('/', 'Users::index');

// CRUD Routes for Users
$routes->group('users', function ($routes) {
    $routes->get('/', 'Users::index');              // List/Read
    $routes->get('create', 'Users::create');        // Show Create Form
    $routes->post('store', 'Users::store');         // Handle Create Submission
    $routes->get('edit/(:num)', 'Users::edit/$1');  // Show Edit Form
    $routes->post('update/(:num)', 'Users::update/$1'); // Handle Update Submission
    $routes->get('delete/(:num)', 'Users::delete/$1'); // Handle Delete
});
```

> **Security Tip:** For production, it's safer to use a **`POST`** or **`DELETE`** request method for the delete action instead of a simple `GET`.

### B. Controller & Model

| File | Location | Purpose |
| :--- | :--- | :--- |
| **`Users.php`** | `app/Controllers/` | Contains all CRUD logic: `index`, `create`, `store`, `edit`, `update`, `delete`. |
| **`UserModel.php`** | `app/Models/` | Handles database interaction using CodeIgniter's Model features (Soft Deletes, ORM). |

### C. Views

| View File | Location | Purpose |
| :--- | :--- | :--- |
| **`list.php`** | `app/Views/users/` | Displays the users table with **server-side pagination** and file previews. |
| **`add.php`** | `app/Views/users/` | The **Create User** form, including file upload and validation error display. |
| **`edit.php`** | `app/Views/users/` | The **Edit User** form, allowing data and optional password/file update. |

-----

## 7️⃣ Feature Highlights

  * **Create:** Handles form validation (e.g., unique email, 10-digit mobile), **file upload** (moves file to `writable/uploads`), **password hashing**, and **CSRF protection**.
      * *Validation Rules:* Fullname (letters/spaces only), Mobile (exactly 10 digits), Email (unique).
  * **Read/List:** Implements **pagination** and displays a preview of the user's uploaded profile file.
  * **Update/Edit:** Allows for field updates, **conditional password update** (only if the field is filled), and **file replacement/removal**.
  * **Delete:** Performs record deletion and handles the removal of the associated profile file from the server.

-----

## 8️⃣ Access URLs

Access the module using the following URLs:

| Action | URL |
| :--- | :--- |
| **List Users** | `http://localhost/myproject/public/users` |
| **Add User** | `http://localhost/myproject/public/users/create` |
| **Edit User (ID 1)** | `http://localhost/myproject/public/users/edit/1` |
| **Delete User (ID 1)** | `http://localhost/myproject/public/users/delete/1` |


```
```