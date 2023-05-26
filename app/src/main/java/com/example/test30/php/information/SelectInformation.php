<?php

    $db_name = "sejongcountry"; 	// DB 명
    $username = "sejongcountry";	// DB 아이디
    $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
    $servername = "localhost";		// 서버 이름

    $con = mysqli_connect($servername, $username, $password, $db_name);
    mysqli_query($con, 'SET NAMES utf8');

    $query = "SELECT INFORMATION_TOKEN FROM information";
    $res = mysqli_query($con, $query);
    $result = array();

    while($row = mysqli_fetch_array($res)) {
        array_push($result, array('TOKEN'=>$row[0]));
    }

    echo json_encode(array("result"=>$result), JSON_UNESCAPED_UNICODE);

    mysqli_close($con)

?>