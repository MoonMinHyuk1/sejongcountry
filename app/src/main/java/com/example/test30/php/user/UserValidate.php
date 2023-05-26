<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];

    $statement = mysqli_prepare($con, "SELECT USER_ID FROM USER WHERE USER_ID = ?");
    mysqli_stmt_bind_param($statement, "s", $userId);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $userId);

    $response = array();
    $response["success"] = true;

    while(mysqli_stmt_fetch($statement)) {
        $response["success"] = false;
        $response["userId"] = $userId;
    }

    echo json_encode($response);
?>