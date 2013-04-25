
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kies de beste docent van het jaar!">
    <meta name="author" content="Herman Banken">

    <!-- Le styles -->
    <link href="<?php echo URL::site("assets/css/bootstrap.css") ?>" rel="stylesheet">
    <link href="<?php echo URL::site("assets/css/app.css") ?>" rel="stylesheet">
    <link href="<?php echo URL::site("assets/css/bootstrap-responsive.min.css") ?>" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="https://ch.tudelft.nl/sites/default/themes/CHallenge/favicon.ico">
		
		<script>var root_url = "<?php echo URL::base(); ?>";</script>
  </head>

  <body class="<?php echo Request::current()->controller()." ".Request::current()->controller()."-".Request::current()->action(); ?>">

    <div class="container<?php echo $container_style ?>">

      <?php echo $menu; ?>

      <hr>

     	<?php echo $content; ?>

      <hr>

      <div class="footer">
        <p>&copy; W.I.S.V. 'Christiaan Huygens' <?php echo date("Y"); ?></p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo URL::site("assets/js/jquery.js") ?>"></script>
    <script src="<?php echo URL::site("assets/js/jquery.hashchange.js") ?>"></script>
    <script src="<?php echo URL::site("assets/js/bootstrap.min.js") ?>"></script>
    <script src="<?php echo URL::site("assets/js/app.js") ?>"></script>
    <script src="<?php echo URL::site("assets/js/Placeholders.min.js") ?>"></script>

  </body>
</html>