<?php
session_start();
require 'connection.php'; 

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function escape_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    if (!validate_email($email)) {
        echo "<script>alert('Invalid email format'); window.location.href='index.php';</script>";
    } else {
      
        $stmt = $con->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

       
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($stored_password);
            $stmt->fetch();

          
            if ($password == $stored_password) {
                $_SESSION['email'] = $email;  
                
                echo "<script>alert('Login successful'); window.location.href='Home-usr.php';</script>";
            } else {
                echo "<script>alert('Incorrect password'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('No user found with that email address'); window.location.href='index.php';</script>";
        }

        $stmt->close();
    }

    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        
        <h2  class="logo"><i class="fa-solid fa-hotel"></i> Hostalia</h2>
        <nav class="navigation">
        <button class="signup-btn" name="owner-btn" onclick="redirectToAdmin()"><b>Admin</b></button>  
        <button class="signup-btn" name="register-btn" onclick="redirectToRegister()"><b>Register</b></button>

<script>
    function redirectToAdmin() {
    window.location.href = "Admin-login.php";
}
function redirectToRegister() {
    window.location.href = "register.php";
}
</script>

        </nav>
    </header>
<div class="container">
<div class="form-box">
    
 <h1>Login</h1>
                <form id="form" action="index.php" method="post">
                <div class="input-group">
                    <div class="input-field" id="nameField">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email"  placeholder="Email Id" required>
                    </div>
                    <div class="input-field">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password"  id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="login-link">
                 <p>
                   <a href="a"> <b>  Forgot password!</a></b>
                 </p>    
                </div>  
                        <input type="submit" name="login" value="Login" class="submit-btn">
                    </div>
                    <div class="btn-field">
            <button type="button" id="StudentBtn" onclick="redirectToStudent()">Student</button>
            <script>
                function redirectToStudent() {
                    window.location.href = "index.html";
                }
                </script>
            <button type="button" id="AdminBtn" class="disable"  onclick="redirectToOwner()">Owner</button>
            <script>
                function redirectToOwner() {
                    window.location.href = "Login-ownr.php";
                }
                </script>
         </div>
         <div class="Register-link">
            <p>
               Don't have an account? <a href="Register.php" onclick="login()"><b>Register</b></a>
            </p>    
           </div>  
                </form>
            </div>
        </div>
    </div>
</body>
</html>
