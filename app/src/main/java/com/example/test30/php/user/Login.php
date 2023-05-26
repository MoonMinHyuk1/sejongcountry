<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];
    $userPw = $_POST["userPw"];

    $query = "SELECT USER_PW, USER_TYPE, USER_GUARDIANPHONE, USER_NAME FROM user WHERE USER_ID = '$userId' AND USER_STATUS = 'u'";
    $result = mysqli_query($con, $query);
    $count = mysqli_num_rows($result);

    if($count == 0) {
        echo json_encode(
            array(
                "status" => "NoId"
            )
        );
    }

    $row = mysqli_fetch_assoc($result);

    if(($count == 1) && ($userPw != $row["USER_PW"])) {
        echo json_encode(
            array(
                "status" => "NoPw"
            )
        );
    }
    else if(($count == 1) && ($userPw == $row["USER_PW"])) {
        echo json_encode(
            array(
                "status" => "true",
                "type" => ($row["USER_TYPE"]),
                "guardian" => ($row["USER_GUARDIANPHONE"]),
                "name" => ($row["USER_NAME"])
            )
        );
    }

    mysqli_close($con)

?>