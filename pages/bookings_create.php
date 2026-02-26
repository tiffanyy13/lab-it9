<?php
include "../db.php";
 
$clients  = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id    = $_POST['client_id'];
  $service_id   = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours        = $_POST['hours'];
 
  $s    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Create Booking</h2>
  <hr>

  <div class="card shadow-sm" style="max-width: 540px;">
    <div class="card-body">
      <form method="post">

        <div class="mb-3">
          <label class="form-label fw-semibold">Client</label>
          <select name="client_id" class="form-select">
            <?php while($c = mysqli_fetch_assoc($clients)) { ?>
              <option value="<?php echo $c['client_id']; ?>">
                <?php echo htmlspecialchars($c['full_name']); ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Service</label>
          <select name="service_id" class="form-select">
            <?php while($s = mysqli_fetch_assoc($services)) { ?>
              <option value="<?php echo $s['service_id']; ?>">
                <?php echo htmlspecialchars($s['service_name']); ?> (₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr)
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Date</label>
          <input type="date" name="booking_date" class="form-control">
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Hours</label>
          <input type="number" name="hours" class="form-control" min="1" value="1">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" name="create" class="btn btn-primary">Create Booking</button>
          <a href="bookings_list.php" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>