<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Parking System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
 <!-- Font Awesome -->
 <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"
      rel="stylesheet"
    />
<style>
    body{
      background image: url('image/parking.png');
    }
</style>
<script type="text/javascript">
        function preventBack() {
            window.history.forward();
        }
        setTimeout(preventBack, 0);
        window.onunload = function () { null; }
    </script>
    </head>

    <header>    
    <div class="logo-header">
    <img src="images/logo.png" alt="Logo" class="logo">
    <h1>Northwestern Mindanao State College</h1>
</div>

        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>

        <nav>
        <a href="login.php" class="tbtn">Admin</a>
        <a href="#about-section" class="tbtn">about</a>
        <a href="#team-section" class="tbtn">Contact Us</a>
    </nav>
</header>

<body>


    <div class="contain">
        <section class="hero">
        <img src="images/r.png" alt="Parking Area" class="Parking">
        <h2>VEHICLE PARKING SPACE MONITORING SYSTEM</h2>
            <p>Enables users to view the parking area in a distance and provides parking area informations in real-time</p>
            <a href="user_parking.php" class="tbtn">Get Started</a>
            
        </section>

        <section class="features">
            <h2>Our Features:</h2>
            <div>
        </section>

        <div class="carousel">
        <div class="images">
        
            <img src="images/parkingA.jpg">
            <img src="images/parkingB.jpg">
            <img src="images/ss.jpg">
        </div>
    </div>

        
        <main class="container">
    <section class="about-us" id="about-section">
        <div class="text-content">
            <h2>About Us</h2>
            <p class="lead">At Vehicle Parking Monitoring System, we provide innovative and efficient smart parking solutions designed to make parking hassle-free for everyone.</p>
            <p>Our mission is to leverage cutting-edge technology to improve urban mobility and provide our customers with a seamless parking experience.</p>
            <p>Founded in [2022], our team consists of passionate individuals committed to transforming the parking industry. Join us in our journey towards smarter cities!</p>
        </div>
      
    <button id="back-to-top" title="Go to top">↑</button>
   
        <div class="image-content">
            <img src="images/us.png" alt="Parking Area" class="about-image">
        </div>
        
    </section>
</main>
    </div>

    <div class="contain">
    <section class="team" id="team-section">
    
    
      <div class="row">
        <h1>Our Team</h1>
      </div>
      <div class="row">
        <!-- Column 1-->
        <div class="column">
          <div class="card">
            <div class="img-container">
              <img src="images/reeg.jpg" />
            </div>
            <h3>Reegen Dael Abella</h3>
            <p>Project Manager</p>
            <div class="icons">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-github"></i>
              </a>
              <a href="#">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- Column 2-->
        <div class="column">
          <div class="card">
            <div class="img-container">
              <img src="images/gun.jpg" />
            </div>
            <h3>Jhon Mark Lobitaña</h3>
            <p>Programmer</p>
            <div class="icons">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="https://web.facebook.com/jhonmark.lobitana.5">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-github"></i>
              </a>
              <a href="https://www.youtube.com/watch?v=ZHgyQGoeaB0">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- Column 3-->
        <div class="column">
          <div class="card">
            <div class="img-container">
              <img src="images/berly.jpg" />
            </div>
            <h3>Beverly Sumalinog</h3>
            <p>Designer</p>
            <div class="icons">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-github"></i>
              </a>
              <a href="#">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- Column 4-->
        <div class="column">
          <div class="card">
            <div class="img-container">
              <img src="images/efren.jpg" /> <!-- Add your image here -->
            </div>
            <h3>Efren Rabanal</h3> <!-- Name of the new member -->
            <p>System Analyst</p> <!-- Position of the new member -->
            <div class="icons">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-github"></i>
              </a>
              <a href="#">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      </div>
      </body>
<?php include "footer.php"?>
</html>
      
    </section>
    
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-OA6hbn2gqtkAu2BUK/7cC03/Z4uAzgU1l2cT+EVX9inCeY6/USLMwtEyTcQBE0km" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-yyg+/f1t2J9wxd8BQLok5esNKZ0FDkmZ9wAM0F0g4bNp6PzZHzTdt2D+4hPuGb3k" crossorigin="anonymous"></script>
    <script src="script.js"></script>

    <script>
        // Show the button when the user scrolls down
        window.onscroll = function() {
            const button = document.getElementById('back-to-top');
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        };

        // Scroll to the top when the button is clicked
        document.getElementById('back-to-top').onclick = function() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        };
    </script>

