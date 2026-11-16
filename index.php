<?php
session_start();
include("config/database.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket Booking</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">
    <div class="logo">Movie Booking</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="theatre.php">Theatres</a>

        <?php if (isset($_SESSION['user_id'])) { ?>
            <a href="booking-history.php">My Bookings</a>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } ?>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1>Book Your Movie Tickets</h1>

        <p>
            Find your favourite movies and book your tickets easily.
        </p>

        <a href="movies.php" class="hero-button">
            Browse Movies
        </a>
    </div>
</section>

<section class="welcome">
    <h2>Welcome to Movie Ticket Booking</h2>

    <p>
        Book movie tickets online quickly and easily.
        Select your movie, theatre, show time and seats.
    </p>
</section>

<section class="features">

    <div class="feature-box">
        <h3>🎬 Movies</h3>
        <p>Explore latest movies.</p>
    </div>

    <div class="feature-box">
        <h3>🏢 Theatres</h3>
        <p>Choose your favourite theatre.</p>
    </div>

    <div class="feature-box">
        <h3>💺 Seats</h3>
        <p>Select your preferred seats.</p>
    </div>

    <div class="feature-box">
        <h3>🎟️ Tickets</h3>
        <p>Book and manage your tickets.</p>
    </div>

</section>

<footer>
    <p>© 2026 Movie Ticket Booking. All Rights Reserved.</p>
</footer>

<script src="js/script.js"></script>

</body>
</html>