<?php
//세션이 없다면 로그인창으로, 있다면 재부여 
session_start();
if(!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])){
    echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
    exit;
}
$login_id = $_SESSION['login_id'];
$check_level = $_SESSION['check_level'];
$sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
//서버 연결 확인
if(!$sql_connection){
    echo "연결에 실패 하였습니다".mysqli_error($sql_connection);
}
//DB 연결 확인
if(!mysqli_select_db($sql_connection, "c12st18")){
    echo "데이터베이스가 다릅니다.".mysqli_error($sql_connection);
}
//가져온 값을 변수에 담음
if(isset($_GET['change_value'])){
    $change_value = $_GET['change_value'];
    //SQL 조건부 조회 명령어 작성 
    $open_table = "SELECT * FROM `favorite` WHERE `id`='$change_value'";
    //조회 명령어 실행
    $show_table = mysqli_query($sql_connection, $open_table);
    ///조회로 생성된 자료 배열화
    $make_data = mysqli_fetch_assoc($show_table);
    //배열화 된 자료를 script 변수에 각각 담기
    echo "<script>let old_id = {$make_data['id']};</script>";
    echo "<script>let old_department = \"{$make_data['department']}\";</script>";
    echo "<script>let old_title = \"{$make_data['title']}\";</script>";
    echo "<script>let old_instroduction = \"{$make_data['introduction']}\";</script>";
    echo "<script>let old_url = \"{$make_data['url']}\";</script>";
    echo "<script>let old_data = \"{$make_data['data']}\";</script>";
    //배열 생성 에러 확인
    if(!$show_table){
        echo "출력이 되지 않았습니다.".mysqli_error($sql_connection);
        exit;
    };
}
if(isset($_GET['au_change_value'])){
    $change_value = $_GET['au_change_value'];
    //SQL 조건부 조회 명령어 작성 
    $open_table = "SELECT * FROM `favorite` WHERE `id`='$change_value'";
    //조회 명령어 실행
    $show_table = mysqli_query($sql_connection, $open_table);
    ///조회로 생성된 자료 배열화
    $make_data = mysqli_fetch_assoc($show_table);
    //배열화 된 자료를 script 변수에 각각 담기
    echo "<script>let old_id = {$make_data['id']};</script>";
    echo "<script>let old_department = \"{$make_data['department']}\";</script>";
    echo "<script>let old_title = \"{$make_data['title']}\";</script>";
    echo "<script>let old_instroduction = \"{$make_data['introduction']}\";</script>";
    echo "<script>let old_url = \"{$make_data['url']}\";</script>";
    echo "<script>let old_data = \"{$make_data['data']}\";</script>";
    //배열 생성 에러 확인
    if(!$show_table){
        echo "출력이 되지 않았습니다.".mysqli_error($sql_connection);
        exit;
    };
    }
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>수정하기</title>
        <link rel="shortcut icon" type="image" href="./favorite.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
        <script src="./JQ/jQuery360.min.js"></script>
        <link rel="stylesheet" href="./favorite.css">
    </head>
    <body>
    <h1>즐겨찾기</h1>
        <section class="change_area">
            <form action='./favorite_changeadd.php' method='GET'>
                <p class="change_depart">분류</p>
                <select class="change_select"value="" name="add_department">
                    <option value="공부용">공부용</option>
                    <option value="개인용">개인용</option>
                    <option value="업무용">업무용</option>
                    <option value="휴식용">휴식용</option>
                    <option value="컴퓨터">컴퓨터</option>
                </select>
                <div>제목</div>
                <input class="change_title" type="text" name="add_title" value="">
                <div>설명</div>
                <input class="change_explain" type="text" name="add_text" value="">
                <div>주소</div>
                <input class="change_addr" type="url" name="add_url" value="">
                <div>날짜</div>
                <input class="change_date" type="date" name="add_data" value="">
                <input class="change_id"type="hidden" name="add_id" value="">
                <input class="change_submit" type="submit" value="수정하기" name="submit_button">
                <?php
                if(isset($_GET['au_au_id'])){
                    $au_au_id= $_GET['au_au_id'];
                    echo"
                        <input type='hidden' name='au_au_id' value='$au_au_id'>
                    ";
                } else {
                    echo"
                        <input type='hidden' name='au_au_id' value='0'>
                    ";
                }
                ?>
                <?php
                if(isset($_GET['change_value'])){
                echo'
                <a href="./favorite_admin.php" class="change_leave" id="exit_button">돌아가기</a>
                ';
                }
                if(isset($_GET['au_change_value'])){
                    $au_au_id= $_GET['au_au_id'];
                    echo"
                    <a href='./favorite_au_detail.php?call_au_detail={$au_au_id}' class='change_leave' id='exit_button'>돌아가기</a>
                    ";
                }
                ?>
            </form>
        </section>
        <script>
            //데이터베이스에서 생성된 변수를 input value에 담음
            $(".change_select").val(old_department);
            $(".change_title").val(old_title);
            $(".change_explain").val(old_instroduction);
            $(".change_addr").val(old_url);
            $(".change_date").val(old_data);
            $(".change_id").val(old_id);
        </script>
    </body>
    </html>