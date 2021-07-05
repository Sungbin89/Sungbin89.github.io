<?php
session_start();
//세션이 없다면 로그인창으로, 있다면 재부여 
if(!isset($_SESSION['login_id']) || !isset($_SESSION['check_level'])){
    echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
    exit;
}
$login_id = $_SESSION['login_id'];
$check_level = $_SESSION['check_level'];
//서버 연결 확인
$sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
if(!$sql_connection){
    echo "연결에 실패 하였습니다".mysqli_error($sql_connection);
}
//DB 연결 확인
if(!mysqli_select_db($sql_connection, "c12st18")){
    echo "데이터베이스가 다릅니다.".mysqli_error($sql_connection);
}
//가져온 값들을 변수에 담음
if(isset($_GET['submit_button'])){
    $update_id = $_GET['add_id'];
    $update_department = $_GET['add_department'];
    $update_title = $_GET['add_title'];
    $update_text = $_GET['add_text'];
    $update_url = $_GET['add_url'];
    $update_data = $_GET['add_data'];
    $au_au_id= $_GET['au_au_id'];
    //SQL 수정 명령어 작성
    $update_table = "UPDATE `favorite` SET `department`= '{$update_department}', `title`= '{$update_title}', `introduction`= '{$update_text}', `url`= '{$update_url}', `data`='{$update_data}' WHERE id='{$update_id}'";
    //수정 명령어 실행
    $call_table = "SELECT * FROM `listpwd` where `id` = '$au_au_id'";
    $show_table = mysqli_query($sql_connection, $update_table);
    $check_table = mysqli_query($sql_connection, $call_table);
    $check_rows = mysqli_num_rows($check_table);
    //수정 명령어 에러 확인
    if(!$show_table){
        echo "출력이 되지 않았습니다.1".mysqli_error($sql_connection);
        exit;
    };
    //출력 페이지로 이동
    if($check_rows != "0"){
        echo "<script>location.href='./favorite_au_detail.php?call_au_detail={$au_au_id}'</script>";
    } else{
        echo "<script>location.href='./favorite_admin.php'</script>";
    }
}
if(isset($_POST['input_change'])){
    $input_name = $_POST['input_name'];
    $input_nickname = $_POST['input_nickname'];
    $input_idx = $_POST['input_idx'];
    $input_password_f = md5($_POST['input_password_f']);
    $input_pn_number = $_POST['input_pn_number'];
    $input_email = $_POST['input_email'];
    $input_date= $_POST['input_date'];
    $update_table = "UPDATE `listpwd` SET `name`= '{$input_name}', `nickname`= '{$input_nickname}',  `pn`= '{$input_pn_number}', `email`='{$input_email}', `date`='{$input_date}' WHERE `idx`='{$input_idx}'";
    $show_table = mysqli_query($sql_connection, $update_table);
    // /`pwd`= '{$input_password_f}',
    /*echo $input_name;
    echo $input_nickname;
    echo $input_id;
    echo $input_idx;
    echo $input_password_f;
    echo $input_pn_number;
    echo $input_email;
    echo $input_date;
    exit;*/
    if($check_level == "1"){
        echo "<script>location.href='./favorite_authority.php'</script>;";
    } else {
        echo "<script>location.href='./favorite_admin.php'</script>;";
    }
}
if(isset($_GET['check_id'])){
    $check_id = $_GET['check_id'];
    $check_row = "SELECT * FROM `listpwd` WHERE `id`='$check_id'";
    //쿼리 생성 확인
    if(!mysqli_query($sql_connection, $check_row)){
        echo "오류있음";
    } else {
        //참이면 조건 조회 실행
        $make_new = mysqli_query($sql_connection, $check_row);
        // 실행값 배열화
        $qeury_record = mysqli_fetch_assoc($make_new);
        //배열에 입력 한 ID와 중복 확인
        if($qeury_record{'id'} != $check_id){
            //중복이  사용 가능
            echo "사용 가능합니다.<script>$('#check_id_hidden').val('1');</script>";
            exit;
        } else {
            //중복이 있다면 사용 불가능
            echo "사용 불가능합니다.<script>$('#check_id_hidden').val('0');</script>";
            exit;
        };
    }
}
if(isset($_GET['check_nick'])){
    $check_nick = $_GET['check_nick'];
    $check_row = "SELECT * FROM `listpwd` WHERE `nickname`='$check_nick'";
    //쿼리 생성 확인
    if(!mysqli_query($sql_connection, $check_row)){
        echo "오류있음";
    } else {
        //참이면 조건 조회 실행
        $make_new = mysqli_query($sql_connection, $check_row);
        // 실행값 배열화
        $qeury_record = mysqli_fetch_assoc($make_new);
        //배열에 입력 한 ID와 중복 확인
        if($qeury_record{'nickname'} != $check_nick){
            //중복이  사용 가능
            echo "사용 가능합니다.<script>$('#check_nick_hidden').val('1');$('.print_nick_dupl').css('color', 'black');</script>";
            exit;
        } else {
            //중복이 있다면 사용 불가능
            echo "사용 불가능합니다.<script>$('#check_nick_hidden').val('0');$('.print_nick_dupl').css('color', 'red');</script>";
            exit;
        };
    }
}
//비관리자 페이지 탍퇴
if(isset($_GET['input_delete'])){
    $input_delete = $_GET['input_delete'];
    $delete_list = "DELETE FROM `favorite` WHERE `user` = '$input_delete'";
    $delete_info = "DELETE FROM `listpwd` WHERE `id`= '$input_delete'";
    $delete_from_list = mysqli_query($sql_connection, $delete_list);
    $delete_from_info = mysqli_query($sql_connection, $delete_info);
    if($check_level == "1"){
        echo "<script>location.href='favorite_authority.php'</script>";
    } else {
        echo "<script>location.href='favorite_logout.php'</script>";
    }
}
//관리자 페이지 선택삭제
if(isset($_GET['del_id'])){
    $del_id = $_GET['del_id'];
    $delete_list = "DELETE FROM `favorite` WHERE `user` = '$del_id'";
    $delete_info = "DELETE FROM `listpwd` WHERE `id`= '$del_id'";
    $delete_from_list = mysqli_query($sql_connection, $delete_list);
    $delete_from_info = mysqli_query($sql_connection, $delete_info);
    echo "<script>location.href='favorite_authority.php'</script>";
}
//개인 상세 페이지 리스트 선택 삭제
if(isset($_GET['del_value'])){
    $del_value = $_GET['del_value'];
    $delete_list = "DELETE FROM `favorite` WHERE `id` = '$del_value'";
    $back_list = "SELECT * FROM `favorite` where `id` = '$del_value'";
    $back_to_list = mysqli_query($sql_connection, $back_list);
    $show_list_for_back = mysqli_fetch_assoc($back_to_list);
    $delete_from_list = mysqli_query($sql_connection, $delete_list);
    echo "<script>location.href='favorite_au_detail.php?call_au_detail={$show_list_for_back['user']}'</script>";
}
/*
if(isset($_POST['input_change'])){
    echo"1";
    exit;
    $input_idx = $_POST['input_idx'];
    $input_name = $_POST['input_name'];
    $input_id = $_POST['input_id'];
    $input_nickname = $_POST['input_nickname'];
    $input_password = $_POST['input_password_f'];
    $input_pn_number = $_POST['input_pn_number'];
    $input_email = $_POST['input_email'];
    $input_date = $_POST['input_date'];
    //SQL 조건부 조회 명령어 작성 
    $open_table = "UPDATE `favoritepwd` SET `favoritepwd` `id` = '{$input_id}', `name` = '{$input_name}', `nickname` = '{$input_nickname}', `pwd` = '{$input_password}', `pn` = '{$input_pn_number}', `email` = '{$input_email}', `date` = '{$input_date}' WHERE `id`='$input_idx'";
    //조회 명령어 실행
    /*$show_table = mysqli_query($sql_connection, $open_table);
    ///조회로 생성된 자료 배열화
    $make_data = mysqli_fetch_assoc($show_table);
    echo"
    let input_name = \"{$input_name['name']}\";
    let input_id = \"{$input_id['id']}\";
    let input_nickname = \"{$input_nickname['nickname']}\";
    let input_password = \"{$input_password['pwd']}\";
    let input_pn_number = \"{$input_pn_number['pn']}\";
    let input_email = \"{$input_email['email']}\";
    let input_date = \"{$input_date['date']}\";
    
    ";
    */
    //echo "<script>location.href='./favorite_authority.php'</script>;";
//}