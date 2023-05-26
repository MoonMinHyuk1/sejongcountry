<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userName = $_POST["userName"];
    $userPhone = $_POST["userPhone"];

    $query = "SELECT USER_NAME, USER_ID FROM user WHERE USER_PHONE = '$userPhone'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);

    if($count == 0) {
        echo json_encode(
            array(
                "status" => "NoPhone"
            )
        );
    }

    $row = mysqli_fetch_assoc($result);

    if(($count == 1) && ($userName != $row["USER_NAME"])) {
        echo json_encode(
            array(
                "status" => "NoName"
            )
        );
    }
    else if(($count == 1) && ($userName == $row["USER_NAME"])) {
        echo json_encode(
            array(
                "status" => "true",
                "ID" => ($row["USER_ID"])
            )
        );
    }

    mysqli_close($con)

?>