<?php
    session_start();
    include('connect.php');
    if(isset($_POST['dangnhap'])){
        if($_POST["username"] == "" or $_POST["password"]==""){
            echo"";
        }
        else{
            $username = strip_tags(trim($_POST["username"]));
            $password = strip_tags(trim($_POST["password"]));
            $query = $conn->prepare("SELECT * FROM tbl_user WHERE password = ?");
            $query->execute(array($password));
            $control = $query->fetch(PDO::FETCH_OBJ);
            if($control > 0){
                $_SESSION["username"] = $username;
                header("location:index.php");
            }else{
                echo"nhập sai, vui lòng nhập lại";
            }

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
    <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">
    <title>Đăng nhập</title>
</head>
<body>
   <div class="login_page">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"> 
            <div class="login_container">
                <div class="login_container_header">
                    <h3 class="heading_login">Đăng nhập</h3>
                    <a class="login_signin" href="./register.php">Đăng ký</a>
                </div>
            <hr>
               <div class="login">
                    <input type="text" name="username" id="" placeholder="Tên đăng nhập">
                    <input type="password" name="password" id="" placeholder="Mật khẩu">

                    <button type="submit" class="btn_submit" name="dangnhap">Đăng nhập</button>
               </div>
            </div>
        </form>
        <?php
        
        ?>
   </div>
</body>
</html>