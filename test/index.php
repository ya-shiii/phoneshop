<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iPhone 15 Pro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            background-color: #f8f8f8;
            padding: 20px;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            margin: 0 10px;
        }
        .header {
            text-align: center;
            margin-top: 50px;
        }
        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        .subheader {
            color: #777;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .iphone-image {
            width: 100%;
            max-width: 600px;
            display: block;
            margin: 0 auto;
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
        .apple-logo, .cart-logo {
            width: 40px;
            height: 40px;
            background-size: cover;
        }
        .apple-logo {
            background-image: url('path-to-apple-logo.png');
        }
        .cart-logo {
            background-image: url('path-to-cart-logo.png');
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#">Manage User</a>
        <a href="manageproduct.php">Manage Product</a>
        <a href="viewDevice.php">View Product</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="header">
        <h1>iPhone 15 Pro</h1>
        <p class="subheader">Titanium. So strong. So light. So pro.</p>
        <img src="https://www.dpreview.com/files/p/articles/2736517948/Apple-iPhone-15-Pro-lineup-Action-button-230912.jpeg" alt="iPhone 15 Pro" class="iphone-image">
    </div>
    <div class="logo-container">
        <div class="apple-logo"></div>
        <div class="cart-logo"></div>
    </div>
</body>
</html>
