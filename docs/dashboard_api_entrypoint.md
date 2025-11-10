# Dashboard API Entrypoint: `requests/dashboard/index.php`

This section documents the dashboard API entrypoint, which is responsible for routing and authenticating all dashboard-related API requests.

---

## File: `requests/dashboard/index.php`

### Purpose
- Handles all API requests for the dashboard/admin area.
- Dynamically routes requests to the appropriate API handler in the `views/` directory.

### Key Features
- **Session & Headers**: Starts a session and sets the response header to JSON.
- **Config & Functions**: Loads configuration and helper functions from the admin includes.
- **Token Extraction**: Reads the Bearer token from the `Authorization` HTTP header (if present) and sets `$token` for use in downstream API files.
- **Localization**: Sets `$titleDB` for use in queries and responses, based on the current language (English/Arabic).
- **Dynamic Routing**: Uses the `endpoint` GET parameter to determine which API file to include from `views/` (e.g., `apiUsers.php` for `endpoint=Users`).
- **Error Handling**: If the requested API file does not exist, returns a JSON error message with a 404 message.

### Example Request
```
GET /requests/dashboard/index.php?endpoint=Users
Authorization: Bearer <token>
```

### Example Routing Logic
- If `endpoint=Users`, the file `views/apiUsers.php` is included and executed.
- If the file does not exist, returns `{ "msg": "Wrong Endpoint Request 404" }` as JSON.

### Security
- All downstream API files expect `$token` to be set for authentication.
- Only valid endpoints (existing files) are included.

---

This entrypoint is the main gateway for all dashboard API operations. For a list of available endpoints and their actions, see the dashboard API reference documentation.
