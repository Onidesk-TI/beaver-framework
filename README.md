# 🦫 Beaver Framework

![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![PSR Standards](https://img.shields.io/badge/PSR-4%2C%207%2C%2011%2C%2015-blueviolet?style=for-the-badge)
![GitHub](https://img.shields.io/badge/GitHub-Frank--Onidesk/beaver--framework-blue?style=for-the-badge&logo=github)

**A lightweight, modular PHP framework for building robust web applications with modern PHP features.**

---

## 📋 Table of Contents
- [✨ Features](#-features)
- [🚀 Quick Start](#-quick-start)
- [📦 Installation](#-installation)
- [🏗️ Architecture](#️-architecture)
- [📖 Documentation](#-documentation)
- [🔧 Usage Examples](#-usage-examples)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)
- [🦫 Why "Beaver"?](#-why-beaver)

## ✨ Features

### 🎯 **Core Philosophy**
> "Build applications that are as solid as a dam." 🦫

### **🚀 Modern & Fast**
- **PHP 8.1+ Only** - Always using the latest PHP features
- **PSR Compliant** - PSR-4, PSR-7, PSR-11, PSR-15, PSR-17
- **Zero Configuration** - Sensible defaults, minimal setup
- **Lightweight** - < 2MB core size

### **🔧 Essential Tools**
- ✅ **Intuitive Routing** - RESTful, expressive, middleware support
- ✅ **Dependency Injection** - PSR-11 compliant container
- ✅ **Template Engine** - Blade-like syntax, zero dependencies
- ✅ **Database Layer** - PDO-based, ActiveRecord & Query Builder
- ✅ **HTTP Abstraction** - PSR-7/15 request/response handling
- ✅ **CLI Tooling** - Built-in console commands
- ✅ **Testing Ready** - PHPUnit integration out of the box

### **🛡️ Security First**
- CSRF protection
- XSS filtering
- SQL injection prevention
- Secure session management
- Environment-based configuration

---

## 🚀 Quick Start

### **1. Clone the Framework**
```bash
git clone https://github.com/Frank-Onidesk/beaver-framework.git
cd beaver-framework
```

### **2. Install Dependencies**
```bash
composer install
```

### **3. Run Development Server**
```bash
php beaver serve
```
Visit: `http://localhost:8000`

### **4. Your First Route**
```php
// Create routes/web.php
$router->get('/', function() {
    return "Welcome to Beaver Framework! 🦫";
});

$router->get('/hello/{name}', function($name) {
    return "Hello, {$name}!";
});
```

---

## 📦 Installation

### **Requirements**
- PHP 8.1 or higher
- PDO extension (for database)
- Composer

### **Install for Development**
```bash
# Clone the framework
git clone https://github.com/Frank-Onidesk/beaver-framework.git
cd beaver-framework
composer install
```

### **Use in Your Project**
Add to your project's `composer.json`:
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "/path/to/beaver-framework"
        }
    ],
    "require": {
        "frank-onidesk/beaver-framework": "@dev"
    }
}
```

---

## 🏗️ Architecture

### **Directory Structure**
```
beaver-framework/
├── src/
│   ├── Http/
│   ├── Routing/
│   ├── Container/
│   ├── Database/
│   ├── View/
│   ├── Console/
│   └── Support/
├── tests/
├── examples/
├── composer.json
└── README.md
```

### **Framework Components**
```
Beaver Framework
├── Http/          # PSR-7/15 HTTP handling
├── Routing/       # Router & Middleware
├── Container/     # PSR-11 DI Container
├── Database/      # PDO, Query Builder, ORM
├── View/          # Template Engine
├── Console/       # CLI Commands
└── Support/       # Helpers & Utilities
```

---

## 📖 Documentation

### **📚 Documentation**
Visit our documentation at: **[https://github.com/Frank-Onidesk/beaver-framework/wiki](https://github.com/Frank-Onidesk/beaver-framework/wiki)**

### **📖 Quick Links**
- [Getting Started](https://github.com/Frank-Onidesk/beaver-framework/wiki/Getting-Started)
- [Routing Guide](https://github.com/Frank-Onidesk/beaver-framework/wiki/Routing)
- [Database Guide](https://github.com/Frank-Onidesk/beaver-framework/wiki/Database)
- [Template Engine](https://github.com/Frank-Onidesk/beaver-framework/wiki/Templates)

---

## 🔧 Usage Examples

### **Routing**
```php
use Beaver\Framework\Router;

$router = new Router();

// Basic routes
$router->get('/', [HomeController::class, 'index']);
$router->post('/users', [UserController::class, 'store']);
$router->put('/users/{id}', [UserController::class, 'update']);
$router->delete('/users/{id}', [UserController::class, 'destroy']);

// Route groups
$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function($router) {
    $router->get('dashboard', [AdminController::class, 'dashboard']);
});
```

### **Database**
```php
use Beaver\Database\Connection;

// PDO-based queries
$db = Connection::getInstance();
$users = $db->query('SELECT * FROM users WHERE active = ?', [1])->fetchAll();

// Query Builder
$users = DB::table('users')
    ->where('status', 'active')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();

// ActiveRecord
class User extends Model
{
    protected $table = 'users';
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

$user = User::find(1);
$posts = $user->posts;
```

### **Templates**
```blade
{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container">
        <h1>Welcome to {{ $appName }}</h1>
        
        @if(count($users) > 0)
            <ul>
                @foreach($users as $user)
                    <li>{{ $user->name }} - {{ $user->email }}</li>
                @endforeach
            </ul>
        @else
            <p>No users found.</p>
        @endif
    </div>
@endsection
```

### **Console Commands**
```bash
# Run development server
php beaver serve

# Create new controller
php beaver make:controller UserController

# Create new model with migration
php beaver make:model User --migration

# List all routes
php beaver route:list

# Run database migrations
php beaver migrate
```

### **Configuration**
```php
// config/app.php
return [
    'name' => env('APP_NAME', 'Beaver App'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
];

// .env file
APP_NAME="My Beaver App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=beaver_app
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🧪 Testing

```php
// tests/Feature/ExampleTest.php
namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_basic_route()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    public function test_user_creation()
    {
        $response = $this->post('/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }
}
```

Run tests:
```bash
# Run all tests
composer test

# Run specific test file
./vendor/bin/phpunit tests/Feature/ExampleTest.php

# Run with coverage
./vendor/bin/phpunit --coverage-html coverage
```

---

## 🔄 Migration from Laravel

If you're coming from Laravel, Beaver Framework will feel familiar:

| Feature | Laravel | Beaver |
|---------|---------|--------|
| Routing | `Route::get()` | `$router->get()` |
| Database | Eloquent ORM | ActiveRecord |
| Templates | Blade | Beaver Blade |
| Container | Service Container | PSR-11 Container |
| Commands | Artisan | Beaver CLI |

```php
// Similar syntax makes migration easy
// From Laravel:
Route::get('/users', [UserController::class, 'index']);

// To Beaver:
$router->get('/users', [UserController::class, 'index']);
```

---

## 🚀 Performance

### **Optimization Tips**
```bash
# Production optimization
composer install --no-dev --optimize-autoloader
php beaver config:cache
php beaver route:cache

# Enable OPCache (production)
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=10000
```

### **Benchmark Example**
```bash
# Test with ApacheBench
ab -n 1000 -c 10 http://localhost:8000/
```

---

## 🚢 Deployment

### **Traditional Server**
```bash
# 1. Clone your application
git clone https://github.com/your-username/your-app.git
cd your-app

# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Set up environment
cp .env.example .env
# Edit .env with production values

# 4. Optimize
php beaver config:cache
php beaver route:cache

# 5. Set permissions
chmod -R 755 storage
chown -R www-data:www-data storage
```

### **Docker Deployment**
```dockerfile
# Dockerfile
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage

EXPOSE 9000

CMD ["php-fpm"]
```

---

## 🤝 Contributing

We welcome contributions! Here's how you can help:

### **Development Setup**
```bash
# 1. Fork and clone
git clone https://github.com/Frank-Onidesk/beaver-framework.git
cd beaver-framework

# 2. Install dependencies
composer install

# 3. Run tests
composer test
```

### **Pull Request Process**
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request on GitHub

### **Code Style**
Beaver follows PSR-12 coding standards. Please ensure your code matches this style.

---

## 📄 License

Beaver Framework is open-source software licensed under the **[MIT license](LICENSE)**.

```
Copyright (c) 2024 Frank-Onidesk

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

---

## 🦫 Why "Beaver"?

Just like beavers:
- **Build solid structures** (dams = robust applications)
- **Work persistently** (consistent development)
- **Are efficient** (minimal, optimized code)
- **Create ecosystems** (modular, extensible framework)
- **Adapt to environments** (flexible, configurable)

---

## 🌐 Community & Support

- **💬 Discussions**: [GitHub Discussions](https://github.com/Frank-Onidesk/beaver-framework/discussions)
- **🐛 Issues**: [Issue Tracker](https://github.com/Frank-Onidesk/beaver-framework/issues)
- **💡 Ideas**: [Feature Requests](https://github.com/Frank-Onidesk/beaver-framework/discussions/categories/ideas)

---

## 🔮 Roadmap

### **Current Features**
- ✅ Core framework structure
- ✅ Routing system
- ✅ Database abstraction
- ✅ Template engine
- ✅ CLI commands

### **Planned Features**
- 🔄 Queue system
- 🔄 Event system
- 🔄 API documentation generator
- 🔄 Real-time capabilities

---

**Built with ❤️ by [Frank-Onidesk](https://github.com/Frank-Onidesk)**

[![Star on GitHub](https://img.shields.io/github/stars/Frank-Onidesk/beaver-framework?style=social)](https://github.com/Frank-Onidesk/beaver-framework/stargazers)
[![Fork on GitHub](https://img.shields.io/github/forks/Frank-Onidesk/beaver-framework?style=social)](https://github.com/Frank-Onidesk/beaver-framework/forks)
[![Watch on GitHub](https://img.shields.io/github/watchers/Frank-Onidesk/beaver-framework?style=social)](https://github.com/Frank-Onidesk/beaver-framework/watchers)

---

<div align="center">
  <sub>If you find Beaver Framework useful, please give it a ⭐ on GitHub!</sub>
  <br>
  <sub>"Building web applications that are as solid as a dam." 🦫</sub>
</div>

---

**Ready to build something amazing?**

```bash
git clone https://github.com/Frank-Onidesk/beaver-framework.git
cd beaver-framework
composer install
```

*Happy coding! 🚀*
