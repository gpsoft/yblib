<?php

function u_empty($d) {
    return is_null($d) ||
        (is_string($d) && strlen($d) == 0) ||
        (!is_string($d) && empty($d));
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
    if ( !array_key_exists($k, $a) ) return $def;
    return $a[$k];
}

