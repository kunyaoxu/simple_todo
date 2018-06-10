<?php
if(empty($_COOKIE["TestCookie"])){
    $value = 'something from somewhere';
    setcookie("TestCookie", $value, time()+3600); /* expire in 1 hour */
} else {
    echo $_COOKIE["TestCookie"];
}

?>