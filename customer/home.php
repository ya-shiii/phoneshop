<?php
session_start();
include 'config.php';

$userId = $f_name = $l_name = '';

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $userSql = "SELECT fname, lname FROM users WHERE id=$userId";
  $userResult = mysqli_query($conn, $userSql);
  if ($userResult && mysqli_num_rows($userResult) > 0) {
    $user = mysqli_fetch_assoc($userResult);
    $f_name = $user['fname'];
    $l_name = $user['lname'];
  }
}

$sql = "SELECT * FROM phones";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home - Reed's Phone Shop</title>
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
    border-radius: 5px;
    margin: 0 auto;
  }

  .navbar {
    margin-bottom: 20px;
  }

  .card {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
          <li class="active"><a href="home.php">Shop</a></li>
          <li><a href="cart.php">My Cart</a></li>
          <li><a href="order.php">My Orders</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="../logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <h1>Reeve Shop</h1>

  <?php
  // Fetch phone details
  $phoneSql = "SELECT * FROM phones";
  $phoneResult = mysqli_query($conn, $phoneSql);

  echo '<div class="container">';
  echo '<div class="row">';

  $count = 0; 
  while ($row = mysqli_fetch_assoc($phoneResult)) {
    if ($count % 4 == 0 && $count != 0) { 
      echo '</div><div class="row">';
    }

    echo '<div class="p-5 col-lg-3 col-md-4 col-sm-6">'; 
    echo '<div class="card" style="height: 350px; margin-bottom: 20px; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">';
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<img src="../seller/' . $row["image"] . '" alt="Phone Image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">';
    echo '</div>';
    echo '<div class="col-12">';
    echo '<h5 class="card-title fw-bold">' . $row["brand"] . '<br><br>' . $row["model"] . '</h5>';
    echo '<p class="card-text"><strong>Price:</strong> $' . $row["price"] . '</p>';
    if ($row['quantity'] == '0') {
      echo '<p class="card-text"><i>Out of stock</i></p>';
    } else {
      echo '<a href="#" data-toggle="modal" data-target="#checkoutModal" 
                data-phoneid="' . $row["phone_id"] . '" 
                data-brand="' . $row["brand"] . '" 
                data-model="' . $row["model"] . '" 
                class="btn btn-primary checkout-button">Add to Cart</a>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    $count++;
  }

  echo '</div>'; 
  echo '</div>';
  ?>





  </div>

  <!-- Checkout Modal -->
  <div id="checkoutModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add to Cart</h4>
        </div>
        <div class="modal-body">
          <form id="checkoutForm">
            <input type="hidden" id="phoneId" name="phoneId">
            <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">

            <label for="checkoutBrand">Brand:</label><br>
            <input type="text" id="checkoutBrand" name="checkoutBrand" readonly><br>

            <label for="checkoutModel">Model:</label><br>
            <input type="text" id="checkoutModel" name="checkoutModel" readonly><br>

            <label for="checkoutFname">First Name:</label><br>
            <input type="text" id="checkoutFname" name="checkoutFname" readonly
              value="<?php echo htmlspecialchars($f_name); ?>"><br>

            <label for="checkoutLname">Last Name:</label><br>
            <input type="text" id="checkoutLname" name="checkoutLname" readonly
              value="<?php echo htmlspecialchars($l_name); ?>"><br>

            <label for="checkoutAddress">Address:</label><br>
            <input type="text" id="checkoutAddress" name="checkoutAddress" required><br>

            <input type="submit" value="Place Order" class="btn btn-success"><br>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('.checkout-button').on('click', function () {
        var phoneId = $(this).data('phoneid');
        var brand = $(this).data('brand');
        var model = $(this).data('model');

        $('#phoneId').val(phoneId);
        $('#checkoutBrand').val(brand);
        $('#checkoutModel').val(model);
      });

      $('#checkoutForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: 'POST',
          url: 'add_to_cart.php',
          data: formData,
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order placed successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'home.php'; 
            });
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error placing order. Please try again.'
            });
          }
        });
      });
    });
  </script>
</body>

</html>