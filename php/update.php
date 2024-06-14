<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

include("db.php");

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user data based on the provided ID
    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }

    // Handle the form submission for updating user data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle the update logic here
        $newUsername = $_POST['new_username'];
        $newFullName = $_POST['new_fullname'];
        $newGender = $_POST['new_gender'];
        $newAge = $_POST['new_age'];

        $updateSql = "UPDATE users SET username = '$newUsername', fullname = '$newFullName', gender = '$newGender', age = $newAge WHERE id = $userId";
        if ($conn->query($updateSql) === TRUE) {
            echo "User updated successfully!";
        } else {
            echo "Error updating user: " . $conn->error;
        }
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
    <title>Update User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Update User</h2>

    <form method="post" action="">
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" value="<?php echo $user['username']; ?>" required><br>

        <label for="new_fullname">New Full Name:</label>
        <input type="text" name="new_fullname" value="<?php echo $user['fullname']; ?>" required><br>

        <label for="new_gender">New Gender:</label>
        <input type="text" name="new_gender" value="<?php echo $user['gender']; ?>" required><br>

        <label for="new_age">New Age:</label>
        <input type="number" name="new_age" value="<?php echo $user['age']; ?>" required><br>

        <input type="submit" value="Update">
        
        <br>
        <a href="datatable.php" class="center-link">Go back to User Datatable</a>

    </form>

</body>
</html>
