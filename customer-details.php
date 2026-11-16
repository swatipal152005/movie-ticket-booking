<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "movie_booking");

if (!$conn) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
</head>

<body>

<h1>Customer Details</h1>

<form method="POST" action="booking-confirm.php">

    <label>Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone</label><br>
    <input type="text" name="phone" required><br><br>
    <input type="hidden" name="show_id" value="<?php echo htmlspecialchars($_POST['show_id'] ?? ''); ?>">

<input type="hidden" name="selected_seats" value="<?php echo htmlspecialchars($_POST['selected_seats'] ?? ''); ?>">

    <button type="submit">Continue</button>
    

</form>

</body>
</html>