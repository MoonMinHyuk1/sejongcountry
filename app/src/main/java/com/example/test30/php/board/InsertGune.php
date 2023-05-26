<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $boardTitle = $_POST["boardTitle"];
    $boardContent = $_POST["boardContent"];
    $boardType = $_POST["boardType"];
    $boardStatus = $_POST["boardStatus"];
    $userId = $_POST["userId"];
    $boardCrtu = $_POST["boardCrtu"];
    $boardCrtd = $_POST["boardCrtd"];

    $query = "SELECT count(*) FROM board";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $count = $row[0] + 1;

    $query1 = "INSERT INTO board (BOARD_NO, BOARD_BOARDMASTER_NO, BOARD_TITLE, BOARD_CONTENT, BOARD_TYPE, BOARD_STATUS, BOARD_USER_ID, BOARD_CRTD, BOARD_CRTU) VALUES ($count, 2, '$boardTitle', '$boardContent', '$boardType', '$boardStatus', '$userId', '$boardCrtd', '$boardCrtu')";
    if(mysqli_query($con, $query1)) {
        echo json_encode(
            array(
                "status" => "true",
                "message" => "Success"
            )
        );
    }
    else {
        echo json_encode(
            array(
                "status" => $query1,
                "message" => "Fail"
            )
        );
    }

    mysqli_close($con);
?>