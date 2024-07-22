<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (isset($title)) :
            echo $title . ' - ';
        endif; ?>
    </title>
    <?php
    echo '<style>' . file_get_contents('/var/www/html/css/output.css') . '</style>';
    echo '<style>' . file_get_contents('/var/www/html/node_modules/paginationjs/dist/pagination.css') . '</style>';
    echo '<style>' . file_get_contents('/var/www/html/node_modules/paginationjs/dist/pagination.css') . '</style>';

    echo '<link rel="stylesheet" href = ' . file_get_contents('/var/www/html/css/style.css') . '>';
    // echo '<link rel="stylesheet" href = ' . file_get_contents('/var/www/html/node_modules/paginationjs/dist/pagination.css') . '>';
    //
    ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" />
</head>


<body class="">
    <div>
        <?php include_once('/var/www/html/src/views/header.php'); ?>
    </div>
    <div>
        <?php echo $content; ?>
    </div>
    <?php include_once('/var/www/html/src/views/javascript.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
</body>

</html>
