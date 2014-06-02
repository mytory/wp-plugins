<?php
    include "lib/AGSLib.php";
    include 'functions.php';

    date_default_timezone_set('UTC');
    define('SOURCE_ENC', 'utf8');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

    // 체크섬 검사
    if (!isset($_POST['checksum'])
        || !isset($_POST['OrdNo'])
        || !isset($_POST['Amt'])
        || (($_POST['checksum'] !== md5($_POST['OrdNo'] . TASTY_SALT . $_POST['Amt'])))
            && ($_POST['checksum'] !== md5($_POST['OrdNo'] . TASTY_SALT . BIG_BUCKS )))
    {
        header('HTTP/1.1 400 BAD REQUEST');
        exit;
    }

    if ($_POST['Job'] !== 'direct') {

        // 필드 있는지 검사
        foreach (allthegate_request_inputs() as $input) {
            if (!isset($_POST[$input])) {
                header('HTTP/1.1 400 BAD REQUEST');
                exit;
            }
        }

        /* 최대 길이 맞추기. 매뉴얼에 따르면:
         * 
         * > 각 항목의 필드 길이를 초과할 경우 심각한 장애가 발생할 수 있습니다
         */
        foreach (allthegate_request_inputs() as $input) {
            $maxlength = allthegate_input_maxlengths($input);
            if (!is_null($maxlength)) {
                $_POST[$input] = mb_strcut($_POST[$input], 0, $maxlength, SOURCE_ENC);
            }
        }

        foreach (array('checksum', 'return-url') as $input) {
            if (!isset($_POST[$input])) {
                header('HTTP/1.1 400 BAD REQUEST');
                echo sprintf("no %s set", $input);
                exit;
            }
        }

        // euc-kr로 변환
        foreach (allthegate_request_inputs() as $input) {
            $post_cp949[$input] = iconv(SOURCE_ENC, 'euc-kr', $_POST[$input]);
        }

        $agspay = new agspay40;
        $agspay->SetValue("AgsPayHome",dirname(__FILE__));
        $agspay->SetValue("log","true");
        $agspay->SetValue("logLevel","INFO");
        $agspay->SetValue("UseNetCancel","true");
        $agspay->SetValue("Type", "Pay");
        $agspay->SetValue("RecvLen", 7);
        $agspay->SetValue("UserIp",$_SERVER["REMOTE_ADDR"]);

        foreach (allthegate_request_inputs() as $input) {
            $agspay->SetValue($input, $post_cp949[$input]);
        }

        $agspay->startPay();

        /*
         *   성공여부   : $agspay->GetResult("rSuccYn") (성공:y 실패:n)
         *   결과메시지 : $agspay->GetResult("rResMsg")
         */
        $_POST['rSuccYn'] = $agspay->GetResult("rSuccYn");
        $_POST['rResMsg'] = iconv('euc-kr', SOURCE_ENC, $agspay->GetResult("rResMsg"));

    } else {

        if (!isset($_POST['rSuccYn'])) $_POST['rSuccYn'] = 'y';
        if (!isset($_POST['rResMsg'])) $_POST['rResMsg'] = '';
    }

    // DB에 정보 입력. 성공할 경우 $result는 빈값이어야 한다.
    $context = stream_context_create(array(
                'http' => array('method'  => 'POST',
                                'header'  => "Content-Type: application/x-www-form-urlencoded",
                                'content' => http_build_query($_POST))));
    $result = file_get_contents($_POST['insert-url'], false, $context);

    if ($result === false || strlen($result)) {
        if ($_POST['Job'] !== 'direct') {
            $agspay->SetValue("Type", "Cancel");
            $agspay->SetValue("CancelMsg", "DB FAIL");
            $agspay->startPay();
            $_POST['rSuccYn'] = 'n';
            $_POST['msg'] = '데이터베이스 오류! 결제를 취소했습니다. 문제가 반복될 경우 문의해주세요.';

        } else {
            $_POST['msg'] = '데이터베이스 오류! 문제가 반복될 경우 문의해주세요.';

        }

        if ($result === false) {
            $_POST['msg'] .= " failed to open insert url: {$_POST['insert-url']}";
            $_POST['msg'] .= "\nresponse header print_r: \n";
            $_POST['msg'] .= print_r($http_response_header, true);
        } else {
            $_POST['msg'] .= "response: $result";
        }

    } else {
        $_POST['msg'] = '';

    }

?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
</head>
<body onload='javascript:document.forms["result"].submit()'>
    <form name='result' action='<?= $_POST['return-url'] ?>' method='post'>
        <?php foreach ($_POST as $key => $val): ?>
            <input type='hidden' name='<?= htmlspecialchars($key) ?>' value='<?= htmlspecialchars($val) ?>'>
        <?php endforeach; ?>
    </form>
</body>
</html>