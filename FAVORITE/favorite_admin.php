<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image" href="./favorite.png">
    <title>즐겨찾기</title>
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
    //관리자 레벨을 확인후 관리자이면 관리자 페이지 출력, 기타 일반등급은 일반 등급 페이지 출력
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
    <!--화면 상단부 축력-->
    <section class="main_place">
        <section class="search_area">
            <form action="./favorite_select.php" class="search_form" method="POST">
                <div class="left_top_search">
                </div>
                <div class="right_bottom_serch">
                    <p>제목</p>
                    <input type="text" id="search_title" class="search_title" name="search_title">
                </div>
                <input type="submit" name="search_submit" value="조회하기">
            </form>
        </section>
        <!--정렬부 출력-->
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
        <!--내용이 나올 곳을 출력-->
        <section class="view_area">
            <div id="move_to_add" class="addtional_button">추가</div>
            <a href="#" id="move_to_delall" class="move_to_delall">선택 삭제</a>
            <input id="whole_check_box" class="whole_check_box" type="checkbox">
            <!--PHP로 DB 연결 및 시작-->
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
            //모든 내용 가져오기
            $open_table = "SELECT * FROM `favorite`";
            $show_table = mysqli_query($sql_connection, $open_table);
            if (!$show_table) {
                echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                exit;
            };
            //가져온 값을 화면에 출력
            $check_rows = mysqli_num_rows($show_table);
            //페이징을 위해 페이지 번호를 확인하고 1페이지 출력
            if (@$_GET['call_page'] == "" || @$_GET['call_page'] == 1) {
                $idex = 1;
                $page_num = 1;
                $select_num = 0;
                //limit으로 해당 페이지에 나올 내용물 갯수 제한
                $limite_table = "SELECT * FROM `favorite` limit {$select_num}, 8";
                @$show_limite_table = mysqli_query($sql_connection, $limite_table);
                echo "<div id='{$page_num}_page' class='original_div hidding_div{$page_num}'>";
                while ($row = mysqli_fetch_assoc($show_limite_table)) {
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
            } else {
                //페이징 번호를 확인 후 해당 번호까지 출력
                $call_page = $_GET['call_page'];
                $idex = 1;
                $page_num = 1;
                @$select_num = 8 * ($call_page - 1);
                //limit에 공식을 넣어 각페이지 별로 나올 갯수와 시작점을 부여
                $limite_table = "SELECT * FROM `favorite` limit {$select_num}, 8";
                @$show_limite_table = mysqli_query($sql_connection, $limite_table);
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
            }
            ?>
        </section>
        <?php
        //페이징에 필요한 번호 출력
        echo "<section class='page_area'>";
        while (($page_num - 1) < ceil($check_rows / 8)) {
            echo "<a class='page_button' href='./favorite_admin.php?call_page={$page_num}'>{$page_num}</a>"; //href='#{$page_num2}_page'
            $page_num++;
        }
        echo "</section>";
        ?>
        <div class="check_again_delete">
            <p>삭제하시겠습니까?</p>
            <input id="double_check" class="double_check" type="button" value="삭제" data-id="1">
            <input id="cancel_del" class="cancel_del" type="button" value="돌아가기">
        </div>
    </section>
        <script>
            //삭제버튼 누를시 팝업 출력
            $("#move_to_delall").on("click", function(e) {
                const empty_array = [];
                let empty_string = "";
                $('.check_box:checked').each(function(index) {
                    empty_array.push($(this).data('id'));
                });
                let i = 0;
                //data-id에서 가저온것을 배열에 담아서 Get으로 넘길 준비
                while (i < empty_array.length) {
                    empty_string += 'check_box_array[]' + '=' + empty_array[i] + '&';
                    i++;
                }
                $("#double_check").data("id", empty_string);
                $(".check_again_delete").show();
            });
            //삭제버튼 누르면 위에서 가져온 배열을 get으로 주소창에 입력
            $("#double_check").on("click", function(e) {
                let empty_string = "";
                empty_string = ($("#double_check").data("id"));
                console.log(empty_string);
                location.href = `./favorite_delete.php?${empty_string}`;
            });
            //선택 삭제 옆 전체 삭제 버튼을 눌렀을때 전체 선택 혹은 해제되게 설계
            $("#whole_check_box").on("change", function(e) {
                if ($("#whole_check_box").is(':checked')) {
                    $('input').prop('checked', true);
                } else {
                    $('input').prop('checked', false);
                };
            });
            //select의 값 별로 정렬 제출
            $("#order_by_select").on("change", function() {
                $("#change_select").submit();
            });
            //페이징 버튼을 누르면 해당 페이지로 넘어감
            $('.page_button').on("click", function() {
                let idx_array = [];
                let idx_string = "";
                idx_string += 'page_button' + ($(this).data('num'));
                $('.original_div').addClass(" display_none");
                $(idx_string).addClass(" display_block");
            });
            $(window).on("click", function(e) {
                switch (e.target.id) {
                    case "move_to_add":
                        //추가버튼 누를시 이동
                        location.href = "favorite_additional.php";
                        break;
                    case "check_again_delete":
                        //cancel 버튼 누를시 DIV 안보이게 하기
                        $(".check_again_delete").hide();
                        break;
                    case "cancel_del":
                        //cancel 버튼 누를시 DIV 안보이게 하기
                        $(".check_again_delete").hide();
                        break;
                };
            });
            //검색중 에러가 나오면 뒤로가기
            $(".search_error").on("click", function(){
                location.href="./favorite_admin.php";
            });
        </script>
</body>

</html>