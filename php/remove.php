<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

include("db.php");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Handle the removal logic here
    $deleteSql = "DELETE FROM users WHERE id = $userId";

    if ($conn->query($deleteSql) === TRUE) {
        echo " ";
    } else {
        echo "Error removing user: " . $conn->error;
    }

} else {
    echo "User ID not provided.";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Remove User</h2>
    <div>
    
        <p>User removed successfully!</p>
        <a href="datatable.php" class="center-link">Go back to User Datatable</a>

    </div>

  

</body>
</html>
