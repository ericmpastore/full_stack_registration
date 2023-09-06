<?php
    // log all errors
    error_reporting(E_ALL);
    
    // capture fields from POST superglobal and verify load
    $email;$fullname;$username;$password;$captcha;
    if(isset($_POST['email'])){
      $email=$_POST['email'];
    }
    if(isset($_POST['fullname'])){
      $comment=$_POST['fullname'];
    }
    if(isset($_POST['username'])){
      $comment=$_POST['username'];
    }
    if(isset($_POST['password'])){
      $comment=$_POST['password'];
    }
    
    // verify captcha loaded
    if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
    }
    if(!$captcha){
      echo '<h2>Please check the the captcha form.</h2>';
      exit;
    }
    
    // post request to server
    $secretKey = "6LcBEmkiAAAAAFjSjy1XHjGtfI1myMnZoiQ7i7s2";
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);
    
    // should return JSON with success as true
    if($responseKeys["success"]) {
        
            //capture info from form
            $email = $_POST['email'];
            $fullname = $_POST["fullname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $signup = date("Y-m-d");
            
            // open connection to ee database
            $mysqli = new mysqli("localhost", "ericmpas_admin","F@ghter3","ericmpas_ee");
            
            // verify if connection was successful
            if ($mysqli -> connect_errno)
            {
                echo "Failed to connect to MySQL: ".$mysqli -> connect_error;
                exit();
            }
            
            // load values from POST superglobal into logins table
            // ensure passwords are hashed on load
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $load_query = $mysqli -> prepare("INSERT INTO logins(email,full_name,user_name,password,signup_date) VALUES(?,?,?,?,?)");
            
            $load_query -> bind_param("sssss",$email,$fullname,$username,$hashedPassword,$signup);
            
            $load_query -> execute();
            
            $load_query -> close();
            $mysqli -> close();
        
            // send confirmation email of registration details
            $msg = "Thank you, $fullname, for registering for Easy Estimator with the user name $username on $signup.\n";
    
            mail($email,"Easy Estimator Registration",$msg);
            
            // direct to login page with registration confirmation
            echo '<!DOCTYPE html>';
            echo    '<html>';
            echo        '<head>';
            echo            '<title>Easy Estimator Registration</title>';
            echo            '<link rel="stylesheet" href="ee.css">';
            echo        '</head>';
            echo        '<body>';
            echo            '<header>';
            echo                '<h1>Easy Estimator Registration Confirmation</h1>';
            echo            '</header>';
            echo            '<main>';
            echo                "<h2>Registration Success</h2>";
            echo                "<p>$msg</p>";
            echo                '<br>';
            echo                '<p>Click <a href="index.html">Login</a> to return to login to Easy Estimator using your credentials.';
            echo            '</main>';
            echo            '<footer>';
            echo                '<p>Copyright 2023 Eric M. Pastore. All Rights Reserved.</p>';
            echo            '</footer>';
            echo        '</body>';
            echo    '</html>';
            
            
    } else {
            echo '<h2>There was a problem verifying your identity. Please try again later.</h2>';
    }
    
?>