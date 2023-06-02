<?php
    session_start();
    if(isset($_SESSION["username"]))
    {
        echo '<h3>login success - ' .$_SESSION["username"].'</h3>' ;
    }
?>