<?php
include 'connection.php';

session_start();

if (!isset($_SESSION['email'])) {
    die("User not logged in.");
}

$user_email = $_SESSION['email'];

$sql = "SELECT username FROM users WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

$user_name = $user['username'];

if (isset($_GET['id'])) {
    $hostel_id = mysqli_real_escape_string($con, $_GET['id']);

    $sql = "SELECT * FROM hostels WHERE hostel_id = '$hostel_id'";
    $result = $con->query($sql);
    $hostel = $result->fetch_assoc();
    
    if (!$hostel) {
        die("Hostel not found.");
    }
} else {
    die("Hostel ID is missing.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hostel_id = mysqli_real_escape_string($con, $_POST['hostel_id']);
    $booking_date = mysqli_real_escape_string($con, $_POST['booking_date']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $booking_status = 'Pending';

    if (!in_array($duration, ['3', '6', '9'])) {
        die("Invalid duration selected.");
    }

    $sql = "INSERT INTO bookings (user_name, user_email, hostel_id, booking_date, duration, booking_status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssss", $user_name, $user_email, $hostel_id, $booking_date, $duration, $booking_status);

    if ($stmt->execute()) {
        echo "<script>
            alert('Booking Request is sent to the Owner!');
            window.location.href = 'home-usr.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="bookingstyle.css">
</head>
<body>
    <style>
       
        form {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: rgb(136, 136, 136);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

      
        .form-group {
            margin-bottom: 15px;
        }

     
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #000;
        }

      
        .form-group input[type="date"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="10" height="5" viewBox="0 0 10 5"><path fill="none" stroke="%23333" stroke-width="1.5" d="M0 0l5 4 5-4"/></svg>') no-repeat right 10px center;
            background-color: #fff;
            background-size: 10px 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .owner-info {
            margin-top: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <header>
        <div class="logo">Hostel Booking</div>
        <nav class="navigation">
            <a href="#home">Home</a>
            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>
        </nav>
    </header>
    <section class="home" id="home">
        <div class="bg">
            <div class="container">
                <form action="booking.php?id=<?php echo htmlspecialchars($hostel_id); ?>" method="POST">
                    <input type="hidden" name="hostel_id" value="<?php echo htmlspecialchars($hostel_id); ?>">
                    <div class="nft">
                        <div class='main'>
                            <img src="<?php echo htmlspecialchars($hostel['room_image']); ?>" alt="Room Image">
                            <h2><?php echo htmlspecialchars($hostel['hostel_name']); ?> #<?php echo htmlspecialchars($hostel_id); ?></h2>
                            <div class="form-group">
                                <label for="booking_date">Booking Date:</label>
                                <input type="date" id="booking_date" name="booking_date" required>
                            </div>
                            <div class="form-group">
                                <label for="duration">Duration:</label>
                                <select id="duration" name="duration" required>
                                    <option value="3">3 months</option>
                                    <option value="6">6 months</option>
                                    <option value="9">9 months</option>
                                </select>
                            </div>
                            <button type="submit">Book Now</button>
                            <div class="owner-info">
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($hostel['owner_email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($hostel['owner_phone']); ?></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function redirectToLogout()
        {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
