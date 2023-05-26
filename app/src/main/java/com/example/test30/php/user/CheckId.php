<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_GET["userId"];

    $query = "SELECT count(*) FROM user WHERE USER_ID = '$userId'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $count = $row[0];

    if($count == 0) {
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