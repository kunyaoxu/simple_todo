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

include_once "../sql/Publish.php";
$publish = new Publish();


$req_publishID = isset(Router::getUri()[1]) ? Router::getUri()[1] : false;
//var_dump(Router::getUri());
if(!empty($_POST) && $req_publishID){
//    if($_SESSION['isAuth'] === true and filter_input(INPUT_POST,'logout')){
//        $_SESSION['isAuth'] = false;
//        $_SESSION['accountID'] = null;
//        header("Location:/");
//    } else
    if(($title_string = filter_input(INPUT_POST, 'title_string')) && ($content_string = filter_input(INPUT_POST, 'content_string'))){
        //$publish_string = filter_input(INPUT_POST,'publish_string');

        if($publish->updatePublish($_SESSION['accoundInfo']['id'], $req_publishID, $title_string, $content_string)){
            //echo "發文成功\n";
            header("HTTP/1.1 200 OK");
            var_dump($_SERVER['REQUEST_METHOD']);
            var_dump($_REQUEST);
            return;
        }
        else{
            //echo "發文失敗\n";
            header('HTTP/1.1 500 Internal Server Error');
            return;
        }
//        echo htmlspecialchars($content_string);
//        echo "\n "." done. \n";
    
    }
    //return; //這樣之後的html就不會回傳給使用者了(POST到時候用ajax寫)
    
} elseif($_SESSION['isAuth'] && $req_publishID && $_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $result = $publish->deletePublish($_SESSION['accoundInfo']['id'], $req_publishID);
    //var_dump($result);
    //$result = 1;
    if($result){
        //header("Location:/123", true, 301);
        header('Content-type: application/json');
        $res = ['status' => 302, 'location' => "/"];
        echo json_encode($res);
        //http_response_code(302);
        exit;
    }
} elseif($_SESSION['isAuth'] && $req_publishID){
    $result = $publish->getByPublishID($_SESSION['accoundInfo']['id'], $req_publishID);
    //var_dump($result);
    if(!$result)
        header("Location:/");
} else{
    header("Location:/");
}

//$publish_result = $publish->getUserAllPublish($_SESSION['accoundInfo']['id']);
//var_dump($publish_result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
    <link rel="stylesheet" href="/css/edit.css">

</head>

<body id="body">
    
    <div id="banner">
        <a id="home" href="/"><i class="fas fa-home btn btn-primary" >HOME</i></a>
        <div class="btn-group btn-sm" id="group1">
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
    </div>


    <div class="container-fluid content">

        <div class="row edit_msg_out flex-grow1">   
        <div class="flex-grow1" id="edit_msg">
            <input type="text" disabled name="title_string" required id="title_string" value="<?php echo htmlspecialchars($result['title']) ?>">
            <textarea disabled class="flex-grow1" name="content_string" id="content_string" required><?php echo htmlspecialchars($result['content']) ?></textarea>

        </div>           
        </div>
        <div class="row func_area">
            <div class="flex-grow1 flex w50 h56px">
                <input type="checkbox" id="delete_btn" class="custom_btn fas fa-trash-alt">
                <div class="delete_check" id="delete_check">
                    <div class="delete_check_window">
                        <p class="">Are you sure you want to remove this note?</p>
                        <div class="flex">
                            <input class="btn btn-danger yes" type="button" value="yes">
                            <input class="btn btn-primary no" type="button" value="no">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-grow1 flex w50 h56px">
<!--                <input type="checkbox" id="delete_btn1" class="flex-end custom_btn fas fa-edit">-->
                <input type="checkbox" id="edit_btn" class="custom_btn fas fa-edit" value="edit">
                <input class="btn btn-primary" id='save_btn' type="button" value="save">
            </div>
        </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!--main.js-->
    <script type="text/javascript" src="/js/edit.js"></script>
    <script type="text/javascript">
        console.log("hahahahhaaha");
    </script>
</body>

</html>