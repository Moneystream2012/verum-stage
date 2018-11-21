<?php
$json = [
    'nick'   => $auth->full_name,
    'id'     => $auth->id,
    'avatar' => $auth->avatar_url,
    'email'  => $auth->email,
    'data'   => [
        'id'       => $auth->id,
        'username' => $auth->username,
        'email'    => $auth->email,
    ],
    'verify' => [
        'id' => $auth->id,
    ],
];
$time = time();
$secret = "s5gANDKqs3";
$user_base64 = base64_encode(json_encode($json));
$sign = md5($secret.$user_base64.$time);
$auth = $user_base64."_".$time."_".$sign;
echo "'".$auth."'";

