<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" method="POST">
    <title>즐겨찾기</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <script src="./JQ/jQuery360.min.js"></script>
    <link rel="stylesheet" href="./favorite.css">
</head>

<body>
    <h1>즐겨찾기</h1>
    <section class="change_area">
        <!--<p class="page_title">수정하기</p>-->
        <form action="./favorite_additional.php" method="POST">
            <p class="change_depart">분류</p>
            <select class="change_select" value="" name="add_depart">
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
            <input class="change_id" type="hidden" name="add_id" value="">
            <input class="change_submit" type="submit" value="수정하기" name="submit_button">
            <a href="./favorite_admin.php" class="change_leave" id="exit_button">돌아가기</a>
        </form>
    </section>
    <?php
    //세션이 없다면 로그인창으로, 있다면 재부여 
    session_start();
    if (!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])) {
        echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
        exit;
    }
    //추가 버튼이 눌렀는지 확인
    if (isset($_POST["submit_button"])) {
        $sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
        //서버 연결 확인
        if (!$sql_connection) {
            echo "연결에 실패 하였습니다" . mysqli_error($sql_connection);
        }
        //DB 연결 확인
        if (!mysqli_select_db($sql_connection, "c12st18")) {
            echo "데이터베이스가 다릅니다." . mysqli_error($sql_connection);
        }
        //가져온 값들을 변수에 담음
        $login_id = $_SESSION['login_id'];
        $login_pwd = $_SESSION['login_pwd'];
        $new_department = $_POST['add_depart'];
        $new_title = $_POST['add_title'];
        $new_text = $_POST['add_text'];
        $new_url = $_POST['add_url'];
        $new_date = $_POST['add_data'];
        //SQL 삽입 명령어 작성
        $add_new = "INSERT INTO `favorite` VALUE('', '${new_department}', '${new_title}', '${login_id}', '${new_text}', '${new_url}', '${new_date}')";
        //SQL 조회 명령어 작성
        $open_table = "SELECT * FROM `favorite`";
        //삽입 명령어 실행
        $insert_table = mysqli_query($sql_connection, $add_new);
        //조회 명령어 실행
        $show_table = mysqli_query($sql_connection, $open_table);
        //삽입 명령어 에러 확인
        if (!$insert_table) {
            echo "삽입이 되지 않았습니다." . mysqli_error($sql_connection);
            exit;
        }
        //출력 페이지로 이동
        echo "<script>location.href='favorite_admin.php'</script>";
    }
    //echo "</table>";
    //echo "</table>";
    //mysqli_free_result($show_table);

    //myslqi_close($sql_connection);
    ?>
    </div>
    </div>
    </section>
    <script>

    </script>
</body>

</html>