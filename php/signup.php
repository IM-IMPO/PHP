<?php
include("db.php");

$message = "";
$showMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $fullname = $_POST["fullname"];
    $role = $_POST["role"]; // Updated to capture role from the select box

    $sql = "INSERT INTO users (username, password, email, age, gender, phone, fullname, role) 
            VALUES ('$username', '$password', '$email', '$age', '$gender', '$phone', '$fullname', '$role')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
        $showMessage = true;
    } else {
        $message = "Error: " . $sql . "<br id='BR'>" . $conn->error;
        $showMessage = true;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <form method="post" action="" onsubmit="return showResult();">
        <h2>Signup</h2>

        Full Name: <input type="text" name="fullname" required><br>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        Email: <input type="email" name="email" required><br>
        Age: <input type="number" name="age" required><br>
        Gender: 
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <!-- Add more options if needed -->
        </select><br>
        Phone Number: <input type="text" name="phone" required><br>

        <!-- Select box for role -->
        Role:
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <!-- Add more roles if needed -->
        </select><br>

        <div id="resultMessage" class="<?php echo $showMessage ? 'fade-out' : ''; ?>">
            <?php
            if ($showMessage && !empty($message)) {
                echo "<p id='BR'>$message</p>";
            }
            ?>
        </div>

        <input type="submit" value="Sign up">
        <input type="button" value="Go to Signin" onclick="location.href='signin.php';">
    </form>

    <script>
        function showResult() {
            document.getElementById("resultMessage").innerHTML = "";

            setTimeout(function () {
                document.getElementById("resultMessage").innerHTML = "<p id='BR'><?php echo $message; ?></p>";
            }, 500);

            return true;
        }

        setTimeout(function () {
            document.getElementById("resultMessage").classList.remove('fade-out');
        }, 2000);
    </script>
</body>
</html>
