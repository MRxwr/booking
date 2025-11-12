# Dashboard API Reference

This document describes all dashboard API endpoints found in `requests/dashboard/views/`. Each endpoint is accessed via a unified dispatcher:

**Endpoint format:** `/requests/dashboard/?endpoint={EndpointName}&action={action}`

- `{EndpointName}` is the capitalized name (e.g., `Services`, `Bookings`, `Branches`, etc.)
- `{action}` is the operation (e.g., `list`, `add`, `update`, `delete`)
- **Method:** POST (with parameters in the body)
- **Authentication:** Most endpoints require a valid `token` (employee session or API token)

---

## Example Usage for Each Endpoint

### Bookings
- List:
  ```http
  POST /requests/dashboard/?endpoint=Bookings&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Bookings&action=add
  Token: {employee_token}
  Body: { branchId: 1, startDate: "2025-12-01", endDate: "2025-12-01", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Bookings&action=update
  Token: {employee_token}
  Body: { id: 10, branchId: 1, startDate: "2025-12-01", endDate: "2025-12-01", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Bookings&action=delete
  Token: {employee_token}
  Body: { id: 10 }
  ```

### Branches
- List:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=add
  Token: {employee_token}
  Body: { enTitle: "Main Branch", arTitle: "الفرع الرئيسي", location: "Kuwait City", seats: 10, hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=update
  Token: {employee_token}
  Body: { id: 5, enTitle: "Main Branch", arTitle: "الفرع الرئيسي", location: "Kuwait City", seats: 12, hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=delete
  Token: {employee_token}
  Body: { id: 5 }
  ```
- Add Service:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=addService
  Token: {employee_token}
  Body: { id: 5, serviceId: 2 }
  ```
- List Services:
  ```http
  POST /requests/dashboard/?endpoint=Branches&action=listServices
  Token: {employee_token}
  Body: { id: 5 }
  ```

### BlockDate
- List:
  ```http
  POST /requests/dashboard/?endpoint=BlockDate&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=BlockDate&action=add
  Token: {employee_token}
  Body: { branchId: 1, startDate: "2025-12-10", endDate: "2025-12-12", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=BlockDate&action=update
  Token: {employee_token}
  Body: { id: 3, branchId: 1, startDate: "2025-12-10", endDate: "2025-12-12", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=BlockDate&action=delete
  Token: {employee_token}
  Body: { id: 3 }
  ```

### BlockDay
- List:
  ```http
  POST /requests/dashboard/?endpoint=BlockDay&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=BlockDay&action=add
  Token: {employee_token}
  Body: { branchId: 1, day: 6, hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=BlockDay&action=update
  Token: {employee_token}
  Body: { id: 2, branchId: 1, day: 6, hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=BlockDay&action=delete
  Token: {employee_token}
  Body: { id: 2 }
  ```

### BlockTime
- List:
  ```http
  POST /requests/dashboard/?endpoint=BlockTime&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=BlockTime&action=add
  Token: {employee_token}
  Body: { branchId: 1, serviceId: 2, startDate: "2025-12-01", endDate: "2025-12-01", fromTime: "09:00", toTime: "12:00", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=BlockTime&action=update
  Token: {employee_token}
  Body: { id: 4, branchId: 1, serviceId: 2, startDate: "2025-12-01", endDate: "2025-12-01", fromTime: "09:00", toTime: "12:00", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=BlockTime&action=delete
  Token: {employee_token}
  Body: { id: 4 }
  ```

### Calendar
- List:
  ```http
  POST /requests/dashboard/?endpoint=Calendar&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Calendar&action=add
  Token: {employee_token}
  Body: { branchId: 1, startDate: "2025-12-01", endDate: "2025-12-31", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Calendar&action=update
  Token: {employee_token}
  Body: { id: 7, branchId: 1, startDate: "2025-12-01", endDate: "2025-12-31", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Calendar&action=delete
  Token: {employee_token}
  Body: { id: 7 }
  ```

### ExtraInfo
- List:
  ```http
  POST /requests/dashboard/?endpoint=ExtraInfo&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=ExtraInfo&action=add
  Token: {employee_token}
  Body: { enTitle: "Notes", arTitle: "ملاحظات", isRequired: 1, type: "text", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=ExtraInfo&action=update
  Token: {employee_token}
  Body: { id: 2, enTitle: "Notes", arTitle: "ملاحظات", isRequired: 1, type: "text", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=ExtraInfo&action=delete
  Token: {employee_token}
  Body: { id: 2 }
  ```

### Extras
- List:
  ```http
  POST /requests/dashboard/?endpoint=Extras&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Extras&action=add
  Token: {employee_token}
  Body: { enTitle: "Coffee", arTitle: "قهوة", price: 2.5, hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Extras&action=update
  Token: {employee_token}
  Body: { id: 3, enTitle: "Coffee", arTitle: "قهوة", price: 2.5, hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Extras&action=delete
  Token: {employee_token}
  Body: { id: 3 }
  ```

### Packages
- List:
  ```http
  POST /requests/dashboard/?endpoint=Packages&action=list
  Token: {employee_token}
  ```

### Payment
- Submit:
  ```http
  POST /requests/dashboard/?endpoint=Payment&action=submit
  Token: {employee_token}
  Body: { packageId: 1 }
  ```

### PictureTypes
- List:
  ```http
  POST /requests/dashboard/?endpoint=PictureTypes&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=PictureTypes&action=add
  Token: {employee_token}
  Body: { enTitle: "Portrait", arTitle: "بورتريه", price: 10, themes: "[1,2]", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=PictureTypes&action=update
  Token: {employee_token}
  Body: { id: 2, enTitle: "Portrait", arTitle: "بورتريه", price: 10, themes: "[1,2]", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=PictureTypes&action=delete
  Token: {employee_token}
  Body: { id: 2 }
  ```

### Services
- List:
  ```http
  POST /requests/dashboard/?endpoint=Services&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Services&action=add
  Token: {employee_token}
  Body: { enTitle: "Haircut", arTitle: "حلاقة", price: 5, period: 30, seats: 1, hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Services&action=update
  Token: {employee_token}
  Body: { id: 4, enTitle: "Haircut", arTitle: "حلاقة", price: 5, period: 30, seats: 1, hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Services&action=delete
  Token: {employee_token}
  Body: { id: 4 }
  ```

### Systems
- List:
  ```http
  POST /requests/dashboard/?endpoint=Systems&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Systems&action=add
  Token: {employee_token}
  Body: { enTitle: "System Name", arTitle: "اسم النظام" }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Systems&action=update
  Token: {employee_token}
  Body: { id: 1, enTitle: "System Name", arTitle: "اسم النظام" }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Systems&action=delete
  Token: {employee_token}
  Body: { id: 1 }
  ```

### Themes
- List:
  ```http
  POST /requests/dashboard/?endpoint=Themes&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Themes&action=add
  Token: {employee_token}
  Body: { enTitle: "Modern", arTitle: "حديث", themes: "[1,2,3]", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Themes&action=update
  Token: {employee_token}
  Body: { id: 2, enTitle: "Modern", arTitle: "حديث", themes: "[1,2,3]", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Themes&action=delete
  Token: {employee_token}
  Body: { id: 2 }
  ```

### Time
- List:
  ```http
  POST /requests/dashboard/?endpoint=Time&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Time&action=add
  Token: {employee_token}
  Body: { branchId: 1, day: 1, startTime: "09:00", closeTime: "18:00", hidden: 0 }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Time&action=update
  Token: {employee_token}
  Body: { id: 3, branchId: 1, day: 1, startTime: "09:00", closeTime: "18:00", hidden: 0 }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Time&action=delete
  Token: {employee_token}
  Body: { id: 3 }
  ```

### Users
- Register:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=register
  Body: { name: "John Doe", email: "john@example.com", password: "123456", phone: "12345678" }
  ```
- Login:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=login
  Body: { email: "john@example.com", password: "123456" }
  ```
- List:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=list
  Token: {employee_token}
  ```
- Add:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=add
  Token: {employee_token}
  Body: { name: "Jane Doe", email: "jane@example.com", password: "abcdef", phone: "87654321" }
  ```
- Update:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=update
  Token: {employee_token}
  Body: { id: 5, name: "Jane Doe", email: "jane@example.com", password: "abcdef", phone: "87654321" }
  ```
- Delete:
  ```http
  POST /requests/dashboard/?endpoint=Users&action=delete
  Token: {employee_token}
  Body: { id: 5 }
  ```

---

## Notes
- All dashboard endpoints return JSON responses with `ok`, `error`, `status`, and `data` fields.
- Always include the `token` parameter for authentication.
- Actions and required parameters may vary; check the source code for advanced usage.
