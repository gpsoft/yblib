<?php

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES);
}

function h($caption) {
    echo '<h2>'.$caption.'</h2>';
}

function code($code) {
    echo '<pre>'.preg_replace('/\n/', '<br/>', $code).'</pre>';
}

function to_s($d) {
    if ( is_bool($d) ) return $d ? 'true' : 'false';
    if ( is_null($d) ) return 'null';
    return print_r($d, true);
}

function eval_print($code, $ret=null) {
    echo '<tr><td><code>'.$code.';</code></td>';
    if ( is_null($ret) ) {
        eval('$ret='.$code.';');
    }
    echo '<td><code>'.esc(to_s($ret)).'</code></td></tr>';
}

function in_table($f) {
    echo '<table class="table table-bordered">';
    echo '<tr><th class="col-xs-6">Code</th><th class="col-xs-6">Result</th></tr>';
    $f();
    echo '</table>';
}

function run() {
    h('空っぽチェック');
    in_table(function(){
        eval_print('u_empty(null)');
        eval_print('u_empty("")');
        eval_print('u_empty("0")');
        eval_print('u_empty(false)');
        eval_print('u_empty(array())');
        eval_print('u_coalesce(array(1,2,3), "no data")');
        eval_print('u_coalesce(array(), "no data")');
    });

    h('配列アクセス');
    in_table(function(){
        $data =<<<EOS
[
    'hoge'=>1,
    'fuga'=>2,
    'piyo'=>[
        'foo'=>'yes',
        'bar'=>['B', 'A', 'R']
    ]
];
EOS;
        code('$data = '.$data);
        eval('$data = '.$data);
        eval_print('u_at(["apple", "cake", "rocket"], 0)');
        eval_print('u_at(["apple", "cake", "rocket"], -1)');
        eval_print('u_at($data, "fuga")', u_at($data, "fuga"));
        eval_print('u_at(null, "hoge")');
        eval_print('u_at(123, "hoge")');
        eval_print('u_at($data, "foo")');
        eval_print('u_at($data, 0)', u_at($data, 0));
        eval_print(
            'u_at($data, array("piyo", "bar"))',
            u_at($data, array("piyo", "bar")));
        eval_print(
            'u_at($data, array("piyo", "bar", 2))',
            u_at($data, array("piyo", "bar", 2)));
        eval_print(
            'u_at($data, array("piyo", "bar", -1))',
            u_at($data, array("piyo", "bar", -1)));
    });
    in_table(function(){
        $data =<<<EOS
[
    'string'=>'abc',
    'integer'=>25,
    'array'=>['A', 'B', 'C'],
    'bool'=>true
];
EOS;
        code('$data = '.$data);
        eval('$data = '.$data);
        eval_print(
            'u_ats($data, "string")',
            u_ats($data, "string"));
        eval_print(
            'u_ats($data, "string2")',
            u_ats($data, "string2"));
        eval_print(
            'u_ati($data, "integer")',
            u_ati($data, "integer"));
        eval_print(
            'u_ati($data, "integer2")',
            u_ati($data, "integer2"));
        eval_print(
            'u_ata($data, "array")',
            u_ata($data, "array"));
        eval_print(
            'u_ata($data, "array2")',
            u_ata($data, "array2"));
        eval_print(
            'u_atb($data, "bool")',
            u_atb($data, "bool"));
        eval_print(
            'u_atb($data, "bool2")',
            u_atb($data, "bool2"));
    });

    h('囲む');
    in_table(function(){
        eval_print('u_wrap("question?", "(")');
        eval_print('u_wrap("question?", "[")');
        eval_print('u_wrap("question?", "<")');
        eval_print('u_wrap("question?", "/")');
        eval_print('u_wrapsq("SELECT * FROM hoge")');
        eval_print('u_wrapdq("SELECT * FROM hoge")');
        eval_print('u_wraptag("Hello, world!", "p")');
        eval_print("u_wraptag('Hello, world!', 'p class=\"danger\"')");
    });

    h('区切り文字列');
    in_table(function(){
        eval_print("u_encA2S([1,2,3])");
        eval_print("u_encA2S([1,2,3], '|')");
        eval_print("u_decS2A('1,2,3')");
        eval_print("u_decS2A('')");
        eval_print("u_decS2A('huh?')");
        eval_print("u_decS2A(',huh?,')");
    });

    h('日時(正規形)');
    in_table(function(){
        eval_print("u_date('hello')");
        eval_print("u_date('1991')");
        eval_print("u_date('20170908')");
        eval_print("u_date('20170908123456')");
        eval_print("u_date('2017/09/08')");
        eval_print("u_datey('2017/09/08')");
        eval_print("u_datem('20170908')");
        eval_print("u_dated('20170908')");
        eval_print("u_dated('201709')");
    });
    in_table(function(){
        eval_print("u_time4('hello')");
        eval_print("u_time4('1234')");
        eval_print("u_time4('12:34')");
        eval_print("u_time4('20170908123456')");
        eval_print("u_time6('1234')");
        eval_print("u_time6('12:34')");
        eval_print("u_time6('12:34:56')");
        eval_print("u_time6('20170908123456')");
        eval_print("u_timeh('12:34:56')");
        eval_print("u_timem('12:34:56')");
        eval_print("u_times('12:34:56')");
    });
    in_table(function(){
        eval_print("u_datetime('hello')");
        eval_print("u_datetime('2017/09/08 12:34:56')");
        eval_print("u_datetime('20170908123456')");
    });

    h('パディング');
    in_table(function(){
        eval_print("u_padsp('hello', 10)");
        eval_print("u_pad('hello', -10, '_')");
        eval_print("u_pad0('64', 4)");
    });
}
