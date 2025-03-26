# Technical Documentation

## System Architecture

### Directory Structure dsb
```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ItemController.php
│   │   │   ├── InventoryController.php
│   │   │   ├── RoleController.php
│   │   │   ├── UserController.php
│   │   │   └── TransactionController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── Item.php
│   │   ├── Inventory.php
│   │   ├── Transaction.php
│   │   └── User.php
│   └── Services/
├── resources/
│   ├── views/
│   │   ├── items/
│   │   ├── inventory/
│   │   ├── roles/
│   │   └── users/
│   └── js/
│       └── custom.js
└── routes/
    └── web.php
```

### Database Schema

#### Items Table
```sql
CREATE TABLE items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    unit_price DECIMAL(10,2) NOT NULL,
    unit_weight DECIMAL(10,2) NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Inventory Table
```sql
CREATE TABLE inventories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_id BIGINT UNSIGNED NOT NULL,
    on_hand_quantity INT NOT NULL DEFAULT 0,
    off_hand_quantity INT NOT NULL DEFAULT 0,
    location VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(id)
);
```

#### Transactions Table
```sql
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    item_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    type ENUM('on_hand', 'off_hand') NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    total_weight DECIMAL(10,2) NOT NULL,
    notes TEXT,
    created_at TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES items(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### API Endpoints

#### Items
- `GET /items` - List all items
- `GET /items/{id}` - Get item details
- `POST /items` - Create new item
- `PUT /items/{id}` - Update item
- `DELETE /items/{id}` - Delete item
- `GET /items/export` - Export items

#### Inventory
- `GET /inventory` - List inventory
- `GET /inventory/{id}` - Get inventory details
- `POST /inventory/import` - Import inventory
- `GET /inventory/export` - Export inventory
- `GET /inventory/template` - Download import template

#### Users
- `GET /users` - List users
- `GET /users/{id}` - Get user details
- `POST /users` - Create user
- `PUT /users/{id}` - Update user
- `DELETE /users/{id}` - Delete user

#### Roles
- `GET /roles` - List roles
- `GET /roles/{id}` - Get role details

### Authentication & Authorization

#### Middleware
```php
// Role-based middleware
$this->middleware('role:admin|super-admin');

// Permission-based middleware
$this->middleware('permission:view-items');
$this->middleware('permission:create-items');
$this->middleware('permission:edit-items');
$this->middleware('permission:delete-items');
```

#### Available Permissions
- view-items
- create-items
- edit-items
- delete-items
- view-inventory
- view-transactions
- view-users
- view-roles
- create-users
- edit-users
- delete-users

### Frontend Components

#### Custom JavaScript
```javascript
// Sidenav Toggle
function toggleSidenav() {
    if (body.classList.contains(className)) {
        body.classList.remove(className);
        body.classList.add('g-sidenav-hidden');
        sidenav.classList.remove('bg-white');
        sidenav.classList.remove('bg-transparent');
    } else {
        body.classList.add(className);
        body.classList.remove('g-sidenav-hidden');
        sidenav.classList.add('bg-white');
        sidenav.classList.remove('bg-transparent');
    }
}

// Search Functionality
function applyFilters() {
    const searchParams = new URLSearchParams(window.location.search);
    if (searchInput.value) searchParams.set('search', searchInput.value);
    if (categoryFilter.value) searchParams.set('category', categoryFilter.value);
    if (priceFilter.value) searchParams.set('price', priceFilter.value);
    window.location.search = searchParams.toString();
}
```

### Development Guidelines

#### Code Style
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions focused and single-purpose

#### Git Workflow
1. Create feature branch
2. Make changes
3. Run tests
4. Submit pull request
5. Code review
6. Merge to main

#### Testing
```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=testName
```

### Deployment

#### Production Setup
1. Set environment variables
2. Optimize autoloader
3. Clear cache
4. Run migrations
5. Set proper permissions

```bash
# Production commands
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
```

#### Server Requirements
- PHP 8.0+
- MySQL 5.7+ / PostgreSQL 10+
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)

### Performance Optimization

#### Database
- Use indexes for frequently queried columns
- Implement eager loading for relationships
- Cache frequently accessed data

#### Frontend
- Minify CSS/JS
- Optimize images
- Use CDN for assets
- Implement lazy loading

### Security Measures

#### Input Validation
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'sku' => 'required|string|unique:items',
    'unit_price' => 'required|numeric|min:0'
]);
```

#### CSRF Protection
- Enabled by default in Laravel
- Use `@csrf` directive in forms

#### XSS Prevention
- Use `{{ }}` for escaping in Blade
- Sanitize user input
- Use prepared statements

### Monitoring & Logging

#### Log Files
- Located in `storage/logs/`
- Rotate daily
- Monitor for errors

#### Performance Monitoring
- Use Laravel Telescope in development
- Implement custom logging for critical operations
- Monitor database query performance

### Backup & Recovery

#### Database Backup
```bash
# Create backup
php artisan backup:run

# Restore backup
php artisan backup:restore
```

#### File Backup
- Regular backup of storage directory
- Version control for code
- Document configuration changes

### Troubleshooting Guide

#### Common Issues
1. **Sidebar Not Working**
   - Check JavaScript console
   - Verify custom.js is loaded
   - Clear browser cache

2. **Search Issues**
   - Check database connection
   - Verify search parameters
   - Clear application cache

3. **Import/Export Problems**
   - Check file permissions
   - Verify file format
   - Check PHP memory limit

#### Debug Tools
- Laravel Debugbar
- Browser Developer Tools
- Database Query Log 