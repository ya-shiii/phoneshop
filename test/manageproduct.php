<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Device</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* General Styles */
        body {
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-top: 50px;
        }

        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
            color: #000;
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

        /* Navigation Menu Styles */
        nav {
            display: flex;
            justify-content: space-around;
            background-color: #f8f8f8;
            padding: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            margin: 0 10px;
        }

        /* Add Container Styles */
        .add-container {
            background-color: #D3BA9C;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 90%;
            margin: 20px auto;
            text-align: center;
            flex-grow: 1;
            position: relative;
        }

        .add-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin-top: 70px;
            margin-bottom: 50px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .add-container h2 {
            font-size: 30px;
            margin: 0 auto 50px auto;
            font-family: 'Italiana', serif;
            color: black;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 15px 30px;
            background-color: #8B4513;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 20px;
        }

        input[type="submit"]:hover {
            background-color: #654321;
        }

        /* Back to Home Styles */
        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #e2e8f0;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }

        .back-to-home a {
            color: #3b517d;
            text-decoration: none;
            font-size: 20px;
        }

        .back-to-home a:hover {
            text-decoration: underline;
        }

        /* Footer Styles */
        .footer {
            background-color: #C1A286;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

    </style>
</head>
<body>
    <!-- Navigation menu -->
    <nav>
        <a href="#">Manage User</a>
        <a href="manageproduct.php">Manage Product</a>
        <a href="viewDevice.php">View Product</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="add-container">
        <div class="back-to-home">
            <a href="viewDevice.php">&#8592;</a>
        </div>
        <div class="container">
            <div class="content">
                <h2>Add Device</h2>
                
                <form action="saveproduct.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Device Image</label>
                        <input type="file" name="image" id="image" accept="image/*" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Device Name:</label>
                        <input type="text" id="name" name="name" required placeholder="Enter Device Name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required placeholder="Enter Device Description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required placeholder="Enter Quantity">
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" step="0.01" id="price" name="price" required placeholder="Enter Price">
                    </div>

                    <div class="form-group">
                        <label for="stock">In Stock:</label>
                        <select name="stock" id="stock" required>
                            <option value="" disabled selected>Select Stock Status</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <input type="submit" name="submit" value="Add Device" class="form-btn">
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        &copy; 2024 DeviceCorp. All rights reserved.
    </footer>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
