<?php
include "../db.php";

if (!isset($_GET['id'])) {
  header("Location: /PHPDB/pages/clients_list.php");
  exit;
}

$id     = (int)$_GET['id'];
$get    = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);

if (!$client) {
  header("Location: /PHPDB/pages/clients_list.php");
  exit;
}

$message = "";

if (isset($_POST['update'])) {
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $address   = $_POST['address'];

  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "UPDATE clients
            SET full_name='$full_name', email='$email', phone='$phone', address='$address'
            WHERE client_id=$id";
    if (mysqli_query($conn, $sql)) {
      header("Location: /PHPDB/pages/clients_list.php");
      exit;
    } else {
      $message = "Error: " . mysqli_error($conn);
    }
  }
}

if (isset($_POST['delete'])) {
  mysqli_query($conn, "DELETE FROM clients WHERE client_id=$id");
  header("Location: /PHPDB/pages/clients_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Client</title>
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Edit Client</h2>
  <hr>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" action="/PHPDB/pages/clients_edit.php?id=<?php echo $id; ?>">
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Full Name <span class="text-danger">*</span></label>
      <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($client['full_name']); ?>">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Email <span class="text-danger">*</span></label>
      <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($client['email']); ?>">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($client['phone']); ?>">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Address</label>
      <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($client['address']); ?>">
    </div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="/PHPDB/pages/clients_list.php" class="btn btn-secondary">Cancel</a>
    <button type="submit" name="delete" class="btn btn-danger float-end"
      onclick="return confirm('Are you sure you want to delete this client?')">Delete</button>
  </form>
</div>

</body>
</html>