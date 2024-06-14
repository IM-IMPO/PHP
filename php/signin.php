<?php
session_start();
include("db.php");
$error = "";

$sqlAdminCheck = "SELECT * FROM users WHERE username='admin' AND role='admin'";
$resultAdminCheck = $conn->query($sqlAdminCheck);

if (!$resultAdminCheck) {
    die("Query failed: " . $conn->error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            header("Location: datatable.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signin</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>
    <form method="post" action="">
        <h2>Signin</h2>

        <?php if ($error): ?>
            <p id="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <p id="error-message" <?php echo !empty($error) ? 'class="hidden"' : ''; ?>>
            <?php echo $error; ?>
        </p>

        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <div class="button-container">
            <input type="submit" value="Signin">
            <input type="button" value="Signup" onclick="location.href='signup.php';">
        </div>
    </form>
</body>
</html>
