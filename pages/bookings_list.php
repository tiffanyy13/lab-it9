<?php
include "../db.php";
 
$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Bookings</h2>
    <a href="bookings_create.php" class="btn btn-primary">+ Create Booking</a>
  </div>

  <table class="table table-bordered table-striped table-hover align-middle bg-white">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Service</th>
        <th>Date</th>
        <th>Hours</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($b = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $b['booking_id']; ?></td>
          <td><?php echo htmlspecialchars($b['client_name']); ?></td>
          <td><?php echo htmlspecialchars($b['service_name']); ?></td>
          <td><?php echo $b['booking_date']; ?></td>
          <td><?php echo $b['hours']; ?></td>
          <td>₱<?php echo number_format($b['total_cost'], 2); ?></td>
          <td>
            <?php
              $badgeClass = match($b['status']) {
                'PAID'      => 'bg-success',
                'PENDING'   => 'bg-warning text-dark',
                'CANCELLED' => 'bg-danger',
                default     => 'bg-secondary'
              };
            ?>
            <span class="badge <?php echo $badgeClass; ?>"><?php echo $b['status']; ?></span>
          </td>
          <td>
            <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn btn-sm btn-outline-primary">
              Process Payment
            </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>