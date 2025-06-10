<?php
include 'connection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Login-ownr.php");
    exit();
}

$owner_email = $_SESSION['email'];

$query = "SELECT hostel_id, hostel_name, capacity, location, rent, available, hostel_image, room_image, owner_email FROM hostels WHERE approval_status = 'approved'";$stmt = $con->prepare($query);
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Hostels</title>
    <script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="wrapper">
    <header>
        <h2 class="logo"><i class="fa-solid fa-hotel"></i> Hostalia/Owner</h2>
        <nav class="navigation">
            <a href="owner-home.php">Home</a>
            <a href="Add-Hostel.php">Add Hostel</a>
            <a href="bookingreq.php">Booking</a>
            <a href="std-List.php">Students List</a>

            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>
        </nav>
        <script>
            function redirectToLogout() {
                window.location.href = "Login-adm.php";
            }
        </script>
    </header>
    <main>
        <div class="content">
            <h1>Hostel Dashboard</h1>
            <style>
*{
    margin: 0;
    padding:0;
    box-sizing: border-box;
    scroll-padding-top: 2rem;
    scroll-behavior: smooth;
    list-style: none;
    text-decoration: none;
    font-family:"poppins", sanas-serif;
} 

.wrapper{
display: flex;
justify-content: center;
align-items: center;
min-height: 110vh;
background: rgba(39,39,39,.4);
}
:root{
  --main-color: #08032d;
  --second-color: #09022d;
  --text-color: #444;
  --gradient:linear-gradient( #fe5b3d, #ffac38);
}

html::-webkit-scrollbar {
width: 0.5rem;
}

html::-webkit-scrollbar-track{
background: white;
}
html::-webkit-scrollbar-track{
background: var(--main-color);
border-radius: 5rem;
}

header{
position: fixed;
top: 0;
left: 0;
width: 100%;
padding: 15px 50px;
background: rgb(1, 1, 51);
display:inline-flex;
justify-content: space-between;
align-items: center;
z-index: 99;
}



.logo{
font-size: 2em;
color: rgb(255, 255, 255);
user-select: none;
}

.navigation{
position: relative;
font-size: 1.1cm;
color: #fff;
text-decoration: none;
font-weight: 500;
margin-left: 40px;
}

.navigation a {
position: relative;
font-size: 20px;
color: #ffff;
text-decoration: none;
font-weight: 500;
margin-left: 40px;
}

.navigation a::after{
content: ''; 
position: absolute;
left: 0;
bottom: -6px;
width: 100%;
height: 3px;
background: #fff;
border-radius : 5px;
transform: scaleX(0); 
transform-origin: right;
transition: transform .5s;
}



.navigation a:hover::after {
transform: scaleX(1);
}

.navigation .signin-btn{
width: 130px;
height: 40px;
background: rgba(255,255,255,0.8);
border-radius: 30px;
cursor: pointer;
font-size: 1.1m;
color: #070000;
font-weight: 500;
margin-left: 40px;
border:none;
transition: .3s ease;
}
.navigation .signin-btn a{

color: #070000;
text-decoration: none;
}

.navigation .signin-btn a:hover{
text-decoration: none;

color: #070000;
;
}    

.navigation .signin-btn:hover{
background: rgba(255,255,255,0.4);

}

body {
    margin: 0;
    background-size: cover;
    font-family: 'Oswald', sans-serif;
    display: flex;
    flex-direction: column;
    min-height: 100vh;

   
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
    height: 100vh;
}







.hostel-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: #000000;
    color: #fff;
}


.hostel-table thead.thead-primary {
    background: #ffffff;
}
.hostel-table th, .hostel-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}


.hostel-table thead th {
    border: none;
    padding: 20px 15px;
    font-size: 14px;
    color: #000000;
}
.hostel-table th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: left;
}

.hostel-table tbody tr {
    margin-bottom: 10px;
}

.hostel-table tbody th,
.hostel-table tbody td {
    border: none;
    padding: 20px 15px;
    border-bottom: 3px solid #f8f9fd;
    font-size: 14px;
    text-transform: uppercase;
}



.hostel-table td img {
    max-width: 100px;
}


main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
}

form {
    background-color: transparent;
    padding: 40px;
    border-radius: 5px;
    max-width: 800px;
    width: 100%;
}

.button {
    display: inline-block;
    padding: 5px 10px;
    margin: 2px 0;
    text-decoration: none;
    color: #fff;
    background-color: #007BFF;
    border: none;
    border-radius: 3px;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #0056b3;
}

.button.delete {
    background-color: #DC3545;
}

.button.delete:hover {
    background-color: #c82333;
}

    </style>
             
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th>Hostel Name</th>
                            <th>Capacity</th>
                            <th>Location</th>
                            <th>Rent</th>
                            <th>Available</th>
                            <th>Hostel Image</th>
                            <th>Room Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['hostel_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['capacity']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['rent']); ?></td>
                                <td><?php echo htmlspecialchars($row['available']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($row['hostel_image']); ?>" alt="Hostel Image" style="width: 100px; height: 100px;"></td>
                                <td><img src="<?php echo htmlspecialchars($row['room_image']); ?>" alt="Room Image" style="width: 100px; height: 100px;"></td>
                                <td>
                                    <a class="button" href="edit-hostel.php?id=<?php echo $row['hostel_id']; ?>">Edit</a>
                                    <a class="button delete" href="delete-hostel.php?id=<?php echo $row['hostel_id']; ?>" onclick="return confirm('Are you sure you want to delete this hostel?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            
        </div>
    </main>
</div>
</body>
</html>
