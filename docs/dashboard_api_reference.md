# Dashboard API Endpoints Reference

This document provides a summary of all API endpoints in the dashboard (`requests/dashboard/views/`). Each API file typically handles CRUD operations and related actions for a specific resource. All endpoints use an `action` parameter to determine the operation, require authentication via a `token`, and return JSON responses.

---

## Common Patterns
- **Authentication**: Most endpoints require a `token` (employee session) for all actions except registration/login.
- **Action Routing**: The `action` parameter in the request determines which operation is performed.
- **Validation**: Each action validates required fields and returns localized error messages.
- **Soft Deletes**: Deletions usually set `status` to 1 or 2 instead of removing records.
- **Responses**: Success and error responses are returned as JSON, using `outputData` and `outputError`.

---

## API Files and Their Actions

### 1. `apiBlockDate.php`
- **list**: List all blocked dates for the vendor.
- **add**: Add a new blocked date (requires `branchId`, `startDate`, `endDate`, `hidden`).
- **update**: Update a blocked date (requires `id`, `branchId`, `startDate`, `endDate`, `hidden`).
- **delete**: Soft-delete a blocked date (requires `id`).

### 2. `apiBlockDay.php`
- **list**: List all blocked days for the vendor.
- **add**: Add a new blocked day (requires `branchId`, `serviceId`, `day`, `hidden`).
- **update**: Update a blocked day (requires `id`, `branchId`, `serviceId`, `day`, `hidden`).
- **delete**: Soft-delete a blocked day (requires `id`).

### 3. `apiBlockTime.php`
- **list**: List all blocked times for the vendor.
- **add**: Add a new blocked time (requires `branchId`, `serviceId`, `startDate`, `endDate`, `fromTime`, `toTime`, `hidden`).
- **update**: Update a blocked time (requires `id`, `branchId`, `serviceId`, `startDate`, `endDate`, `fromTime`, `toTime`, `hidden`).
- **delete**: Soft-delete a blocked time (requires `id`).

### 4. `apiBookings.php`
- **list**: List all bookings for the vendor (with customer and branch/service info).
- **add**: Add a new booking (requires `branchId`, `startDate`, `endDate`, `hidden`).
- **update**: Update a booking (requires `id`, `branchId`, `startDate`, `endDate`, `hidden`).
- **delete**: Soft-delete a booking (requires `id`).

### 5. `apiBranches.php`
- **list**: List all branches for the vendor.
- **add**: Add a new branch (requires `enTitle`, `arTitle`, `location`, `seats`, `hidden`).
- **update**: Update a branch (requires `id`, `enTitle`, `arTitle`, `location`, `seats`, `hidden`).
- **delete**: Soft-delete a branch (requires `id`).
- **addService**: Add a service to a branch (requires `id`, `serviceId`).
- **listServices**: List services for a branch (requires `id`).

### 6. `apiCalendar.php`
- **list**: List all calendar entries for the vendor.
- **add**: Add a new calendar entry (requires `branchId`, `startDate`, `endDate`, `hidden`).
- **update**: Update a calendar entry (requires `id`, `branchId`, `startDate`, `endDate`, `hidden`).
- **delete**: Soft-delete a calendar entry (requires `id`).

### 7. `apiExtraInfo.php`
- **list**: List all extra info fields for the vendor.
- **add**: Add a new extra info field (requires `enTitle`, `arTitle`, `isRequired`, `type`, `hidden`).
- **update**: Update an extra info field (requires `id`, `enTitle`, `arTitle`, `isRequired`, `type`, `hidden`).
- **delete**: Soft-delete an extra info field (requires `id`).

### 8. `apiExtras.php`
- **list**: List all add-ons for the vendor.
- **add**: Add a new add-on (requires `enTitle`, `arTitle`, `price`, `hidden`).
- **update**: Update an add-on (requires `id`, `enTitle`, `arTitle`, `price`, `hidden`).
- **delete**: Soft-delete an add-on (requires `id`).

### 9. `apiPackages.php`
- **list**: List all available packages.

### 10. `apiPayment.php`
- **submit**: Submit a payment for a package (requires `packageId`).

### 11. `apiPictureTypes.php`
- **list**: List all picture types for the vendor.
- **add**: Add a new picture type (requires `enTitle`, `arTitle`, `price`, `themes`, `hidden`).
- **update**: Update a picture type (requires `id`, `enTitle`, `arTitle`, `price`, `themes`, `hidden`).
- **delete**: Soft-delete a picture type (requires `id`).

### 12. `apiServices.php`
- **list**: List all services for the vendor.
- **add**: Add a new service (requires `enTitle`, `arTitle`, `price`, `period`, `seats`, `hidden`).
- **update**: Update a service (requires `id`, `enTitle`, `arTitle`, `price`, `period`, `seats`, `hidden`).
- **delete**: Soft-delete a service (requires `id`).
- **addPictureTypes**: Add picture types to a service (requires `id`, `listTypes`).
- **deletePictureTypes**: Remove a picture type from a service (requires `id`, `index`).
- **addThemes**: Add themes to a service (requires `id`, `themes`).
- **deleteThemes**: Remove a theme from a service (requires `id`, `index`).

### 13. `apiSystems.php`
- **list**: List all booking systems (vendors) for the user.
- **add**: Add a new booking system (requires `enTitle`, `arTitle`, `type`, `url`, `logo`, `coverImg`).
- **update**: Update a booking system (requires `id`, `enTitle`, `arTitle`, `type`, `url`).
- **theme**: Update theme and color for a booking system (requires `id`, `theme`, `websiteColor`).
- **socialMedia**: Update social media links (requires `id`, social fields).
- **paymentOptions**: Update payment options (requires `id`, `chargeType`, `chargeTypeAmount`, `iban`).
- **moreDetails**: Update details and terms (requires `id`, `enDetails`, `arDetails`, `enTerms`, `arTerms`).
- **delete**: Soft-delete a booking system (requires `id`).

### 14. `apiThemes.php`
- **list**: List all themes for the vendor.
- **add**: Add a new theme (requires `enTitle`, `arTitle`, `hidden`).
- **update**: Update a theme (requires `id`, `enTitle`, `arTitle`, `hidden`).
- **delete**: Soft-delete a theme (requires `id`).
- **addTheme**: Upload theme images (requires `id`, `themes` as files).
- **deleteTheme**: Remove a theme image (requires `id`, `index`).

### 15. `apiTime.php`
- **list**: List all time slots for the vendor.
- **add**: Add a new time slot (requires `branchId`, `day`, `startTime`, `closeTime`, `hidden`).
- **update**: Update a time slot (requires `id`, `branchId`, `day`, `startTime`, `closeTime`, `hidden`).
- **delete**: Soft-delete a time slot (requires `id`).

### 16. `apiUsers.php`
- **register**: Register a new user (requires `name`, `email`, `password`, `phone`).
- **login**: User login (requires `email`, `password`).
- **logout**: User logout (requires `token`).
- **update**: Update user profile (requires `token`, `name`, `phone`).
- **delete**: Delete user (requires `token`).
- **changePassword**: Change user password (requires `token`, `oldPassword`, `newPassword`).
- **forgetPassword**: Request password reset (requires `email`).

---

## Helper Functions Used
- `selectDBNew`, `selectDB2New`, `selectDB`, `selectJoinDB`: Database queries
- `insertDB`, `updateDB`: Insert/update records
- `uploadImageAPI`: File uploads
- `outputData`, `outputError`: JSON responses
- `checkAPILanguege`: Localization

---

This reference should help you quickly understand what each API file does and what actions are available. For details, see the code in each file under `requests/dashboard/views/`.
