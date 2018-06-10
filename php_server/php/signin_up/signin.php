<?php
if(isset($_SESSION['isAuth']) ? $_SESSION['isAuth'] : true){
    header("Location:/");
}
//echo "var_dump _POST: </br>";
//var_dump($_POST);

//echo "var_dump _SESSION: </br>";
//var_dump($_SESSION);


if(!empty($_POST)){
    if($_SESSION['isAuth'] === false and
       checkStrLen(filter_input(INPUT_POST,'account') ,8 ,30) and
       checkStrLen(filter_input(INPUT_POST,'password') ,8 ,30)){
        $user = new AccountInfo();
        if($user->checkAccountAuthInfo($_POST['account'], $_POST['password'], $result)){
            $_SESSION['isAuth'] = true;
            $_SESSION['accountID'] = $_POST['account'];
            $_SESSION['accoundInfo'] = $result;
            //var_dump($result);
            //echo "成功登入";
            //$signin_success = true;
            //header("Refresh: 3; url= /");
            header("Location: /");
        }else{
            $_SESSION['isAuth'] = false;
            //echo "帳號或密碼輸入錯誤";
            $signin_success = false;
        }
        
    }
    //return; //這樣之後的html就不會回傳給使用者了(POST到時候用ajax寫)
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <link rel="stylesheet" href="/css/signin_up.css">

</head>

<body class="text-center">
<!--
    <?php if ($_SESSION['isAuth'] === true): ?>
        <form method="post" action="/" name="form1">
            <input type="submit" value="登出" name="logout">
        </form>
    <?php else: ?>
        <form method="post" action="/" name="form1">
            <label>account<input type="text" name="account" value=""></label>
            <label>password<input type="text" name="password" value=""></label>
            <input type="submit" value="確定" name="ok">
        </form>
    <?php endif; ?>
-->
    
    <form class="form-signin" method="post" action="/signin" name="form1">
        <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>
        <label for="inputAccountID" class="sr-only">Account ID</label>
        <input type="text" id="inputAccountID" class="form-control" placeholder="Account ID" name="account" pattern="[a-zA-Z0-9]{8,30}" maxlength="30" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" pattern="[\x21-\x7e]{8,30}" maxlength="30" required>
        <?php if(isset($signin_success) ? !$signin_success : false): ?>
            <div class="alert alert-danger" role="alert">
               Incorrect input! Check out your account-id and password.
            </div>
        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <a href="/signup">create an account</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!--main.js-->
    <script type="text/javascript" src="/js/main.js"></script>
</body>

</html>