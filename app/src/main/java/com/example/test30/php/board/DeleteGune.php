<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $boardNo = $_POST["boardNo"];

    $query = "UPDATE board SET BOARD_STATUS = 'd' WHERE BOARD_NO = '$boardNo' AND BOARD_BOARDMASTER_NO = 2";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    echo json_encode(
        array(
            "status" => "true"
        )
    );

    mysqli_close($con)

?>