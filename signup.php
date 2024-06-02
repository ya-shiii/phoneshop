<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="css/all.min.css">

    <head>
        <!-- Other meta tags and stylesheets -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- Your other scripts and styles -->
    </head>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus {
            border-color: #007bff;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .social-login {
            text-align: center;
            margin-top: 20px;
        }

        .social-login p {
            margin-bottom: 10px;
        }

        .social-login a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .social-login a i {
            margin-right: 10px;
        }

        .facebook {
            background-color: #3b5998;
        }

        .gmail {
            background-color: #db4437;
        }

        .social-login a:hover {
            background-color: #333;
        }

        .container img {
            display: block;
            margin: 0 auto;
            width: 50%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            background-color: light;
            border: 1px solid #007bff;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-button:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('date_created').setAttribute('min', today);
        });
    </script>
</head>

<body>
    <div class="container">
        <!-- Add an image here -->
        <img src="img/logo.jpg" alt="Phone Shop">

        <div class="container">
            <h2>Sign Up</h2>
            <form action="signup.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="date" id="date_created" name="date_created" placeholder="Date Created" required><br></br>
                <input type="submit" value="Sign Up">
            </form>
            <p>Already have an account?</p>
            <a href="index.php" class="back-button">Back to Login</a>
        </div>
    </div>
</body>

</html>
<?php
include 'conn/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Store password as plain text
    $confirm_password = $_POST['confirm_password'];
    $date_created = $_POST['date_created'];

    // Check for duplicate username or email
    $duplicateCheck = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($duplicateCheck);
    if ($result->num_rows > 0) {
        // If duplicate entries found, show error message
        echo "<script>Swal.fire('Oops!', 'Username or Email already exists!', 'error');</script>";
    } else {
        // If passwords match, proceed with insertion
        if ($password == $confirm_password) {
            $sql = "INSERT INTO users (username, fname, lname, email, password, date_created, `role`)
                    VALUES ('$username', '$fname', '$lname', '$email', '$password', '$date_created', 'customer')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>Swal.fire('Success!', 'Registered Successfully!', 'success');window.location.href = 'index.php';</script>";
            } else {
                echo "<script>Swal.fire('Error!', 'Error: " . $sql . "<br>" . $conn->error . "', 'error');</script>";
            }
        } else {
            // If passwords don't match, show error message
            echo "<script>Swal.fire('Oops!', 'Passwords do not match!', 'error');</script>";
        }
    }
}

$conn->close();
?>
