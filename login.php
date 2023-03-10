<!DOCTYPE html>
<html>
    <head>
    <title>Citizens Health & Information Center | Login</title>
    
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
        <?php 
            if(isset($_POST['login']))
            {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']); 
                //hashedPassword 
                $hashedPassword = hash('sha3-256', $password, true);
                //hashedPassword_hex 
                $hashedPassword_hex = bin2hex($hashedPassword);
                
                $exist = 0; 
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
                $sql = "SELECT * FROM citizens"; 
                $result = $con -> query($sql); 
                while($row = $result -> fetch_object())
                {
                    $compareUsername = $row -> username;  
                    $comparePassword = $row -> password;   

                    if(strcmp($compareUsername, $username)==0 && strcmp($comparePassword, $hashedPassword_hex)==0)
                    {
                        $exist = 1;   
                        $location = "citizenDetails.php?username=".$username; 
                        echo "<script type='text/javascript'>alert('Login successfully');window.location='$location'</script>";
                    } 
                    else 
                    {
                        $exist = 0;
                    }
                }
                if($exist === 0)
                {
                    echo "<script type='text/javascript'>alert('Username and password do not match');</script>";
                }
            }
        ?> 
            <!--Nav bar-->
      <nav class="navbar navbar-expand-lg nav-back fixed-top"id="nav">
          <div class="container">
          <img src="homeWallpaper001.jpg"width=50; height=50px>

              <a href="#" class="navbar-brand">Citizens Health & Information Center </a>
                <button class="navbar-toggler navbar-toggler-right"type="button"
                data-toggle="collapse" data-toggle="#myNavbar" aria-controls="myNavbar"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse"id="myNavbar"> 
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="Home.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                    <a href="register.php" class="nav-link">Register</a>
                    </li>
                    </ul>
					 </div>
                     
            </div>
      </nav>        
      <!--End of Nav bar-->
      <br>
      <br>
      <br>
        <div class="container">
            <form id="loginForm" method="post" action="">
            <div class="bigTextDiv">
                <h1 class="bigText">Citizens Health & Information Center | Login</h1>
            </div>
            <!-- username --> 
            <input type="text" class="txtBox" id="username" 
            name="username" placeholder="Username" 
            autofocus="autofocus" required="required"/>
            <br>
            <br>
            <!-- password --> 
            <input type="password" class="txtBox" id="password" 
            name="password" placeholder="Password" required="required"/>
            <br>
            <br>
            <input type="submit" class="btn2" id="login" value="Login" name="login" />
            <br> 
            <br>
            </form>
        </div>
    </body> 
</html>