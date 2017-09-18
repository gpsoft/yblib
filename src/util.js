function js_u_args2array(args) {
    return Array.prototype.slice.apply(args);
}

function js_u_empty(d) {
    return d === undefined ||
        d === null ||
        (d.length !== undefined && d.length === 0) ||
        d === false;
}

function js_u_coalesce(a, b) {
    if ( js_u_empty(a) ) return b;
    return a;
}

function js_u_decS2A(s, sepa) {
    if ( sepa === undefined ) sepa = ',';
    return js_u_empty(s) ? [] : s.split(sepa);
}

function js_u_encA2S(a, sepa) {
    if ( sepa === undefined ) sepa = ',';
    return a.join(sepa);
}

function js_u_enc2S() {
    let args = js_u_args2array(arguments);
    if ( js_u_empty(args) ) return '';
    let sepa = args.pop();
    return js_u_encA2S(args, sepa);
}

function js_u_plusSA(s, item, sepa) {
    if ( sepa === undefined ) sepa = ',';
    if ( js_u_empty(item) ) return s;
    let a = js_u_decS2A(s, sepa);
    if ( a.includes(item.toString()) ) return s;
    a.push(item);
    return js_u_encA2S(a, sepa);
}

function js_u_minusSA(s, item, sepa) {
    if ( sepa === undefined ) sepa = ',';
    if ( js_u_empty(item) ) return s;
    let a = js_u_decS2A(s, sepa);
    if ( !a.includes(item.toString()) ) return s;
    return js_u_encA2S(a.filter(function(e){
        return e !== item.toString();
    }), sepa);
}

function js_u_pad(s, len, pad) {
    if ( s === null ) s = '';
    let l = Math.abs(len);
    let fill = pad.repeat(l);
    l = Math.max(s.length, l);
    if ( len > 0 ) return (fill+s).substr(-l);
    return (s+fill).substr(0, l);
}
function js_u_padsp(s, len) { return js_u_pad(s, len, ' '); }
function js_u_pad0(s, len) { return js_u_pad(s, len, '0'); }

function js_u_date(s) {
    if ( js_u_empty(s) ) return '';
    let d = s.replace(/[^0-9]/g, '');
    if ( d.length < 8 ) return '';
    return d.substr(0, 8);
}
function js_u_time(s, sec) {
    if ( js_u_empty(s) ) return '';
    if ( sec === undefined ) sec = true;
    let t = s.replace(/[^0-9]/g, '');
    if ( t.length < 4 ) return '';
    if ( t.length >= 12 ) t = t.substr(8);
    if ( sec && t.length == 4 ) t = t+'00';
    return t.substr(0, sec?6:4);
}
function js_u_datetime(s) {
    if ( js_u_empty(s) ) return '';
    let dt = s.replace(/[^0-9]/g, '');
    if ( dt.length < 14 ) return '';
    return dt.substr(0, 14);
}
function js_u_dtnormalize(s, type) {
    if ( type == 'date' ) return js_u_date(s);
    if ( type == 'time4' ) return js_u_time4(s);
    if ( type == 'time6' ) return js_u_time6(s);
    if ( type == 'datetime' ) return js_u_datetime(s);
    return s;
}
function js_u_isdttype(type) {
    return ['date', 'time4', 'time6', 'datetime'].includes(type);
}

function js_u_datey(s) { return js_u_coalesce(js_u_date(s).substr(0, 4), ''); }
function js_u_datem(s) { return js_u_coalesce(js_u_date(s).substr(4, 2), ''); }
function js_u_dated(s) { return js_u_coalesce(js_u_date(s).substr(6, 2), ''); }
function js_u_time6(s) { return js_u_time(s, true); }
function js_u_time4(s) { return js_u_time(s, false); }
function js_u_timeh(s) { return js_u_coalesce(js_u_time(s).substr(0, 2), ''); }
function js_u_timem(s) { return js_u_coalesce(js_u_time(s).substr(2, 2), ''); }
function js_u_times(s) { return js_u_coalesce(js_u_time(s).substr(4, 2), ''); }

function js_u_dtcmp(a, b, type) {
    return js_u_dtnormalize(a, type) - js_u_dtnormalize(b, type);
}
function js_u_datecmp(a, b) { return js_u_dtcmp(a, b, 'date'); }
function js_u_time4cmp(a, b) { return js_u_dtcmp(a, b, 'time4'); }
function js_u_time6cmp(a, b) { return js_u_dtcmp(a, b, 'time6'); }
function js_u_datetimecmp(a, b) { return js_u_dtcmp(a, b, 'datetime'); }
