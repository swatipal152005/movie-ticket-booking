```php
<?php
session_start();

require_once 'config/database.php';

// Check whether user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Booking ID check
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Invalid booking ID.");
}

$user_id = (int) $_SESSION['user_id'];
$booking_id = (int) $_GET['id'];

// Fetch booking from the correct table
$sql = "SELECT id, booking_status, status
        FROM booking
        WHERE id = ? AND user_id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $booking_id, $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$booking = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$booking) {
    die("Booking not found.");
}

$message = "";

// Check if booking is already cancelled
if (
    strtolower($booking['booking_status']) === 'cancelled' ||
    strtolower($booking['status']) === 'cancelled'
) {
    $message = "This booking is already cancelled.";
}

// Cancel booking after confirmation
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['confirm_cancel']) &&
    $message === ''
) {
    $update_sql = "UPDATE booking
                   SET booking_status = 'Cancelled',
                       status = 'Cancelled'
                   WHERE id = ?
                     AND user_id = ?
                     AND booking_status = ?
                     AND status = ?";

    $update_stmt = mysqli_prepare($conn, $update_sql);

    mysqli_stmt_bind_param(
        $update_stmt,
        "iiss",
        $booking_id,
        $user_id,
        $booking['booking_status'],
        $booking['status']
    );

    if (mysqli_stmt_execute($update_stmt) &&
        mysqli_stmt_affected_rows($update_stmt) === 1) {

        mysqli_stmt_close($update_stmt);

        header("Location: booking-history.php");
        exit();

    } else {
        $message = "Booking cancel nahi hui. Please dobara try karein.";

        mysqli_stmt_close($update_stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div style="max-width:600px;margin:50px auto;padding:25px;background:white;border-radius:10px;">

    <h2>Cancel Movie Booking</h2>

    <p>
        Booking ID:
        <?php echo htmlspecialchars((string)$booking['id']); ?>
    </p>

    <?php if ($message !== ''): ?>

        <p><?php echo htmlspecialchars($message); ?></p>

        <a href="booking-history.php">Go to Booking History</a>

    <?php else: ?>

        <p>Kya aap sach mein apni booking cancel karna chahti hain?</p>

        <form method="POST">
            <button
                type="submit"
                name="confirm_cancel"
                style="background:#dc3545;color:white;padding:10px 15px;border:0;border-radius:5px;cursor:pointer;">
                Yes, Cancel Booking
            </button>

            <a href="booking-history.php">Go Back</a>
        </form>

    <?php endif; ?>

</div>

</body>
</html>
```
