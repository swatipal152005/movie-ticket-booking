```php
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$message = "";
$message_type = "";

$name = "";
$email = "";
$phone = "";

try {
    // Database connection
    require_once __DIR__ . "/config/database.php";

    if (!isset($conn) || !$conn) {
        throw new Exception("Database connection is not available.");
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $phone = trim($_POST["phone"] ?? "");
        $password = $_POST["password"] ?? "";

        if (
            $name === "" ||
            $email === "" ||
            $phone === "" ||
            $password === ""
        ) {
            $message = "Please fill in all fields.";
            $message_type = "error";

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Please enter a valid email address.";
            $message_type = "error";

        } elseif (strlen($password) < 6) {
            $message = "Password must contain at least 6 characters.";
            $message_type = "error";

        } else {

            // Check if email already exists
            $check_sql = "SELECT id FROM users WHERE email = ?";
            $check_stmt = mysqli_prepare($conn, $check_sql);

            mysqli_stmt_bind_param(
                $check_stmt,
                "s",
                $email
            );

            mysqli_stmt_execute($check_stmt);

            $check_result = mysqli_stmt_get_result($check_stmt);

            if (mysqli_num_rows($check_result) > 0) {

                $message = "Email already registered. Please login.";
                $message_type = "error";

            } else {

                // Hash password before saving
                $hashed_password = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                // Insert user into database
                $insert_sql = "INSERT INTO users
                    (name, email, phone, password)
                    VALUES (?, ?, ?, ?)";

                $insert_stmt = mysqli_prepare(
                    $conn,
                    $insert_sql
                );

                mysqli_stmt_bind_param(
                    $insert_stmt,
                    "ssss",
                    $name,
                    $email,
                    $phone,
                    $hashed_password
                );

                mysqli_stmt_execute($insert_stmt);

                $message = "Registration successful! You can now login.";
                $message_type = "success";

                $name = "";
                $email = "";
                $phone = "";

                mysqli_stmt_close($insert_stmt);
            }

            mysqli_stmt_close($check_stmt);
        }
    }

} catch (Throwable $e) {

    error_log("Registration error: " . $e->getMessage());

    $message = "Registration failed. Please check your database and table settings.";
    $message_type = "error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Movie Ticket Booking</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f3f6;
            margin: 0;
            padding: 0;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .register-box {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            box-sizing: border-box;
        }

        .register-box h2 {
            text-align: center;
            margin: 0 0 10px;
            color: #222;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .register-box label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .register-box input {
            display: block;
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        .register-box input:focus {
            outline: none;
            border-color: #e50914;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .register-box button:hover {
            background: #b80710;
        }

        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
            overflow-wrap: anywhere;
        }

        .success {
            color: #155724;
            background: #d4edda;
        }

        .error {
            color: #721c24;
            background: #f8d7da;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #e50914;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="register-container">

    <div class="register-box">

        <h2>Create Account</h2>
        <p class="subtitle">Movie Ticket Booking</p>

        <?php if ($message !== ""): ?>
            <div class="message <?php echo htmlspecialchars($message_type); ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your full name"
                value="<?php echo htmlspecialchars($name); ?>"
                required
            >

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >

            <label for="phone">Phone Number</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                placeholder="Enter your phone number"
                value="<?php echo htmlspecialchars($phone); ?>"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password (minimum 6 characters)"
                minlength="6"
                required
            >

            <button type="submit" name="register" value="1">
                Register
            </button>

        </form>

        <p class="login-link">
            Already have an account?
            <a href="login.php">Login Here</a>
        </p>

        <p class="login-link">
            <a href="index.php">Back to Home</a>
        </p>

    </div>

</div>

</body>
</html>
```
