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
            if(isset($_POST['register']))
            {
                $username = trim($_POST['username']); 
                $password = trim($_POST['password']);
                $confirmPassword = trim($_POST['confirmPassword']);
                $fullName  = trim($_POST['fullName']);
                $address  = trim($_POST['address']);
                $dateOfBirth = trim($_POST['dateOfBirth']);
                $phoneNumber = trim($_POST['phoneNumber']);
                //img 
                $img = file_get_contents($_FILES['img']['tmp_name']);
                $closeContactFullName = trim($_POST['closeContactFullName']);
                $closeContactPhoneNumber = trim($_POST['closeContactPhoneNumber']); 
                
                $error['username'] = validateUsername($username); 
                $error['password'] = validatePassword ($password, $confirmPassword); 
                $error['fullName'] = validateFullName($fullName); 
                $error['address'] = validateAddress($address); 
                $error['dateOfBirth'] = validateDateOfBirth($dateOfBirth); 
                $error['phoneNumber'] = validatePhoneNumber($phoneNumber); 
                $error['closeContactFullName'] = validateCloseContactFullName($closeContactFullName); 
                $error['closeContactPhoneNumber'] = validateCloseContactPhoneNumber($closeContactPhoneNumber); 
                $error = array_filter($error); 
                
                $cipher = 'AES-128-CBC';
                $key = 'thebestsecretkey';
                
                //iv_hex
                $iv = random_bytes(16);
                $iv_hex = bin2hex($iv); 
                
                //hashedPassword 
                $hashedPassword = hash('sha3-256', $password, true);
                //hashedPassword_hex 
                $hashedPassword_hex = bin2hex($hashedPassword);
                
                //encryptedFullName
                $encryptedFullName = openssl_encrypt($fullName, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedFullName_hex
                $encryptedFullName_hex =  bin2hex($encryptedFullName);
                
                //encryptedAddress
                $encryptedAddress = openssl_encrypt($address, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedAddress_hex
                $encryptedAddress_hex =  bin2hex($encryptedAddress);
                
                //encryptedDateOfBirth
                $encryptedDateOfBirth = openssl_encrypt($dateOfBirth, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedDateOfBirth_hex
                $encryptedDateOfBirth_hex =  bin2hex($encryptedDateOfBirth);
                
                //encryptedPhoneNumber
                $encryptedPhoneNumber = openssl_encrypt($phoneNumber, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedPhoneNumber_hex
                $encryptedPhoneNumber_hex =  bin2hex($encryptedPhoneNumber);
                
                //encryptedImg
                $encrypted_img = openssl_encrypt($img, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedImg_hex
                $encryptedImg_hex = bin2hex($encrypted_img);
                
                //encryptedCloseContactFullName
                $encryptedCloseContactFullName = openssl_encrypt($closeContactFullName, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedCloseContactFullName_hex
                $encryptedCloseContactFullName_hex =  bin2hex($encryptedCloseContactFullName);
                
                //encryptedCloseContactPhoneNumber
                $encryptedCloseContactPhoneNumber = openssl_encrypt($closeContactPhoneNumber, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                //encryptedCloseContactPhoneNumber_hex
                $encryptedCloseContactPhoneNumber_hex =  bin2hex($encryptedCloseContactPhoneNumber);
                
                if(empty($error))
                {
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    
                    $sql = "INSERT INTO citizens (id, iv, username, password, fullName, address, dateOfBirth, phoneNumber, img, closeContactFullName, closeContactPhoneNumber) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $con -> prepare($sql); 
                    $id = NULL; 
                    
                    $stmt -> bind_param('issssssssss', $id, $iv_hex, $username, $hashedPassword_hex, $encryptedFullName_hex, $encryptedAddress_hex, $encryptedDateOfBirth_hex, $encryptedPhoneNumber_hex, $encryptedImg_hex, $encryptedCloseContactFullName_hex, $encryptedCloseContactPhoneNumber_hex); 
                    
                    $stmt -> execute(); 
                    if($stmt -> affected_rows > 0)
                    {
                        printf('<script>alert("Register successfully"); location.href = "./login.php"</script>');
                    }
                    
                    $stmt->close();
                    $con->close();
                }
                else
                {
                   //display error msg 
                   echo "<ul class=‘error’>";
                   foreach ($error as $value)
                   {
                   echo "<li>$value</li>";
                   echo "</ul>";
                   }
                }
            }
        ?>
         <!--Nav bar-->
      <nav class="navbar navbar-expand-lg nav-back fixed-top"id="nav">
          <div class="container">
                <img src="homeWallpaper001.jpg"width=50; height=50px>

                <a href="#" class="navbar-brand">Citizens Health & Information Center 

                </a>
                    <button class="navbar-toggler navbar-toggler-right"type="button"
                        data-toggle="collapse" data-toggle="#myNavbar" aria-controls="myNavbar"
                        aria-expanded="false" aria-label="Toggle navigation">
                    </button>
                <div class="collapse navbar-collapse"id="myNavbar"> 
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="Home.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
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
            <form class="user" action="" method="post" enctype='multipart/form-data'>
        
            <div class="bigTextDiv">
                <h1 class="bigText">Citizens Health & Information Center | Register</h1>
            </div>
            <!-- username --> 
            <input type="text" class="txtBox" id="username" name="username" placeholder="Username" autofocus="autofocus" required="required"/>
            <br>
            <br>
            <!-- password --> 
            <input type="password" class="txtBox" id="password" name="password" placeholder="Password" required="required"/>
            <br>
            <br>
            <!-- confirmPassword --> 
            <input type="password" class="txtBox" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required="required"/>
            <br>
            <br>
            <!-- fullName --> 
            <input type="text" class="txtBox" id="fullName" name="fullName" placeholder="Full Name" required="required"/>
            <br>
            <br>
            <!-- address --> 
            <input type="text" class="txtBox" id="address" name="address" placeholder="Address" required="required"/>
            <br>
            <br>
            <!-- dateOfBirth --> 
            <input type="date" class="txtBox" id="dateOfBirth" name="dateOfBirth" required="required"/>
            <br>
            <br>
            <!-- phoneNumber --> 
            <input type="text" class="txtBox" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required="required" maxlength="10"/>
            <br>
            <br>
            <!-- img --> 
            <label class="txtBox">Image of a positive antigen test :</label>
            <input type="file" class="txtBox" id="img" name="img" accept="image/*" required="required"/>
            <br>
            <br>
            <!-- closeContactFullName --> 
            <input type="text" class="txtBox" id="closeContactFullName" name="closeContactFullName" placeholder="Close Contact Full Name"/>
            <br>
            <br>
            <!-- closeContactPhoneNumber -->
            <input type="text" class="txtBox" id="closeContactPhoneNumber" name="closeContactPhoneNumber" placeholder="Close Contact Phone Number" maxlength="10"/>
            
            <br>
            <br>
            <br>
            <input type="submit" class="btn2" id="register" value="Register" name="register" />
            </form>
            <br> 
        
        </div>
    </body>
</html>