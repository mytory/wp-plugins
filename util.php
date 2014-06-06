<?php
/**
*  wordpress에 의존하지 않는 함수 모음
*/

function title_parse ($title) {
$title = html_entity_decode($title);
$sub_leading_delim = preg_quote('─–―-', '/');
$sub_trailing_delim = preg_quote(':', '/');
$escape = preg_quote('\\', '/');

preg_match('/
    ^ # 줄 시작
    (?:                           # 말머리(optional)
        \[                          # 여는 괄호
        (?P<tag>[^\]]*)
        \]                          # 닫는 괄호
    )?

    (?:                           # 앞 소제목(optional)
        (?P<sub_leading>.+?)
        (?<!'.$escape.')             # 이스케이핑이 앞에 없는
        ['.$sub_leading_delim.']     # 표시자
    )?

    (?P<title>.+?)                # 제목

    (?:                           # 뒷 소제목(optional)
        (?<!'.$escape.')             # 이스케이핑이 앞에 없는
        ['.$sub_trailing_delim.']    # 표시자
        (?P<sub_trailing>.+)
    )?
    $ # 줄 끝
/xu', $title, $match);

$match = array_map('trim', $match);

# remove integer keys
foreach (array_filter(array_keys($match), 'is_numeric') as $key) {
    unset($match[$key]);
}

if (!isset($match['sub_trailing'])) $match['sub_trailing'] = '';

# remove escaping
$match['sub_leading'] = preg_replace('/'.$escape.'(['.$sub_leading_delim.'])/',
                                     '$1', $match['sub_leading']);
$match['title'] = preg_replace('/'.$escape.'(['.$sub_trailing_delim.'])/',
                               '$1', $match['title']);

return $match;
}

function title_strip_sub ($title) {
$parsed = title_parse($title);
return $parsed['title'];
}

function template ($path, $args=array()) {
    extract($args);
    include $path;
}

function unescape_nl ($str) {
    return str_replace('\\n', "<br>", $str);
}

function have_jongsung ($chr) {
    static $no_jongsung = "가갸거겨고교구규그기개걔게계과괘궈궤괴귀긔까꺄꺼껴꼬꾜꾸뀨끄끼깨꺠께꼐꽈꽤꿔꿰꾀뀌끠나냐너녀노뇨누뉴느니내냬네녜놔놰눠눼뇌뉘늬다댜더뎌도됴두듀드디대댸데뎨돠돼둬뒈되뒤듸따땨떠뗘또뚀뚜뜌뜨띠때떄떼뗴똬뙈뚸뛔뙤뛰띄라랴러려로료루류르리래럐레례롸뢔뤄뤠뢰뤼릐마먀머며모묘무뮤므미매먜메몌뫄뫠뭐뭬뫼뮈믜바뱌버벼보뵤부뷰브비배뱨베볘봐봬붜붸뵈뷔븨빠뺘뻐뼈뽀뾰뿌쀼쁘삐빼뺴뻬뼤뽜뽸뿨쀄뾔쀠쁴사샤서셔소쇼수슈스시새섀세셰솨쇄숴쉐쇠쉬싀싸쌰써쎠쏘쑈쑤쓔쓰씨쌔썌쎄쎼쏴쐐쒀쒜쐬쒸씌아야어여오요우유으이애얘에예와왜워웨외위의자쟈저져조죠주쥬즈지재쟤제졔좌좨줘줴죄쥐즤짜쨔쩌쪄쪼쬬쭈쮸쯔찌째쨰쩨쪠쫘쫴쭤쮀쬐쮜쯰차챠처쳐초쵸추츄츠치채챼체쳬촤쵀춰췌최취츼카캬커켜코쿄쿠큐크키캐컈케켸콰쾌쿼퀘쾨퀴킈타탸터텨토툐투튜트티태턔테톄톼퇘퉈퉤퇴튀틔파퍄퍼펴포표푸퓨프피패퍠페폐퐈퐤풔풰푀퓌픠하햐허혀호효후휴흐히해햬헤혜화홰훠훼회휘희2459";
    return mb_strpos($no_jongsung, $chr) === false ? true : false;
}

function select_marker ($s, $have_jongsung, $no_jongsung) {
    $last_chr = mb_substr($s, -1, 1);
    return have_jongsung($last_chr) ?
        $s.$have_jongsung :
        $s.$no_jongsung;
}

function generate_order_id () {
    $session_id = session_id();
    if (empty($session_id)) {
        session_start();
    }
    return md5(session_id() . date('YmdHis'));
}

function add_commas ($num) {
    $num = strrev((string)((int) $num));
    $len = strlen($num);
    $off = $len % 3;
    $buff = '';
    for ($i = 0; $i < $len; $i++) {
        $buff .= substr($num, $i, 1);
        if ($len - $i - 1 && !(($i + 1) % 3)) $buff .= ',';
    }
    return strrev($buff);
}

function doc_root () {
    $patt = '/'.preg_quote($_SERVER['SCRIPT_NAME'], '/').'$/';
    return preg_replace($patt, '', $_SERVER['SCRIPT_FILENAME']);
}

function ellipsize ($str, $trim, $ellipsis='...') {
    $len = mb_strlen($str);
    if ($trim < $len) {
        $str = mb_substr($str, 0, $trim);
        $str .= $ellipsis;
    }
    return $str;
}

function hidden_input ($name, $value='') {
    return sprintf("<input type='hidden' name='%s' value='%s'>",
                   htmlspecialchars($name),
                   htmlspecialchars($value));
}

function override_url_query ($url, $params) {
    $buffer = '';

    $url = parse_url($url);
    parse_str(isset($url['query']) ? $url['query'] : '', $query);
    $query = array_merge($query, (array) $params);

    foreach ($query as $key => $val) if ($val === false) unset($query[$key]);

    if (isset($url['scheme'])) $buffer .= $url['scheme'] . ':';
    if (isset($url['user'])) $buffer   .= '//'.$url['user'].'@';
    if (isset($url['host'])) {
        if (!isset($url['user'])) $buffer .= '//';
        $buffer .= $url['host'];
    }
    if (isset($url['path'])) $buffer .= $url['path'];
    if ($query) $buffer .= '?' . http_build_query($query);
    if (isset($url['fragment'])) $buffer .= '#'.$url['fragment'];

    return $buffer;
}

function has_image_extension ($filename) {
    $image_extension = array(
        'jpg', 'png', 'jpeg'
    );
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    if(in_array($extension, $image_extension)){
        return true;
    }else{
        return false;
    }
}