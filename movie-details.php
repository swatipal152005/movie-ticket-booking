<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "movie_booking";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("Movie not found.");
}

$id = $_GET['id'];

$sql = "SELECT * FROM movies WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Movie not found.");
}

$movie = mysqli_fetch_assoc($result);
?>

if (mysqli_num_rows($result) == 0) {
    die("Movie not found.");
}

$movie = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $movie['title']; ?> - Movie Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar">

    <div class="logo">
        Movie Booking
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="theatre.php">Theatres</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>

</nav>

<section class="movie-details">

    <h1><?php echo $movie['title']; ?></h1>

    <?php if (!empty($movie['poster'])) { ?>

        <img src="images/<?php echo $movie['poster']; ?>"
             alt="<?php echo $movie['title']; ?>"
             width="300">

    <?php } ?>

    <h3>Movie Details</h3>

    <p>
        <strong>Description:</strong>
        <?php echo $movie['description']; ?>
    </p>

    <p>
        <strong>Genre:</strong>
        <?php echo $movie['genre']; ?>
    </p>

    <p>
        <strong>Language:</strong>
        <?php echo $movie['language']; ?>
    </p>

    <p>
        <strong>Duration:</strong>
        <?php echo $movie['duration']; ?>
    </p>

    <p>
        <strong>Release Date:</strong>
        <?php echo $movie['release_date']; ?>
    </p>

    <a href="theatre.php" class="book-button">
        Book Ticket
    </a>

</section>

<footer>
    <p>© 2026 Movie Ticket Booking. All Rights Reserved.</p>
</footer>

</body>
</html>