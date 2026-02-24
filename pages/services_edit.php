<?php
include "../db.php";
$id = $_GET['id'];

$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);

if (isset($_POST['update'])) {
  $name   = $_POST['service_name'];
  $desc   = $_POST['description'];
  $rate   = $_POST['hourly_rate'];
  $active = $_POST['is_active'];

  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");

  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Service</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Edit Service</h2>
  <hr>

  <div class="card shadow-sm" style="max-width: 540px;">
    <div class="card-body">
      <form method="post">

        <div class="mb-3">
          <label class="form-label fw-semibold">Service Name</label>
          <input type="text" name="service_name" class="form-control"
                 value="<?php echo $service['service_name']; ?>">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="4"><?php echo $service['description']; ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Hourly Rate</label>
          <div class="input-group">
            <span class="input-group-text">₱</span>
            <input type="text" name="hourly_rate" class="form-control"
                   value="<?php echo $service['hourly_rate']; ?>">
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Active</label>
          <select name="is_active" class="form-select">
            <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
            <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
          </select>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" name="update" class="btn btn-primary">Update</button>
          <a href="services_list.php" class="btn btn-outline-secondary">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>