```php
<?php

$conn = mysqli_connect("localhost", "root", "", "movie_booking");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$theatre_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT
            s.id,
            m.title,
            s.show_date,
            s.show_time,
            s.ticket_price
        FROM `show` AS s
        INNER JOIN movies AS m ON s.movie_id = m.id
        WHERE s.theatre_id = $theatre_id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Show Timings - Movie Booking</title>
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
        <a href="register.php">Register</a>
    </div>
</nav>

<section class="movies-section">

    <h1>Available Show Timings</h1>

    <div class="movie-container">

        <?php if (mysqli_num_rows($result) > 0) { ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <div class="movie-card">
                    <div class="movie-info">

                        <h2>
                            <?php echo htmlspecialchars($row['title']); ?>
                        </h2>

                        <p>
                            <strong>Date:</strong>
                            <?php echo htmlspecialchars($row['show_date']); ?>
                        </p>

                        <p>
                            <strong>Time:</strong>
                            <?php echo htmlspecialchars($row['show_time']); ?>
                        </p>

                        <p>
                            <strong>Price:</strong>
                            ₹<?php echo htmlspecialchars($row['ticket_price']); ?>
                        </p>

                        <a href="seats.php?id=<?php echo (int)$row['id']; ?>"
                           class="book-button">
                            Select Seats
                        </a>

                    </div>
                </div>

            <?php } ?>

        <?php } else { ?>

            <p class="no-movies">
                No shows available for this theatre.
            </p>

        <?php } ?>

    </div>

</section>

<footer>
    <p>© 2026 Movie Ticket Booking. All Rights Reserved.</p>
</footer>

</body>
</html>
```
