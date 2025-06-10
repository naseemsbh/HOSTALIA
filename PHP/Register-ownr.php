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
    $name = trim($_POST['name']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone_no = trim($_POST['phone_no']);
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
        $stmt = $con->prepare("INSERT INTO owners (name, lname, email, address, phone_no, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $lname, $email, $address, $phone_no, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Owner registered successfully'); window.location.href='Login-ownr.php';</script>";
        } else {
            error_log("Registration error: " . $stmt->error);
            echo "<script>alert('Registration error, please try again later'); window.location.href='Register-ownr.php';</script>";
        }

        $stmt->close();
    } else {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('".escape_output($error_message)."'); window.location.href='Register-ownr.php';</script>";
    }

    $con->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="rstyle.css">
    <script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration/Owner</title>
    <script>
        function validateEmail(email) {
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            return emailPattern.test(email);
        }

        function validatePassword(password) {
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{4,}$/;
            return passwordPattern.test(password);
        }

        function validatePhoneNumber(phone_no) {
            const phonePattern = /^\d{10}$/;
            return phonePattern.test(phone_no);
        }

        function validateName(name) {
            const namePattern = /^[a-zA-Z ]+$/;
            return namePattern.test(name);
        }

        function liveValidate() {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const cpassword = document.getElementById('cpassword');
            const phone_no = document.getElementById('phone_no');
            const name = document.getElementById('name');
            const lname = document.getElementById('lname');

            email.addEventListener('input', function () {
                if (!validateEmail(email.value)) {
                    email.setCustomValidity('Invalid email format');
                } else {
                    email.setCustomValidity('');
                }
                email.reportValidity();
            });

            password.addEventListener('input', function () {
                if (!validatePassword(password.value)) {
                    password.setCustomValidity('Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.');
                } else {
                    password.setCustomValidity('');
                }
                password.reportValidity();
            });

            cpassword.addEventListener('input', function () {
                if (password.value !== cpassword.value) {
                    cpassword.setCustomValidity('Passwords do not match');
                } else {
                    cpassword.setCustomValidity('');
                }
                cpassword.reportValidity();
            });

            phone_no.addEventListener('input', function () {
                if (!validatePhoneNumber(phone_no.value)) {
                    phone_no.setCustomValidity('Invalid phone number. It must be 10 digits long.');
                } else {
                    phone_no.setCustomValidity('');
                }
                phone_no.reportValidity();
            });

            name.addEventListener('input', function () {
                if (!validateName(name.value)) {
                    name.setCustomValidity('Invalid name format. Only letters and spaces are allowed.');
                } else {
                    name.setCustomValidity('');
                }
                name.reportValidity();
            });

            lname.addEventListener('input', function () {
                if (!validateName(lname.value)) {
                    lname.setCustomValidity('Invalid last name format. Only letters and spaces are allowed.');
                } else {
                    lname.setCustomValidity('');
                }
                lname.reportValidity();
            });
        }

        window.onload = liveValidate;
    </script>
</head>
<body>
    <div class="wrapper">
        <header>
            <h2 class="logo"><i class="fa-solid fa-hotel"></i> Hostalia</h2>
            <nav class="navigation">
                <button class="signin-btn" name="signin-btn" onclick="redirectToSignin()"><b>Sign in</b></button>
                <script>
                    function redirectToSignin() {
                        window.location.href = "Login-adm.php";
                    }
                </script>
            </nav>
        </header>
        <div class="form-box">
            <div class="r-container">
                <h1>Registration/Owner</h1>
                <form id="form" action="Register-ownr.php" method="post">
                    <div class="two-form">
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="name" id="name" class="input-field1" placeholder="First Name" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="lname" id="lname" class="input-field2" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" id="email" class="input-field" placeholder="Email Id" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone_no" maxlength="10" id="phone_no" pattern="\d{10}" class="input-field" placeholder="Phone no" required>
                    </div>
                    <div class="input-box">
                        <i class="fa-solid fa-house"></i>
                        <textarea type="text" name="address" class="input-field4" id="address" placeholder="Address" required></textarea>
                    </div>
                    <div class="input-box">
                        <div class="input-control">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" class="input-field5" id="password" name="password" placeholder="Password" required>
                          
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
                        <span>Already have an account? <a href="Login-adm.php" onclick="login()"><b>Sign In</b></a></span>
                  
                    <span>Register as user?<a href="Register.php" onclick="login()"> <b>Register </b></a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
