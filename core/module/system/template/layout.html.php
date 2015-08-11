<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="/core/etc/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css" />
</head>
<body>

<div data-role="page">
    <div data-role="header"><?php include 'core/module/system/template/header.html.php'; ?></div>
    <div class="ui-content"><?php include template()?></div>
    <div data-role="footer"><?php include 'core/module/system/template/footer.html.php'; ?></div>
</div>
<!--[if lt IE 9]>
<script type='text/javascript' src='/core/etc/js/jquery-1.11.3/jquery-1.11.3.min.js'></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type='text/javascript' src='/core/etc/js/jquery-2.1.4/jquery-2.1.4.min.js'></script>
<!--<![endif]-->
<script>
    $( document ).on( "mobileinit", function() {
        //$.mobile.defaultPageTransition = 'slide';
        $.mobile.ajaxEnabled = false;
    });
</script>
<script src="/core/etc/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>

</body>
</html>
