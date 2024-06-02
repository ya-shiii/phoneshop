<?php
$servername = "localhost";
$username = "root";
$password = "newpassword";
$dbname = "phoneshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

// Fetch data from devices table
$sql = "SELECT id FROM devices WHERE, name, description, price, quantity, stock, image FROM devices";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Device List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
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
    </style>
</head>
<body>

<h2>Device List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Stock</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["price"] . "</td>";
            echo "<td>" . $row["quantity"] . "</td>";
            echo "<td>" . $row["stock"] . "</td>";
            echo "<td>";
            if ($row["image"]) {
                echo "<img src='image/" . $row["image"] . "' alt='" . $row["name"] . "'>";
            } else {
                echo "No image";
            }
            echo "<td>";
            echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary edit-button'>Edit</a>";
            echo "<button class='btn btn-danger delete-button' onclick='confirmDelete(" . $row["id"] . ")'>Delete</button>";
            echo "</td>";
        }
    } else {
        echo "<tr><td colspan='7'>No devices found</td></tr>";
    }
    $conn->close();
    ?>
</table>

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
