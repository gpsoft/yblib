<?php

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES);
}

function h($caption, $no=null) {
    echo u_wraptag(
        u_wraptag('', 'i class="fa fa-plus-square-o"')
        .u_wraptag('', 'i class="fa fa-minus-square-o"')
        .$caption,
        'h2'.(is_null($no)?'':
        (' class="collapse-bar collapsed" data-toggle="collapse" data-target="#chap'.$no.'"')));
}

function code($code) {
    echo u_wraptag(preg_replace('/\n/', '<br/>', $code), 'pre');
}

function to_s($d) {
    if ( is_bool($d) ) return $d ? 'true' : 'false';
    if ( is_null($d) ) return 'null';
    return print_r($d, true);
}

function eval_print($code, $ret=null) {
    echo '<tr>'.u_wraptag(u_wraptag(esc($code).';', 'code'), 'td');
    if ( is_null($ret) ) {
        eval('$ret='.$code.';');
    }
    echo u_wraptag(u_wraptag(esc(to_s($ret)), 'code'), 'td').'</tr>';
}

function in_table($f) {
    echo '<table class="table table-bordered">';
    echo u_wraptag(
        u_wraptag('Code', 'th class="col-xs-6"')
        .u_wraptag('Result', 'th class="col-xs-6"'),
        'tr');
    $f();
    echo '</table>';
}

function run() {
    assert_options(ASSERT_BAIL, 1);

    $no = 1;
    $with_collapse = function($caption, $f)use(&$no){
        h($caption, $no);
        echo '<div id="chap'.$no.'" class="collapse">';
        $f();
        echo '</div>';
        $no++;
    };
    $with_collapse('空っぽチェック', function(){
        in_table(function(){
            eval_print('u_empty(null)');
            eval_print('u_empty("")');
            eval_print('u_empty("0")');
            eval_print('u_empty(false)');
            eval_print('u_empty(array())');
            eval_print('u_coalesce(array(1,2,3), "no data")');
            eval_print('u_coalesce(array(), "no data")');
        });
    });
    $with_collapse('配列アクセス', function(){
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
    });

    $with_collapse('囲む', function(){
        in_table(function(){
            eval_print('u_wrap("question?", "(")');
            eval_print('u_wrap("question?", "[")');
            eval_print('u_wrap("question?", "<")');
            eval_print('u_wrap("question?", "/")');
            eval_print('u_wrapsq("SELECT * FROM hoge")');
            eval_print('u_wrapdq("SELECT * FROM hoge")');
            eval_print('u_wrappar("SELECT * FROM hoge")');
            eval_print('u_wraptag("Hello, world!", "p")');
            eval_print("u_wraptag('Hello, world!', 'p class=\"danger\"')");
        });
    });

    $with_collapse('区切り文字列', function(){
        in_table(function(){
            eval_print("u_encA2S([1,2,3])");
            eval_print("u_encA2S([1,2,3], '|')");
            eval_print("u_enc2S(1, 2, 3, '-')");
            eval_print("u_decS2A('1,2,3')");
            eval_print("u_decS2A('')");
            eval_print("u_decS2A('huh?')");
            eval_print("u_decS2A(',huh?,')");
        });
    });

    $with_collapse('日時(正規化)', function(){
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
            eval_print("u_dtnormalize('2017/09/08 12:34:56', 'date')");
            eval_print("u_dtnormalize('2017/09/08 12:34:56', 'time4')");
            eval_print("u_dtnormalize('2017/09/08 12:34:56', 'time6')");
            eval_print("u_dtnormalize('2017/09/08 12:34:56', 'datetime')");
        });
    });

    $with_collapse('日時(比較)', function(){
        in_table(function(){
            eval_print("u_datecmp('2017/09/08', '2017/09/09')");
            eval_print("u_time4cmp('1234', '12:00')");
            eval_print("u_time6cmp('123456', '12:34:56')");
            eval_print("u_datetimecmp('2017/09/08 12:34:56', '2017/09/09 12:34:56')");
            eval_print("u_time4cmp('2017/09/08 12:34:56', '2017/09/09 12:34:56')");
        });
    });

    $with_collapse('パディング', function(){
        in_table(function(){
            eval_print("u_padsp('hello', 10)");
            eval_print("u_pad('hello', -10, '_')");
            eval_print("u_pad0('64', 4)");
        });
    });

    $with_collapse('SQL式', function(){
        in_table(function(){
            eval_print("sql_logic('code', '!=', 'active', 'str')");
            eval_print("sql_logic('code', 'IS NOT', null)");
            eval_print("sql_logic('kbn', '>=', 1, 'num')");
            eval_print("sql_logic('name', 'LIKE', 'hoge', 'left')");
            eval_print("sql_logic('name', 'LIKE', 'hoge', 'right')");
            eval_print("sql_logic('name', 'LIKE', 'hoge', 'partial')");
            eval_print("sql_logic('code', 'IN', ['active','inactive'], 'strset')");
            eval_print("sql_logic('kbn', 'IN', [1,2,3], 'numset')");
            eval_print("sql_logic('updated', '=', '2017/09/08 12:34:56', 'datetime')");
            eval_print("sql_logic('reserved', '=', '2017/09/08 12:34:56', 'date')");
            eval_print("sql_logic('hhmm', '=', '2017/09/08 12:34:56', 'time4')");
            eval_print("sql_logic('hhmmss', '=', '2017/09/08 12:34:56', 'time6')");
        });
        in_table(function(){
            eval_print("sql_inrange('updated', '2017/09/08', '2017/09/30', 'date')");
            eval_print("sql_exrange('updated', '2017/09/08', '2017/09/30', 'date')");
            eval_print("sql_inrange('updated', '2017/09/08', '2017/09/30', 'datetime')");
            eval_print("sql_exrange('updated', '2017/09/08', '2017/10/01', 'datetime')");
            eval_print("sql_inrange('updated', '2017/09/08 10:00:00'"
                .", '2017/09/30 23:59:59', 'datetime')");
            eval_print("sql_exrange('updated', '2017/09/08 10:00:00'"
                .", '2017/10/01 00:00:00', 'datetime')");
            eval_print("sql_exrange('updated', '10:00:00', '12:34:56', 'time4')");
            eval_print("sql_exrange('updated', '10:00:00', '13:00:00', 'time6')");
            eval_print("sql_inrange('reserved', 'begin_dt', 'end_dt')");
        });
        in_table(function(){
            eval_print("sql_overwrap('sta', 'end', '2017/09/08', '2017/09/30', 'date')");
            eval_print("sql_overwrap('sta', 'end', '2017/09/08', '2017/09/30', 'datetime')");
            eval_print("sql_overwrap('sta', 'end', '10:00:00', '13:00:00', 'time4')");
            eval_print("sql_overwrap('sta', 'end', '10:00:00', '13:00:00', 'time6')");
        });
        in_table(function(){
            eval_print("sql_lgappend('', 'kbn=1')");
            eval_print('sql_lgappend("(kbn=1)", "code!=\'active\'")');
            eval_print('sql_lgappend("(kbn=1)", "code!=\'active\'", "OR")');
            eval_print('sql_lgjoin("A", "B", "C")');
            eval_print('sql_lgjoin("X", "Y", "Z", "OR")');
            eval_print('sql_lgjoin(["A", ["B1", "B2"], "C", "OR"], ["X", "Y", "Z", "OR"])');
        });
    });
}
