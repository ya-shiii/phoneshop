<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    
    <style>
        /* General Styles */
        body {
            background-color: #EDD7BE;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        /* Header Styles */
        .header {
            background-color: #C1A286;
            padding: 15px;
            text-align: center;
            font-family: 'Italiana', serif;
            font-size: 40px;
            color : #EDE1D1;
        }

        .header h1 {
            font-size: 40px;
        }

          /* Navigation Menu Styles */
        nav {
            background-color: #CFB08C;
            padding: 20px 15px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-family: 'Italiana';
            font-size: 20px;
            font-weight: bold;
            padding: 20px 50px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #BC7249;
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
        
         @media (min-width: 576px) {
            /* Small devices (576px and up) */
        }

        @media (min-width: 768px) {
            /* Medium devices (768px and up) */
        }

        @media (min-width: 992px) {
            /* Large devices (992px and up) */
        }

        @media (min-width: 1200px) {
            /* Extra large devices (1200px and up) */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Add Product</h1>
    </div>
    
    <!-- Navigation menu -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto"> <!-- Use mx-auto class to center the content -->
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view.php"><i class="fas fa-users"></i> User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewDevices.php"><i class="fas fa-box"></i> Product Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addDeviceForm.php"><i class="fas fa-plus"></i> Add Product</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    

    <div class="add-container">
        <div class="back-to-home">
            <a href="viewDevices.php">&#8592;</a> <!-- Unicode arrow character -->
        </div>
                <h2>Add Product</h2>
                
                <form action="addDevice.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prod_image">Device Image</label>
                        <input type="file" name="prod_image" id="prod_image" accept="image/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required placeholder="Enter Device Name">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" required placeholder="Enter Device Description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price"  placeholder="Enter Price">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required placeholder="Enter Quantity">
                    </div>

                    <div class="form-group">
                        <label for="stock">Stocks:</label>
                        <input type="number" id="stock" name="stock" required placeholder="Enter Stocks">
                    </div>

                    <input type="submit" name="submit" value="Add Device" class="btn btn-primary"> <!-- Using Bootstrap button class -->
                </form>
            </div>
        </div>
    </div>

    
    
<!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
