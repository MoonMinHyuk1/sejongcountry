<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $query = "SELECT BOARD_NO, BOARD_TITLE, BOARD_TYPE, BOARD_CRTD FROM board WHERE BOARD_TYPE = '1' AND BOARD_STATUS = 'u' AND BOARD_BOARDMASTER_NO = 1 ORDER BY BOARD_CRTD DESC";
    $res = mysqli_query($con, $query);
    $result = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($result, array('NO'=>$row[0], 'TITLE'=>$row[1], 'TYPE'=>$row[2], 'CRTD'=>$row[3]));
    }

    echo json_encode(array("result"=>$result), JSON_UNESCAPED_UNICODE);

    mysqli_close($con)

?>