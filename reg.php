<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icon/userAdd.png" type="image/x-icon">
    <link rel="stylesheet" href="admin.css">
    <title>Register Account</title>
</head>
<body>
    
        <div class="ui">
            <form action="reg.php" method="post">
                <h1>Register Account</h1>
                <h3>Username</h3>
                <input type="text" name="username" placeholder="Enter username">
                <h3>Password</h3>
                <input type="password" name="password" id="password" placeholder="Enter password">
                <div class="showP">
                    <input type="checkbox" name="show" id="showPass">
                    <label for="showPass">Show Password</label>
                </div>
                <div class="clickers">
                    <input class="reg" type="submit" value="Sign Up">
                </div>
                <p>─────────── OR ───────────</p>
                <div class="alreadyAcc">
                    <a href="login.php">Already have an account?</a>
                </div>
            </form>
        </div>
    </div>

        <?php
        $conn = mysqli_connect("localhost", "root", "", "manidlangan_crud");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
            if (mysqli_num_rows($check) > 0) {
                echo("<script>alert('Username already exists!'); window.location.href='reg.php';</script>");
                exit;
            }

            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo("<script>alert('Account registered successfully!'); window.location.href='login.php';</script>");
            } else {
                echo("Error: ") . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        ?>

    <script src="script.js"></script>
    
</body>
</html>