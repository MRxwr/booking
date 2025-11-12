# Booking System Documentation

## Overview

This project is a PHP-based multi-vendor booking system. It provides:
- An **admin control panel** for managing vendors, bookings, services, employees, and system settings.
- A **vendor-facing booking interface** for clients to make reservations.
- **Multi-language support** (English and Arabic).

---

## Project Structure

- **/admin/**: Admin dashboard for system management.
  - **index.php**: Loads admin pages based on user actions.
  - **views/**: PHP templates for admin pages (e.g., bookings, employees, services, settings).
  - **includes/**: Core logic and configuration.
    - **config.php**: MySQL database connection settings.
    - **functions/**: Utility functions for general logic, SQL, cart, payment, etc.
- **/css/**, **/js/**: Shared stylesheets and JavaScript files for UI and interactivity.
- **/img/**, **/logos/**: Images, icons, and branding assets.
- **/templates/**: Theme files for the vendor/client booking interface (customizable per vendor).
- **index.php**: Main entry for the public booking interface (client-facing).
- **default.php**: Default landing page if no vendor is selected.

---

## Main Features

- **Vendor Management**: Add, edit, and manage vendors, each with a unique URL and theme.
- **Booking Management**: Create, update, and track bookings. Integrates with payment gateways and tracks booking status.
- **Service Management**: Define and manage services offered by each vendor.
- **Employee Management**: Assign employees to vendors and services.
- **Multi-language Support**: All UI and logic support both English and Arabic, with direction and translation helpers.
- **Admin Dashboard**: Full CRUD (Create, Read, Update, Delete) for vendors, services, employees, bookings, and settings.
- **Customizable Themes**: Vendors can use different UI themes for their booking pages.
- **Security**: Uses prepared SQL statements and input sanitization to prevent SQL injection and other attacks.

---

## Technical Details

- **Backend**: PHP (procedural, modular functions)
- **Database**: MySQL (accessed via `mysqli` with a configurable table prefix)
- **Frontend**: Bootstrap (UI), jQuery (interactivity), Flatpickr (date/time pickers), AOS (animations), FontAwesome (icons)
- **Templating**: PHP-based, with Blade-like conventions for admin views

---

## Key Files and Folders

- `admin/includes/config.php`: MySQL database connection and settings.
- `admin/includes/functions/`: Utility functions for general logic, SQL, cart, payment, etc.
- `admin/views/`: Admin panel pages for managing bookings, vendors, services, employees, and settings.
- `index.php`: Loads vendor data and renders the booking interface for clients.
- `templates/`: Theme files for the public booking interface (can be customized per vendor).

---

## How the System Works

### 1. Admin Panel (`/admin`)
- Accessible by system administrators.
- Manage vendors, services, employees, bookings, and system settings.
- Each admin page is a separate PHP template in `admin/views/`.

### 2. Vendor/Client Booking Interface (Frontend)
- Each vendor has a unique public URL (e.g., `/index.php?vendorURL=...`).
- Clients can:
  - View vendor information, available services, and pricing.
  - Select services, pick dates/times, and submit booking requests.
  - Complete payments (if enabled for the vendor).
  - Receive booking confirmations and status updates.
- The frontend UI is built using Bootstrap for responsive design, with interactive elements powered by jQuery and Flatpickr for date/time selection.
- The look and feel of each vendor's booking page can be customized via the `templates/` directory, allowing for different themes and branding.
- All client actions (booking, payment, etc.) are processed and stored in the backend database, and vendors can manage these bookings from the admin panel.

### 3. Database
- All data (vendors, bookings, services, employees, etc.) is stored in MySQL tables.
- Table names are prefixed (see `config.php`).

### 4. Language Handling
- Language is set via cookies or URL parameters.
- Helper functions handle text direction and translation.
- Both admin and client interfaces support English and Arabic.

### 5. Security
- All SQL queries use prepared statements.
- User input is sanitized before database operations.

---

## Extending the System

- **Add new admin pages**: Create a new PHP file in `admin/views/` for the desired feature (e.g., `bladeNewFeature.php`).
- **Add new utility functions**: Place new PHP functions in `admin/includes/functions/` (e.g., `general.php` for general logic, `sql.php` for database helpers).
- **Create new frontend themes**: Add a new folder in `templates/` with the required PHP, CSS, and JS files for a new vendor-facing theme. Update vendor settings to use the new theme. You can fully customize the client booking experience, including layout, branding, and interactive features.

---

## Notes

- **Database Setup**: Ensure the credentials in `admin/includes/config.php` match your MySQL environment. The database must have all required tables and structure.
- **Multi-language**: Use the provided helper functions for all UI strings to ensure proper translation and direction.
- **Customization**: You can add new features, pages, or themes by following the modular structure described above. Both the admin and client-facing sides are fully extensible.

---

For more details, review the code in each module or contact the project maintainer.
