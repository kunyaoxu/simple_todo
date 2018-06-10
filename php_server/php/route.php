<?php
//沒先跑session_start()自然就不會讀到$_SESSION的內容
if(!isset($_SESSION['isAuth'])){
    header("Location:/");
}

//class Request {
//    public static function uri()
//    {
//        $uri = str_replace(static::getFolderName(), "", static::redirect_url());
//        return trim($uri, '/');
//    }
//
//    private static function redirect_url() {
//        if( isset($_SERVER['REDIRECT_URL']) )
//            return $_SERVER['REDIRECT_URL'];
//        return explode("?", $_SERVER['REQUEST_URI'] )[0];
//    }
//
//    private static function getFolderName()
//    {
//        $folder_name = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
//        return $folder_name;
//    }
//}
class Router {
    public static function getUri(){
        $str = "";
        if(isset($_SERVER['REDIRECT_URL']))
            $str = $_SERVER['REDIRECT_URL'];
        return preg_split("/\//", trim($str, "/"));
    }
}

//echo "hello!!!!!!!!!!!!!!!!!!!!!";