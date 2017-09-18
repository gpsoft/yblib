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
