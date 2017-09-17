<?php

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
    echo '<tr><td><code>'.$code.'</code></td>';
    if ( is_null($ret) ) {
        eval('$ret='.$code.';');
    }
    echo '<td><code>'.to_s($ret).'</code></td></tr>';
}

function in_table($f) {
    echo '<table class="table table-bordered">';
    echo '<tr><th>Code</th><th>Result</th></tr>';
    $f();
    echo '</table>';
}

function run() {
    h('親切な、空っぽチェック');
    in_table(function(){
        eval_print('u_empty(null)');
        eval_print('u_empty("")');
        eval_print('u_empty("0")');
        eval_print('u_empty(false)');
        eval_print('u_empty(array())');
    });

    h('安全な、配列アクセス');
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
    });
}
