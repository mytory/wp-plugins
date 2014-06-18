<?php
define('TASTY_SALT', 'wofhadfiuhwkn309fkndsglnqli3u309vnalvqliuh2392cnael9vq2p98rqliuhf');
define('BIG_BUCKS', '10000000000');

function allthegate_user_inputs() {
    return array(
        'Job',
        'StoreId',
        'OrdNo',
        'Amt',
        'StoreNm',
        'ProdNm',
        'MallUrl',
        'UserEmail',
        'ags_logoimg_url',
        'SubjectData',
        'UserId',
        'OrdNm',
        'OrdPhone',
        'OrdAddr',
        'RcpNm',
        'RcpPhone',
        'DlvAddr',
        'Remark',
        'CardSelect',
        'HP_ID',
        'HP_PWD',
        'HP_SUBID',
        'ProdCode',
        'HP_UNITType',
        'MallPage',
        'VIRTUAL_DEPODT',
    );
}

function allthegate_required_user_inputs() {
    return array(
        'Job',
        'StoreId',
        'OrdNo',
        'Amt',
        'StoreNm',
        'ProdNm',
        'MallUrl',
        'UserEmail',
        // 'ags_logoimg_url',
        // 'SubjectData',
        'UserId',
        'OrdNm',
        'OrdPhone',
        'OrdAddr',
        'RcpNm',
        'RcpPhone',
        'DlvAddr',
        // 'Remark',
        // 'CardSelect',
        'HP_ID',
        // 'HP_PWD',
        'HP_SUBID',
        'ProdCode',
        'HP_UNITType',
        'MallPage',
        // 'VIRTUAL_DEPODT',
    );
}

function allthegate_inputs() {
    return array(
        'Job',
        'StoreId',
        'OrdNo',
        'Amt',
        'StoreNm',
        'ProdNm',
        'MallUrl',
        'UserEmail',
        'ags_logoimg_url',
        'SubjectData',
        'UserId',
        'OrdNm',
        'OrdPhone',
        'OrdAddr',
        'RcpNm',
        'RcpPhone',
        'DlvAddr',
        'Remark',
        'CardSelect',
        'HP_ID',
        'HP_PWD',
        'HP_SUBID',
        'ProdCode',
        'HP_UNITType',
        'MallPage',
        'VIRTUAL_DEPODT',
        'Flag',
        'AuthTy',
        'SubTy',
        'DeviId',
        'QuotaInf',
        'NointInf',
        'AuthYn',
        'Instmt',
        'partial_mm',
        'noIntMonth',
        'KVP_RESERVED1',
        'KVP_RESERVED2',
        'KVP_RESERVED3',
        'KVP_CURRENCY',
        'KVP_CARDCODE',
        'KVP_SESSIONKEY',
        'KVP_ENCDATA',
        'KVP_CONAME',
        'KVP_NOINT',
        'KVP_QUOTA',
        'CardNo',
        'MPI_CAVV',
        'MPI_ECI',
        'MPI_MD64',
        'ExpMon',
        'ExpYear',
        'Passwd',
        'SocId',
        'ICHE_OUTBANKNAME',
        'ICHE_OUTACCTNO',
        'ICHE_OUTBANKMASTER',
        'ICHE_AMOUNT',
        'HP_SERVERINFO',
        'HP_HANDPHONE',
        'HP_COMPANY',
        'HP_IDEN',
        'HP_IPADDR',
        'ARS_PHONE',
        'ARS_NAME',
        'ZuminCode',
        'VIRTUAL_CENTERCD',
        'VIRTUAL_NO',
        'mTId',
        'ES_SENDNO',
        'ICHE_SOCKETYN',
        'ICHE_POSMTID',
        'ICHE_FNBCMTID',
        'ICHE_APTRTS',
        'ICHE_REMARK1',
        'ICHE_REMARK2',
        'ICHE_ECWYN',
        'ICHE_ECWID',
        'ICHE_ECWAMT1',
        'ICHE_ECWAMT2',
        'ICHE_CASHYN',
        'ICHE_CASHGUBUN_CD',
        'ICHE_CASHID_NO',
        'ICHEARS_SOCKETYN',
        'ICHEARS_ADMNO',
        'ICHEARS_POSMTID',
        'ICHEARS_CENTERCD',
        'ICHEARS_HPNO'
    );
}

function allthegate_input_maxlengths($field) {
    $maxlengths = array(
        'Job' => 20,
        'StoreId' => 20,
        'OrdNo' => 40,
        'Amt' => 12,
        'StoreNm' => 50,
        'ProdNm' => 300,
        'MallUrl' => 100,
        'UserEmail' => 50,
        'ags_logoimg_url' => 400,
        'UserId' => 20,
        'OrdNm' => 40,
        'OrdPhone' => 21,
        'OrdAddr' => 100,
        'RcpNm' => 40,
        'RcpPhone' => 21,
        'DlvAddr' => 100,
        'Remark' => 350,
        'HP_SUBID' => 10,
        'ProdCode' => 10,
    );
    if (isset($maxlengths[$field])) {
        return $maxlengths[$field];
    } else {
        return null;
    }
}

function allthegate_request_inputs() {
    return array(
        // 'Job',
        'StoreId',
        'OrdNo',
        'Amt',
        // 'StoreNm',
        'ProdNm',
        'MallUrl',
        'UserEmail',
        // 'ags_logoimg_url',
        // 'SubjectData',
        'UserId',
        'OrdNm',
        'OrdPhone',
        'OrdAddr',
        'RcpNm',
        'RcpPhone',
        'DlvAddr',
        'Remark',
        // 'CardSelect',
        'HP_ID',
        // 'HP_PWD',
        'HP_SUBID',
        // 'ProdCode',
        'HP_UNITType',
        'MallPage',
        'VIRTUAL_DEPODT',
        // 'Flag',
        'AuthTy',
        'SubTy',
        'DeviId',
        // 'QuotaInf',
        // 'NointInf',
        'AuthYn',
        'Instmt',
        'partial_mm',
        'noIntMonth',
        // 'KVP_RESERVED1',
        // 'KVP_RESERVED2',
        // 'KVP_RESERVED3',
        'KVP_CURRENCY',
        'KVP_CARDCODE',
        'KVP_SESSIONKEY',
        'KVP_ENCDATA',
        'KVP_CONAME',
        'KVP_NOINT',
        'KVP_QUOTA',
        'CardNo',
        'MPI_CAVV',
        'MPI_ECI',
        'MPI_MD64',
        'ExpMon',
        'ExpYear',
        'Passwd',
        'SocId',
        'ICHE_OUTBANKNAME',
        'ICHE_OUTACCTNO',
        'ICHE_OUTBANKMASTER',
        'ICHE_AMOUNT',
        'HP_SERVERINFO',
        'HP_HANDPHONE',
        'HP_COMPANY',
        'HP_IDEN',
        'HP_IPADDR',
        'ARS_PHONE',
        'ARS_NAME',
        'ZuminCode',
        'VIRTUAL_CENTERCD',
        'VIRTUAL_NO',
        // 'mTId',
        'ES_SENDNO',
        'ICHE_SOCKETYN',
        'ICHE_POSMTID',
        'ICHE_FNBCMTID',
        'ICHE_APTRTS',
        'ICHE_REMARK1',
        'ICHE_REMARK2',
        'ICHE_ECWYN',
        'ICHE_ECWID',
        'ICHE_ECWAMT1',
        'ICHE_ECWAMT2',
        'ICHE_CASHYN',
        'ICHE_CASHGUBUN_CD',
        'ICHE_CASHID_NO',
        'ICHEARS_SOCKETYN',
        'ICHEARS_ADMNO',
        'ICHEARS_POSMTID',
        'ICHEARS_CENTERCD',
        'ICHEARS_HPNO'
    );
}

/**
 * 워드프레스가 아닌 경우 이걸 사용하지 말고 그냥 하드코딩하시길.
 */
if(function_exists('plugins_url')){
    function allthegate_request_uri() {
        return plugins_url('pay.php', __FILE__);
    }
}

function allthegate_Job_label($Job) {
    $labels = array('direct' => '무통장 입금',
        'onlycard' => '신용카드',
        'onlyhp' => '휴대폰 결제');

    if (!isset($labels[$Job])) {
        return '';
    } else {
        return $labels[$Job];
    }
}

function stringify_ticket_array($ticket_array, $pricing){
    $product_name = array();
    foreach ($ticket_array as $ticket_name => $count) {
        if ($count) {
            $product_name[] = $ticket_name . ':' . $count;
        }
    }
    $product_name = implode(',', $product_name);
    $product_name = sprintf('%s(%s)', $product_name, $pricing ? $pricing : '기본');
    return $product_name;

}