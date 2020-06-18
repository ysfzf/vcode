<?php
return [
    'code'=>[
        'debug'               =>env('VCODE_DEBUG',false),  //是否开启调试，开启时默认验证码123123
        'life'                =>env('VCODE_LIFE',300), //验证码有效期
        'interval'            =>env('VCODE_INTERVAL',60),  //发送验证码间隔时长
        'code_length'         =>env('VCODE_CODE_LENGTH',6), //验证码长度
        'max_check_times'     =>env('VCODE_MAX_CHECK_TIMES',5) //验证码最多验证失败次数
    ],

    'sms'=>[
        'accessKeyId'         => env('SMS_ACCESSKEYID',''),
        'accessKeySecret'     => env('SMS_ACCESSKEYSECRET',''),
        'signName'            => env('SMS_SIGNNAME'),
        'templates'           => [
            'default'         =>'',
        ]
    ]
];


/*
VCODE_DEBUG=
SMS_ACCESSKEYID=
SMS_ACCESSKEYSECRET=
SMS_SIGNNAME=

*/