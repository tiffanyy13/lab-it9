<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $address   = $_POST['address'];

  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    if (mysqli_query($conn, $sql)) {
      header("Location: /PHPDB/pages/clients_list.php");
      exit;
    } else {
      $message = "Error: " . mysqli_error($conn);
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Client</title>
</head>
<body class="bg-light">

<?php include "../nav.php"; ?>

<div class="container mt-4">
  <h2>Add Client</h2>
  <hr>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?php echo $message; ?></div>
  <?php endif; ?>

  <form method="post" action="/PHPDB/pages/clients_add.php">
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Full Name <span class="text-danger">*</span></label>
      <input type="text" name="full_name" class="form-control">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Email <span class="text-danger">*</span></label>
      <input type="text" name="email" class="form-control">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="mb-3" style="max-width:500px;">
      <label class="form-label">Address</label>
      <input type="text" name="address" class="form-control">
    </div>
    <button type="submit" name="save" class="btn btn-primary">Save</button>
    <a href="/PHPDB/pages/clients_list.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>