<?php
    /**
     *  우편 번호 검색을 위한 endpoint
     *  
     *  요청 메서드: 상관 없음(GET, POST)
     *
     *  매개변수:
     *       dong: 검색할 동 이름
     *
     *  결과:
     *      결과 json = 성공 | 실패
     *           성공 = {rows: 검색결과, count: <결과 수>, success: 1}
     *           실패 = {success: 0, msg: <오류 메시지 문자열>}
     *        검색결과 = {head: <우편번호 앞 세자리>,
     *                   tail: <우편번호 뒷 세자리>,
     *                   addr: <주소>}
     */
    include 'postcode-finder.class.php';

    define('COL_POST_CODE', 0);
    define('COL_DONG', 4);
    define('COL_FULL_ADDR', 10);
    
    $fh = fopen('postcodes.csv', 'r');

    $result = array();

    if (!empty($_REQUEST['dong'])) {
        $finder = new Postcode_finder($fh, $_REQUEST['dong'], COL_DONG);
        foreach ($finder as $count => $row) {            
            list($head, $tail) = sscanf($row[COL_POST_CODE], "%3s%3s");
            $result['rows'][] = array('head' => $head,
                                      'tail' => $tail,
                                      'addr' => $row[COL_FULL_ADDR]);
        }
        $result['count'] = $count;
        $result['success'] = 1;

    } else {
        $result['msg'] = '검색어를 입력하세요';
        $result['success'] = 0;
    }

    header('Content-type: application/json');
    echo json_encode($result);
