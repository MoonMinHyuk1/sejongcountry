<?php
 $db_name = "sejongcountry"; 		// DB 명
 $username = "sejongcountry";		// DB 아이디
 $password = "zoqtmxhs1!"; 		// MySQL 비밀번호
 $servername = "localhost";		// 서버 이름인데 로컬호스트로 ㄱㄱ

 $conn = mysqli_connect($servername, $username, $password, $db_name);

 if($conn){
  echo "Login success";}
  else{
  echo "Login fail";}
?>