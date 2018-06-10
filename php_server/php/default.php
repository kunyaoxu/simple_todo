<?php
//echo "var_dump _POST: </br>";
//var_dump($_POST);
if(!isset($_SESSION['isAuth'])){
    header("Location:/");
}

//if (empty($_SESSION['isAuth'])) {
//    $_SESSION['isAuth'] = false;
//} 

//echo "var_dump _SESSION: </br>";
//var_dump($_SESSION);


if(!empty($_POST)){
    if($_SESSION['isAuth'] === true and filter_input(INPUT_POST,'logout')){
        $_SESSION['isAuth'] = false;
        $_SESSION['accountID'] = null;
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
    
    <link rel="stylesheet" href="/css/default.css">

</head>

<body>
    
    <div id="banner">
    <?php if ($_SESSION['isAuth'] === true): ?>
        <div class="btn-group btn-sm">
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['accountID'] ?>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">nothing</a>
                <a class="dropdown-item" href="#">nothing~</a>
                <div class="dropdown-divider"></div>
                <form method="post" action="/">
                    <input type="submit" value="logout" name="logout" class="dropdown-item logout">
                </form>
            </div>
        </div>
    <?php else: ?>
        <a href="/signin" class="btn signin_up">sign in</a>
        <span>or</span>
        <a href="/signup" class="btn signin_up">sign up</a>
    <?php endif; ?>  
    </div>
    
    <div class="content">
        <div class="jumbotron">
            <h1 class="display-4">Hello, world!</h1>
            <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!--main.js-->
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript">
        console.log("hahahahhaaha");
    </script>
</body>

</html>