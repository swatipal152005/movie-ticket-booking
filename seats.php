<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "movie_booking");

if (!$conn) {
    die("Database connection failed.");
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Show not found. Please select a show first.");
}

$show_id = (int) $_GET['id'];

$sql = "SELECT * FROM `show` WHERE id = $show_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Show not found.");
}

$show = mysqli_fetch_assoc($result);
$screen_id = (int) $show['screen_id'];

$seat_sql = "SELECT * FROM seats WHERE screen_id = $screen_id";
$seat_result = mysqli_query($conn, $seat_sql);

if (!$seat_result) {
    die("Seats load nahi ho paayi.");
}

if (mysqli_num_rows($seat_result) == 0) {
    for ($i = 1; $i <= 50; $i++) {
        $seat_number = "A" . $i;

        $insert_sql = "INSERT INTO seats
            (screen_id, seat_number, seat_type, status)
            VALUES
            ($screen_id, '$seat_number', 'Regular', 'Available')";

        mysqli_query($conn, $insert_sql);
    }

    $seat_result = mysqli_query($conn, $seat_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Seats - Movie Booking</title>
    <link rel="stylesheet" href="css/style.css">

    <style>
        .seat-container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            text-align: center;
        }

        .screen {
            background: #333;
            color: white;
            padding: 12px;
            width: 70%;
            margin: 25px auto;
            border-radius: 5px;
        }

        .seats {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 25px 0;
        }

        .seat {
            width: 55px;
            padding: 12px 0;
            background: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .seat.selected {
            background: orange;
        }

        .continue-button {
            display: inline-block;
            padding: 12px 25px;
            background: #222;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #message {
            color: red;
            margin: 15px;
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
    </div>
</nav>

<section class="seat-container">

    <h1>Select Your Seats</h1>

    <div class="screen">SCREEN</div>

    <form action="customer-details.php" method="POST" onsubmit="return checkSeats()">

        <input type="hidden" name="show_id"
               value="<?php echo $show_id; ?>">

        <div class="seats">
            <?php while ($seat = mysqli_fetch_assoc($seat_result)) { ?>

                <button
                    type="button"
                    class="seat"
                    data-seat-id="<?php echo (int)$seat['id']; ?>"
                    onclick="selectSeat(this)">
                    <?php echo htmlspecialchars($seat['seat_number']); ?>
                </button>

            <?php } ?>
        </div>

        <input type="hidden" name="selected_seats" id="selected_seats">

        <p id="message"></p>

        <p>Selected seats: <span id="seat-count">0</span></p>

        <button type="submit" class="continue-button">
            Continue
        </button>

    </form>

</section>

<script>
let selectedSeats = [];

function selectSeat(button) {
    const seatId = button.dataset.seatId;

    if (button.classList.contains("selected")) {
        button.classList.remove("selected");
        selectedSeats = selectedSeats.filter(id => id !== seatId);
    } else {
        button.classList.add("selected");
        selectedSeats.push(seatId);
    }

    document.getElementById("selected_seats").value =
        selectedSeats.join(",");

    document.getElementById("seat-count").textContent =
        selectedSeats.length;

    document.getElementById("message").textContent = "";
}

function checkSeats() {
    if (selectedSeats.length === 0) {
        document.getElementById("message").textContent =
            "Please pehle kam se kam ek seat select karein.";
        return false;
    }

    return true;
}
</script>

<footer>
    <p style="text-align:center;">
        © 2026 Movie Ticket Booking. All Rights Reserved.
    </p>
</footer>

</body>
</html>