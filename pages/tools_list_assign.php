<?php
include "../db.php";
 
$message = "";
$messageType = "";
 
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
    $messageType = "danger";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
    $message = "Tool assigned successfully!";
    $messageType = "success";
  }
}
 
$tools    = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tools</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Tools / Inventory</h2>
  <hr>

  <?php if ($message): ?>
    <div class="alert alert-<?php echo $messageType; ?>"><?php echo $message; ?></div>
  <?php endif; ?>

  <h5 class="mb-3">Available Tools</h5>
  <table class="table table-bordered table-striped table-hover align-middle bg-white mb-5">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Total</th>
        <th>Available</th>
      </tr>
    </thead>
    <tbody>
      <?php while($t = mysqli_fetch_assoc($tools)) { ?>
        <tr>
          <td><?php echo htmlspecialchars($t['tool_name']); ?></td>
          <td><?php echo $t['quantity_total']; ?></td>
          <td><?php echo $t['quantity_available']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <h5 class="mb-3">Assign Tool to Booking</h5>
  <div class="card shadow-sm" style="max-width: 540px;">
    <div class="card-body">
      <form method="post">

        <div class="mb-3">
          <label class="form-label fw-semibold">Booking ID</label>
          <select name="booking_id" class="form-select">
            <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
              <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Tool</label>
          <select name="tool_id" class="form-select">
            <?php
              $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
              while($t2 = mysqli_fetch_assoc($tools2)) {
            ?>
              <option value="<?php echo $t2['tool_id']; ?>">
                <?php echo htmlspecialchars($t2['tool_name']); ?> (Avail: <?php echo $t2['quantity_available']; ?>)
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Qty Used</label>
          <input type="number" name="qty_used" class="form-control" min="1" value="1">
        </div>

        <div class="d-flex gap-2">
          <button type="submit" name="assign" class="btn btn-primary">Assign</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>