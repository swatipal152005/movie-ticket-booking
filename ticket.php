<?php
$payment_method = $_POST['payment_method'] ?? 'Not Selected';
$amount = $_POST['amount'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Ticket</title>
</head>
<body style="font-family: Arial; text-align: center;">

    <h1 style="color: green;">Booking Confirmed!</h1>

    <h2>Your Movie Ticket</h2>

    <p><b>Movie:</b> Jawan</p>
    <p><b>Screen:</b> Screen 1</p>
    <p><b>Amount:</b> ₹<?php echo htmlspecialchars((string)$amount); ?></p>
    <p><b>Payment Method:</b> <?php echo htmlspecialchars($payment_method); ?></p>

    <button onclick="window.print()">Print Ticket</button>

    <br><br>

    <a href="index.php">Back to Home</a>

</body>
</html>