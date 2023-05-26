<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $replyBoardNo = $_POST["replyBoardNo"];
    $replyContent = $_POST["replyContent"];
    $replyUserId = $_POST["replyUserId"];
    $replyCrtd = $_POST["replyCrtd"];
    $replyCrtu = $_POST["replyCrtu"];

    $query = "SELECT count(*) FROM reply";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $count = $row[0] + 1;

    $query1 = "INSERT INTO reply (REPLY_NO, REPLY_BOARD_NO, REPLY_CONTENT, REPLY_TYPE, REPLY_STATUS, REPLY_USER_ID, REPLY_CRTD, REPLY_CRTU) VALUES ($count, '$replyBoardNo', '$replyContent', '1', 'u', '$replyUserId', '$replyCrtd', '$replyCrtu')";
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
                "status" => "false",
                "message" => "Fail"
            )
        );
    }

    mysqli_close($con);
?>