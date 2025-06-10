<?php
session_start();
require 'connection.php'; 

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{4,}$/', $password);
}

function escape_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $lname = trim($_POST['lname']);
    $college = trim($_POST['College']);
    $year = trim($_POST['year']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);

    $errors = [];

    if (!validate_email($email)) {
        $errors[] = "Invalid email format";
    }
    if (!validate_password($password)) {
        $errors[] = "Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.";
    }
    if ($password !== $cpassword) {
        $errors[] = "Passwords do not match";
    }

    if (empty($errors)) {
        $stmt = $con->prepare("INSERT INTO users (username, lname, college, year, email, address, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $username, $lname, $college, $year, $email, $address, $phone, $password);

        if ($stmt->execute()) {
            echo "<script>alert('User registered successfully'); window.location.href='Home-usr.php';</script>";
        } else {
            error_log("Registration error: " . $stmt->error);
            echo "<script>alert('Registration error, please try again later'); window.location.href='Register.php';</script>";
        }

        $stmt->close();
    } else {
        
        $error_message = implode("\\n", $errors);
        echo "<script>alert('".escape_output($error_message)."'); window.location.href='Register.php';</script>";
    }

    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="">
    <script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student/Registration</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h2 class="logo"><i class="fa-solid fa-hotel"></i> Hostalias</h2>
            <nav class="navigation">
                <button class="signin-btn" name="signin-btn" onclick="redirectToSignin()"><b>Sign in</b></button>
                <script>
                    function redirectToSignin() {
                        window.location.href = "index.php";
                    }
                </script>
            </nav>
        </header>
        <div class="form-box">
            <div class="r-container">
                <h1>Registration/Student</h1>

                <style>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'poppins', sans-serif;
    
}

body{
    background:  linear-gradient(rgba(1, 1, 30, 0.8),rgba(0,0,30,0.8)),url(background_image.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 110vh;
    background: rgba(39,39,39,.4);
}

header{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 15px 50px;
    background:  linear-gradient(rgba(2, 2, 38, 0.8),rgba(0,0,50,0.8));
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
}



.logo{
    font-size: 2em;
    color: #fff;
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
   
}    

.navigation .signin-btn:hover{
   background: rgba(255,255,255,0.4);
    
}

.form-box{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 512px;
    height: 100px;
    
    z-index: 2;
}

.r-container{
    width: 500px;
    display: flex;
    flex-direction: column;
    transition: .5s ease-in-out;
}

.top span{
    color: #ffffff;
    font-size: small;
    padding: 10px 0;
    display: flex;
    justify-content: center;
}

.top span a{
    font-weight: 500;
    color: #ffffff;
    margin-left: 5px;
}
.form-box h1{
    color: #ffffff;
    font-size: 30px;
    text-align: center;
    padding: 10px 0 30px 0;
}

.two-form{
    display: flex;
    gap: 20px;
}
.two-form1{
    display: flex;
    gap: 0px;
}
.two-formcat{
    display: flex;
    gap: 10px;
}
.input-field{

    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    display: flex;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    padding: 20px 45px;
}

.input-field1{
    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    width: 102% ;
    padding: 20px 45px;
    
}
.input-fieldc{
    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    width: 95% ;
    padding: 20px 45px;
    
}

.input-field2{
    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    width: 102% ;
    padding: 20px 45px;
    
}

.input-field3{
    background:rgba(255,255,255,0.2);
    margin: 2px 0;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    width: 96% ;
    padding: 20px 45px;
}

.input-field4{
    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    width: 100% ;
    padding: 20px 40px;
}


input{
    width: 100%;
    background: transparent;
    border: 0;
    outline: 0;
    padding: 18px 15px;
}

.input-box a{
    color: #fff;
    margin-left: 5px;
}

.input-field1:hover,.input-field1:focus{
    background:rgba(255,255,255,0.25);
}
.input-field2:hover,.input-field2:focus{
    background:rgba(255,255,255,0.25);
}
.input-field3:hover,.input-field3:focus{
    background:rgba(255,255,255,0.25);
}
.input-field4:hover,.input-field4:focus{
    background:rgba(255,255,255,0.25);
}
.input-field:hover,.input-field:focus{
    background:rgba(255,255,255,0.25);
}

::-webkit-input-placeholder{
    color: #fff;    
}

.input-box i{
    position: relative;
    top: 39px;
    left: 17px;
    color: #fff;
}

.drop-listcat select{
    height: 53px;
    width: 200%;
    background: rgba(255, 255, 255, 0.2);
    margin:  20px -20px 0;
    display: flex;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    font-size: 16px;
    color: #ffffff;
    margin-left: 1px;
    outline: none;
    cursor: pointer;
}

.drop-listcat option{
    color: #000000;
}


.drop-listcat .tite{
    position: relative;
    color: #000000;
}

.drop-listcat .tite::before{
    position: absolute;
    content: 'category:';
    top: -61px;
    left: 20px;
    background: transparent;
    color: #fff;
    width: 12%;
   height: -10%;
    text-align: center;
    font-size: medium;
}


.drop-list select{
    height: 53px;
    width: 353%;
    background: rgba(255, 255, 255, 0.2);
    margin:  20px -20px 0;
    display: flex;
    max-height: 65px;
    transition: Max-height 0.5s;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
    font-size: 16px;
    color: #ffffff;
    
    outline: none;
    cursor: pointer;
}

.drop-list option{
    color: #000000;
}


.drop-list .tite{
    position: relative;
    color: #000000;
}

.drop-list .tite::before{
    position: absolute;
    content: 'Year:';
    top: -61px;
    left: -5px;
    background: transparent;
    color: #fff;
    width: 12%;
   height: -10%;
    text-align: center;
    font-size: medium;
}



.submit-btn{
    font-size: 15px;
    font-weight: 500;
    color: rgb(0, 0, 0);
    border: none;
    border-radius: 30px;
    outline: none;
    background: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: .3s ease-in-out;
    height: 48px;
    width: 200px;
    text-align: center;
    margin-left: 25px;
    margin: 15px 30px;
}

.submit-btn:hover{
    background: rgba(255,255,255,0.4) ;
    box-shadow: 1px 5px 7px 1px rgba(0,0,0,0.2);
}

.two-form3{
    display: flex;
    gap: 10px;
}

.reset-btn{
    font-size: 15px;
    font-weight: 500;
    color: #000000;
    border: none;
    border-radius: 30px;
    outline: none;
    background: rgba(255,255,255,0.7);
    cursor: pointer;
    transition: .3s ease-in-out;
    height: 45px;
    width: 200px;
    text-align: center;
    margin:15px 0px 20px;
}

.reset-btn:hover{
    background: rgba(255,255,255,0.4) ;
    box-shadow: 1px 5px 7px 1px rgba(0,0,0,0.2);
}

.top span{
    font-size: 14px;
    color: rgb(255, 255, 255);
    text-align: center;
}


.top a{
    font-weight: 500;
    color: #ffffff;
    font-size: 15px;
    text-align: center;

}

input::-webkit-inner-spin-button,
input::-webkit-outer-spin-button{
    -webkit-appearance: none;
    margin: 0;
}

input:valid {
    color: rgb(255, 255, 255);
  }
  input:invalid {
    color: rgb(255, 255, 255);
  }

  textarea:valid{
    color: rgb(255, 255, 255);
  }

  .input-control {
    display: flex;
    flex-direction: column;

}

.input-control input {
    border: none;
	border-radius: 30px;
	display: block;
	
	
	width: 100%;
    
    background: rgba(255,255,255,0.2);
    margin: 2px 0;
    display: flex;
    align-items: center;
    max-height: 65px;
    transition: Max-height 0.5s;
   
    transition: .2s ease;
    padding: 20px 45px;
}

.input-control input:focus {
    outline: 0;
}

.input-control.success input {
    border-color: transparent;
}

.input-control.error input {
    border-color: transparent;
}

.input-control .error {
    color: #ffffff;
    font-size: 15px;
    height: 13px;
    padding: 20px;
}

.input-box img{
    width: 25px;
    cursor: pointer;
    margin-left: 450px;
    margin-top: -40px;
}



                </style>
                <form id="form" action="Register.php" method="post">
                    <div class="two-form">
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="username" id="fname" class="input-field1" placeholder="First Name" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="lname" id="lname" class="input-field2" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="two-formcat">
                        <main class="drop-listcat">
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="college" id="college" class="input-fieldc" placeholder="college" required>
                        </div>
                           
                        </main>
                        <main class="drop-list">
                            <select name="year" id="year" required>
                                <option value="">Select Year</option>
                                <option name="1styear" value="1styear">1st Year</option>
                                <option name="2ndyear" value="2ndyear">2nd Year</option>
                                <option name="3rdyear" value="3rdyear">3rd Year</option>
                                <option name="4thyear" value="4thyear">4th Year</option>
                            </select>
                            <span class="tite"></span>
                        </main>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" class="input-field" placeholder="Email Id" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" maxlength="10" id="phone" pattern="\d{10}" class="input-field" placeholder="Phone no" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-house"></i>
                        <textarea type="text" name="address" class="input-field4" id="address" placeholder="Address" required></textarea>
                    </div>
                    <div class="input-box">
                        <div class="input-control">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input-field5" id="password" name="password" placeholder="Password" required>
                            <img src="eye-close.png" id="eyeicon">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input-field5" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="two-form3">
                        <div class="input-box">
                            <input type="submit" name="submit" value="Submit" class="submit-btn">
                        </div>
                        <div class="input-box">
                            <input type="reset" value="Reset" class="reset-btn">
                        </div>
                    </div>
                    <div class="top">
                        <span>Already have an account? <a href="index.php" onclick="login()"><b>Sign In</b></a></span>
                   
                    <span>Register as owner?<a href="Register-ownr.php" onclick="login()"> <b>Register </b></a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
