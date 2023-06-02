<?php
    session_start();
    include('../connect.php');
    if(isset($_POST['dangnhap'])){
        if($_POST["username"] == "" or $_POST["password"]==""){
            echo"Vui lòng nhập thông tin đăng nhập đầy đủ";
        }
        else{
            $username = strip_tags(trim($_POST["username"]));
            $password = strip_tags(trim($_POST["password"]));
            $query = $conn->prepare("SELECT * FROM tbl_admin WHERE password = ?");
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
    <link rel="stylesheet" href="./styleadmin.css">
    <link rel="stylesheet" href="../fontawesome-free-6.2.1-web/css/all.min.css">
    <title>Login admin</title>
</head>
<body>
    <div class="main_login">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="imgcontainer">
            <img src="../image/anh dai dien.jpg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
 
            <input type="text" placeholder="Tên đăng nhập" name="username" required>

            <div class="pass">
                <input type="password" placeholder="Mật khẩu" name="password" class="password" id="password" required>
            
            </div>
           
            <input type="submit" class="dangnhap_btn" value="Đăng nhập" name="dangnhap">
            <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

    </form>
    </div>
</body>


</html>

<script src="">
    
    
</script>