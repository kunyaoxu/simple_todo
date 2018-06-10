<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
class DB{
    const servername = "localhost";
    const username = "phptest";
    const password = "12345678";
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
}

/*
CREATE TABLE USER (
    id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    account VARCHAR(30) BINARY NOT NULL,
    password VARCHAR(30) NOT NULL,
    reg_date TIMESTAMP,
    UNIQUE(account));
*/
class AccountInfo{
    private static $conn;
//    public $u_account = null;
//    private $u_password = null;
    
    function __construct() {
        $servername = DB::servername;
        $dbname = DB::dbname;
        self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", DB::username, DB::password, array(PDO::ATTR_PERSISTENT => true));
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }
    

    public function createAccount($u_account = null, $u_password = null) {
        if(!self::checkInputStr($u_account, REGEXP::account) or !self::checkInputStr($u_password, REGEXP::password)){
            //echo "createAccount() error input. \n";
            return false;
        }
        //BINARY表示二進位比較，因為預設的mysql是沒有對大小寫比較，寫這樣可以應付資料庫有分大小寫或是沒分大小寫的狀況
        $sql = "SELECT * FROM USER WHERE BINARY account=:account";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(array(":account" => $u_account));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //echo '$stmt->rowCount()' . $stmt->rowCount() . "\n";

        if($stmt->rowCount() === 0){
            $sql = "INSERT INTO USER (account, password) VALUES (:account, :password)";
            $stmt = self::$conn->prepare($sql);
            $result = $stmt->execute(array(":account" => $u_account, ":password" => $u_password));
            //$result = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($result);
            if($result){
                //echo "註冊成功~\n";
                return true;
            }
            else{
                //echo "createAccount() ERROR!!!!";
                return false;
            }
        } else{
            //echo "同樣帳戶ID的已經有囉!\n";
            return false;
        }
    }

    public function checkAccountExist($u_account = null) {
        if(!self::checkInputStr($u_account, REGEXP::account)){
            //echo "error u_account input. \n";
            return false;
        }
        $sql = "SELECT * FROM USER WHERE BINARY account=:account";
        //$sql = "SELECT * FROM USER";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(array(":account" => $u_account));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

//        //echo $stmt->rowCount() . "\n";
//        //echo $result["password"] . "\n";
//        var_dump($result);
        
        if($stmt->rowCount() === 1){
            //echo "hello 歡迎回來\n";
            return true;
        } else{
            //echo "還沒登入喔!\n";
            return false;
        }
    }
    
    public function checkAccountAuthInfo($u_account = null, $u_password = null, &$retuen_val = null) {
        if(!self::checkInputStr($u_account, REGEXP::account) or !self::checkInputStr($u_password, REGEXP::password)){
            //echo "checkAccountAuthInfo() error input. \n";
            return false;
        }
        $sql = "SELECT * FROM USER WHERE BINARY account=:account";
        //$sql = "SELECT * FROM USER";
        $stmt = self::$conn->prepare($sql);
        $stmt->execute(array(":account" => $u_account));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //echo $stmt->rowCount() . "\n";
        //echo $result["password"] . "\n";
        //var_dump($result);
        

        if($stmt->rowCount() === 1 && $u_password === $result["password"]){
            //echo "hello歡迎您的登入\n";
            //echo $result;
            $retuen_val = $result;
            return true;
        } else{
            //echo "帳號密碼驗證錯誤，還沒登入喔!\n";
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