<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log In</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #FFC96F;
    }
    .login-container {
      background-color: rgba(255, 255, 255, 0.8); 
      padding: 20px;
      border-radius: 5px;
      margin-top: 50px;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ff523b;
    }
    .login-container input[type="text"],
    .login-container input[type="password"],
    .login-container input[type="email"],
    .login-container input[type="date"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #fff; 
    }
    .login-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #ff523b; 
      color: #fff; 
      cursor: pointer;
    }
    .login-container input[type="submit"]:hover {
      background-color: #ff785b; 
    }
    .login-container a {
      text-decoration: none;
      color: #ff523b; 
      font-weight: bold;
      display: block;
      text-align: center;
    }
    .login-container a:hover {
      text-decoration: underline; 
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="login-container">
        <h2>Log in</h2>
        <form action="checkuser.php" method="POST">
          <input type="text" name="uname"  placeholder="Uname" required>
          <input type="password" name="password"  placeholder="Password" required>
          <input type="submit" value="Login">
        </form>
        <a href="Signup.php">Need an Account? Sign up</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

</body>
</html>
