<?php
include "../db.php";

$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Payments</h2>
  <hr>

  <table class="table table-bordered table-striped table-hover align-middle bg-white">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Booking ID</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while($p = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $p['payment_id']; ?></td>
          <td><?php echo htmlspecialchars($p['full_name']); ?></td>
          <td><?php echo $p['booking_id']; ?></td>
          <td>₱<?php echo number_format($p['amount_paid'], 2); ?></td>
          <td><?php echo $p['method']; ?></td>
          <td><?php echo $p['payment_date']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>