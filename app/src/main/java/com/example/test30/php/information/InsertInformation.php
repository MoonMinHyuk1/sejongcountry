<?php
    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $informationToken = $_POST["informationToken"];
    $informationUid = $_POST["informationUid"];
    $informationUserid = $_POST["informationUserid"];

    $query = "SELECT count(*) FROM information WHERE information_token = '$informationToken'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $count = $row[0];

    if($count == 0) {
        $query1 = "INSERT INTO information (INFORMATION_TOKEN, INFORMATION_UID, INFORMATION_USERID) VALUES ('$informationToken', '$informationUid', '$informationUserid')";
        if(mysqli_query($con, $query1)) {
            echo json_encode(
                array(
                    "status" => "insert success",
                    "count" => $count,
                    "message" => $query1
                )
            );
        }
        else {
            echo json_encode(
                array(
                    "status" => "insert fail",
                    "count" => $count,
                    "message" => $query1
                )
            );
        }
    }
    else {
        $query1 = "UPDATE information SET INFORMATION_UID = '$informationUid', INFORMATION_USERID = '$informationUserid' WHERE INFORMATION_TOKEN = '$informationToken'";
        if(mysqli_query($con, $query1)) {
            echo json_encode(
                array(
                    "status" => "update success",
                    "count" => $count,
                    "message" => $query1
                )
            );
        }
        else {
            echo json_encode(
                array(
                    "status" => "update fail",
                    "count" => $count,
                    "message" => $query1
                )
            );
        }
    }

    mysqli_close($con);
?>