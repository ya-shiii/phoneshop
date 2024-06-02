<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Users</title>
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

  .container {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    margin: 0 auto;
  }

  .navbar {
    margin-bottom: 20px;
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
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li class="active"><a href="dashboard.php">Dashboard</a></li>
          <li><a href="add_phones.php">Add Product</a></li>
          <li><a href="view.php">View Phones</a></li>
          <li><a href="orders.php">View Orders</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h2>View Users</h2>

    <?php
    // Include database configuration
    include '../conn/config.php';

    // SQL query to select all rows from 'users' table
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
      echo '<table class="table table-bordered">';
      echo '<thead>';
      echo '<tr>';
      echo '<th>ID</th>';
      echo '<th>Username</th>';
      echo '<th>First Name</th>';
      echo '<th>Last Name</th>';
      echo '<th>Email</th>';
      echo '<th>Role</th>';
      echo '<th>Date Created</th>';
      echo '<th>Action</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row["id"] . '</td>';
        echo '<td>' . $row["username"] . '</td>';
        echo '<td>' . $row["fname"] . '</td>';
        echo '<td>' . $row["lname"] . '</td>';
        echo '<td>' . $row["email"] . '</td>';
        echo '<td>' . $row["role"] . '</td>';
        echo '<td>' . $row["date_created"] . '</td>';
        echo '<td>';
        echo '<a href="#" data-toggle="modal" data-target="#editModal" 
                  data-userid="' . $row["id"] . '" 
                  data-username="' . $row["username"] . '" 
                  data-fname="' . $row["fname"] . '" 
                  data-lname="' . $row["lname"] . '" 
                  data-email="' . $row["email"] . '" 
                  data-role="' . $row["role"] . '" 
                  class="btn btn-primary edit-button">Edit</a>';
        echo ' ';
        echo '<a href="#" data-toggle="modal" data-target="#deleteModal" data-userid="' . $row["id"] . '" class="btn btn-danger delete-button">Delete</a>';
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
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit User Details</h4>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="form-group">
              <label for="editUsername">Username:</label>
              <input type="text" class="form-control" id="editUsername" name="editUsername">
            </div>

            <div class="form-group">
              <label for="editFname">First Name:</label>
              <input type="text" class="form-control" id="editFname" name="editFname">
            </div>

            <div class="form-group">
              <label for="editLname">Last Name:</label>
              <input type="text" class="form-control" id="editLname" name="editLname">
            </div>

            <div class="form-group">
              <label for="editEmail">Email:</label>
              <input type="email" class="form-control" id="editEmail" name="editEmail">
            </div>

            <div class="form-group">
              <label for="editRole">Role:</label>
              <select class="form-control" id="editRole" name="editRole">
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
                <option value="seller">Seller</option>
              </select>
            </div>

            <input type="hidden" id="editUserId" name="editUserId">
            <button type="submit" class="btn btn-success">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Delete Modal -->
  <div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete User</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this user?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('.edit-button').on('click', function () {
        var userId = $(this).data('userid');
        var username = $(this).data('username');
        var fname = $(this).data('fname');
        var lname = $(this).data('lname');
        var email = $(this).data('email');
        var role = $(this).data('role');

        $('#editUserId').val(userId);
        $('#editUsername').val(username);
        $('#editFname').val(fname);
        $('#editLname').val(lname);
        $('#editEmail').val(email);
        $('#editRole').val(role);
      });

      $('.delete-button').on('click', function () {
        var userId = $(this).data('userid');
        $('#confirmDelete').data('userid', userId);
      });

      $('#confirmDelete').on('click', function () {
        var userId = $(this).data('userid');
        $.ajax({
          type: 'POST',
          url: 'delete_user.php',
          data: { userId: userId },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'User deleted successfully!',
              timer: 1500
            }).then(function () {
              location.reload();
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error deleting user. Please try again.'
            });
          }
        });
      });

      $('#editForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: 'POST',
          url: 'edit_user.php',
          data: formData,
          success: function (response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status === "success") {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: jsonResponse.message,
                timer: 1500
              }).then(function () {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: jsonResponse.message
              });
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error editing user. Please try again.'
            });
          }
        });
      });

    });
  </script>

</body>

</html>