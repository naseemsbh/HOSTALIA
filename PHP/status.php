<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['email'];

$stmt = $con->prepare("SELECT b.booking_id, h.hostel_name, b.booking_date, b.duration, b.booking_status
                        FROM bookings b
                        JOIN hostels h ON b.hostel_id = h.hostel_id
                        WHERE b.user_email = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
    width: 80%;
    margin: 100px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Hostel Booking</div>
        <nav class="navigation">
            <a href="Home-usr.php">Home</a>
            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>
        </nav>
    </header>
    <div class="container">
        <h2>Your Booking Status</h2>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Hostel Name</th>
                <th>Booking Date</th>
                <th>Duration (months)</th>
                <th>Status</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['booking_id']) . "</td>
                            <td>" . htmlspecialchars($row['hostel_name']) . "</td>
                            <td>" . htmlspecialchars($row['booking_date']) . "</td>
                            <td>" . htmlspecialchars($row['duration']) . "</td>
                            <td>" . htmlspecialchars($row['booking_status']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No bookings found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <script>
        function redirectToLogout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
