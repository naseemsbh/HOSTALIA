<?php
include 'connection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Login-adm.php");
    exit();
}

$owner_email = $_SESSION['email'];
if (isset($_GET['id'])) {
    $hostel_id = $_GET['id'];
}else {
    echo "Hostel ID is not specified.";
    exit();
}

$query = "SELECT hostel_name, capacity, location, rent, available, hostel_image, room_image FROM hostels WHERE hostel_id = ? AND owner_email = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("is", $hostel_id, $owner_email);
$stmt->execute();
$result = $stmt->get_result();
$hostel = $result->fetch_assoc();

if (!$hostel) {
    echo "Hostel not found.";
    exit();
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hostel</title>
    <script type="text/javascript">
        function showAlert() {
            alert("Updated successfully");
            window.location.href = "hostel-dashboard.php";
        }
    </script>
    <script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-padding-top: 2rem;
            scroll-behavior: smooth;
            list-style: none;
            text-decoration: none;
            font-family: "Poppins", sans-serif;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 110vh;
            background: rgba(39, 39, 39, .4);
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
main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
}

.table {
    width: 100%;
    background: #000000;
    border-collapse: collapse;
    color: #fff;
    max-width: 800px;
    margin: auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.table thead.thead-primary {
    background: #ffffff;
}

.table thead th {
    border: none;
    padding: 20px 15px;
    font-size: 14px;
    color: #000000;
}

.table tbody tr {
    margin-bottom: 10px;
}

.table tbody th,
.table tbody td {
    border: none;
    padding: 20px 15px;
    border-bottom: 3px solid #f8f9fd;
    font-size: 14px;
    text-transform: uppercase;
}


form {
    background-color: transparent;
    padding: 40px;
    border-radius: 5px;
    max-width: 800px;
    width: 100%;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="checkbox"] {
    width: 70%;
    padding: 100px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

input[type="text"],  input[type="file"], select {
    width: 70%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
input[type="number"],  input[type="file"], select {
    width: 70%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
}
/* Upload button styling */
input[type="file"] {
    padding: 10px;
    background-color: #333;
    color: #fff;
    cursor: pointer;
}

input[type="file"]::-webkit-file-upload-button {
    visibility: hidden;
}

input[type="file"]::before {
    content: 'Upload Image';
    display: inline-block;
    background: #333;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 10px 15px;
    outline: none;
    white-space: nowrap;
   
    cursor: pointer;
    text-align: center;
    font-size: 10pt;
}

input[type="file"]:hover::before {
    background: #444;
}

button[type="submit"] {
    color: #fff;
    background: black;
    padding: 10px 20px;
    text-decoration: none;
    margin: 0 10px;
    text-transform: uppercase;
    border-radius: 0%;
}

button[type="submit"]:hover {
    background: #fff;
    color: #000;
    padding: 10px 20px;

}






    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <h2 class="logo"><i class="fa-solid fa-hotel"></i> Hostalia</h2>
        <nav class="navigation">
            <a href="admin-home.php">Home</a>
            <a href="Add-Hostel.php">Add Hostel</a>
            <a href="hostel-dashboard.php">Hostels</a>
            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>
        </nav>
        <script>
            function redirectToLogout() {
                window.location.href = "Login-adm.php";
            }
        </script>
    </header>
    <main>
        <form  method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="hostel_id" value="<?php echo $hostel_id; ?>">
            <table class="table">
                <tbody>
                    <tr>
                        <th><label for="hostel_name">Hostel Name:</label></th>
                        <td><input type="text" id="hostel_name" name="hostel_name" value="<?php echo $hostel['hostel_name']; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="capacity">Capacity:</label></th>
                        <td><input type="number" id="capacity" name="capacity" value="<?php echo $hostel['capacity']; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="rent">Rent:</label></th>
                        <td><input type="number" id="rent" name="rent" value="<?php echo $hostel['rent']; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="location">Location:</label></th>
                        <td><input type="text" id="location" name="location" value="<?php echo $hostel['location']; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="hostel_image">Upload Hostel Image:</label></th>
                        <td><input type="file" name="hostel_image" id="hostel_image"></td>
                    </tr>
                    <tr>
                        <th><label for="room_image">Upload Room Image:</label></th>
                        <td><input type="file" name="room_image" id="room_image"></td>
                    </tr>
                    <tr>
                        <th><label for="available">Available:</label></th>
                        <td><input type="checkbox" id="available" name="available" <?php if($hostel['available']) echo 'checked'; ?>></td>
                    </tr>
                </tbody>
            </table>
            <div class="edithostel">
                <button type="submit" onclick="showAlert()" class="btn">Update Hostel</button>
            

            </div>
        </form>
    </main>
</div>
</body>
</html>
