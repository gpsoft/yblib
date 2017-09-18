<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<?php
include_once('util.php');
include_once('sql.php');
include('app.php');
?>

<div class="container">
    <h1>PHP</h1>
    <section>
        <?php run(); ?>
    </section>
    <h1>Javascript</h1>
    <section id="jsBody">
    </section>
</div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="polyfill.js"></script>
    <script type="text/javascript" src="json2.js"></script>
    <script type="text/javascript" src="util.js"></script>
    <script type="text/javascript" src="app.js"></script>
    
    <script type="text/javascript">
    $(function(){
        run($('#jsBody'));
    });
    </script>
</body>
</html>
