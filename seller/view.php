<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 20px;
    }

    h2 {
        color: #333;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        margin: 0 auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    input[type="file"],
    input[type="submit"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Reed's Phone Shop</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="add_phones.php">Add Product</a></li>
        <li class="active"><a href="view.php">View Phones</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
      </ul>
    </div>
  </div>
</nav> 
<div class="container">

<?php
// Include database configuration
include 'config.php';

// SQL query to select all rows from 'phones' table
$sql = "SELECT * FROM phones";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Image</th>';
    echo '<th>Brand</th>';
    echo '<th>Model</th>';
    echo '<th>Price</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td><img src="' . $row["image"] . '" alt="Phone Image" width="100px"></td>';
        echo '<td>' . $row["brand"] . '</td>';
        echo '<td>' . $row["model"] . '</td>';
        echo '<td>' . $row["price"] . '</td>';
        echo '<td>';
        echo '<a href="#" data-toggle="modal" data-target="#editModal" 
                data-phoneid="' . $row["phone_id"] . '" 
                data-brand="' . $row["brand"] . '" 
                data-model="' . $row["model"] . '" 
                data-price="' . $row["price"] . '" 
                data-image="' . $row["image"] . '" 
                class="btn btn-primary edit-button">Edit</a>';
        echo '<a href="#" data-toggle="modal" data-target="#deleteModal" data-phoneid="' . $row["phone_id"] . '" class="btn btn-danger">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo "No records found";
}

// Close connection
mysqli_close($conn);
?>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Phone Details</h4>
      </div>
      <div class="modal-body">
        <!-- Form for editing phone details -->
        <form id="editForm" enctype="multipart/form-data">
          <!-- Input fields for editing -->
          <label for="editBrand">Brand:</label>
          <input type="text" id="editBrand" name="editBrand">

          <label for="editModel">Model:</label>
          <input type="text" id="editModel" name="editModel">

          <label for="editPrice">Price:</label>
          <input type="number" id="editPrice" name="editPrice">

          <label for="editImage">Image:</label>
          <input type="file" id="editImage" name="editImage">

          <input type="hidden" id="editPhoneId" name="editPhoneId">
          <!-- Hidden input for storing phone ID -->

          <!-- Submit button for form -->
          <input type="submit" value="Save Changes" class="btn btn-success">
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Phone</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this phone?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).ready(function(){
    $('.edit-button').on('click', function(){
        var phoneId = $(this).data('phoneid');
        var brand = $(this).data('brand');
        var model = $(this).data('model');
        var price = $(this).data('price');

        $('#editPhoneId').val(phoneId);
        $('#editBrand').val(brand);
        $('#editModel').val(model);
        $('#editPrice').val(price);
    });
});

// AJAX request to edit phone
$('#editForm').on('submit', function (e) {
  e.preventDefault(); // Prevent default form submission
  var formData = new FormData(this); // Create FormData object
  $.ajax({
    type: 'POST',
    url: 'edit.php',
    data: formData,
    contentType: false, // Don't set contentType
    processData: false, // Don't process the data
    success: function (response) {
      // Handle success response
      console.log(response);
      // Show success message with SweetAlert
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Phone edited successfully!',
        timer: 1500 // Automatically close after 1.5 seconds
      }).then(function () {
        location.reload(); // Reload the page after successful edit
      });
    },
    error: function (xhr, status, error) {
      // Handle error response
      console.error(xhr.responseText);
      // Show error message with SweetAlert
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error editing phone. Please try again.'
      });
    }
  });
});

</script>
