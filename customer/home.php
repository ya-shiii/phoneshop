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
          <li><a href="account.php">My Account</a></li>
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
    echo '<div class="card" style="height: 400px; margin-bottom: 20px; padding: 40px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">';
    echo '<div class="row">';
    echo '<div class="col-12">';
    echo '<img src="../seller/' . $row["image"] . '" alt="Phone Image" style="width: 100%; height: 200px; object-fit: cover; border-radius: 5px;">';
    echo '</div>';
    echo '<div class="col-12">';
    echo '<h5 class="card-title"><b>' . $row["brand"] . '</b><br><br>' . $row["model"] . '</h5>';
    echo '<p class="card-text"><strong>Price:</strong> Php ' . $row["price"] . '.00</p>';
    if ($row['quantity'] == '0') {
      echo '<p class="card-text"><i>Out of stock</i></p>';
    } else {
      echo '<a href="#" data-phoneid="' . $row["phone_id"] . '" 
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

  <script>
    $(document).ready(function () {
      $('.checkout-button').on('click', function (e) {
        e.preventDefault();
        var phoneId = $(this).data('phoneid');
        var brand = $(this).data('brand');
        var model = $(this).data('model');
        var userId = '<?php echo $userId; ?>';
        var fname = '<?php echo htmlspecialchars($f_name); ?>';
        var lname = '<?php echo htmlspecialchars($l_name); ?>';

        $.ajax({
          type: 'POST',
          url: 'add_to_cart.php',
          data: {
            phoneId: phoneId,
            userId: userId,
            checkoutBrand: brand,
            checkoutModel: model,
            checkoutFname: fname,
            checkoutLname: lname,
            checkoutAddress: '' // Pass an empty address since it's not provided
          },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Order placed successfully!',
              timer: 1500
            }).then(function () {
              window.location.href = 'cart.php'; 
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
