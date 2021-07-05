<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>정보관리 수정</title>
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
        <section class="info_place">
            <?php
            //세션이 없다면 로그인창으로, 있다면 재부여 
            session_start();
            if(!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])){
                echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
                exit;
            }
            $login_id = $_SESSION['login_id'];
            $check_level = $_SESSION['check_level'];
            //서버 연결 확인
            $sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
            if (!$sql_connection) {
                echo "연결에 실패 하였습니다" . mysqli_error($sql_connection);
            }
            //db 연결
            if (!mysqli_select_db($sql_connection, "c12st18")) {
                echo "데이터베이스가 다릅니다." . mysqli_error($sql_connection);
            }
            //모든 내용 가져오기
            $call_au_detail = $_GET['call_au_detail'];
            $open_table = "SELECT * FROM `listpwd` where `id` = '${call_au_detail}'";
            $show_table = mysqli_query($sql_connection, $open_table);
            if (!$show_table) {
                echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                exit;
            };
            //가져온 값을 화면에 출력
            $call_detail = mysqli_fetch_assoc($show_table);
            echo "
            <script>
                let call_detail_idx = \"{$call_detail['idx']}\";
                let call_detail_id = \"{$call_detail['id']}\";
                let call_detail_name = \"{$call_detail['name']}\";
                let call_detail_nickname = \"{$call_detail['nickname']}\";
                let call_detail_pn = \"{$call_detail['pn']}\";
                let call_detail_date = \"{$call_detail['date']}\";
                let call_detail_email = \"{$call_detail['email']}\";
                let check_level = `${check_level}`;
            </script>
            ";
            if (!$call_detail) {
                echo "배열 생성이 되지 않았습니다." . mysqli_error($sql_connection);
                exit;
            }
            ?>
            <form action="./favorite_changeadd.php" method="POST">
                <p>이름</p>
                <input type="text" class="input_name" name="input_name">
                <p>아이디</p>
                <p type="text" class="input_id"></p>
                <!-- <button id= "check_id_dupl" class="check_id_dupl" type="button">중복확인</button> -->
                <!-- <p class="print_id_dupl"></p> -->
                <p>닉네임</p>
                <input type="text" class="input_nickname" name="input_nickname">
                <button id="check_nick_dupl" class="check_nick_dupl" type="button">중복확인</button>
                <p class="print_nick_dupl"></p>
                <p>비밀번호</p>
                <input type="password" id="input_password_f" class="input_password" name="input_password_f">
                <p>비밀번호확인</p>
                <input type="password" id="input_password_s" class="input_password" name="input_password_s">
                <p class="print_pw_dupl"></p>
                <p>휴대전화</p>
                <input type="number" class="input_second_num" name="input_pn_number">
                <p>이메일</p>
                <input type="text" class="input_email" name="input_email">
                <p>생년월일</p>
                <input class="input_date" type="date" name="input_date" id="">
                <?php
                if($call_detail['id'] =='admin'){
                    echo"
                    <input type='submit' name='input_change' class='input_change_forau' value='수정하기'>
                    ";
                } else {
                    echo"
                        <input type='submit' name='input_change' class='input_change' value='수정하기'>
                        <input id='del_id' type='submit' name='input_delete' class='input_delete' value='탈퇴하기'>
                        <input id='del_value' type='hidden' value={$call_detail['id']}>
                    ";
                }
                ?>
                <?php
                    echo "
                        <input type='hidden' name='input_idx' id='this_idx'>
                    ";
                ?>
                <input type='hidden' name='this_idx' id='check_id_hidden'>
                <input type='hidden' name='chick_nick' id='check_nick_hidden' value="1">
                <input type='hidden' name='check_pn' id='check_pn_hidden' value="1">
            </form>
            <section>
                <p>작성내역</p>
                <ul class="">
                    <li class="">순서</li>
                    <li class="">제목</li>
                    <li class="">URL</li>
                    <li class="">수정</li>
                    <li class="">삭제</li>
                    <li class="">바로가기</li>
                </ul>
                <hr>
            </section>
            <section>
                <?php
                //모든 내용 가져오기
                $call_au_detail = $_GET['call_au_detail'];
                $detail_table = "SELECT f.id as idx, f.title, f.url, l.authorize, l.id as id FROM `favorite` AS f right JOIN `listpwd` AS l ON f.user = l.id";
                $show_detail = mysqli_query($sql_connection, $detail_table);
                if (!$show_detail) {
                    echo "출력이 되지 않았습니다." . mysqli_error($sql_connection);
                    exit;
                };
                //가져온 값을 화면에 출력
                $idx= 1;
                while($call_each_detail = mysqli_fetch_assoc($show_detail)){
                    //echo $call_each_detail['idx'];
                    if(($call_each_detail['id'] == $call_au_detail) && !($call_each_detail['idx'] == 0) ){    //&& $call_each_detail['idx'] != ""
                            echo "
                                <ul class=''>
                                    <li>$idx</li>
                                    <li>{$call_each_detail['title']}</li>
                                    <li><a href='{$call_each_detail['url']}' target='blank'>{$call_each_detail['url']}</a></li>
                                    <a class='' href='favorite_change.php?au_change_value={$call_each_detail['idx']}&au_au_id={$call_each_detail['id']}'>수정</a>
                                    <a class='delete_button' href='#' data-id='{$call_each_detail['idx']}'>삭제</a>
                                    <a class='' href='favorite_select.php?show_detail={$call_each_detail['idx']}&au_au_id={$call_each_detail['id']}'>바로가기</a>
                                    </ul>
                                ";
                            $idx++;
                    }
                }
                ?>
            </section>
            <section>
            <button class="input_return">돌아가기</button>
            </section>
        </section>
        <div class="double_check_box">
            <p>삭제하시겠습니까?</p>
            <button id="double_delete">네</button>
            <button class="comfirm_button">아니요</button>
            <input id="delete_row_hidden"type="hidden">
        </div>
        <div class="double_delete_box">
            <p>탈퇴하시겠습니까?</p>
            <button id="delete_id">네</button>
            <button class="comfirm_button">아니요</button>
            <input id="delete_id_hidden"type="hidden">
        </div>
    </body>
    <script>
        if(check_level == "1"){
            $(".input_return").on("click", function(){
                location.href="./favorite_authority.php";
            });
        } else{
            $(".input_return").on("click", function(){
                location.href="./favorite_admin.php";
            });
            
        }
        $(".input_name").val(call_detail_name);
        $(".input_id").html(call_detail_id);
        $("#this_idx").val(call_detail_idx);
        $(".input_nickname").val(call_detail_nickname);
        $(".input_second_num").val(call_detail_pn);
        $(".input_date").val(call_detail_date);
        $(".input_email").val(call_detail_email);
        //아이디 중복확인
        // $("#check_id_dupl").on("click", function(){
        //     let check_this =  $(".input_id").val();
        //     $.ajax({
        //             url:`./favorite_changeadd.php?check_id=${check_this}`,
        //             type: 'GET',
        //             success:function(item){
        //                 $(".print_id_dupl").html(item);
        //             }
        //     });
        // });
        //닉네임 중복확인
        $("#check_nick_dupl").on("click", function(){
            let check_this =  $(".input_nickname").val();
            $.ajax({
                    url:`./favorite_changeadd.php?check_nick=${check_this}`,
                    type: 'GET',
                    success:function(item){
                        $(".print_nick_dupl").html(item);
                    }
            });
        });
        // 비밀번호의 일치 확인
        $("#input_password_s").on("keyup", function(){
            $("#input_password_s").val() != "" && $("#input_password_f").val() != "" && $("#input_password_s").val() != $("#input_password_f").val() && $("#check_nick_hidden").val("0") && $(".print_pw_dupl").html("비밀번호가 틀렸습니다.").css("color", "red");
            $("#input_password_s").val() != "" && $("#input_password_f").val() != "" && $("#input_password_s").val() == $("#input_password_f").val() && $("#check_nick_hidden").val("1") && $(".print_pw_dupl").html("비밀번호가 같습니다.").css("color", "black");
        });
        $("#input_password_f").on("keyup", function(){
            $("#input_password_s").val() != "" && $("#input_password_f").val() != "" && $("#input_password_s").val() != $("#input_password_f").val() && $("#check_nick_hidden").val("0") && $(".print_pw_dupl").html("비밀번호가 틀렸습니다.").css("color", "red");
            $("#input_password_s").val() != "" && $("#input_password_f").val() != "" && $("#input_password_s").val() == $("#input_password_f").val() && $("#check_nick_hidden").val("1") && $(".print_pw_dupl").html("비밀번호가 같습니다.").css("color", "black");
        });
        $(".input_id").on("keyup", function(){

        })
        $(".input_nickname").on("keyup", function(){
            $("#check_nick_hidden").val("0") && $(".print_nick_dupl").html("중복확인 해주세요").css("color", "red");
        });
        $(".input_change").on("click", function(e){
            !($("#check_nick_hidden").val() =="1" &&  $("#check_pn_hidden").val() =="1") && e.preventDefault();
        })
        //내용삭제
        $(".delete_button").on("click", function(){
            let empty_string="";
            $(".double_check_box").show();
            empty_string = $(this).data('id');
            $("#delete_row_hidden").val(empty_string);
        })
        $("#double_delete").on("click", function(){
            let empty_string = $("#delete_row_hidden").val();
            location.href= `./favorite_changeadd.php?del_value=${empty_string}`;
        });
        $(".comfirm_button").on("click", function(){
            $(".double_check_box").hide();
            $(".double_delete_box").hide();
        })
        //탈퇴
        $("#del_id").on("click", function(e){
            let empty_string = $("#del_value").val();
            $(".double_delete_box").show();
            $("#delete_id_hidden").val(empty_string) && e.preventDefault();
        });
        $("#delete_id").on("click", function(){
            let empty_string = $("#delete_id_hidden").val();
            location.href= `./favorite_changeadd.php?input_delete=${empty_string}`;
        });
    </script>
</html>