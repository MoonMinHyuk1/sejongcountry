<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $query = "SELECT BOARD_NO, BOARD_TITLE, BOARD_USER_ID, BOARD_TYPE FROM board WHERE BOARD_STATUS = 'u' AND BOARD_BOARDMASTER_NO = 2 ORDER BY BOARD_CRTD ASC";
    $res = mysqli_query($con, $query);
    $result = array();

    while($row = mysqli_fetch_array($res)) {
        $query1 = "SELECT USER_NAME FROM user WHERE USER_ID = '$row[2]'";
        $res1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_assoc($res1);

        array_push($result, array('NO'=>$row[0], 'TITLE'=>$row[1], 'NAME'=>$row1["USER_NAME"], 'TYPE'=>$row[3]));
    }

    echo json_encode(array("result"=>$result), JSON_UNESCAPED_UNICODE);

    mysqli_close($con)

?>