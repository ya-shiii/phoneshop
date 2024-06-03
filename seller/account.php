<?php
session_start();
include '../conn/config.php';

// Check if the user is logged in and set the session variables
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $userSql = "SELECT * FROM users WHERE id=$userId";
  $userResult = mysqli_query($conn, $userSql);
  if ($userResult && mysqli_num_rows($userResult) > 0) {
    $user = mysqli_fetch_assoc($userResult);
    $u_name = $user['username'];
    $f_name = $user['fname'];
    $l_name = $user['lname'];
    $password = $user['password'];
    $email = $user['email'];
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Account</title>
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
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="add_phones.php">Add Product</a></li>
          <li><a href="view.php">View Phones</a></li>
          <li class="active"><a href="account.php">My Account</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2>My Account</h2>
    <div>
      <div class="modal-body">
        <form id="editForm">
          <div class="form-group">
            <label for="editUsername">Username:</label>
            <input type="text" class="form-control" id="editUsername" name="editUsername"
              value="<?php echo htmlspecialchars($u_name); ?>">
          </div>

          <div class="form-group">
            <label for="editPassword">Password:</label>
            <input type="password" class="form-control" id="editPassword" name="editPassword"
              value="<?php echo htmlspecialchars($password); ?>">
          </div>

          <div class="form-group">
            <label for="editFname">First Name:</label>
            <input type="text" class="form-control" id="editFname" name="editFname"
              value="<?php echo htmlspecialchars($f_name); ?>">
          </div>

          <div class="form-group">
            <label for="editLname">Last Name:</label>
            <input type="text" class="form-control" id="editLname" name="editLname"
              value="<?php echo htmlspecialchars($l_name); ?>">
          </div>

          <div class="form-group">
            <label for="editEmail">Email:</label>
            <input type="email" class="form-control" id="editEmail" name="editEmail"
              value="<?php echo htmlspecialchars($email); ?>">
          </div>

          <input type="hidden" id="editUserId" name="editUserId" value="<?php echo $userId; ?>">
          <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
      </div>
    </div>
  </div>



  <script>
    $(document).ready(function () {
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