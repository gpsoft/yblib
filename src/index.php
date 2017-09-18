<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset='utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
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
    <?php run(); ?>
    <h1>Javascript</h1>
</div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    $(function(){
    });
    </script>
</body>
</html>
