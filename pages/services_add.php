<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description  = $_POST['description'];
  $hourly_rate  = $_POST['hourly_rate'];
  $is_active    = $_POST['is_active'];

  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);

    header("Location: /PHPDB/pages/services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Service</title>
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Add Service</h2>
  <hr>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" action="/PHPDB/pages/services_add.php">
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Service Name <span class="text-danger">*</span></label>
      <input type="text" name="service_name" class="form-control"
             value="<?php echo isset($_POST['service_name']) ? htmlspecialchars($_POST['service_name']) : ''; ?>">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Hourly Rate (₱) <span class="text-danger">*</span></label>
      <input type="text" name="hourly_rate" class="form-control"
             value="<?php echo isset($_POST['hourly_rate']) ? htmlspecialchars($_POST['hourly_rate']) : ''; ?>">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Active?</label>
      <select name="is_active" class="form-select">
        <option value="1" <?php echo (isset($_POST['is_active']) && $_POST['is_active'] == '1') ? 'selected' : ''; ?>>Yes</option>
        <option value="0" <?php echo (isset($_POST['is_active']) && $_POST['is_active'] == '0') ? 'selected' : ''; ?>>No</option>
      </select>
    </div>
    <button type="submit" name="save" class="btn btn-primary">Save Service</button>
    <a href="/PHPDB/pages/services_list.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>