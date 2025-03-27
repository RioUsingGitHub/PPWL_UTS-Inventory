# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- Transaction creation with 30-day limit feature
- Edit name functionality for users
- Global search functionality with permission-based results
- Quick access dropdown menu in top navigation
- Enhanced UI for login and registration pages
- Modern background graphics and icons
- Improved form validation feedback
- Better error handling and user feedback

### Changed
- Enhanced UI/UX across the application
- Improved navigation sidebar functionality
- Updated permission checks to use Gate facade
- Reorganized routes for better structure
- Enhanced search functionality with better UI
- Improved form layouts and styling
- Updated color scheme for better consistency
- Enhanced mobile responsiveness

### Fixed
- Sidebar navigation issues
- Permission check bugs
- Search functionality permission issues
- Form validation display issues
- Mobile responsiveness bugs
- Navigation state persistence issues

### Removed
- Unused controllers:
  - UserProfileController.php
  - PageController.php
- Unused views:
  - user-profile.blade.php
  - tables.blade.php
  - billing.blade.php
  - dashboard_new.blade.php
- Unused requests:
  - UpdateProductRequest.php
  - StoreProductRequest.php
- Unused images (some are not removed):
  - vr-bg.jpg
  - team-*.jpg files
  - marie.jpg
  - kal-visuals-square.jpg
  - ivancik.jpg and ivana-square.jpg
  - home-decor-*.jpg files
  - carousel-*.jpg files
  - bruce-mars.jpg
  - bg1.jpg
  - bg-profile.jpg

### Security
- Updated permission checks to use Gate facade
- Enhanced form validation
- Improved password handling
- Added CSRF protection
- Enhanced route protection

### Documentation
- Added comprehensive CHANGELOG.md
- Updated README.md with new features
- Added inline code documentation
- Improved route documentation

## [Previous Versions]

### [0.1.0] - 2024-03-27
- Initial release
- Basic inventory management system
- User authentication and authorization
- Role-based access control
- Basic CRUD operations for items and inventory 