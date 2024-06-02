<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .login-container {
            background-color: #ffffff;
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        button {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
        }
        /* Signup button styles */
        .signup-btn {
            background-color: #28a745;
        }
        .signup-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="img/logo.jpg" alt="Logo">
        </div>
        <h2>Login</h2>
        <form action="index.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Login</button>
        </form>
        <!-- Signup button -->
        <center><button class="signup-btn" onclick="window.location.href='signup.php'">Sign Up</button></center>
    </div>
</body>
</html>
<?php
session_start();
include 'conn/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];

        if ($row['role'] == 'admin') {
            // Admin login successful
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Admin Login Successful',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'admin/dashboard.php';
                    });
                  </script>";
        } else if ($row['role'] == 'seller') {
            // Seller login successful
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Seller Login Successful',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'seller/dashboard.php';
                    });
                  </script>";
        } else  {
            // Non-admin user login successful
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login successful',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = 'customer/home.php';
                    });
                  </script>";
        }
    } else {
        // Login failed
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid username or password',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'index.php';
                });
              </script>";
    }
}
?>


