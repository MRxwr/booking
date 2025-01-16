<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Control Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <!-- Font Awesome for Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background-color: #343a40;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 1000;
    }
    .header h3 {
      margin: 0;
    }
    .sidebar {
      position: fixed;
      top: 60px;
      left: 0;
      bottom: 0;
      width: 250px;
      background-color: #2c3e50;
      color: #fff;
      padding: 20px;
      overflow-y: auto;
      z-index: 999;
    }
    .sidebar .nav-link {
      color: #fff;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
      display: flex;
      align-items: center;
    }
    .sidebar .nav-link:hover {
      background-color: #34495e;
    }
    .sidebar .nav-link.active {
      background-color: #0d6efd;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
    }
    .main-content {
      margin-left: 250px;
      margin-top: 60px;
      padding: 20px;
    }
    .card {
      border: none;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <!-- Fixed Header -->
  <div class="header">
    <h3>Vendor Control Panel</h3>
    <div>
      <span class="me-3">Welcome, Vendor Name</span>
      <button class="btn btn-sm btn-light">
        <i class="fas fa-sign-out-alt"></i> Logout
      </button>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link active" href="#branches" data-module="branches">
          <i class="fas fa-code-branch"></i>Branches
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#services" data-module="services">
          <i class="fas fa-cogs"></i>Services
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#bookings" data-module="bookings">
          <i class="fas fa-calendar-alt"></i>Bookings
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#profile" data-module="profile">
          <i class="fas fa-user"></i>Profile
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Branches Module -->
    <div id="branches" class="module active">
      <h2 class="mb-4"><i class="fas fa-code-branch me-2"></i>Branches</h2>
      <div class="card">
        <div class="card-body">
          <table id="branchesTable" class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be loaded here -->
            </tbody>
          </table>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBranchModal">
            <i class="fas fa-plus me-2"></i>Add Branch
          </button>
        </div>
      </div>
    </div>

    <!-- Services Module -->
    <div id="services" class="module" style="display: none;">
      <h2 class="mb-4"><i class="fas fa-cogs me-2"></i>Services</h2>
      <div class="card">
        <div class="card-body">
          <table id="servicesTable" class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be loaded here -->
            </tbody>
          </table>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            <i class="fas fa-plus me-2"></i>Add Service
          </button>
        </div>
      </div>
    </div>

    <!-- Bookings Module -->
    <div id="bookings" class="module" style="display: none;">
      <h2 class="mb-4"><i class="fas fa-calendar-alt me-2"></i>Bookings</h2>
      <div class="card">
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <!-- Profile Module -->
    <div id="profile" class="module" style="display: none;">
      <h2 class="mb-4"><i class="fas fa-user me-2"></i>Profile</h2>
      <div class="card">
        <div class="card-body">
          <form id="profileForm">
            <div class="mb-3">
              <label for="vendorName" class="form-label">Vendor Name</label>
              <input type="text" class="form-control" id="vendorName" required>
            </div>
            <div class="mb-3">
              <label for="vendorEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="vendorEmail" required>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save me-2"></i>Save Profile
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Branch Modal -->
  <div class="modal fade" id="addBranchModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Branch</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="addBranchForm">
            <div class="mb-3">
              <label for="branchName" class="form-label">Branch Name</label>
              <input type="text" class="form-control" id="branchName" required>
            </div>
            <div class="mb-3">
              <label for="branchLocation" class="form-label">Location</label>
              <input type="text" class="form-control" id="branchLocation" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Service Modal -->
  <div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Service</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="addServiceForm">
            <div class="mb-3">
              <label for="serviceName" class="form-label">Service Name</label>
              <input type="text" class="form-control" id="serviceName" required>
            </div>
            <div class="mb-3">
              <label for="serviceDescription" class="form-label">Description</label>
              <textarea class="form-control" id="serviceDescription" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <!-- jQuery (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <!-- FullCalendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <!-- Custom JS -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Initialize DataTables
      $('#branchesTable').DataTable({
        ajax: 'api/branches.json', // Replace with your API endpoint
        columns: [
          { data: 'id' },
          { data: 'name' },
          { data: 'location' },
          {
            data: null,
            render: function (data) {
              return `
                <button class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              `;
            }
          }
        ]
      });

      $('#servicesTable').DataTable({
        ajax: 'api/services.json', // Replace with your API endpoint
        columns: [
          { data: 'id' },
          { data: 'name' },
          { data: 'description' },
          {
            data: null,
            render: function (data) {
              return `
                <button class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i></button>
                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              `;
            }
          }
        ]
      });

      // Initialize FullCalendar
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'api/bookings.json', // Replace with your API endpoint
      });
      calendar.render();

      // Navigation between modules
      document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
          this.classList.add('active');
          document.querySelectorAll('.module').forEach(module => module.style.display = 'none');
          document.querySelector(this.getAttribute('href')).style.display = 'block';
        });
      });
    });
  </script>
</body>
</html>