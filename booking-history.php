<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "movie_booking");

if (!$conn) {
    die("Database connection failed.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking History</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .history-box {
            width: 80%;
            margin: 40px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
        }

        .message {
            text-align: center;
            padding: 20px;
        }
    </style>
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

<div class="history-box">

    <h1>My Booking History</h1>

    <?php
    if (isset($_SESSION['user_id'])) {

        $user_id = (int) $_SESSION['user_id'];

        $sql = "SELECT * FROM bookings
                WHERE user_id = $user_id
                ORDER BY id DESC";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<hr>";
                echo "<p><b>Booking ID:</b> "
                    . htmlspecialchars((string)$row['id']) . "</p>";

                echo "<p><b>Booking Date:</b> "
                    . htmlspecialchars((string)$row['booking_date']) . "</p>";

                echo "<p><b>Total Amount:</b> ₹"
                    . htmlspecialchars((string)$row['total_amount']) . "</p>";

                echo "<p><b>Booking Status:</b> "
                    . htmlspecialchars((string)$row['booking_status']) . "</p>";

                echo "<p><b>Payment Status:</b> "
                    . htmlspecialchars((string)$row['payment_status']) . "</p>";
                    if (strtolower($row['booking_status']) != 'cancelled') {
    echo "<p><a href='cancel-booking.php?id="
        . (int)$row['id']
        . "' style='display:inline-block;padding:10px 15px;background:#dc3545;color:white;text-decoration:none;border-radius:5px;'>Cancel Booking</a></p>";
} else {
    echo "<p style='color:red;'><b>Booking Cancelled</b></p>";
}
            }

        } else {
            echo "<p class='message'>Abhi koi booking history nahi hai.</p>";
        }

    } else {
        echo "<p class='message'>Booking history dekhne ke liye pehle login karein.</p>";
        echo "<p class='message'><a href='login.php'>Login Now</a></p>";
    }
    ?>

</div>

<footer>
    <p style="text-align:center;">© 2026 Movie Ticket Booking</p>
</footer>

</body>
</html>