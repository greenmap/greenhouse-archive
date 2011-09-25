<?php 
global $base_url;
global $i18n_langpath; ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--page.tpl.php-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<link rel="stylesheet" type="text/css" href="<?php print $base_url ?>/themes/iphoneappreferral/iphonestyle.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print $base_url ?>/themes/iphoneappreferral/style.css" media="screen" />
<script type="application/x-javascript" src="<?php print $base_url ?>/themes/iphoneappreferral/iui.js"></script>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
<meta name="apple-touch-fullscreen" content="YES" />
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="author" content="Original design by Andreas Viklund - http://andreasviklund.com / Ported by Matt Koglin - http://antinomia.comn / restyled by Thomas Turnbull - http://wwww.thomasturnbull.com , Te Baybute - http://tebaybute.net , and Akiko Rokube http://rokube.com / for http://www.greenmap.org" />


</head>
<div class="toolbar">
<span id="backButton" class="button" ONCLICK="history.go(-1)" style="display:block !important;">Back</span>
    </div>


			<div id="content">
				<?php if ($title) { ?><h1><?php print $title ?></h1><?php } ?>
				<?php print $help ?>
				<?php print $messages ?>
				<?php print $content; ?>
			
</div>		


	

	
	<?php print $closure ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-418876-2");
pageTracker._trackPageview();
} catch(err) {}</script> 
</body>
</html>
<!--/page.tpl.php-->
