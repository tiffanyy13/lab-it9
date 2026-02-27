<?php
include "../db.php";


/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
  $delete_id = $_GET['delete_id'];


  // Soft delete (set is_active to 0)
  mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");


  header("Location: services_list.php");
  exit;
}


/* ============================
   FETCH ALL SERVICES
   ============================ */
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Services</h2>
    <a href="services_add.php" class="btn btn-primary">+ Add Service</a>
  </div>
  <hr>

  <table class="table table-bordered table-striped table-hover align-middle bg-white">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Rate</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['service_id']; ?></td>
          <td><?php echo $row['service_name']; ?></td>
          <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
          <td>
            <?php if ($row['is_active'] == 1): ?>
              <span class="badge bg-success">Active</span>
            <?php else: ?>
              <span class="badge bg-secondary">Inactive</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-primary">Edit</a>

            <?php if ($row['is_active'] == 1): ?>
              <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>"
                 class="btn btn-sm btn-warning"
                 onclick="return confirm('Deactivate this service?')">Deactivate</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>