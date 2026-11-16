<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "movie_booking";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM movies WHERE status='Active'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Movies - Movie Ticket Booking</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Movies Page Design */

        .movies-section {
            background: #f5f5f5;
            padding: 40px 25px;
            min-height: 70vh;
        }

        .movies-section h1 {
            text-align: center;
            margin-bottom: 35px;
            color: #222;
            font-size: 34px;
        }

        .movie-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 260px));
            justify-content: center;
            gap: 30px;
        }

        .movie-card {
            width: 100%;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .movie-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .movie-poster {
            width: 100%;
            height: 350px;
            background: #e5e5e5;
            overflow: hidden;
        }

        .movie-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .no-poster {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 18px;
        }

        .movie-info {
            padding: 20px;
        }

        .movie-info h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #222;
        }

        .movie-info p {
            margin-bottom: 10px;
            color: #555;
            font-size: 15px;
        }

        .book-button {
            display: block;
            text-align: center;
            margin-top: 18px;
            padding: 12px;
            background: #e50914;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .book-button:hover {
            background: #b20710;
        }

        .no-movies {
            width: 100%;
            text-align: center;
            font-size: 20px;
            color: #777;
        }

        @media (max-width: 600px) {
            .movies-section {
                padding: 30px 15px;
            }

            .movie-container {
                grid-template-columns: minmax(0, 320px);
            }
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->

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

    <!-- Movies Section -->

    <section class="movies-section">

        <h1>Available Movies</h1>

        <div class="movie-container">

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <?php while ($movie = mysqli_fetch_assoc($result)) { ?>

                    <div class="movie-card">

                        <div class="movie-poster">

                            <?php
                            $poster = trim($movie['poster'] ?? '');
                            $title = $movie['title'] ?? 'Movie';
                            ?>

                            <?php if ($poster !== '') { ?>

                                <img
                                    src="images/<?php echo htmlspecialchars($poster, ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                                >

                            <?php } else { ?>

                                <div class="no-poster">
                                    No Poster Available
                                </div>

                            <?php } ?>

                        </div>

                        <div class="movie-info">

                            <h2>
                                <?php
                                echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
                                ?>
                            </h2>

                            <p>
                                <strong>Genre:</strong>
                                <?php
                                echo htmlspecialchars($movie['genre'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
                                ?>
                            </p>

                            <p>
                                <strong>Language:</strong>
                                <?php
                                echo htmlspecialchars($movie['language'] ?? 'Not Available', ENT_QUOTES, 'UTF-8');
                                ?>
                            </p>

                            <p>
                                <strong>Duration:</strong>
                                <?php
                                echo htmlspecialchars((string)($movie['duration'] ?? 'Not Available'), ENT_QUOTES, 'UTF-8');
                                ?>
                            </p>

                            <a
                                href="movie-details.php?id=<?php echo (int)$movie['id']; ?>"
                                class="book-button"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <p class="no-movies">
                    No movies available.
                </p>

            <?php } ?>

        </div>

    </section>

    <!-- Footer -->

    <footer>
        <p>
            &copy; 2026 Movie Ticket Booking. All Rights Reserved.
        </p>
    </footer>

    <script src="js/script.js"></script>

</body>

</html>

<?php
mysqli_close($conn);
?>