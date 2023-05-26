<?php
    $token = $_POST["TOKEN"];
    $title = $_POST["TITLE"];
    $message = $_POST["MESSAGE"];

    $notification = array();
    $notification['title'] = $title;
    $notification['body'] = $message;
    $tokens = array();
    $tokens[0] = $token;

    $url = 'https://fcm.googleapis.com/fcm/send';
    $apiKey = "AAAA1Y50Jsw:APA91bFYpOZAOiLRocw3sbH8MLcn4gZtLbMXFvJscI8Yrnr7EoRQQ18FcU7-fMZyaWqtbFSwwj0XhzgOZ5IwDbXMtnd_tXyxo0gBudslRV2z8KT3Ai-GXRCZ5sLgGLeqj2Em9VmK9jW9";
    $fields = array('registration_ids' => $tokens, 'notification' => $notification);
    $headers = array('Authorization:key='.$apiKey,'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if($result === FALSE) {
        echo json_encode(
            array(
                "status" => "false"
            )
        );
    }
    else {
        echo json_encode(
            array(
                "status" => "true"
            )
        );
    }

    curl_close($ch);

?>