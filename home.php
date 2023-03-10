<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Citizens Health & Information Center | Home</title>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/66de160463.js" crossorigin="anonymous"></script>
</head>
<body>
        <?php 
            require_once 'validation.php';
        ?>
		
		<!--Nav bar-->
      <nav class="navbar navbar-expand-lg nav-back fixed-top"id="nav">
          <div class="container">
          <img src="./images/homeWallpaper01.jpg"width=50; height=50px>
                
              <a href="#" class="navbar-brand">Citizens Health & Information Center </a>
                <button class="navbar-toggler navbar-toggler-right"type="button"
                data-toggle="collapse" data-toggle="#myNavbar" aria-controls="myNavbar"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse"id="myNavbar"> 
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                    </li>
                    <li class="nav-item">
                    <a href="register.php" class="nav-link">Register</a>
                    </li>
                    </ul>
					 </div>
                    
            </div>
      </nav>        
      <!--End of Nav bar-->
      
      <!--mainpage Image-->
      <section id="mainpage" class="d-flex align-items-center">
          <div class="container text-center position-relative">
              <h1>Total Care</h1>
              <h2 class="text-uppercase">Citizens Health & Information Center.</h2>
                </div>
            </section>
            <!--End of mainpage-->
    </body>
</html>