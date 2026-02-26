<?php
include "../db.php";

$booking_id = $_GET['booking_id'];

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));

$paidRow    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];

$balance = $booking['total_cost'] - $total_paid;
$message = "";

if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];

  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");

    $paidRow2   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
    $new_balance = $booking['total_cost'] - $total_paid2;

    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }

    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Process Payment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Process Payment <span class="text-muted fs-5">(Booking #<?php echo $booking_id; ?>)</span></h2>
  <hr>

  <?php if ($message): ?>
    <div class="alert alert-danger" style="max-width: 540px;"><?php echo $message; ?></div>
  <?php endif; ?>

  <div class="card shadow-sm mb-4" style="max-width: 540px;">
    <div class="card-body">
      <h6 class="card-title text-muted">Booking Summary</h6>
      <p class="mb-1"><strong>Total Cost:</strong> ₱<?php echo number_format($booking['total_cost'], 2); ?></p>
      <p class="mb-1"><strong>Total Paid:</strong> ₱<?php echo number_format($total_paid, 2); ?></p>
      <p class="mb-0"><strong>Balance:</strong> <span class="text-danger">₱<?php echo number_format($balance, 2); ?></span></p>
    </div>
  </div>

  <div class="card shadow-sm" style="max-width: 540px;">
    <div class="card-body">
      <form method="post">

        <div class="mb-3">
          <label class="form-label fw-semibold">Amount Paid</label>
          <div class="input-group">
            <span class="input-group-text">₱</span>
            <input type="number" name="amount_paid" class="form-control" step="0.01">
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Method</label>
          <select name="method" class="form-select">
            <option value="CASH">CASH</option>
            <option value="GCASH">GCASH</option>
            <option value="CARD">CARD</option>
          </select>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" name="pay" class="btn btn-primary">Save Payment</button>
          <a href="bookings_list.php" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>