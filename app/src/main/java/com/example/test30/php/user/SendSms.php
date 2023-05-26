<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];

    $query = "SELECT USER_NAME, USER_GUARDIANPHONE FROM user WHERE USER_ID = '$userId'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    echo json_encode(
        array(
            "status" => "true",
            "NAME" => ($row["USER_NAME"]),
            "PHONE" => ($row["USER_GUARDIANPHONE"])
        )
    );

    mysqli_close($con)

?>