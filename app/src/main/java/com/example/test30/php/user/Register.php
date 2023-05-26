<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $userId = $_POST["userId"];
    $userPw = $_POST["userPw"];
    $userName = $_POST["userName"];
    $userGender = $_POST["userGender"];
    $userBirth = $_POST["userBirth"];
    $userPhone = $_POST["userPhone"];
    $userTelephone = $_POST["userTelephone"];
    $userGuardianphone = $_POST["userGuardianphone"];
    $userAddress = $_POST["userAddress"];
    $userCrtd = $_POST["userCrtd"];
    $userCrtu = $_POST["userCrtu"];

    // $statement = mysqli_prepare($con, "INSERT INTO user (USER_ID, USER_PW, USER_NAME, USER_GENDER, USER_BIRTH, USER_PHONE, USER_TELEPHONE, USER_GUARDIANPHONE, USER_ADDRESS, USER_CRTD, USER_CRTU) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // mysqli_stmt_bind_param($statement, "sssssssssss", $userId, $userPw, $userName, $userGender, $userBirth, $userPhone, $userTelephone, $userGuardianphone, $userAddress, $userCrtd, $userCrtu);
    // mysqli_stmt_execute($statement);

    $query = "INSERT INTO user (USER_ID, USER_PW, USER_NAME, USER_GENDER, USER_BIRTH, USER_PHONE, USER_TELEPHONE, USER_GUARDIANPHONE, USER_ADDRESS, USER_TYPE, USER_STATUS, USER_CRTD, USER_CRTU) VALUES ('$userId', '$userPw', '$userName', '$userGender', '$userBirth', '$userPhone', '$userTelephone', '$userGuardianphone', '$userAddress', '0', 'u', '$userCrtd', '$userCrtu')";
    if(mysqli_query($con, $query)) {
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
                "message" => $query
            )
        );
    }

    mysqli_close($con);
?>