<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "phoneshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM devices";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users Info</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
   <style>
       /* General Styles */
       table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }

        

        /* Search Form Styling */
        .search-form {
         display: flex;
         justify-content: flex-end;
         align-items: center;
         width: 70%;
         margin-top: 0; /* Remove the top margin */
        }
        .searchbar-input {
            padding: 15px;
            border: 2px solid #7F6044;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-button,
        .reset-button {
            padding: 5px 20px;
            background-color: #896451;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            color: #ffffff;
        }

        .reset-button {
            background-color: #C1A286;
        }
         .search-button:hover,
         .reset-button:hover {
          background-color: #7e4f34; /* Change the background color on hover */
        }


         .reset-button:hover {
         background-color: #9c7d5d; /* Change the background color on hover */
          }

        

        /* Add Product Button Styling */
        .add-product-button {
         text-decoration: none;
         color: #ffffff;
         font-size: 16px;
          font-weight: 700;
          padding: 10px 20px;
          background-color: #896451;
           border-radius: 5px;
           margin-left: 20px;
           
        }
      .add-product-button:active,
      .add-product-button:focus,
      .add-product-button:hover,
      .add-product-button:visited {
       background-color: #896451; /* Set the background color */
       color: #D8CBBB; /* Set the text color */
       text-decoration: none; /* Remove underline */
       outline: none; /* Remove outline */
       }


        .add-product-button:hover {
         background-color: #7F6044;
          }
        
    </style>
</head>
<body>
    <div class="header">
        <h1>View Users Info</h1>
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
    

    <div class="content">
        
        <!-- Add New Product button -->
        <div class="add-product-button ml-auto">
            <a href="addDeviceForm.php" class="add-product-button">Add New Product</a>
        </div>
        
        <!-- Search form -->
        <div class="search-form">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="d-flex">
                <input class="searchbar-input form-control mr-2" type="search" name="search_query" value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : ''; ?>" placeholder="Search for products...">
                <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                <button type="button" class="reset-button ml-2" onclick="window.location.href='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'"><i class="fas fa-sync-alt"></i></button>
            </form>
        </div>

        

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "phoneshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_query = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search_query"])) {
    $search_query = trim($_POST["search_query"]);
    if (!empty($search_query)) {
        $search_query = $conn->real_escape_string($search_query);
        $sql = "SELECT * FROM devices WHERE name LIKE '$search_query%' OR product_price LIKE '$search_query%'";
    } else {
        $sql = "SELECT * FROM devices";
    }
} else {
    $sql = "SELECT * FROM devices";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><img src='image/" . $row["id"] . ".jpg' width=150px></td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>₱" . number_format($row["price"], 2, '.', ',') . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>" . $row["stock"] . "</td>";

        echo "<td>";
echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary edit-button'>Edit</a>";
echo "<button class='btn btn-danger delete-button' onclick='confirmDelete(" . $row["id"] . ")'>Delete</button>";
echo "</td>";

    }
} else {
    echo "<tr><td colspan='6'>No results found</td></tr>";
}
$conn->close();
?>

                </tbody>
            </table>
        </div>
    </div>
</div>

    
<!-- Bootstrap JS and dependencies -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




<script>
    function confirmEdit(id) {
        if (confirm("Are you sure you want to Edit this product?")) {
            window.location.href = "edit.php?id=" + id;
        }
    }
</script>

<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = "delete.php?id=" + id;
    }
}
</script>




</body>
</html>
