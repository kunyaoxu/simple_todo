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

if(!empty($_POST)){
    if($_SESSION['isAuth'] === true and filter_input(INPUT_POST,'logout')){
        $_SESSION['isAuth'] = false;
        $_SESSION['accountID'] = null;
        header("Location:/");
    } elseif(($title_string = filter_input(INPUT_POST, 'title_string')) && ($content_string = filter_input(INPUT_POST, 'content_string'))){
        //$publish_string = filter_input(INPUT_POST,'publish_string');

        if($publish->createPublish($_SESSION['accoundInfo']['id'], $title_string, $content_string)){
            //echo "發文成功\n";
            header('Content-type: application/json');
            $res = ['status' => 302, 'location' => "/"];
            echo json_encode($res);
            //http_response_code(302);
            exit;
        }
        else{
            //echo "發文失敗\n";
            //return;
        }
//        echo htmlspecialchars($content_string);
//        echo "\n "." done. \n";
    
    }
    //return; //這樣之後的html就不會回傳給使用者了(POST到時候用ajax寫)
    
}

$publish_result = $publish->getUserAllPublish($_SESSION['accoundInfo']['id']);
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
    
    <link rel="stylesheet" href="css/default.css">

</head>

<body id="body">
    
    <div id="banner">
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
    </div>
<!--
    <form method="post" action="/">
        <input type="submit" value="logout" name="logout" class="dropdown-item logout">
    </form>
-->
    <div class="container-fluid content">
        <div class="row">
            <div class="lists">
            <?php
                if($publish_result)
                    foreach ($publish_result as $value) {
                        $value_title = htmlspecialchars($value['title']);
                        echo "<div class='list_item'>
                        <a href='/edit/$value[id]' class='btn'>
                            <p class='list_item_content'>$value_title</p>
                        </a>
                        </div>";
                    }
                else
                    echo "<div class='list_item'>
                    <p class='list_item_content'>There is nothing.</p>
                    </div>";
            
            ?>
            </div>
            
            <input type="checkbox" id="add_btn" class="fas fa-plus">
            <div class="outer_mask"></div>
            <div id="add_msg">
                <form id="new_publish">
                    <input type="text" id="title_string" required>
                    <textarea id="content_string" required></textarea>
                    <input type="submit" value="publish" class="btn btn-primary" id="publish_btn">
                </form>
            </div>
            
        </div>
        

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!--main.js-->
    <script type="text/javascript" src="js/default.js"></script>
    <script type="text/javascript">
        console.log("hahahahhaaha");
    </script>
</body>

</html>