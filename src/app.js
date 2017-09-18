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
            // .addClass('collapse')
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

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });

    withCollapse('', function($wrapper){
        inTable($wrapper, function($t){
        });
    });
}
