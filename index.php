<?php
session_start();
include 'Server/connection.php'; // Ensure $conn is defined

$register_msg = "";
$login_msg = "";

$_SESSION['logged_in'] = true; // Or some other truthy value
// $_SESSION['user_id'] = $user_id; // Set the logged-in user ID


if (isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

// REGISTER USER
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($email) || empty($password)) {
        $register_msg = "All fields are required.";
    } else {
        $checkQuery = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            $register_msg = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $register_msg = "Registration successful. Please login.";
            } else {
                $register_msg = "Registration failed. Try again.";
            }
        }
    }
}

// LOGIN USER
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $login_msg = "Please enter email and password.";
    } else {
        $query = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $login_msg = "Account not found. Please register first.";
        } else {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['user_password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_email'] = $user['user_email'];

                echo "<script>window.location.href = 'main.php';</script>";
                exit();
            } else {
                $login_msg = "Incorrect password.";
            }
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopBag - Online Shopping</title>
    <link rel="icon" type="image/png" href="Assets/img/logo.png">
    <!-- Bootstrap CSS  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Style Link  -->
    <link rel="stylesheet" href="Assets/css/login-style.css">
    <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="index.php" method="POST">
                <h1>Create Account</h1>
                <?php if (!empty($register_msg)) {
                    echo "<p style='color:red;'>$register_msg</p>";
                } ?>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="register">Register</button>
            </form>
        </div>


        <!-- 🛠 Separator Line -->
        <div class="separator-line"></div>

        <div class="form-container sign-in-container">
            <form action="index.php" method="POST">
                <h1>Sign In</h1>
                <?php if (!empty($login_msg)) {
                    echo "<p style='color:red;'>$login_msg</p>";
                } ?>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="login">Login</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>Already have an account? Login here</p>
                    <button class="ghost" id="signIn">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Don't have an account? Register here</p>
                    <button class="ghost" id="signUp">Register</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>

</html>