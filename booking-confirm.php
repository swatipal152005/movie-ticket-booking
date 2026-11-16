<?php

session_start();
$conn = mysqli_connect("localhost", "root", "", "movie_booking");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$user_id = $_SESSION['user_id'] ?? 0;
$show_id = $_POST['show_id'] ?? 0;
$selected_seats = $_POST['selected_seats'] ?? '';
$amount = 200;
echo "User ID: " . $user_id . " | Show ID: " . $show_id;
if ($user_id > 0 && $show_id > 0) {
    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO bookings (user_id, show_id, booking_date, total_amount, booking_status)
         VALUES (?, ?, NOW(), ?, 'Confirmed')"
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iid", $user_id, $show_id, $amount);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['booking_id'] = mysqli_insert_id($conn);
        } else {
            echo "Booking save error: " . htmlspecialchars(mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Database query error: " . htmlspecialchars(mysqli_error($conn));
    }
} else {
    echo "Please login and select a show before booking.";
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">
    <div class="logo">Movie Booking</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="theatre.php">Theatres</a>
        <a href="login.php">Login</a>
    </div>
</nav>

<section class="movies-section">

    <h1>Booking Confirmation</h1>

    <div class="movie-card">

        <div class="movie-info">

            <h2>Customer Details</h2>

            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>

            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>

            <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>

            <h3>Booking Confirmed Successfully!</h3>

            <p>Your movie ticket booking details have been received.</p>

            <a href="payment.php" class="book-button">
                Continue to Payment
            </a>

        </div>

    </div>

</section>

<footer>
    <p>© 2026 Movie Ticket Booking. All Rights Reserved.</p>
</footer>

</body>
</html>