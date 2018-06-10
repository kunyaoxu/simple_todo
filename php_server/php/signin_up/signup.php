<?php
if(isset($_SESSION['isAuth']) ? $_SESSION['isAuth'] : true){
    header("Location: /");
}
//echo "var_dump _POST: </br>";
//var_dump($_POST);
//echo "</br>var_dump _GET: </br>";
//var_dump($_GET);

//$signup_success = false;
if(!empty($_POST)){
    if(checkStrLen(filter_input(INPUT_POST,'account') ,8 ,30) and
       checkStrLen(filter_input(INPUT_POST,'password') ,8 ,30)){
        $user = new AccountInfo();
        if($user->createAccount($_POST['account'], $_POST['password'])){
//            echo "帳號建立成功";
            $signup_success = true;
            header("Refresh: 3; url= /");
        } else{
//            echo "帳號建立失敗，已經有相同名字的帳號了";
            $signup_success = false;
            //大概要重新思考這邊的程式要怎麼改了，因為目前的方案不能確定是有輸入中文或是已經有同樣帳號的狀況
        }
    } else {
        $signup_success = false;
//        echo "非法的的長度或字元";
    }

    //return; //這樣之後的html就不會回傳給使用者了(客戶端POST未來可以改用jq ajax寫)
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
    <?php if(isset($signup_success) ? !$signup_success : true): ?>
    <button type="button" class="btn btn-primary modal-btn" data-toggle="modal" data-target="#infoModal">
      ID and password requirements.
    </button>
    <form class="form-signin" method="post" action="/signup" name="form1" oninput="(password.value === confirmpassword.value && (password.value.length >= 8 && account.value.length >= 8))? submit.disabled='':submit.disabled='disabled'">
        <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>
        <label for="inputAccountID" class="sr-only">Account ID</label>
        <input type="text" id="inputAccountID" class="form-control" placeholder="Account ID" name="account" pattern="[a-zA-Z0-9]{8,30}" maxlength="30" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" pattern="[\x21-\x7e]{8,30}" maxlength="30" required>
        <label for="confirmPassword" class="sr-only">Confirm password</label>
        <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" name="confirmpassword" pattern="[\x21-\x7e]{8,30}" maxlength="30" required>
        <?php if(isset($signup_success) ? !$signup_success : false): ?>
            <div class="alert alert-danger" role="alert">
               Already have the same ID! Please check out your account-id and password.
            </div>
        <?php endif; ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign up</button>
        <a href="/signin">to signin page</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
    <?php else: ?>
    <div class="alert alert-success success" role="alert">
        Signup success! page will redirect to signin page in 3 seconds.
    </div>
    <?php endif; ?>
    
    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ID and Password requirements.</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ID only can contain alphanumeric. Passwords can contain any printable ASCII characters except whitespace character. And must contain a minimum of 8 characters, maximum of 30 characters.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!--main.js-->
    <script type="text/javascript" src="/js/main.js"></script>

</body>

</html>
