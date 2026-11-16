<?php
session_start();

include("config/database.php");

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {

        $message = "Please enter email and password.";

    } else {

        $sql = "SELECT id, name, email, password
                FROM users
                WHERE email = ?
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {

            // Verify hashed password
            if (password_verify($password, $user['password'])) {

                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];

                header("Location: index.php");
                exit();

            } else {

                // Support accounts created with the old plain-text code
                if (hash_equals((string)$user['password'], $password)) {

                    // Upgrade old password to a secure hash
                    $new_hash = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $update_sql = "UPDATE users SET password = ? WHERE id = ?";
                    $update_stmt = mysqli_prepare($conn, $update_sql);

                    mysqli_stmt_bind_param(
                        $update_stmt,
                        "si",
                        $new_hash,
                        $user['id']
                    );

                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);

                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];

                    header("Location: index.php");
                    exit();

                } else {

                    $message = "Invalid Email or Password!";
                }
            }

        } else {

            $message = "Invalid Email or Password!";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Movie Ticket Booking</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="login-container">

    <div class="login-box">

        <h2>Login</h2>
        <p class="subtitle">Movie Ticket Booking</p>

        <?php if ($message !== "") { ?>
            <p class="error-message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST" action="login.php">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit" name="login">
                Login
            </button>

        </form>

        <p class="register-link">
            Don't have an account?
            <a href="register.php">Register</a>
        </p>

    </div>

</div>

<script src="js/script.js"></script>

</body>
</html>