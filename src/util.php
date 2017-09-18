<?php

function u_empty($d) {
    return is_null($d) ||
        (is_string($d) && strlen($d) == 0) ||
        (!is_string($d) && empty($d));
}

function u_coalesce($a, $b) {
    if ( u_empty($a) ) return $b;
    return $a;
}

function u_at($a, $ks, $def=null) {
    if ( is_null($a) ) return $def;
    if ( !is_array($a) ) return $a;
    if ( is_array($ks) ) {
        $k = array_shift($ks);
        $v = u_at($a, $k, $def);
        if ( empty($ks) ) return $v;
        return u_at($v, $ks, $def);
    }

    $k = $ks;
    if ( is_int($k) && $k < 0 && count($a) > -$k ) $k += count($a);
    if ( !array_key_exists($k, $a) ) return $def;
    return $a[$k];
}
function u_ata($a, $ks) { return u_at($a, $ks, array()); }
function u_ats($a, $ks) { return u_at($a, $ks, ''); }
function u_ati($a, $ks) { return (int)u_at($a, $ks, 0); }
function u_atb($a, $ks) { return (boolean)u_at($a, $ks, false); }

function u_wrap($s, $w) {
    $ps = array(
        '('=>')',
        '['=>']',
        '<'=>'>',
    );
    if ( is_null($s) ) $s = '';
    $wb = $w;
    $we = u_at($ps, $w, $w);
    return $wb.$s.$we;
}
function u_wrapsq($s) { return u_wrap($s, "'"); }
function u_wrapdq($s) { return u_wrap($s, '"'); }
function u_wrappar($s) { return u_wrap($s, '('); }
function u_wraptag($s, $t) {
    return '<'.$t.'>'.$s.'</'.u_at(explode(' ', $t), 0).'>';
}

function u_decS2A($s, $sepa=',') {
    return u_empty($s) ? array() : explode($sepa, $s);
}
function u_encA2S($a, $sepa=',') {
    return implode($sepa, $a);
}
function u_enc2S() {
    $args = func_get_args();
    if ( u_empty($args) ) return '';
    $sepa = array_pop($args);
    return u_encA2S($args, $sepa);
}

function u_pad($s, $len, $pad) {
    if ( is_null($s) ) $s = '';
    $l = abs($len);
    $fill = str_repeat($pad, $l);
    $l = max(mb_strlen($s), $l);
    if ( $len > 0 ) return mb_substr($fill.$s, -$l);
    return mb_substr($s.$fill, 0, $l);
}
function u_padsp($s, $len) { return u_pad($s, $len, ' '); }
function u_pad0($s, $len) { return u_pad($s, $len, '0'); }

function u_date($s) {
    $d = preg_replace('/[^0-9]/', '', $s);
    if ( strlen($d) < 8 ) return '';
    return substr($d, 0, 8);
}
function u_time($s, $sec=true) {
    $t = preg_replace('/[^0-9]/', '', $s);
    if ( strlen($t) < 4 ) return '';
    if ( strlen($t) >= 12 ) $t = substr($t, 8);
    if ( $sec && strlen($t) == 4 ) $t = $t.'00';
    return substr($t, 0, $sec?6:4);
}
function u_datetime($s) {
    $dt = preg_replace('/[^0-9]/', '', $s);
    if ( strlen($dt) < 14 ) return '';
    return substr($dt, 0, 14);
}
function u_dtnormalize($s, $type) {
    if ( $type == 'date' ) return u_date($s);
    if ( $type == 'time4' ) return u_time4($s);
    if ( $type == 'time6' ) return u_time6($s);
    if ( $type == 'datetime' ) return u_datetime($s);
    return $s;
}
function u_isdttype($type) {
    return in_array($type, array(
        'date', 'time4', 'time6', 'datetime'
    ));
}
function u_datey($s) { return u_coalesce(substr(u_date($s), 0, 4), ''); }
function u_datem($s) { return u_coalesce(substr(u_date($s), 4, 2), ''); }
function u_dated($s) { return u_coalesce(substr(u_date($s), 6, 2), ''); }
function u_time6($s) { return u_time($s, true); }
function u_time4($s) { return u_time($s, false); }
function u_timeh($s) { return u_coalesce(substr(u_time($s), 0, 2), ''); }
function u_timem($s) { return u_coalesce(substr(u_time($s), 2, 2), ''); }
function u_times($s) { return u_coalesce(substr(u_time($s), 4, 2), ''); }

function l_u_dtcmp($a, $b, $type) {
    return u_dtnormalize($a, $type) - u_dtnormalize($b, $type);
}
function u_datecmp($a, $b) { return l_u_dtcmp($a, $b, 'date'); }
function u_time4cmp($a, $b) { return l_u_dtcmp($a, $b, 'time4'); }
function u_time6cmp($a, $b) { return l_u_dtcmp($a, $b, 'time6'); }
function u_datetimecmp($a, $b) { return l_u_dtcmp($a, $b, 'datetime'); }
