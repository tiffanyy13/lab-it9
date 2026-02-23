<?php // nav.php ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/PHPDB/index.php">Client Management</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/PHPDB/index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/PHPDB/pages/clients_list.php">Clients</a></li>
        <li class="nav-item"><a class="nav-link" href="/PHPDB/pages/services_list.php">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="/PHPDB/pages/bookings_list.php">Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="/PHPDB/pages/tools_list_assign.php">Tools</a></li>
        <li class="nav-item"><a class="nav-link" href="/PHPDB/pages/payments_list.php">Payments</a></li>
      </ul>
    </div>
  </div>
</nav>