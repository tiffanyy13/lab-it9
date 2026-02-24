<?php
include "../db.php";
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
  <h2>Services</h2>
  <hr>

  <table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Rate</th>
        <th>Active</th>
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
            <?php if($row['is_active']): ?>
              <span class="badge bg-success">Yes</span>
            <?php else: ?>
              <span class="badge bg-secondary">No</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>