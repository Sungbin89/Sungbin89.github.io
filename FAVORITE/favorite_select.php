<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>즐겨찾기</title>
    <link rel="shortcut icon" type="image" href="./favorite.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <script src="./JQ/jQuery360.min.js"></script>
    <link rel="stylesheet" href="./favorite.css">
</head>

<body>
    <h1><a href="./favorite_admin.php">즐겨찾기</a></h1>
    <!--세션 확인 및 부여-->
    <?php
    //세션이 없다면 로그인창으로, 있다면 재부여 
    session_start();
    if (!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])) {
        echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
        exit;
    }
    $login_id = $_SESSION['login_id'];
    $check_level = $_SESSION['check_level'];
    //아이디를 가져와서 인사말 출력
    if($check_level == 1){
        echo "<p class='login_greeting'>안녕하세요 <a href='./favorite_authority.php'>$login_id</a> 님</p>";
        echo "<a href='./favorite_authority.php'><span class='login_mypage'>관리자페이지</span></a>";
        echo "<p class='login_out'><a href='./favorite_logout.php'> 로그아웃</a></p>";
    } else {
        echo "<p class='login_greeting'>안녕하세요 $login_id 님</p>";
        echo "<a href='./favorite_au_detail.php?call_au_detail=$login_id'><span class='login_mypage'>마이페이지</span></a>";
        echo "<p class='login_out'><a href='./favorite_logout.php'> 로그아웃</a></p>";
    }
    ?>
    <!--출력될 곳 만들기-->
    <section class="main_place">
        <section class="search_area">
            <form action="./favorite_select.php" class="search_form" method="POST">
                <div class="left_top_search">
                </div>
                <div class="right_bottom_serch">
                    <p>제목</p>
                    <input type="text" id="search_title" class="serach_title" name="search_title">
                </div>
                <input type="submit" name="search_submit" value="조회하기">
            </form>
        </section>
        <section class="sort_area">
            <form id="change_select" action="./favorite_select.php" method="GET">
                <select name="order_by_select" id="order_by_select">
                    <option value="show_all" selected>선택</option>
                    <option value="show_all">전체보기</option>
                    <option value="공부용">공부용</option>
                    <option value="개인용">개인용</option>
                    <option value="업무용">업무용</option>
                    <option value="휴식용">휴식용</option>
                    <option value="컴퓨터">컴퓨터</option>
                </select>
            </form>
            <!--각 a태그로 정렬 및 연결-->
            <p>제목</p>
            <div>
                <a class="up_sort" href="./favorite_select.php?this_value_up=title">&#9651;</a>
                <a class="down_sort" href="./favorite_select.php?this_value_down=title">&#9661;</a>
            </div>
            <p>설명</p>
            <div>
                <a class="up_sort" href="./favorite_select.php?this_value_up=introduction">&#9651;</a>
                <a class="down_sort" href="./favorite_select.php?this_value_down=introduction">&#9661;</a>
            </div>
            <p>주소</p>
            <div>
                <a class="up_sort" href="./favorite_select.php?this_value_up=url">&#9651;</a>
                <a class="down_sort" href="./favorite_select.php?this_value_down=url">&#9661;</a>
            </div>
            <p>날짜</p>
            <div>
                <a class="up_sort" href="./favorite_select.php?this_value_up=data">&#9651;</a>
                <a class="down_sort" href="./favorite_select.php?this_value_down=data">&#9661;</a>
            </div>
            <p class="maker_class">작성자</p>
            <div>
                <a class="up_sort" href="./favorite_select.php?this_value_up=user">&#9651;</a>
                <a class="down_sort" href="./favorite_select.php?this_value_down=user">&#9661;</a>
            </div>
        </section>
        <section class="view_area">
            <div id="move_to_add" class="addtional_button">추가</div>
            <a href="#" id="move_to_delall" class="move_to_delall">선택 삭제</a>
            <input id="whole_check_box" class="whole_check_box" type="checkbox">
            <?php
            //sql 연결
            $sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
            if (!$sql_connection) {
                echo "연결에 실패 하였습니다" . mysqli_error($sql_connection);
            }
            //db 연결
            if (!mysqli_select_db($sql_connection, "c12st18")) {
                echo "데이터베이스가 다릅니다." . mysqli_error($sql_connection);
            }
            $open_table = "SELECT * FROM `favorite`";
            $show_table = mysqli_query($sql_connection, $open_table);
            if (!$show_table) {
                echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                exit;
            };
            $check_rows = mysqli_num_rows($show_table);
            $page_num = 1;
            if (isset($_GET['show_detail']) != 0 && isset($_GET['au_au_id'])) {
                $this_value = $_GET["show_detail"];
                //조건부 SQL 조회 명령어 생성
                $open_table = "SELECT * FROM `favorite` WHERE `id` =  '$this_value'";
                // 명령어 실행
                $show_table = mysqli_query($sql_connection, $open_table);
                //명령어 에러 확이
                if (!$show_table) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                ///조회로 생성된 자료 배열화

                $make_data = mysqli_fetch_assoc($show_table);
                if (!$make_data) {
                    echo "배열 생성이 되지 않았습니다." . mysqli_error($sql_connection);
                    echo "3";
                    exit;
                }
                //배열화 된 자료를 script 변수에 각각 담기
                //가져온 값을 화면에 출력
                echo  "
                                <section class='whole_show'>
                                    <form action='./favorite_changeadd.php' method='GET'>
                                        <h2 class='show_title'>상세내용</h2>
                                        <a href='./favorite_au_detail.php?call_au_detail={$make_data['user']}' class='change_leave' id='exit_button'>X</a>
                                        <p class='show_depart'>분류</p>
                                        <div class='change_select'></div>
                                        <p>제목</p>
                                        <div class='change_title'></div>
                                        <p>설명</p>
                                        <div class='change_explain'></div>
                                        <p>주소</p>
                                        <div class='change_addr'><a href='' class='change_call_page' target='blank'></a></div>
                                        <p>날짜</p>
                                        <div class='change_date'></div>
                                        <p>작성자</p>
                                        <div class='change_writer'></div>
                                        <a class='change_submit' href='./favorite_au_detail.php?call_au_detail={$make_data['user']}'>뒤로가기</a>
                                    </form>
                                </section>
                                
                                <script>
                                let old_id = {$make_data['id']};
                                let old_department = \"{$make_data['department']}\";
                                let old_title = \"{$make_data['title']}\";
                                let old_instroduction = \"{$make_data['introduction']}\";
                                let old_url = \"{$make_data['url']}\";
                                let old_data = \"{$make_data['data']}\";
                                let old_writer = \"{$make_data['user']}\";
                                    //데이터베이스에서 생성된 변수를 input value에 담음
                                    $('.change_select').html(old_department);
                                    $('.change_title').html(old_title);
                                    $('.change_explain').html(old_instroduction);
                                    $('.change_addr>a').html(old_url).attr('href', old_url)
                                    $('.change_date').html(old_data);
                                    $('.change_id').html(old_id);
                                    $('.change_writer').html(old_writer);
                                </script>
                                ";
            };
            if (isset($_GET['show_detail']) != 0 && !isset($_GET['au_au_id'])) {
                $this_value = $_GET["show_detail"];
                //조건부 SQL 조회 명령어 생성
                $open_table = "SELECT * FROM `favorite` WHERE `id` =  '$this_value'";
                // 명령어 실행
                $show_table = mysqli_query($sql_connection, $open_table);
                //명령어 에러 확이
                if (!$show_table) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                ///조회로 생성된 자료 배열화

                $make_data = mysqli_fetch_assoc($show_table);
                if (!$make_data) {
                    echo "배열 생성이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                }
                //배열화 된 자료를 script 변수에 각각 담기
                //가져온 값을 화면에 출력
                echo  "
                                <section class='whole_show'>
                                    <form action='./favorite_changeadd.php' method='GET'>
                                        <h2 class='show_title'>상세내용</h2>
                                        <a href='./favorite_admin.php' class='change_leave' id='exit_button'>X</a>
                                        <p class='show_depart'>분류</p>
                                        <div class='change_select'></div>
                                        <p>제목</p>
                                        <div class='change_title'></div>
                                        <p>설명</p>
                                        <div class='change_explain'></div>
                                        <p>주소</p>
                                        <div class='change_addr'><a class='change_call_page' href='' target='blank'></a></div>
                                        <p>날짜</p>
                                        <div class='change_date'></div>
                                        <p>작성자</p>
                                        <div class='change_writer'></div>
                                        <a class='change_submit' href='./favorite_admin.php'>뒤로가기</a>
                                    </form>
                                </section>
                                
                                <script>
                                let old_id = {$make_data['id']};
                                let old_department = \"{$make_data['department']}\";
                                let old_title = \"{$make_data['title']}\";
                                let old_instroduction = \"{$make_data['introduction']}\";
                                let old_url = \"{$make_data['url']}\";
                                let old_data = \"{$make_data['data']}\";
                                let old_writer = \"{$make_data['user']}\";
                                    //데이터베이스에서 생성된 변수를 input value에 담음
                                    $('.change_select').html(old_department);
                                    $('.change_title').html(old_title);
                                    $('.change_explain').html(old_instroduction);
                                    $('.change_addr>a').html(old_url).attr('href', old_url);
                                    $('.change_date').html(old_data);
                                    $('.change_id').html(old_id);
                                    $('.change_writer').html(old_writer);
                                </script>
                                ";
            };
            /*//sql 연결
                $sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
                if(!$sql_connection){
                    echo "연결에 실패 하였습니다".mysqli_error($sql_connection);
                }
                //db 연결
                if(!mysqli_select_db($sql_connection, "c12st18")){
                    echo "데이터베이스가 다릅니다.".mysqli_error($sql_connection);
                }*/
            //넘어온 값의 유무 확인
            if (isset($_GET['this_value_down']) != 0) {
                $select_num = 0;
                $page_num = 1;
                $this_value = $_GET['this_value_down'];
                $open_table = "SELECT * FROM `favorite` ORDER BY `{$this_value}` limit {$select_num}, 8";
                $show_table = mysqli_query($sql_connection, $open_table);
                if (!$show_table) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                $idex = 1;
                //가져온 값을 화면에 출력
                //echo "<div id='move_to_add' class='addtional_button'>추가</div>";
                //echo "<a href='#' id='move_to_delall' class='move_to_delall'>선택 삭제</a>";
                //echo "<input id='whole_check_box' class='whole_check_box' type='checkbox'>";
                echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                    while ($row = mysqli_fetch_assoc($show_table)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                    }
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&this_value_down=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                } else {
                    $call_page = $_GET['call_page'];
                    $idex = 1;
                    @$select_num = 8 * ($call_page - 1);
                    $open_table = "SELECT * FROM `favorite` ORDER BY `{$this_value}` limit {$select_num}, 8";
                    @$show_limite_table = mysqli_query($sql_connection, $open_table);
                    echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                    while (@$row = mysqli_fetch_assoc($show_limite_table)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                    $idex++;
                    }
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&this_value_down=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                }
            }
            //값이 유무 확인
            if (isset($_GET['this_value_up']) != 0) {
                $select_num = 0;
                $this_value = $_GET["this_value_up"];
                //SQL 조회 내림차순 명령어 생성
                $open_table = "SELECT * FROM `favorite` ORDER BY `{$this_value}` desc limit {$select_num}, 8";
                //명령어 실행
                $show_table = mysqli_query($sql_connection, $open_table);
                //명령어 에러 확인
                if (!$show_table) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                $idex = 1;
                $page_num = 1;
                //가져온 값을 화면에 출력
                //echo "<div id='move_to_add' class='addtional_button'>추가</div>";
                //echo "<a href='#' id='move_to_delall' class='move_to_delall'>선택 삭제</a>";
                //echo "<input id='whole_check_box' class='whole_check_box' type='checkbox'>";
                echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                    while ($row = mysqli_fetch_assoc($show_table)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                    };
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&this_value_up=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                } else {
                    $call_page = $_GET['call_page'];
                    $idex = 1;
                    @$select_num = 8 * ($call_page - 1);
                    $open_table = "SELECT * FROM `favorite` ORDER BY `{$this_value}` desc limit {$select_num}, 8";
                    @$show_limite_table = mysqli_query($sql_connection, $open_table);
                    echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                    while (@$row = mysqli_fetch_assoc($show_limite_table)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                    }
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&this_value_up=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                }
            }
            //넘어온 값의 유무 확인 및 정렬 명령어
            if (isset($_GET['order_by_select']) != 0) {
                $select_num = 0;
                $this_value = $_GET{"order_by_select"};
                if ($this_value == 'show_all') {
                    echo "<script>location.href='favorite_admin.php'</script>";
                    //$open_table = "SELECT * FROM `favorite`";
                } else {
                    //조건부 SQL 조회 명령어 생성
                    $open_table = "SELECT * FROM `favorite` WHERE `department` =  '$this_value'";
                    // 명령어 실행
                }
                $show_table = mysqli_query($sql_connection, $open_table);
                $check_rows_detail = mysqli_num_rows($show_table);
                $detail_table = "SELECT * FROM `favorite` WHERE `department` =  '$this_value' limit {$select_num}, 8";
                $show_detail = mysqli_query($sql_connection, $detail_table);
                //명령어 에러 확이
                if (!$show_table) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                $idex = 1;
                //가져온 값을 화면에 출력
                echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                    while ($row = mysqli_fetch_assoc($show_detail)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                    };
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows_detail / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&order_by_select=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                } else {
                    $call_page = $_GET['call_page'];
                    $idex = 1;
                    @$select_num = 8 * ($call_page - 1);
                    $open_table = "SELECT * FROM `favorite` WHERE `department` =  '$this_value' limit {$select_num}, 8";
                    @$show_limite_table = mysqli_query($sql_connection, $open_table);
                    echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                    while (@$row = mysqli_fetch_assoc($show_limite_table)) {
                        echo  " <section class=\"each_section\">
                                <div>";
                                if($login_id == $row['user'] && $login_id != 'admin'){
                                    echo"
                                        <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                        <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                        ";
                                }
                                if($login_id == 'admin'){
                                    echo"
                                        <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                        <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                        ";
                                }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                    }
                    echo "</div>";
                    echo "</section>";
                    echo "<section class='page_area'>";
                    while (($page_num - 1) < ceil($check_rows_detail / 8)) {
                        echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}&order_by_select=$this_value'>{$page_num}</a>"; //href='#{$page_num2}_page'
                        $page_num++;
                    }
                    echo "</section>";
                }
            }
            //검색
            if (isset($_POST['search_submit'])) {
                $select_num = 0;
                $search_title = $_POST['search_title'];
                $search_this = "SELECT * FROM `favorite` WHERE `title` LIKE '%{$search_title}%' limit {$select_num}, 8";
                $show_search = mysqli_query($sql_connection, $search_this);
                $check_rows_detail = mysqli_num_rows($show_search);
                if ($check_rows_detail == 0) {
                    echo "
                        <div class='search_error'>
                        <p>검색어를 정확히<br>
                            입력해주세요</p>
                        </div>
                    " . mysqli_error($sql_connection);
                } else {
                    if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                        $idex = 1;
                        $page_num = 1;
                        $select_num = 0;
                        echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                        while ($make_search = mysqli_fetch_assoc($show_search)) {
                            echo  " <section class=\"each_section\">
                                    <div>";
                                        if($login_id == $make_search['user'] && $login_id != 'admin'){
                                            echo"
                                                <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$make_search['id']}> 
                                                <a class='a_button' href='./favorite_change.php?change_value={$make_search['id']}'>수정</a>
                                                ";
                                        }
                                        if($login_id == 'admin'){
                                            echo"
                                                <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$make_search['id']}> 
                                                <a class='a_button' href='./favorite_change.php?change_value={$make_search['id']}'>수정</a>
                                                ";
                                        }
                                        echo"<div class=\"result_area\">{$make_search['title']}</div>
                                        <a class=\"long_url\" href=\"{$make_search['url']}\" target=\"blank\">{$make_search['url']}</a>
                                    </div>
                                    <a class='check_detail' href='favorite_select.php?show_detail={$make_search['id']}'>자세히보기</a>
                                </section>
                            ";
                            $idex++;
                        }
                        echo "</div>";
                        echo "</section>";
                        echo "<section class='page_area'>";
                        while (($page_num - 1) < ceil($check_rows_detail / 8)) {
                            echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}'>{$page_num}</a>"; //href='#{$page_num2}_page'
                            $page_num++;
                        }
                        echo "</section>";
                    } else {
                        $call_page = $_GET['call_page'];
                        $idex = 1;
                        $page_num = 1;
                        @$select_num = 8 * ($call_page - 1);
                        $search_this = "SELECT * FROM `favorite` WHERE `title` LIKE '%{$search_title}%' limit {$select_num}, 8";
                        $show_search = mysqli_query($sql_connection, $search_this);
                        echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                        while ($make_search = mysqli_fetch_assoc($show_search)) {
                            echo  " <section class=\"each_section\">
                                <div>";
                                    if($login_id == $row['user'] && $login_id != 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    if($login_id == 'admin'){
                                        echo"
                                            <input id='check_box$idex' class='check_box' type='checkbox' name='check_box' value='false' data-id={$row['id']}> 
                                            <a class='a_button' href='./favorite_change.php?change_value={$row['id']}'>수정</a>
                                            ";
                                    }
                                    echo"<div class=\"result_area\">{$row['title']}</div>
                                    <a class=\"long_url\" href=\"{$row['url']}\" target=\"blank\">{$row['url']}</a>
                                </div>
                                <a class='check_detail' href='favorite_select.php?show_detail={$row['id']}'>자세히보기</a>
                            </section>
                        ";
                        $idex++;
                        }
                        echo "</div>";
                        echo "</section>";
                        echo "<section class='page_area'>";
                        while (($page_num - 1) < ceil($check_rows_detail / 8)) {
                            echo "<a class='page_button' href='./favorite_select.php?call_page={$page_num}>{$page_num}</a>"; //href='#{$page_num2}_page'
                            $page_num++;
                        }
                        echo "</section>";
                    }
                }
            } else {
                //echo "<script>alert('1')</script>";
            }
            ?>
        </section>
        <div class="check_again_delete">
            <p>삭제하시겠습니까?</p>
            <input id="double_check" class="double_check" type="button" value="삭제" data-id="1">
            <input id="cancel_del" class="cancel_del" type="button" value="돌아가기">
        </div>
        <script>
            $("#move_to_delall").on("click", function(e) {
                const empty_array = [];
                let empty_string = "";
                $('.check_box:checked').each(function(index) {
                    empty_array.push($(this).data('id'));
                });
                let i = 0;
                while (i < empty_array.length) {
                    empty_string += 'check_box_array[]' + '=' + empty_array[i] + '&';
                    i++;
                }
                $("#double_check").data("id", empty_string);
                $(".check_again_delete").show();
                // = `./favorite_delete.php?${empty_string}`;
            });
            $("#double_check").on("click", function(e) {
                let empty_string = "";
                empty_string = ($("#double_check").data("id"));
                location.href = `./favorite_delete.php?${empty_string}`;
            });
            /*
            $("#move_to_delall").on("click", function(e) {
                const empty_array = [];
                let empty_string = "";
                $('.check_box:checked').each(function(index) {
                    empty_array.push($(this).data('id'));
                });
                let i = 0;
                while (i < empty_array.length) {
                    empty_string += 'check_box_array[]' + '=' + empty_array[i] + '&';
                    i++;
                }
                location.href = `./favorite_delete.php?${empty_string}`;
            });
            */
            $(window).on("click", function(e) {
                switch (e.target.id) {
                    case "move_to_add":
                        location.href = "favorite_additional.php";
                        break;
                    case "check_again_delete":
                        $(".check_again_delete").hide();
                        break;
                    case "cancel_del":
                        $(".check_again_delete").hide();
                        break;
                };
            });
            $(".search_error").on("click", function(){
                location.href="favorite_admin.php";
            });
            $("#whole_check_box").on("change", function(e) {
                if ($("#whole_check_box").is(':checked')) {
                    $('input').prop('checked', true);
                } else {
                    $('input').prop('checked', false);
                };
            });
            $("#order_by_select").on("change", function() {
                $("#change_select").submit();
            });
        </script>
</body>

</html>