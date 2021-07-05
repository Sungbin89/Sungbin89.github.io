<?php
$sql_connection = mysqli_connect("localhost", "c12st18", "LKIKsNZqInF8NqaO", "c12st18");
//서버 연결 확인
if(!$sql_connection){
    echo "연결에 실패 하였습니다".mysqli_error($sql_connection);
}
// DB 연결 확인
if(!mysqli_select_db($sql_connection, "c12st18")){
    echo "데이터베이스가 다릅니다.".mysqli_error($sql_connection);
}

//입력한 ID, PW 가져오기
$login_id = $_GET['login_id'];
$login_pwd = $_GET['login_pwd'];
//입력한 아이디 가져오기
$call_auth_one = "SELECT `pwd`, `id`, `authorize` FROM `listpwd` WHERE `id`='$login_id'";
//조회 에러 확인
if( !mysqli_query($sql_connection, $call_auth_one)){
    echo "조회가 되지 않았습니다.".mysqli_error($sql_connection);
} else {
    //에러 없다면 DB 조회
    $call_data = mysqli_query($sql_connection, $call_auth_one);
}
//조회된 데이터 배열화
$array_row = mysqli_fetch_assoc($call_data);
//echo md5($login_pwd)."\n";    
// 배열화 에러 확인
//배열된 각 값을 호출
$test_pw= $array_row['pwd'];
$test_id= $array_row['id'];
$check_level= $array_row['authorize'];
/*if(!$array_row){
    echo "1";
    //echo $test_id;
    //echo $login_id;
    //exit;
};*/
//echo $check_level."\n";
//관리자 등급, 비번 일치 확인
/*if($test_id != $login_id && $test_id = ""){
    //echo $test_id;
    //echo $login_id;
    //exit;
    echo"1";
}*/
if($test_pw != md5($login_pwd)){
    echo"2";
}
/*if(isset($_GET['mission_complete'])){
    session_start();
    $_SESSION['login_id']= $login_id;
    $_SESSION['login_pwd']= $login_pwd;
    echo "<meta http-equiv='refresh' content='0; url=./favorite_admin.php'>";
}*/
if(isset($_GET['mission_complete'])){
if($check_level !="1" ||  md5($login_pwd) != $test_pw){
    if($check_level !="0" || md5($login_pwd) != $test_pw){
        //echo $test_id."\n";
        //echo md5($login_pwd)."\n";
        //echo $test_pw."\n";
        //echo $login_id."\n";
        //echo $test_id."\n";
        //echo $check_level."\n";
        echo "땡";  
        exit;
    } else{
        //일반등급이라면 sesstion 부여 및 이동
        session_start();
        $_SESSION['login_id']= $login_id;
        $_SESSION['check_level']= $check_level;
        echo "<meta http-equiv='refresh' content='0; url=./favorite_admin.php'>";
    }
} else{
    //관리자등급이라면 sesstion 부여 및 이동
    session_start();
    $_SESSION['login_id']= $login_id;
    $_SESSION['check_level']= $check_level;
    echo "<meta http-equiv='refresh' content='0; url=./favorite_admin.php'>";
}
}
?>
