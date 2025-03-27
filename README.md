 # Inventory Management System Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [System Architecture](#system-architecture)
3. [Installation & Setup](#installation--setup)
4. [User Guide](#user-guide)
5. [Administration](#administration)
6. [Troubleshooting](#troubleshooting)
7. [Glossary](#glossary)
8. [References](#references)

## Introduction

### Purpose
The Inventory Management System is a comprehensive solution designed to streamline inventory tracking, user management, and role-based access control. It helps organizations maintain accurate stock levels, track transactions, and manage user permissions effectively.

### Target Audience
- Inventory Managers
- Warehouse Supervisors
- System Administrators
- Regular Users (with appropriate permissions)

### Key Features
- Real-time inventory tracking
- User role management
- Transaction history
- Stock level monitoring
- Import/Export functionality
- Role-based access control

### New Features
- Transaction Creation with 30-day Limit
- Global Search with Permission-based Results
- Quick Access Navigation
- Enhanced UI/UX
- Modern Background Graphics
- Improved Form Validation
- Better Error Handling
- Mobile Responsive Design

### Core Features
- User Authentication & Authorization
- Role-Based Access Control (RBAC)
- Item Management
- Inventory Tracking
- Transaction History
- User Management
- Role Management
- Profile Management
- Export/Import Functionality
- Search Functionality

### Technical Features
- Laravel 10.x
- MySQL Database
- Blade Templates
- Tailwind CSS
- Alpine.js
- Laravel Sanctum
- Spatie Permission Package
- Laravel Excel for Import/Export

## System Architecture

### Technology Stack
- **Backend**: Laravel (PHP Framework)
- **Frontend**: 
  - Argon Dashboard Template
  - Bootstrap 5
  - JavaScript/jQuery
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Auth with Spatie Permission

### Core Components
1. **User Management**
   - User authentication
   - Role assignment
   - Permission management

2. **Inventory Management**
   - Stock tracking
   - Location management
   - Transaction logging

3. **Role Management**
   - Predefined roles
   - Permission assignment
   - User role association

### Data Flow
1. User Authentication → Role Verification → Permission Check
2. Inventory Updates → Transaction Recording → Stock Level Adjustment
3. User Actions → Permission Validation → System Response

## Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- Composer
- Node.js & NPM
- MySQL/PostgreSQL
- Web Server (Apache/Nginx)

### Installation Steps
1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd [project-directory]
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   ```

4. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure database in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Seed initial data:
   ```bash
   php artisan db:seed
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

## User Guide

### User Roles
1. **Super Admin**
   - Full system access
   - User management
   - Role management
   - System configuration

2. **Admin**
   - User management
   - Inventory management
   - Transaction management

3. **Inventory Manager**
   - Stock management
   - Transaction processing
   - Report generation

4. **Regular User**
   - View inventory
   - Process transactions
   - Generate reports

### Common Operations

#### Inventory Management
1. View Inventory
   - Navigate to Inventory section
   - Use filters for specific items
   - Export data if needed

2. Update Stock
   - Select item
   - Enter quantity
   - Add notes
   - Submit transaction

3. Import/Export
   - Download template
   - Fill in data
   - Upload file
   - Verify import

#### User Management
1. Create User
   - Navigate to Users
   - Click "Add User"
   - Fill in details
   - Assign roles
   - Save

2. Edit User
   - Select user
   - Modify details
   - Update roles
   - Save changes

## Administration

### Role Management
- Predefined roles cannot be modified
- View role permissions
- Monitor user assignments
- Track role usage

### System Configuration
1. **Database Backup**
   ```bash
   php artisan backup:run
   ```

2. **Cache Management**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

3. **Queue Management**
   ```bash
   php artisan queue:work
   ```

## Troubleshooting

### Common Issues

1. **Sidebar Not Working**
   - Clear browser cache
   - Check JavaScript console
   - Verify custom.js is loaded

2. **Search Functionality Issues**
   - Verify database connection
   - Check search parameters
   - Clear application cache

3. **Import/Export Problems**
   - Verify file format
   - Check file permissions
   - Validate data structure

### Error Messages
- "There is no role named X for guard web"
  - Solution: Verify role exists in database
  - Check role assignment syntax

- "Undefined method 'save'"
  - Solution: Verify model relationships
  - Check authentication setup

## Glossary

### Terms
- **SKU**: Stock Keeping Unit
- **RBAC**: Role-Based Access Control
- **CRUD**: Create, Read, Update, Delete
- **API**: Application Programming Interface

### Components
- **Sidenav**: Side navigation menu
- **Dashboard**: Main system overview
- **Inventory**: Stock management system
- **Transaction**: Stock movement record

## References

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Permission Documentation](https://spatie.be/docs/laravel-permission)
- [Argon Dashboard Documentation](https://demos.creative-tim.com/argon-dashboard)

### Support
- Technical Support: [satriommw@gmail.com]
- Issue Tracker: [repository-issues]
- Documentation Updates: [docs-repository]

### Additional Resources
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)