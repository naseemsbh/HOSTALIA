<?php
require_once('connection.php');
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home</title>
<link rel="stylesheet" href="homestyle.css">
<style>
  

</style>
<script src="https://kit.fontawesome.com/38a7376f2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
    <header>
        
        <h2  class="logo"><i class="fa-solid fa-hotel"></i> Hostalia</h2>
        <nav class="navigation">
        <a href="#home">Home</a>
         <a href="#intro">Booking</a>
            <a href="#booking">Room</a>
            
            <a href="status.php">Booking Status</a>
            <button class="signin-btn" name="signin-btn" onclick="redirectToLogout()"><b>Log out</b></button>

<script>
function redirectToLogout() {
    window.location.href = "logout.php";
}
</script>

        </nav>
    </header>
    <!--HOME-->
    <section class="home" id="home">
      <div class="bdy">
    <div class="bg">
    <h1>HOSTALIA</h1>
  </div>
  <div class="nft">
    <div class='home-main'>
      <img class='tokenImage' src="home-usr1.jpg"  alt="NFT" />
      <h2 class="h2">Hostalia</h2>
      <p class='description'> Discover Hostalia: Streamlined and modern hostel management, ensuring a comfortable and convenient stay for every one.</p>
      <div class='tokenInfo'>
        <div class="price">
         
          <p></p>
        </div>
        <div class="duration">
          <ins>◷</ins>
          <p>24/7</p>
        </div>
      </div>
      <hr />
      <div class='creator'>
        
        <p><ins>Explore </ins><a href="#intro" onclick="login()">Hostalia</a></p>
      </div>
    </div>
  </div>
    </div>
  </div>
  </section>
      <!--steps-->
      <section class="intro" id="intro">
  
            <h1>HOSTALIA</h1>
          </div>
          <div class="heading">
              <span>How Its work</span>
              <h1>Booking with 3 Easy steps</h1>
          </div>
          <div class="ride-container">
          <div class="card">
            <div class="box">
              <div class="content">
                <h2>01</h2>
                <h3>Filter and Select</h3>
                <p>Filter and you can select any of our hostel and check the availability of   rooms based on your preferences.</p>
                
              </div>
            </div>
          </div>
        
          <div class="card">
            <div class="box">
              <div class="content">
                <h2>02</h2>
                <h3>Register and Apply</h3>
                <p>complete the application form with your details, and submit your booking request.</p>
               
              </div>
            </div>
          </div>
        
          <div class="card">
            <div class="box">
              <div class="content">
                <h2>03</h2>
                <h3>Confirm and Check-in</h3>
                <p>Owner verify you details and check the availability of room and you will receive confirmation and prepare for your seamless check-in at Hostalia.</p>
                
              </div>
            </div>
          </div>
        </div>
      </div>
          </section>
      <!--Booking-->
     




      <section class="booking" id="booking">
    <div class="heading">
        <span>Best Services</span>
        <h1>Explore Our Top Deals <br>From Top Rated Hostels</h1>
    </div>
    <div class="booking-container">
        <?php 
        include 'connection.php';
        
        $sql2 = "SELECT * FROM hostels WHERE AVAILABLE='Y'";
        $result = mysqli_query($con, $sql2);
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath =   $row['hostel_image'];
            echo '<!-- Image Path: ' . $imagePath . ' -->';
        ?>

            <div class="box">
                <div class="box-img">
                <img src="<?php echo $imagePath; ?>" alt="<?php echo $row['hostel_name']; ?>">
                </div>
                <p><?php echo $row['hostel_id']; ?></p>
                <h3><?php echo $row['hostel_name']; ?></h3>
                <a href="booking.php?id=<?php echo $row['hostel_id']; ?>" class="btn">Book Now</a>
            </div>
        <?php
        }
        ?>
    </div>
</section>


    
</body>

</html>