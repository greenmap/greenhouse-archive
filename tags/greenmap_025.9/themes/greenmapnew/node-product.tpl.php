<!--node-product.tpl.php-->
<?php 
// if viewing teaser show limited info.
if ($teaser) {
?>
<div class="storenode">

<?php print theme('image_teaser', $node); ?>
<div class="producttitle"><a href="<?php print $node_url ?>"><?php print $title ?></a></div>
<div class="priceshort">$<?php print $node->price ?></div>
<div class="links"><?php print $links;  ?></div>

</div>

<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {

?>

<div class="node storepage">
	<strong>Price: </strong>$<?php print $node->price ?>
	<div class="links"><?php print $links;  ?></div>
<p></p><p></p>
<?php  print $body ?>
	<div class="links"><?php // print $links;  ?></div>


</div>

<?php // print_r($node); ?>
		
		
<?php
// end else, for showing full page view.
}
?>
<!--/node-product.tpl.php-->
