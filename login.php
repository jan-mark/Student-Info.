<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icon/icon.png" type="icon">
    <link rel="stylesheet" href="admin.css">
    <title>Login Account</title>
</head>
<body>
    
        <div class="ui">
            <form action="login.php" method="post">
                <h1>Login Account</h1>
                <h3>Username</h3>
                <input type="text" name="username" placeholder="Enter username">
                <h3>Password</h3>
                <input type="password" name="password" id="password" placeholder="Enter password">
                <div class="showP">
                    <input type="checkbox" name="show" id="showPass">
                    <label for="showPass">Show Password</label>
                </div>
                <div class="clickers">
                    <input class="done" type="submit" value="LOG IN">
                </div>
                <p>─────────── OR ───────────</p>
                <div class="registerAcc">
                    <button class="regAcc" type="button" onclick="window.location.href='reg.php'">Create New Account</button>
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
            $username = $_POST["username"] ?? '';
            $password = $_POST["password"] ?? '';

            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = mysqli_query($conn, $query);

            if (empty($username) || empty($password)) {
                echo("<script>alert('Fill up the Username and Password!'); window.location.href='index.php';</script>");
                exit;
            }

            if (mysqli_num_rows($result) === 1) {
                header("Location: view.php");
                exit;
            } else {
                echo("<script>alert('Incorrect username or password!'); window.location.href='index.php';</script>");
            }
        }

        mysqli_close($conn);
        ?>


    <script src="script.js"></script>

</body>
</html>