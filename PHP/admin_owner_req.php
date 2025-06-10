<?php
include 'connection.php'; 


session_start();
if (!isset($_SESSION['email'])) {
    header("Location: admin-login.php");
    exit();
}

if (isset($_POST['approve'])) {
    $owner_id = $_POST['owner_id'];
    $stmt = $con->prepare("UPDATE owners SET approval_status = 'approved' WHERE email = ?");
    $stmt->bind_param("s", $owner_id);

    if ($stmt->execute()) {
        echo "<script>alert('Owner approved successfully'); window.location.href='admin_owner_req.php';</script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['reject'])) {
    $owner_id = $_POST['owner_id'];
    $stmt = $con->prepare("DELETE FROM owners WHERE email = ?");
    $stmt->bind_param("s", $owner_id);

    if ($stmt->execute()) {
        echo "<script>alert('Owner rejected and deleted successfully'); window.location.href='admin_owner_req.php';</script>";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

$query = "SELECT id, lname, name, email, address, password, phone_no  FROM owners WHERE approval_status = 'pending'";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Requests</title>
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
            min-height: 110vh;
            background: rgba(39, 39, 39, .4);
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
            background: #fe5b3d;
        }

        .logo {
            font-size: 2em;
            color: #fff;
            user-select: none;
        }
        nav a {
            font-size: 1.1em;
            color: #fff;
            font-weight: 500;
            margin-left: 50px;
        }
        .signin-btn {
            padding: 10px 20px;
            background: var(--gradient);
            border: none;
            outline: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
    body {
    margin: 0;
    background-size: cover;
    font-family: 'Oswald', sans-serif;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
background-color: black;
	
	height: 100vh;
}

header {
    width: 100%;
    padding: 20px;
    top: 0;
    color: white;
    text-align: center;
    z-index: 1000;
    display: flex;
    justify-content: center;
    background: var(--main-color);
}

main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
}

.centered-content {
    width: 100%;
    max-width: 1200px;
}

h1 {
    color: #c0c0c0;
    font-weight: 100;
}

.table {
    width: 100%;
    background: #000000;
    border-collapse: collapse;
    color: #fff;

}
.table thead.thead-user {
    background: #09022d;
    color: #fff;
}
.table thead.thead-primary {
    background: #0000;
}

.table thead th {
    border: none;
    padding: 20px 15px;
    font-size: 14px;
    color: #fff;
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

.btn {
    color: #ffffff;
    background: black;
    padding: 10px 20px;
    font-size: 12px;
    text-decoration: none;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.btn:hover {
    border: none;
    background: #fff;
    padding: 20px 20px;
    color: #000000;
}

.delete{
    text-decoration: none;
    color: #f6f6f6;

}
.delete:hover{
    color: red;
}

.footer {
    font-size: 8px;
    color: #fff;
    letter-spacing: 5px;
    border: 1px solid #fff;
    padding: 5px;
    text-decoration: none;
    width: 210px;
    margin: 40px auto;
    text-align: center;
}

.addvehicle {
    margin-top: 20px; 
    text-align: center; 
}

.addvehicle .btn {
    display: inline-block;
}

.approve {
    padding: 8px 12px;
    top:50%;
    background-color:navy;
    color: #fff;
    border:none; 
    border-radius:5px; 
    
   
    cursor: pointer;
}
.reject {
    padding: 8px 12px;
    top:50%;
    background-color:red;
    color: #fff;
    border:none; 
    border-radius:5px; 
    
   
    cursor: pointer;
}

@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
</style>
</head>
<body>
    <header>
        <nav>
            <a href="Hadmin.php" class="btn">Home</a>
            <a href="admin_owner_req.php" class="btn">Approval</a>
            <a href="owner_list.php" class="btn">List</a>
            <a href="admin_logout.php" class="btn">Log out</a>
        </nav>
    </header>
    <main>
        <div>
            <table class="table">
                <thead class="thead-user">
                    <tr>
                        <th colspan="10">OWNER APPROVAL REQUESTS</th>
                    </tr>
                </thead>
                <thead class="thead-primary">
                    <tr>
                    <th>Owner ID</th>    
                    <th>First Name</th>
                        <th>Second Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>phone number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='active-row'>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['lname']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['phone_no']}</td>";
                    echo "<td>
                            <form method='post' style='display:inline-block'>
                                <input type='hidden' name='owner_id' value='{$row['email']}'>
                                <input type='submit' class='approve' name='approve' value='Approve'>
                            </form>
                            <form method='post' style='display:inline-block'>
                                <input type='hidden' name='owner_id' value='{$row['email']}'>
                                <input type='submit' class='reject' name='reject' value='Reject'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>