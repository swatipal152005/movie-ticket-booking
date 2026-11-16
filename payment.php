<!DOCTYPE html>
<html>
<head>
    <title>Payment - Movie Booking</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .payment-box {
            width: 350px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #222;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="payment-box">

    <h1>Payment</h1>

    <form action="ticket.php" method="POST">

        <label>Payment Method</label>

        <select name="payment_method" required>
            <option value="">Select Payment Method</option>
            <option value="UPI">UPI</option>
            <option value="Card">Debit/Credit Card</option>
            <option value="Cash">Cash</option>
        </select>

        <label>Amount (₹)</label>

        <input type="number" name="amount" value="200" readonly>

        <button type="submit">Continue to Ticket</button>

    </form>

</div>

</body>
</html>