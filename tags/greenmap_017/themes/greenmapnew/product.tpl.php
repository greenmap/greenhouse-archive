

<?php
// drupal_add_js('misc/collapse.js');
?>

<?php 
// if viewing teaser show limited info.
if ($teaser) {
?><fieldset><legend><a href="<?php print $node_url ?>"><?php print $title ?></a></legend>

<?php print $body ?> 
</fieldset>

<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {

?>
<fieldset><legend><a href="<?php print $node_url ?>"><?php print $title ?></a></legend>

</fieldset>
<?php
// end else, for showing full page view.
}
?>
