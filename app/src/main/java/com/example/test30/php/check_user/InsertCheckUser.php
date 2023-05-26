<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];

    $query = "INSERT INTO check_user (CHECK_USER_ID) VALUES ('$userId')";

    if(mysqli_query($con, $query)) {
        echo json_encode(
            array(
                "status" => "Success",
                "message" => $query
            )
        );
    }
    else {
        echo json_encode(
            array(
                "status" => "Fail",
                "message" => $query
            )
        );
    }

    mysqli_close($con);
?>