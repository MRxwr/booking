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
  <style>
    .module { display: none; }
    .module.active { display: block; }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 bg-light p-3">
        <h3>Vendor Panel</h3>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#branches" data-module="branches">Branches</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services" data-module="services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#bookings" data-module="bookings">Bookings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#profile" data-module="profile">Profile</a>
          </li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-9 p-3">
        <!-- Branches Module -->
        <div id="branches" class="module active">
          <h2>Branches</h2>
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
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBranchModal">Add Branch</button>
        </div>

        <!-- Services Module -->
        <div id="services" class="module">
          <h2>Services</h2>
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
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</button>
        </div>

        <!-- Bookings Module -->
        <div id="bookings" class="module">
          <h2>Bookings</h2>
          <div id="calendar"></div>
        </div>

        <!-- Profile Module -->
        <div id="profile" class="module">
          <h2>Profile</h2>
          <form id="profileForm">
            <div class="mb-3">
              <label for="vendorName" class="form-label">Vendor Name</label>
              <input type="text" class="form-control" id="vendorName" required>
            </div>
            <div class="mb-3">
              <label for="vendorEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="vendorEmail" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Profile</button>
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
                <button class="btn btn-sm btn-warning">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
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
                <button class="btn btn-sm btn-warning">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
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
          document.querySelectorAll('.module').forEach(module => {
            module.classList.remove('active');
          });
          document.querySelector(this.getAttribute('href')).classList.add('active');
        });
      });
    });
  </script>
</body>
</html>