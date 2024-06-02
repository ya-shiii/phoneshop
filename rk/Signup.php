<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #FFC96F; /* Changed to a blueish color */
    }
    .login-container {
      background-color: rgba(255, 255, 255, 0.8); /* Transparent white */
      padding: 20px;
      border-radius: 5px;
      margin-top: 50px;
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #ff523b; /* Red text color */
    }
    .login-container input[type="text"],
    .login-container input[type="password"],
    .login-container input[type="email"],
    .login-container input[type="date"],
    .login-container select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #fff; /* White background */
    }
    .login-container input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      box-sizing: border-box;
      background-color: #ff523b; /* Red button color */
      color: #fff; /* White text color */
      cursor: pointer;
    }
    .login-container input[type="submit"]:hover {
      background-color: #ff785b; /* Darker red on hover */
    }
    .login-container a {
      text-decoration: none;
      color: #ff523b; /* Red text color */
      font-weight: bold;
      display: block;
      text-align: center;
      margin-top: 10px;
    }
    .login-container a:hover {
      text-decoration: underline; /* Underline on hover */
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="login-container">
        <h2>Sign Up</h2>
        <form id="signupForm" action="Ssighnup.php" method="POST">
          <div id="personalInfo">
        
            
            <input type="text" name="uname" id="uname" placeholder="Uname" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
          
            <input type="submit" value="Sign Up">
          </div>
        </form>
        <a href="Login.php">Already have an account? Log in</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
    $("#nextStep").click(function(){
      // Check if all required fields are filled
      var valid = true;
      $("#personalInfo :input[required]").each(function(){
        if($(this).val() === ""){
          valid = false;
          return false;
        }
      });
      if(valid){
        $("#personalInfo").hide();
        $("#accountInfo").show();
      } else {
        alert("Please fill out all required fields.");
      }
    });
  });
</script>

</body>
</html>
