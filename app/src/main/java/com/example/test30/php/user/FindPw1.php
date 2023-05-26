<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];
    $userName = $_POST["userName"];
    $userPhone = $_POST["userPhone"];

    $query = "SELECT USER_NAME, USER_PHONE FROM user WHERE USER_ID = '$userId'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    if($userName != $row["USER_NAME"]) {
        echo json_encode(
            array(
                "status" => "NoName",
                "message" => "Fail"
            )
        );
    }
    else if($userPhone != $row["USER_PHONE"]) {
        echo json_encode(
            array(
                "status" => "NoPhone",
                "message" => "Fail"
            )
        );
    }
    else if(($userName == $row["USER_NAME"]) && ($userPhone == $row["USER_PHONE"])) {
        echo json_encode(
            array(
                "status" => "true",
                "message" => "Success"
            )
        );
    }

    mysqli_close($con);

?>