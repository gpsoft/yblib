function run($parent) {
    let no = 1;
    let icon = function(iconClass) {
        return $('<i>').addClass('fa '+iconClass);
    };
    let h = function(caption, no) {
        $('<h2>'+caption+'</h2>')
            .addClass('collapse-bar collapsed')
            .attr('data-toggle', 'collapse')
            .attr('data-target', '#jsChap'+no)
            .prepend(icon('fa-plus-square-o'))
            .prepend(icon('fa-minus-square-o'))
            .appendTo($parent);
    };
    let inTable = function($wrapper, f){
        let $table = $('<table>')
            .addClass('table table-bordered')
            .appendTo($wrapper);
        $('<tr>')
            .append($('<th>')
                .addClass('col-xs-6')
                .text('Code'))
            .append($('<th>')
                .addClass('col-xs-6')
                .text('Result'))
            .appendTo($table);
        f($table);
    };
    let evalPrint = function($table, code, ret){
        $('<tr>')
            .append($('<td><code>'+code+'</code></td>'))
            .append($('<td><code>'
                +JSON.stringify(eval(code))
                +'</code></td>'))
            .appendTo($table);
    };
    let withCollapse = function(caption, f){
        h(caption, no);
        let $wrapper = $('<div>')
            .addClass('collapse')
            .attr('id', 'jsChap'+no)
            .appendTo($parent);
        f($wrapper);
        no++;
    };

    withCollapse('空っぽチェック', function($wrapper){
        inTable($wrapper, function($t){
            evalPrint($t, 'js_u_empty(null)');
            evalPrint($t, 'js_u_empty("")');
            evalPrint($t, 'js_u_empty("0")');
            evalPrint($t, 'js_u_empty(false)');
            evalPrint($t, 'js_u_empty([])');
            evalPrint($t, 'js_u_coalesce([1,2,3], "no data")');
            evalPrint($t, 'js_u_coalesce([], "no data")');
        });
    });

    withCollapse('区切り文字', function($wrapper){
        inTable($wrapper, function($t){
            evalPrint($t, 'js_u_encA2S([1,2,3])');
            evalPrint($t, 'js_u_encA2S([1,2,3], "|")');
            evalPrint($t, 'js_u_enc2S(1, 2, 3, "-")');
            evalPrint($t, 'js_u_decS2A("1,2,3")');
            evalPrint($t, 'js_u_decS2A("")');
            evalPrint($t, 'js_u_decS2A("huh?")');
            evalPrint($t, 'js_u_decS2A("|huh?|", "|")');
            evalPrint($t, 'js_u_plusSA("1,2,3", 4)');
            evalPrint($t, 'js_u_plusSA("1,2,3", 2)');
            evalPrint($t, 'js_u_minusSA("1,2,3", 4)');
            evalPrint($t, 'js_u_minusSA("1,2,3", 2)');
        });
    });

    withCollapse('日時(正規化)', function($wrapper){
        inTable($wrapper, function($t){
            evalPrint($t, "js_u_date('hello')");
            evalPrint($t, "js_u_date('1991')");
            evalPrint($t, "js_u_date('20170908')");
            evalPrint($t, "js_u_date('20170908123456')");
            evalPrint($t, "js_u_date('2017/09/08')");
            evalPrint($t, "js_u_datey('2017/09/08')");
            evalPrint($t, "js_u_datem('20170908')");
            evalPrint($t, "js_u_dated('20170908')");
            evalPrint($t, "js_u_dated('201709')");
        });
        inTable($wrapper, function($t){
            evalPrint($t, "js_u_time4('hello')");
            evalPrint($t, "js_u_time4('1234')");
            evalPrint($t, "js_u_time4('12:34')");
            evalPrint($t, "js_u_time4('20170908123456')");
            evalPrint($t, "js_u_time6('1234')");
            evalPrint($t, "js_u_time6('12:34')");
            evalPrint($t, "js_u_time6('12:34:56')");
            evalPrint($t, "js_u_time6('20170908123456')");
            evalPrint($t, "js_u_timeh('12:34:56')");
            evalPrint($t, "js_u_timem('12:34:56')");
            evalPrint($t, "js_u_times('12:34:56')");
        });
        inTable($wrapper, function($t){
            evalPrint($t, "js_u_datetime('hello')");
            evalPrint($t, "js_u_datetime('2017/09/08 12:34:56')");
            evalPrint($t, "js_u_datetime('20170908123456')");
            evalPrint($t, "js_u_dtnormalize('2017/09/08 12:34:56', 'date')");
            evalPrint($t, "js_u_dtnormalize('2017/09/08 12:34:56', 'time4')");
            evalPrint($t, "js_u_dtnormalize('2017/09/08 12:34:56', 'time6')");
            evalPrint($t, "js_u_dtnormalize('2017/09/08 12:34:56', 'datetime')");
        });
    });

    withCollapse('日時(比較)', function($wrapper){
        inTable($wrapper, function($t){
            evalPrint($t, "js_u_datecmp('2017/09/08', '2017/09/09')");
            evalPrint($t, "js_u_time4cmp('1234', '12:00')");
            evalPrint($t, "js_u_time6cmp('123456', '12:34:56')");
            evalPrint($t, "js_u_datetimecmp('2017/09/08 12:34:56', '2017/09/09 12:34:56')");
            evalPrint($t, "js_u_time4cmp('2017/09/08 12:34:56', '2017/09/09 12:34:56')");
        });
    });

    withCollapse('パディング', function($wrapper){
        inTable($wrapper, function($t){
            evalPrint($t, "js_u_padsp('hello', 10)");
            evalPrint($t, "js_u_pad('hello', -10, '_')");
            evalPrint($t, "js_u_pad0('64', 4)");
        });
    });
}
