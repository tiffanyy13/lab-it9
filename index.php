<?php
include "db.php";

$clients  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];

$revRow  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "nav.php"; ?>

<div class="container mt-4">
  <h2>Dashboard</h2>
  <hr>

  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h6 class="card-title text-muted">Total Clients</h6>
          <h3><?php echo $clients; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h6 class="card-title text-muted">Total Services</h6>
          <h3><?php echo $services; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h6 class="card-title text-muted">Total Bookings</h6>
          <h3><?php echo $bookings; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h6 class="card-title text-muted">Total Revenue</h6>
          <h3>₱<?php echo number_format($revenue, 2); ?></h3>
        </div>
      </div>
    </div>
  </div>

  <p>Quick links:
    <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-sm btn-primary">Add Client</a>
    <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-sm btn-secondary">Create Booking</a>
  </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>