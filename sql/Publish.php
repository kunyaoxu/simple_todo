<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
/*class DB{
    const servername = "localhost";
    const username = "phptest";
    const password = "80128012";
    const dbname = "test_db";
}

class REGEXP {
    const account = "/^[a-zA-Z0-9]{8,30}$/";
    const password = "/[\x21-\x7e]{8,30}$/";
    //const password = "/^[^\x{7F}-\x{ff}\x{00}-\x{20}]+$/"; //這個也可以用，同上面的意思
}

function checkStrLen($str, $min_len = 8, $max_len = 30){
    $len = strlen($str);
    if($len <= $max_len and $len >= $min_len){
        return true;
    } else
        return false;
}*/

/*
CREATE TABLE PUBLISH (id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		senderID INT(8) UNSIGNED NOT NULL,
		like_num INT(8) UNSIGNED,
		createTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        title TEXT,
		content TEXT,
		FOREIGN KEY (senderID) REFERENCES USER(id));



INSERT INTO PUBLISH (senderID, like_num, title, content) VALUES (66, 0, "title","hello");
*/

class Publish{
    private static $conn;
//    public $u_account = null;
//    private $u_password = null;
    
    function __construct() {
        $servername = DB::servername;
        $dbname = DB::dbname;
        self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", DB::username, DB::password, array(PDO::ATTR_PERSISTENT => true));
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }
    

    public function createPublish($u_ID = null, $title_str = null,$content_str = null) {
//        if(!self::checkInputStr($u_account, REGEXP::account) or !self::checkInputStr($u_password, REGEXP::password)){
//            //echo "createAccount() error input. \n";
//            return false;
//        }
        if($content_str == "" || $title_str == ""){
            return false;
        }
        $sql = "INSERT INTO PUBLISH (senderID, like_num, title, content) VALUES (:senderID, 0, :title, :content);";
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute(array(":senderID" => $u_ID, ":title" => $title_str, ":content" => $content_str));


        if($result){
            //echo "發文成功~\n";
            return true;
        }
        else{
            //echo "createPublish() ERROR!!!!";
            return false;
        }
    }

    public function getUserAllPublish($u_ID = null) {
//        if(!self::checkInputStr($u_account, REGEXP::account) or !self::checkInputStr($u_password, REGEXP::password)){
//            //echo "createAccount() error input. \n";
//            return false;
//        }
        if($u_ID == ""){
            return false;
        }
        $sql = "SELECT id, senderID, like_num, title, content FROM PUBLISH WHERE senderID=:u_ID";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(array(":u_ID" => $u_ID));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if($result){
            //echo "發文成功~\n";
            //var_dump($result);
            return $result;
        }
        else{
            //echo "createPublish() ERROR!!!!";
            return false;
        }
    }
    
    public function getByPublishID($u_ID = null, $publishID = null) {
        if($u_ID == "" && $publishID == ""){
            return false;
        }
        $sql = "SELECT id, senderID, like_num, title, content FROM PUBLISH WHERE senderID=:u_ID and id=:publishID";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(array(":u_ID" => $u_ID, ":publishID" => $publishID));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if($result){
            //echo "發文成功~\n";
            //var_dump($result);
            return $result;
        }
        else{
            //echo "createPublish() ERROR!!!!";
            return false;
        }
    }

    public function updatePublish($u_ID = null, $publish_ID = null, $title_str = null, $content_str = null) {
        if($u_ID == null || $publish_ID == null || $content_str == "" || $title_str == ""){
            return false;
        }
        $sql = "UPDATE PUBLISH SET title=:title, content=:content WHERE id=:publishID and senderID=:senderID";
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute(array(":senderID" => $u_ID, ":publishID" => $publish_ID, ":title" => $title_str, ":content" => $content_str));


        if($result){
            //echo "發文成功~\n";
            return true;
        }
        else{
            //echo "createPublish() ERROR!!!!";
            return false;
        }
    }
    
    public function deletePublish($u_ID = null, $publishID = null) {
        if($u_ID == "" && $publishID == ""){
            return false;
        }
        $sql = "DELETE FROM PUBLISH WHERE senderID=:u_ID and id=:publishID";
        $stmt = self::$conn->prepare($sql);
        $result = $stmt->execute(array(":u_ID" => $u_ID, ":publishID" => $publishID));


        if($result){
            //echo "發文成功~\n";
            //var_dump($result);
            return $result;
        }
        else{
            //echo "createPublish() ERROR!!!!";
            return false;
        }
    }

    public static function checkInputStr($input = null, $regex = null){
        if($input === null || $regex === null){
            return false;
        }
        //$regex = '/^([a-zA-Z0-9]+)([\w]+?)([a-zA-Z0-9]+)$/';
        $str = $input;
        preg_match($regex, $str,$matches);
        //var_dump($matches);

        if (!preg_match($regex, $str)){
            //echo '輸入的格式不符合！';
            return false;
        } else {
            //echo '符合格式 ~';
            return true;
        }
    }

}

//
////test AccountInfo class
//$test = new AccountInfo();

//echo 'test->createAccount: ' . ($test->createAccount(isset($argv[1]) ? $argv[1] : null,isset($argv[2]) ? $argv[2] : null) ? 'true': 'false') . "\n";
//
//echo "checkAccountExist :" .  ($test->checkAccountExist(isset($argv[1]) ? $argv[1] : null,isset($argv[2]) ? $argv[2] : null) ? 'true': 'false') . "\n";
//echo "checkAccountAuthInfo :" . ($test->checkAccountAuthInfo(isset($argv[1]) ? $argv[1] : null,isset($argv[2]) ? $argv[2] : null) ? 'true': 'false') . "\n";