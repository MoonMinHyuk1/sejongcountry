<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $boardNo = $_POST["boardNo"];

    $query = "SELECT BOARD_TITLE, BOARD_CONTENT, BOARD_CRTD, BOARD_USER_ID FROM board WHERE BOARD_NO = '$boardNo' AND BOARD_BOARDMASTER_NO = 2";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    echo json_encode(
        array(
            "status" => "true",
            "TITLE" => ($row["BOARD_TITLE"]),
            "CONTENT" => ($row["BOARD_CONTENT"]),
            "CRTD" => ($row["BOARD_CRTD"]),
            "ID" => ($row["BOARD_USER_ID"])
        )
    );

    mysqli_close($con)

?>