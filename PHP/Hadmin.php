<?php
include 'connection.php'; 

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:admin-login.php");
    exit();
}

$query = "SELECT hostel_id, hostel_name, capacity, location, rent, available, hostel_image, room_image, owner_email FROM hostels WHERE approval_status = 'approved'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            font-family: "poppins", sans-serif;
        }
      
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;

        }
        :root {
            --main-color: #08032d;
            --second-color: #09022d;
            --text-color: #444;
            --gradient: linear-gradient(#fe5b3d, #ffac38);
        }
        html::-webkit-scrollbar {
            width: 0.5rem;
        }
        html::-webkit-scrollbar-track {
            background: transparent;
        }
        html::-webkit-scrollbar-thumb {
           
            background: #070000;
        }
        header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 20px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--main-color);
        }
        .logo {
            font-size: 2em;
            color: #fff;
            user-select: none;
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

    background:url(https://img.freepik.com/free-photo/low-angle-shot-facade-white-modern-building-blue-clear-sky_181624-48219.jpg?size=626&ext=jpg);

	height: 100vh;
}

        main {
            margin-top: 100px;
            padding: 20px;
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .content {
            background: #000;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: white;
            color: #000;
        }
      
        .button {
        padding: 8px 12px;
    top:50%;
    background-color:#002ead;
    color: #fff;
    border:none; 
    border-radius:5px; 
    
   
    cursor: pointer;
  }
        .button:hover {
      background-color:#0a0a23;
      transition: 0.7s;
  }
    </style>
</head>
<body>
<div class="wrapper">
    <header>
        <h2 class="logo"><i class="fa-solid fa-hotel"></i> Hostalia Admin</h2>
        <nav class="navigation">
            <a href="Hadmin.php">Home</a>
            <a href="admin_hostel_req.php">Hostel Requset</a>
            <a href="admin_owner_req.php">Owner Requset</a>
            <a href="owner_list.php">Owners details</details></a>
            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>
        </nav>
        <script>
            function redirectToLogout() {
                window.location.href = "Admin-login.php";
            }
        </script>
    </header>
    <main>
        <div class="content">
            <h1>Hostel Dashboard</h1>
            <table>
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
                            <a class="button delete" href="delete.php?hostel_id=<?php echo $row['hostel_id']; ?>" onclick="return confirm('Are you sure you want to delete this hostel?');">Remove</a>
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
