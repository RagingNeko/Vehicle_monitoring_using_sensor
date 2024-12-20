<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - NMSC</title>
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
    <script type="text/javascript">
        // Prevent back navigation
        function preventBack() {
            window.history.forward();
        }
        setTimeout(preventBack, 0);
        window.onunload = function () { null; };
    </script>
</head>

<?php include 'header.php' ?>
<body>

<main class="container">
    <section class="about-us">
        <div class="text-content">
            <h2>About Us:</h2>
            <p class="lead">At Vehicle Parking Monitoring System, we provide innovative and efficient smart parking solutions designed to make parking hassle-free for everyone.</p>
            <p>Our mission is to leverage cutting-edge technology to improve urban mobility and provide our customers with a seamless parking experience.</p>
            <p>Founded in [2022], our team consists of passionate individuals committed to transforming the parking industry. Join us in our journey towards smarter cities!</p>
        </div>
        <div class="image-content">
            <img src="images/us.png" alt="Parking Area" class="about-image">
        </div>
    </section>
</main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-OA6hbn2gqtkAu2BUK/7cC03/Z4uAzgU1l2cT+EVX9inCeY6/USLMwtEyTcQBE0km" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-yyg+/f1t2J9wxd8BQLok5esNKZ0FDkmZ9wAM0F0g4bNp6PzZHzTdt2D+4hPuGb3k" crossorigin="anonymous"></script>
</body>
<?php include 'footer.php' ?>
</html>
