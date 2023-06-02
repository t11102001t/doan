<?php
define('BASEPATH', true); //access connection script if you omit this line file will be blank
require 'connect.php'; //require connection script

 if(isset($_POST['submit'])){  
        try {
            $dsn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  
         $user = $_POST['username'];
         $email = $_POST['email'];
         $pass = $_POST['password'];
         
         //encrypt password
        //  $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
          
         //Check if username exists
         $sql = "SELECT COUNT(username) AS num FROM tbl_user WHERE username = :username";
         $stmt = $conn->prepare($sql);

         $stmt->bindValue(':username', $user);
         $stmt->execute();
         $row = $stmt->fetch(PDO::FETCH_ASSOC);

         if($row['num'] > 0){
             echo '<script>alert("Username already exists")</script>';
        }
        
       else{

    $stmt = $dsn->prepare("INSERT INTO tbl_user (username, email, password) 
    VALUES (:username,:email, :password)");
    $stmt->bindParam(':username', $user);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    
    

   if($stmt->execute()){
    echo '<script>alert("Tài khoản mới đã được tạo")</script>';
    //redirect to another page
    echo '<script>window.location.replace("index.php")</script>';
     
   }else{
       echo '<script>alert("An error occurred")</script>';
   }
}
}catch(PDOException $e){
    $error = "Error: " . $e->getMessage();
    echo '<script type="text/javascript">alert("'.$error.'");</script>';
}
     }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Đăng ký</title>
</head>
<body>
    <div class="login_page">
    <form action="register.php" method="post">
        <div class="login_container">
            <div class="login_container_header">
                <h3 class="heading_login">Đăng ký</h3>
                <a href="./login_main.php" class="login_signin">Đăng nhập</a>
            </div>
            <hr>
            <div class="login">
                <input type="text" required="required" name="username" placeholder="Tên đăng nhập">
                <input required="required" type="text" name="email" placeholder="Email">
                <input required="required" type="password" name="password" placeholder="Mật khẩu">                  
                <button name="submit" class="btn_submit" type="submit">Đăng ký</button>
            </div>
        </div>
    </form>
    </div>
</body>
</html>