<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>정보관리</title>
        <link rel="shortcut icon" type="image" href="./favorite.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
        <script src="./JQ/jQuery360.min.js"></script>
        <link rel="stylesheet" href="./favorite.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <h1>정보관리</h1>
        <section class="manage_main">
            <header class="manage_nav">
                <ul>
                    <li>순서</li>
                    <li>아이디</li>
                    <li>닉네임</li>
                    <li>등급</li>
                    <li>수정</li>
                    <li>삭제</li>
                </ul>
                <hr>
            </header>
            <!--<section class="manage_list">-->
            <?php
            //세션이 없다면 로그인창으로, 있다면 재부여 
            session_start();
            if(!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])){
                echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
                exit;
            }
            $login_id = $_SESSION['login_id'];
            $check_level = $_SESSION['check_level'];
                    //sql 연결
            $sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
            if (!$sql_connection) {
                echo "연결에 실패 하였습니다" . mysqli_error($sql_connection);
            }
            //db 연결
            if (!mysqli_select_db($sql_connection, "c12st18")) {
                echo "데이터베이스가 다릅니다." . mysqli_error($sql_connection);
            }
            //모든 내용 가져오기
            $open_table = "SELECT * FROM `listpwd`";
            $show_table = mysqli_query($sql_connection, $open_table);
            if (!$show_table) {
                echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                exit;
            };
            //가져온 값을 화면에 출력
            $check_rows = mysqli_num_rows($show_table);
            //if(@$_GET['call_page'] == "" || @$_GET['call_page'] == 1  || $call_page = $_GET['call_page']){
            //echo $check_rows;
            if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                $idex = 1;
                $page_num = 1;
                $select_num = 0;
                $limite_table = "SELECT * FROM `listpwd`";
                //$limite_table = "SELECT * FROM `listpwd` limit {$select_num}, 8";
                @$show_limite_table = mysqli_query($sql_connection, $limite_table);
                echo "<section id='{$page_num}_page' class='manage_list hidding_div{$page_num}'>";
                while ($row = mysqli_fetch_assoc($show_limite_table)) {
                    if ($row['authorize'] == "1" ) {
                        echo  " <ul class=\"manage_each_list\">
                                <li class='manage_each_row'>$idex</li>
                                <li class='manage_each_row'>{$row['id']}</li>
                                <li class='manage_each_row'>{$row['nickname']}</li>
                                <li class='manage_each_row'>관리자</li>
                                <li class='manage_each_row'><a href='./favorite_au_detail.php?call_au_detail={$row['id']}'>수정</a></li>
                                <input id='{$row['id']}' class='delete_hidden' type='hidden' value='{$row['id']}'>
                            </ul>
                            ";    
                    } else {
                    echo  " <ul class=\"manage_each_list\">
                                <li class='manage_each_row'>$idex</li>
                                <li class='manage_each_row'>{$row['id']}</li>
                                <li class='manage_each_row'>{$row['nickname']}</li>
                                <li class='manage_each_row'>일반회원</li>
                                <li class='manage_each_row'><a href='./favorite_au_detail.php?call_au_detail={$row['id']}'>수정</a></li>
                                <li class='manage_each_row'><a class='del_button' href='#' data-id={$row['id']}>삭제</a></li>    
                                <input id='{$row['id']}' class='delete_hidden' type='hidden' value='{$row['id']}'>
                            </ul>
                            ";
                    }
                    $idex++;
                }
                echo "</section>";
            } else {
                $call_page = $_GET['call_page'];
                $idex = 1;
                $page_num = 1;
                @$select_num = 8 * ($call_page - 1);
                $limite_table = "SELECT * FROM `listpwd` limit {$select_num}, 8";
                @$show_limite_table = mysqli_query($sql_connection, $limite_table);
                echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                while ($row = mysqli_fetch_assoc($show_limite_table)) {
                    echo  " <ul class=\"manage_each_list\">
                                <li class='manage_each_row'>$idex</li>
                                <li class='manage_each_row'>{$row['title']}</li>
                                <li class='manage_each_row'>{$row['url']}</li>
                                <li class='manage_each_row'><a href='./favorite_au_detail.php?call_au_detail={$row['id']}'>수정</a></li>
                                <li class='manage_each_row'><a class='del_button' href='#' data-id={$row['id']}>삭제</a></li>    
                                <li class='manage_each_row'><a href='favorite_select.php?show_detail={$row['id']}'>바로가기</a></li>
                                <input id='{$row['id']}' class='delete_hidden' type='hidden' value='{$row['id']}'>
                            </ul>
                            ";
                    $idex++;
                }
                echo "</section>";
            }
            ?>
                
            <!-- <footer>
            </footer> -->
        </section>
        <button class='back_to_page'>돌아가기</button>
        <div class="double_check_box">
            <p>삭제하시겠습니까?</p>
            <button id="double_delete">네</button>
            <button class="comfirm_button">아니요</button>
            <input id="delete_row_hidden"type="hidden">
        </div>
    </body>
    <script>
        $('.back_to_page').on('click', function(){
            location.href="./favorite_admin.php";
        })
        $(".del_button").on("click", function(e){
            let empty_string= $(this).data('id');
            $("#double_delete").data("id", empty_string);
            console.log(empty_string);
            $(".double_check_box").show() && e.preventDefault();
        })
        $("#double_delete").on("click", function(){
            let empty_string = ($("#double_delete").data("id"));
            console.log(empty_string);
            location.href= `./favorite_changeadd.php?del_id=${empty_string}`;
        })
        $(".comfirm_button").on("click", function(){
            $(".double_check_box").hide();
        })
    </script>
</html>