<?php
//서버 연결
$sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
//서버 연결 확인
if(!$sql_connection){
    echo "연결에 실패 하였습니다".mysqli_error($sql_connection);
}
//DB 연결 확인
if(!mysqli_select_db($sql_connection, "c12st18")){
    echo "데이터베이스가 다릅니다.".mysqli_error($sql_connection);
}
// 값의 유무 확인
if(isset($_GET['make_id_input'])){
    $check_id = $_GET['make_id_input'];
    // 조건 조회 SQL 명령어 생성
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
            //중복이 없다면 사용 가능
            echo "사용 가능합니다.<script>$('#hidden_id').val('1');$('.check_id_ment').css('color', 'black');</script>";
        } else {
            //중복이 있다면 사용 불가능
            echo "사용 불가능합니다.<script>$('#hidden_id').val('0');$('.check_id_ment').css('color', 'red');</script>";
        };
    }
}
if(isset($_GET['make_nickname_input'])){
    $check_nickname = $_GET['make_nickname_input'];
    // 조건 조회 SQL 명령어 생성
    $check_row = "SELECT * FROM `listpwd` WHERE `nickname`='$check_nickname'";
    //쿼리 생성 확인
    if(!mysqli_query($sql_connection, $check_row)){
        echo "오류있음";
    } else {
        //참이면 조건 조회 실행
        $make_new = mysqli_query($sql_connection, $check_row);
        // 실행값 배열화
        $qeury_record = mysqli_fetch_assoc($make_new);
        //배열에 입력 한 ID와 중복 확인
        if($qeury_record{'nickname'} != $check_nickname){
            //중복이 없다면 사용 가능
            echo "사용 가능합니다.<script>$('#hidden_nick').val('1');$('.check_nickname_ment').css('color', 'black');</script>";
        } else {
            //중복이 있다면 사용 불가능
            echo "사용 불가능합니다.<script>$('#hidden_nick').val('0');$('.check_nickname_ment').css('color', 'red');</script>";
        };
    }
}
//값의 유무 확인
if(isset($_POST['submit'])){
    $make_id = $_POST['make_id_input'];
    //비밀번호는 md5로 변환 후 저장
    $make_name = $_POST['make_name_input'];
    $make_nickname = $_POST['make_nickname_input'];
    $make_pw = md5($_POST['make_pw_input']);
    $make_pn = $_POST['make_pn_input'];
    $make_email = $_POST['make_email_input'];
    $make_date = $_POST['make_date_input'];
    //SQL 삽입 명령어 생성
    $make_row = "INSERT INTO `listpwd` VALUE('', '{$make_id}', '{$make_name}', '{$make_nickname}', '{$make_pw}', '{$make_pn}', '{$make_email}', '{$make_date}','0')";
    //삽입 명령어 실행
    $insert_id = mysqli_query($sql_connection, $make_row);
    //삽입 명령어 에러 확인
    if(!$insert_id){
        echo"쿼리 안됨".mysqli_error($sql_connection);
    } else {
        echo "<meta http-equiv='refresh' content='0;url=./Main_favorite.html'>";
    }
} 


/*if(!mysqli_fetch_assoc($check_id)){
    echo "배열로 정렬 할수 없습니다.".mysqli_error($sql_connection);
    //$test_row = $make_data['id'];
    //echo "$test_row";
};*/
//$test_row = $make_data['id'];
//  echo "$test_row";
//echo "$make_id_input";
//if( $test_row != $make_id_input){
    //$id_ment = "사용 불가능합니다.";
    //echo "<script>let id_ment ='$id_ment';history.back()</script>";
//} else{
//    $id_ment = "사용 가능합니다.";
    //echo "<script>history.back()</script>";
//}

?>