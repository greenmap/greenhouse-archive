<!--node-content_press_image.tpl.php-->


<?php
drupal_add_js('misc/collapse.js');


?>

<fieldset><legend class="toollegend">
<?php $check_official = check_official_gms($node->uid) ; //
if($check_official) { ?>
	<img class="gmsicon" src="<?php print base_path(); ?>/misc/GMS_icon.gif" width="12" height="15" alt="Official Green Map System image" />
<?php } ?>
	<a href="<?php print $node_url ?>"><?php print $title ?></a></legend>

<?php 
 // Load author details
$author = user_load(array('uid' => $node->uid));
?>


<?php print theme('imagecache', blogteaser, $field_thumbnail_of_the_resource[0]['filepath']) ; ?> 

<?php if (content_format('field_description_of_tool', $field_description_of_tool[0]) > '') : ?>
 <div class="item">
  <?php foreach ($field_description_of_tool as $item) { ?>
    <?php print 'Caption: ' . content_format('field_description_of_tool', $item) ?>
  <?php } ?>
  </div>
<?php endif; ?>

<?php if (content_format('field_photo_credit', $field_photo_credit[0]) > '') : ?>
 <div class="item">
  <?php foreach ($field_photo_credit as $item) { ?>
    <?php print 'Credit: ' . content_format('field_photo_credit', $item) ?>
  <?php } ?>
  </div>
<?php endif; ?>

<div class="item">Download as 

<?php if (content_format('field_thumbnail_of_the_resource', $field_thumbnail_of_the_resource[0]) > '') : ?>
  <?php foreach ($field_thumbnail_of_the_resource as $item) { ?>
    <?php print l('jpg', file_create_url($item['filepath']) ); ?>
  <?php } ?>
<?php endif; ?>

<?php if (content_format('field_jpg_file_information', $field_jpg_file_information[0]) > '') : ?>
  <?php foreach ($field_jpg_file_information as $item) { ?>
    <?php print ' (' . content_format('field_jpg_file_information', $item) . ') ' ; ?>
  <?php } ?>
<?php endif; ?>

<?php if (content_format('field_link_to_tool', $field_link_to_tool[0]) > '') : ?>
  <?php foreach ($field_link_to_tool as $item) { ?>
    <?php print l('tif', $item['url'] ); ?>
  <?php } ?>
<?php endif; ?>

<?php if (content_format('field_tif_file_information', $field_tif_file_information[0]) > '') : ?>
  <?php foreach ($field_tif_file_information as $item) { ?>
    <?php print ' (' . content_format('field_tif_file_information', $item) . ') ' ; ?>
  <?php } ?>
<?php endif; ?>

</div>
 
</fieldset>


<!--/node-content_press_image.tpl.php-->
