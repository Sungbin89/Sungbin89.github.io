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
//값의 유무 확인
if(isset($_GET['delete_value'])) {
    //있다면 진행
    $row_id = $_GET['delete_value'];
    //SQL 삭제 명령어 생성
    $check_row = "DELETE FROM `favorite` WHERE `id`='$row_id'";
    //삭제 명령어 실행
    $delete_point = mysqli_query($sql_connection, $check_row);
    //삭제 후 페이지 이동
    echo "<script>location.href='favorite_admin.php'</script>";
}
//부분 삭제 연습중
if(isset($_GET['check_box_array'])){
    //echo "<script>alert('값 받아옴')</script>";
    //echo "빙고";
    //$check_box[] = $_GET['check_box'];
    //echo $check_box;
    //$empty_array = $_GET['check_box_array'];
    $check_box= $_GET['check_box_array'];
    foreach($check_box as $list){
        //echo "<script>alert('값 쪼겜')</script>";
        $delete_list = $list;
        $delete_row = "DELETE FROM `favorite` WHERE `id`='$delete_list'";
        $delete_each_row = mysqli_query($sql_connection, $delete_row);
        
       // echo $check_box;
        //echo "<script>alert($delete_list)</script>";
    };
    echo "<script>location.href='favorite_admin.php'</script>";
} else{
    echo "<script>location.href='favorite_admin.php'</script>";
}
/*$row_id = $_GET['delete_value'];
$check_row = "DELETE FROM favorite WHERE id='$row_id'";
$delete_row = mysqli_query($sql_connection, $check_row);
echo "<script>location.href='favorite_admin.php'</script>";*/
?>