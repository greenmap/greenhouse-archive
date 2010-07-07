<!--node-content_photo.tpl.php-->


<?php
drupal_add_js('misc/collapse.js');
drupal_add_js('misc/collapse.js');
drupal_add_js('themes/greenmap/gallery.js');
?>

<?php 
// if viewing teaser show limited info.
if ($teaser) {
?>

<a href="<?php print base_path() . 'albums' ; ?>" title="<?php print $title; ?>"><?php print theme('imagecache', galleryhomepage,  $field_photo[0]['filepath']) ; ?></a>


<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {

$allowed_editor = FALSE;
if ((user_access('administer users') || $GLOBALS['user']->uid == $node->uid)) {
	$allowed_editor = TRUE;
}

?>

<?php 

// query database to get all photos for selected album, and set up array of path, caption & nid ?>

<?php // $current_album_nid = $field_album_via_computed_value[0]['view']; ?>
<?php $current_album_nid = $field_album_via_computed[0]['value']; ?>

<?php $resultgallery = db_query("SELECT p.field_photo_alt, n.title, n.nid
								FROM node_content_photo p 
									INNER JOIN node n on p.nid = n.nid
								WHERE p.field_album_via_computed_value = $current_album_nid  
								ORDER BY n.nid  
								LIMIT 100"); 
							
	$number = mysql_numrows($resultgallery);
	$i = 0;
	
	while($number > $i){
	
		$item[$i]['value'] = 'files/albumphotos/' . mysql_result($resultgallery,$i,"field_photo_alt");
		$item[$i]['title'] = mysql_result($resultgallery,$i,"title");
		$item[$i]['nid'] = mysql_result($resultgallery,$i,"nid");
				
  // end looping row
  $i++;
  }

							?>

<div id="gallery">

<?php // don't try to display images if there's none
if ($number > 0) { ?>

	<?php 
	// if they're admin or owner, tell them they can double click on thumb to edit
	if($allowed_editor) {
		print t('Double click on a thumbnail to edit that photo');
	} ?>
	
	
	<div class="gallerysection">
	
	<?php foreach ($item as $path) { 
	
	$editpath = base_path() . 'node/' . $path['nid'] . '/edit'; ?>
	<a class="thumbs" href="#" onClick="LoadGallery('<?php print base_path() . $path['value'] ?>','<?php print addslashes($path['title']) ?>');"
	<?php // if they're an admin or owner of photo, let them double click to edit
	if ($allowed_editor) { ?>
		onDblClick="EditPhoto('<?php print $editpath ?>')"
	<? } // end allowed editor click, last tag below closes anchor tag ?>
	>
	<?php print theme('imagecache', gallerythumb, $path['value']) ; ?>
	</a>
	<?php  } ?>
	
	</div> <?php // end of thumblist div ?>
	
	<?php // div containing full size image ?> 
	<div class="gallerysection">
	<img class="imageHolder" src="<?php print base_path() .  $item[0]['value'] ?>" id="imageHolder" alt="<?php print $item[0]['title'] ?>" />
	</div>
	<div class="gallerysection">
	<p id="captionHolder"><?php print $item[0]['title'] ?></p>

</div>
	
<?php } else {
	print t('There are no photos in this gallery yet');
}?>

<div id="gallerydescription" class="gallerysection">
<?php if (content_format('field_album_description', $field_album_description[0]) > '') : ?>
 <p><?php print check_markup(content_format('field_album_description', $field_album_description[0])) ?></p>
<?php endif; ?>




<?php // set up a block only to be seen by administrators & album owner to add more photos, or edit existing ones
if($allowed_editor) {
?>

<p><a href="<?php print base_path() ?>node/add/content_photo?album_nid=<?php print $current_album_nid  ?>">Add another photo to this album</a></p>


<?php 
// end admin block
}
?>
</div> 
<?php 
		
// end of gallery div ?>	
</div>
<div class="links">
	<?php print $links; ?>
</div>
    <?php
	    if (($submitted) || ($taxonomy)) {
	    print '<div class="styledbox postinfo">';
	    	if ($taxonomy) { print $terms; }
//	    	if ($submitted) { print $submitted; }  changed this to remove time from submitted by information - TT - 14th March 2007
			if ($submitted) {
				print  t('Submitted by') . '&nbsp;' . theme('username', $node) . '&nbsp;' . t('on') . '&nbsp;' . format_date($node->created, 'custom', 'jS M Y') . '&nbsp;' . $rss;
			}
	    print '</div>';
	    } ?>	
<?php
// end else, for showing full page view.
}
?>
<!--/node-content_photo.tpl.php-->
