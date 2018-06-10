<?php
//session_name("hello");
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();
include_once "./php/route.php";
include_once "../sql/AccountInfo.php";

//echo "route.php : " . Request::uri() . "</br>"
//
//var_dump($_COOKIE);
//echo " _COOKIE</br>";
//var_dump($_SESSION);
//echo " _SESSION</br>";
//echo session_id() . " session_id()</br>";
//
//echo '$_SERVER[PHP_SELF]' . $_SERVER['PHP_SELF'] . "</br>";
//echo '$_SERVER[REDIRECT_URL]' . htmlentities($_SERVER['REDIRECT_URL']) . "</br>";
//echo '$_SERVER[REQUEST_URI]' . htmlentities($_SERVER['REQUEST_URI']) . "</br>";



if (empty($_SESSION['isAuth'])) {
    $_SESSION['isAuth'] = false;
} 


//var_dump($_COOKIE);
    
if (empty($_SESSION['count'])) {
    setcookie("PHPSESSID", session_id(), time()+31556926);
    //setcookie("hello", session_id(),  time()+31556926);
    //echo session_id() . " _hello3</br>";  
    //$_SESSION['count'] = 1;
    
} else {
    //$_SESSION['count']++;
}

//echo "var_dump : ";
//var_dump($_POST);

//$user = new AccountInfo();
//$user->checkAccountExist($_POST['account']);

//////////目前只實做會員登錄系統
$sw = Router::getUri()[0];
//var_dump($sw);
switch($sw){
//    case "account":
//        //echo "this is account page</br>";
//        break;
    case "signup":
        //echo "this is signup page</br>";
        include "./php/signin_up/signup.php";
        break;
    case "signin":
        //echo "this is signin page</br>";
        include "./php/signin_up/signin.php";
        break;
    case "edit":
        //echo "this is signin page</br>";
        include "./php/edit.php";
        break;
    case "":
        //echo "this is default</br>";
        if($_SESSION['isAuth'])
            include "./php/default_isAuth.php";
        else
            include "./php/default.php";
        break;
    default:
        //echo "redirect, this is default</br>";
        //include "./php/default.php";
        header("Location:/");
        break;
}
?>