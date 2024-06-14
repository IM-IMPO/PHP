<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include("db.php");

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Datatable</title>
    <!-- Include DataTables CSS and JS files -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="datatable.css">
</head>
<body>
    <h2>User Datatable</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table id='userTable'>";
        echo "<thead><tr><th>ID</th><th>Username</th><th>Full Name</th><th>Gender</th><th>Age</th>";

        // Check the user's role to determine which columns to display
        if ($_SESSION['role'] == 'admin') {
            echo "<th>Password</th><th>Email</th><th>Phone</th><th>Action</th>";
        }

        echo "</tr></thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['fullname']}</td>";
            echo "<td>{$row['gender']}</td>";
            echo "<td>{$row['age']}</td>";

            // Check the user's role to determine which columns to display
            if ($_SESSION['role'] == 'admin') {
                echo "<td>{$row['password']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['phone']}</td>";
                echo "<td><a href='update.php?id={$row['id']}'>Update</a> | <a href='remove.php?id={$row['id']}'>Remove</a></td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Initialize DataTable
        echo "<script>$(document).ready( function () { $('#userTable').DataTable(); } );</script>";
    } else {
        echo "No users found.";
    }
    ?>

    <br>
    <a href="logout.php" id="logoutBtn">Logout</a>
</body>
</html>
