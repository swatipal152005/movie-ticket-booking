<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "movie_booking";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM theatre WHERE status='Active'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>theatress - Movie Ticket Booking</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">
    <div class="logo">Movie Booking</div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="theatre.php">theatress</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>
</nav>

<section class="movies-section">

    <h1>Available theatress</h1>

    <div class="movie-container">

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($theatre = mysqli_fetch_assoc($result)) {

        ?>

            <div class="movie-card">

                <div class="movie-info">

                    <h2><?php echo $theatre['name']; ?></h2>

                    <p>
                        <strong>City:</strong>
                        <?php echo $theatre['city']; ?>
                    </p>

                    <p>
                        <strong>Address:</strong>
                        <?php echo $theatre['address']; ?>
                    </p>

                    <p>
                        <strong>Total Screens:</strong>
                        <?php echo $theatre['total_screens']; ?>
                    </p>

                    <a href="show-time.php?id=<?php echo $theatre['id']; ?>"
                       class="book-button">
                        Select Theatre
                    </a>

                </div>

            </div>

        <?php

            }

        } else {

        ?>

            <p class="no-movies">No theatress available.</p>

        <?php } ?>

    </div>

</section>

<footer>
    <p>© 2026 Movie Ticket Booking. All Rights Reserved.</p>
</footer>

</body>
</html>