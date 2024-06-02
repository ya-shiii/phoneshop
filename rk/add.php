<?php
session_start();

if (!isset($_SESSION['UserID'])) {
    // Redirect to login page if not logged in
    header('Location: Login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>.:: Allan Rey System ::.</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #FBF8DD;
      color: #A34343;
    }
    .navbar {
      background-color: #E9C874;
    }
    .navbar-brand img {
      filter: invert(1);
    }
    .navbar-dark .navbar-nav .nav-link {
      color: #A34343;
    }
    .navbar-dark .navbar-nav .nav-link:hover {
      color: #C0D6E8;
    }
    .form-control {
      background-color: #E9C874;
      color: #A34343;
      border-color: #C0D6E8;
    }
    .form-control:focus {
      background-color: #E9C874;
      color: #A34343;
      border-color: #C0D6E8;
      box-shadow: 0 0 0 0.2rem #C0D6E8;
    }
    .btn-primary {
      background-color: #C0D6E8;
      border-color: #C0D6E8;
    }
    .btn-primary:hover {
      background-color: #A34343;
      border-color: #A34343;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark">
  <a class="navbar-brand" href="index.php">
    <img src="img/logo.png" alt="Logo" style="width:40px;">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
    <?php if($_SESSION['UserType'] == 'admin' || $_SESSION['UserType'] == 'seller') { ?>
        <li class="nav-item">
          <a class="nav-link" href="add.php">Add</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="view.php">View</a>
      </li>
      <?php if($_SESSION['UserType'] == 'admin') { ?>
        <li class="nav-item">
          <a class="nav-link" href="update.php">Update</a>
        </li>
        <?php } ?>
        <?php if($_SESSION['UserType'] == 'admin') { ?>
        <li class="nav-item">
          <a class="nav-link" href="delete.php">Delete</a>
        </li>
      <?php } ?>
     
        <li class="nav-item">
          <a class="nav-link" href="search.php">Search </a>
        </li>
  
      <li class="nav-item">
        <a class="nav-link" href="Logout.php">Logout</a>
      </li>
    </ul>
  </div>  
</nav>
<br>

<div class="container">
  <h1>Add T-Shirt </h1>
		
  <form action="save.php" method="post" enctype="multipart/form-data">

    
    <div class="form-group">
      <label for="shirt">Shirt:</label>
      <input type="text" class="form-control" id="shirt" name="shirt" required>
    </div>
    <div class="form-group">
      <label for="size">Size:</label>
      <select class="form-control" id="size" name="size" required>
        <option value="XS">XS</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
      </select>
    </div>
    <div class="form-group">
      <label for="color">Color:</label>
      <input type="text" class="form-control" id="color" name="color" required>
    </div>
     <div class="form-group">
            <label for="image">Photos:</label>
            <div class="input-group">
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="product_image" onchange="previewImage()" required>
                <label class="custom-file-label" for="image">Choose from existing images</label>
                </div>
            </div>
    <div class="form-group">
      <img id="preview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px;">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</div>

<script>
function previewPhoto(input) {
  var preview = document.getElementById('preview');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

</body>
</html>
