# Booking System API & Requests Documentation

This document describes all main API endpoints and request files in the `requests/views/` directory, their required parameters, and how to use them for client-side booking operations.

---

## 1. apiCheckout.php
**Endpoint:** `/requests/views/apiCheckout.php`
**Method:** POST

### Required Parameters:
- `vendorId` (int, required)
- `branchId` (int, required)
- `serviceId` (int, required)
- `date` (YYYY-MM-DD, required)
- `time` (string, required)
- `customer[name]` (string, required)
- `customer[email]` (string, required)
- `customer[mobile]` (string, required)
- `pictureTypeId` (int, optional, for certain vendor types)
- `extras` (comma-separated IDs, optional)
- `themeId` (int, optional)
- `extraInfo` (array, optional)

### Description:
Creates a booking request. Validates all input, checks vendor/service/branch availability, and if valid, proceeds to payment. Returns booking/payment status or error.

---

## 2. apiGetTimeSlots.php
**Endpoint:** `/requests/views/apiGetTimeSlots.php`
**Method:** POST

### Required Parameters:
- `branchId` (int, required)
- `vendorId` (int, required)
- `serviceId` (int, required)
- `date` (YYYY-MM-DD, required)

### Description:
Returns available time slots for a given branch, vendor, service, and date. Takes into account blocked times, bookings, and service/branch seat limits.

---

## 3. apiServices.php
**Endpoint:** `/requests/views/apiServices.php`
**Method:** POST

### Required Parameters:
- `branchId` (int, required)

### Description:
Returns all available services for a given branch. Each service includes its details if active and not hidden.

---

## 4. apiPayment.php
**Endpoint:** `/requests/views/apiPayment.php`
**Method:** POST

### Required Parameters:
- `vendorId` (int, required)
- `branchId` (int, required)
- `serviceId` (int, required)
- `date` (YYYY-MM-DD, required)
- `time` (string, required)
- `customer[name]` (string, required)
- `customer[email]` (string, required)
- `customer[mobile]` (string, required)
- `pictureTypeId` (int, optional, for certain vendor types)
- `extras` (comma-separated IDs, optional)

### Description:
Calculates the total price for a booking, initiates payment via the payment gateway, and returns a payment link or booking confirmation. Handles different vendor charge types and payment scenarios.

---

## Usage Example (Booking Flow)
1. **Get Services:**
   - POST to `apiServices.php` with `branchId` to get available services.
2. **Get Time Slots:**
   - POST to `apiGetTimeSlots.php` with `branchId`, `vendorId`, `serviceId`, and `date` to get available times.
3. **Checkout:**
   - POST to `apiCheckout.php` with all required booking and customer details.
4. **Payment:**
   - If required, follow the payment link returned by `apiCheckout.php` or use `apiPayment.php` directly for payment processing.

---

## Notes
- All endpoints return JSON responses with `ok`, `error`, `status`, and `data` fields.
- Always validate required parameters before making requests.
- For more advanced or dashboard-related APIs, see the `requests/dashboard/views/` directory.
