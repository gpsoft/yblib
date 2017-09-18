<?php

include_once('util.php');

function sql_esc($unescapedVal) {
    if ( is_array($unescapedVal) ) {
        return array_map('sql_esc', $unescapedVal);
    }
    if ( is_null($unescapedVal) ) return null;
    $s = $unescapedVal; // you should do something here.
    return $s;
}

function sql_val($unescapedVal, $type) {
    $v = sql_esc($unescapedVal);
    if ( $type == 'str' ) return u_wrapsq($v);
    if ( $type == 'left' ) return u_wrapsq($v.'%');
    if ( $type == 'right' ) return u_wrapsq('%'.$v);
    if ( $type == 'partial' ) return u_wrapsq('%'.$v.'%');
    if ( $type == 'num' ) return (int)$v;
    if ( u_isdttype($type) ) return u_wrapsq(u_dtnormalize($v, $type));
    if ( $type == 'null' || is_null($v) ) return 'NULL';
    if ( in_array($type, array('numset','strset')) ) {
        if ( !is_array($v) ) $v = array($v);
        if ( $type == 'strset' ) $v = array_map('u_wrapsq', $v);
        return u_wrappar(implode(',', $v));
    }
    return $v;
}

function sql_logic($left, $lg, $right, $type=null) {
    return u_wrappar(u_enc2S($left, $lg, sql_val($right, $type), ' '));
}
function sql_logicr($left, $lg, $right, $type=null) {
    return u_wrappar(u_enc2S(sql_val($right, $type), $lg, $left, ' '));
}

function sql_lgappend($cs, $c, $lg='AND') {
    assert(in_array($lg, array('AND', 'OR')));
    $c = u_wrappar($c);
    if ( u_empty($cs) ) return $c;
    $ret = u_enc2S($cs, $lg, $c, ' ');
    if ( $lg == 'OR' ) $ret = u_wrappar($ret);
    return $ret;
}

function sql_lgjoin() {
    $args = func_get_args();
    if ( u_empty($args) ) return '';
    $ope = 'AND';
    $last = u_at($args, -1);
    if ( in_array($last, array('AND', 'OR')) ) $ope = array_pop($args);
    if ( u_empty($args) ) return '';
    $args = array_map('l_sql_lgflatten1', $args);
    //$args = array_map('u_wrappar', $args);
    return u_wrappar(implode(u_wrap($ope, ' '), $args));
}

function l_sql_lgflatten1($mix) {
    if ( !is_array($mix) ) return $mix;
    return call_user_func_array('sql_lgjoin', $mix);
}

function l_sql_inferdt($v, $pad) {
    $dt = u_datetime($v);
    if ( !u_empty($dt) ) return u_wrapsq($dt);
    $d = u_date($v);
    return u_wrapsq(u_pad($d, -14, $pad));
}

function l_sql_dtrange($col, $min, $max, $type, $exclusiveEnd) {
    $vmin = sql_val($min, $type);
    $vmax = sql_val($max, $type);
    if ( $type == 'datetime' ) {
        if ( $vmin == "''" ) $vmin = l_sql_inferdt($min, 0);
        if ( $vmax == "''" ) $vmax = l_sql_inferdt($max, $exclusiveEnd?0:9);
    }
    assert($vmin!="''" && $vmax!="''");
    return sql_lgjoin(
        sql_logic($col, '>=', $vmin),
        sql_logic($col, $exclusiveEnd?'<':'<=', $vmax));
}
function sql_inrange($col, $min, $max, $type=null) {
    return l_sql_dtrange($col, $min, $max, $type, false);
}
function sql_exrange($col, $min, $max, $type=null) {
    return l_sql_dtrange($col, $min, $max, $type, true);
}

function sql_overwrap($colsta, $colend, $sta, $end, $type) {
    $exclusive = $type!='date';
    $vsta = sql_val($sta, $type);
    $vend = sql_val($end, $type);
    if ( $type == 'datetime' ) {
        if ( $vsta == "''" ) $vsta = l_sql_inferdt($sta, 0);
        if ( $vend == "''" ) $vend = l_sql_inferdt($end, 0);
    }
    assert($vsta!="''" && $vend!="''");
    return sql_lgjoin(
        sql_logic($colend, $exclusive?'>':'>=', $vsta),
        sql_logic($colsta, $exclusive?'<':'<=', $vend));
}
