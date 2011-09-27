<?php 
global $base_url;
global $i18n_langpath; ?>

<?php
	$color = 'blue'; //set to blue, black, green, orange, purple, or red
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--page-simple.tpl.php-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <style type="text/css" media="all">@import "<?php print $base_url . '/' . $directory . '/colorcss/' . $color ?>.css";</style>
  <style type="text/css" media="all">@import "<?php print $base_url . '/' . $directory . '/simple'  ?>.css";</style>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Original design by Andreas Viklund - http://andreasviklund.com / Ported by Matt Koglin - http://antinomia.comn / restyled by Thomas Turnbull - http://wwww.thomasturnbull.com / for http://www.greenmap.org" />
</head>

<body>



				<?php print $help ?>
				<?php print $messages ?>
				<?php print $content; ?>


	
	<?php print $closure ?>
</body>
</html>
<!--/page-simple.tpl.php-->
