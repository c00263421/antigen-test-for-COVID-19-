<!DOCTYPE html>
<html>
<head>
        <title>Citizens Health & Information Center | Citizen Details</title>
        
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
            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                if(!empty($_GET['username']))
                {
                    $cipher = 'AES-128-CBC';
                    $key = 'thebestsecretkey';
                    
                    //retrieve username from URL
                    $username = trim($_GET['username']); 
                    
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    
                    $sql = "SELECT * FROM citizens WHERE username ='$username'";
                    
                    $result = $con -> query($sql); 
                    
                    if($row = $result -> fetch_object())
                    {
                        //iv
                        $iv = hex2bin($row -> iv); 
                        
                        //username
                        $username = $row -> username; 
                         
                        //fullName
                        $fullName_bin = hex2bin($row -> fullName); 
                        $fullName = openssl_decrypt($fullName_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        //address
                        $address_bin = hex2bin($row -> address); 
                        $address = openssl_decrypt($address_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        //dateOfBirth
                        $dateOfBirth_bin = hex2bin($row -> dateOfBirth); 
                        $dateOfBirth = openssl_decrypt($dateOfBirth_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        //phoneNumber
                        $phoneNumber_bin = hex2bin($row -> phoneNumber); 
                        $phoneNumber = openssl_decrypt($phoneNumber_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        //img 
                        $img_bin = hex2bin($row -> img); 
                        $img = openssl_decrypt($img_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        
                        //closeContactFullName
                        $closeContactFullName_bin = hex2bin($row -> closeContactFullName); 
                        $closeContactFullName = openssl_decrypt($closeContactFullName_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                        
                        //closeContactPhoneNumber
                        $closeContactPhoneNumber_bin = hex2bin($row -> closeContactPhoneNumber); 
                        $closeContactPhoneNumber = openssl_decrypt($closeContactPhoneNumber_bin, $cipher, $key, OPENSSL_RAW_DATA, $iv);
                    }
                     $result -> free();
                     $con -> close();
                }
                else 
                {
                    $location = "login.php"; 
                    echo "<script type='text/javascript'>alert('Please login to view citizen details');window.location='$location'</script>";
                }

            }
            
            else
            { 
                $username = trim($_GET['username']); 
                $fullName  = trim($_POST['fullName']);
                $address  = trim($_POST['address']);
                $dateOfBirth = trim($_POST['dateOfBirth']);
                $phoneNumber = trim($_POST['phoneNumber']);
                //img 
                $img = file_get_contents($_FILES['img']['tmp_name']);
                $closeContactFullName = trim($_POST['closeContactFullName']);
                $closeContactPhoneNumber = trim($_POST['closeContactPhoneNumber']); 
                 
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
                    
                    $sql = "UPDATE citizens SET iv = ?, fullName  = ?, address = ?, dateOfBirth = ?, phoneNumber = ?, img = ?, closeContactFullName = ?, closeContactPhoneNumber = ? WHERE username = ?";
                    
                    $stmt = $con -> prepare($sql);  
                    
                    $stmt -> bind_param('sssssssss', $iv_hex, $encryptedFullName_hex, $encryptedAddress_hex, $encryptedDateOfBirth_hex, $encryptedPhoneNumber_hex, $encryptedImg_hex, $encryptedCloseContactFullName_hex, $encryptedCloseContactPhoneNumber_hex, $username); 
                    
                    if($stmt -> execute())
                    {
                        $location = "citizenDetails.php?username=".$username; 
                        echo "<script type='text/javascript'>alert('Successfully update citizen details');window.location='$location'</script>";
                    }
                    else 
                    {
                        $location = "citizenDetails.php?username=".$username;
                        
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
      <br>
      <br>
      <br>
        <div class="container">
        <form class="user" action="" method="post" enctype='multipart/form-data'>
        
             
            <div class="bigTextDiv">
                <h1 class="bigText">Citizens Health & Information Center | Citizen Details</h1>
            </div>
             
            <!-- username --> 
            <label class="txtBox">Username (unachangeable) :</label>
            <br>
            <input type="text" class="txtBox" id="username" name="username" value="<?php echo $username?>" readonly/>
              
            <br><br>
            
            <!-- fullName --> 
            <label class="txtBox">Full Name :</label>
            <br>
            <input type="text" class="txtBox" id="fullName" name="fullName" value="<?php echo $fullName?>" required="required"/>
            
            <br><br>
            
            <!-- address --> 
            <label class="txtBox">Address :</label>
            <br>
            <input type="text" class="txtBox" id="address" name="address" value="<?php echo $address?>" required="required"/>
            
            <br><br>
            
            <!-- dateOfBirth --> 
            <label class="txtBox">Date Of Birth :</label>
            <br>
            <input type="date" class="txtBox" id="dateOfBirth" name="dateOfBirth" value="<?php echo $dateOfBirth?>" required="required"/>
            
            <br><br>
            
            <!-- phoneNumber --> 
            <label class="txtBox">Phone Number :</label>
            <br>
            <input type="text" class="txtBox" id="phoneNumber" name="phoneNumber" value="<?php echo $phoneNumber?>" required="required" maxlength="10"/>
            
            <br><br><br>
            
            <!-- image --> 
            <label class="txtBox">Image of a positive antigen test :</label>
            <br>
            <?php $display_img = '<img src="data:image/jpeg;base64,'.base64_encode( $img ).'" width="650px" height="500px"/>'; ?>
            <label><?php echo $display_img?></label>
            <input type="file" class="txtBox" id="img" name="img" accept="image/*" required="required"/>
            
            <br><br>
            
            <!-- closeContactFullName --> 
            <label class="txtBox">Full name of Close Contact :</label>
            <br>
            <input type="text" class="txtBox" id="closeContactFullName" 
            name="closeContactFullName" value="<?php echo $closeContactFullName?>" />
            
            <br><br>
            
            <!-- closeContactPhoneNumber -->
            <label class="txtBox">Phone Number Close Contact :</label>
            <br>
            <input type="text" class="txtBox" id="closeContactPhoneNumber" 
            name="closeContactPhoneNumber" value="<?php echo $closeContactPhoneNumber?>" maxlength="10"/>
            
            <br>
            <br>
            <br>
            
            <input type="submit" class="btn2" id="update" value="Update" name="update" />
            </form>
            
            <br>
        </div>
        
        
    </body>
</html>