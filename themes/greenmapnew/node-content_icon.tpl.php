<!--node-content_icon.tpl.php-->


<?php
 drupal_add_js('misc/collapse.js'); 

$allowed_editor = FALSE;
if (user_access('administer users')) {
	$allowed_editor = TRUE;
}

?>

<?php 
// if viewing teaser show limited info. -----------------------------------------------------------------------------------------------------------------
if ($teaser) { ?>

<table class="icontable">
	<tr>
		<td class="iconcolumn">
			<?php // start with checking which is preferred icon, and displaying it ?>
			
			<?php $image1 = $field_main_icon_image[0]['filepath'];  ?>
			<?php $image2 = $field_old_icon_image[0]['filepath'];  ?>
			<?php $image3 = $field_alternative_icon_images[0]['filepath'];  ?>
			<?php $image4 = $field_4_alternative_icon_image[0]['filepath'];  ?>
			<?php $image5 = $field_5_alternative_icon_image[0]['filepath'];  ?>
			<?php $preferred = $field_preferred_icon[0]['view']; ?>
			<?php $image_to_print = FALSE; ?>
			
			<?php 
			
			
			// get preferred number, and see if there's an image for that one, and if so then print that image
			if (($field_preferred_icon == '1') && ($image1 > '') ) { $image_to_print = $image1; }
			elseif (($field_preferred_icon == '2') && ($image2 > '') ) { $image_to_print = $image2; }
			elseif (($field_preferred_icon == '3') && ($image3 > '') ) { $image_to_print = $image3; }
			elseif (($field_preferred_icon == '4') && ($image4 > '') ) { $image_to_print = $image4; }
			elseif (($field_preferred_icon == '5') && ($image5 > '') ) { $image_to_print = $image5; }
			// else loop through each of possible images and print the first we find
			elseif ($image1 > '') { $image_to_print = $image1; }
			elseif ($image2 > '') { $image_to_print = $image2; }
			elseif ($image3 > '') { $image_to_print = $image3; }
			elseif ($image4 > '') { $image_to_print = $image4; }
			elseif ($image5 > '') { $image_to_print = $image5; }
			
			if ($image_to_print) {
				// print the image
				print theme('imagecache', iconlarge,  $image_to_print) ; 
			}	
			else {
				// else just print a nbsp to stop the table cell collapsing
				print '&nbsp;';
			}
			
			
			?>
			
		</td>
		<td class="icontitle">
			
			<?php // then display title ?>
			<a name="<?php print $nid ?>" ></a> <?php // link for # anchor ?>
			<span title="<?php print content_format('field_definition', $field_definition[0] ) ?>"><?php print $title ?></span>&nbsp;
			<?php if ($allowed_editor) {
				// if page is being viewed by an admin, then print an edit link ?>
				<a href="<?php print $node_url ?>" >[Edit]</a>
			<?php } ?>
			<br />
			
			<?php // put old title on line below if exists ?>
			<span class="old" title="<?php print content_format('field_old_definition', $field_old_definition[0] ) ?>"><?php print content_format('field_old_icon_title', $field_old_icon_title[0] ) ?></span>&nbsp;
					
		</td>
		<td>
		
			<?php // new or old? 	field_existing_icon ?>
			<?php if ($field_existing_icon[0]['value'] == '3') { print 'V3'; }
					else { print 'V2'; } ?>
			&nbsp;
		</td>

		
		<td class="iconcomment"> 
		  <?php // count comments and insert link to add ?>
		  <?php $add_path = base_path() . 'comment/reply/' . $node->nid . '#comment_form' ; ?>
		  <?php print $comment_count . ' comments' ; ?> 
		  
		  
		</td>
	</tr>
</table>

<?php // print a dropdown fieldset containing the full icon... might be overwhelming! ?>

<fieldset id="fieldset<?php  print $nid ?>" class="fakecollapsible fakecollapsed iconlist">
	<legend><a href="#<?php  print $nid ?>" onClick="iconIframe('<?php print $nid ; ?>','<?php print base_path(); ?>');collapseManualAttach('fieldset<?php print $nid ; ?>')"><?php print t('View details and comments for ') . $title; ?></a>
	</legend>
	

		<?php // print comment_render($node); ?>
		<?php // print comment_form(); // problem - this prints the form, but is illegal to submit ?>
		<?php $iframepath = base_path() . 'node/' . $nid ; ?>

		<iframe id="<?php  print $nid; ?>" name="<?php  print $nid; ?>" src="about:blank" height="10px" width="100%" frameborder="0" ></iframe> 

	
</fieldset>

<?php 
}
else { // if not teaser show full node for icon ------------------------------------------------------------------------------------------------------------- ?>
<div id="iconpage">


	
	<fieldset class="collapsible"><legend><?php print t('Icon Title'); ?></legend>
		
		<div class="item">
			<div><label><?php print t('New Title'); ?></label></div>
			<div class="data"><?php print $title; ?></div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Old Title'); ?></label></div>
			<div class="data old"><?php print $field_old_icon_title[0]['view'] ; ?></div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Title Status'); ?></label></div>
			<div class="data"><?php print $field_title_status[0]['view'] ; ?></div>
		</div>
		
	</fieldset>
		
	<fieldset class="collapsible"><legend><?php print t('Icon Images'); ?></legend>


		<div class="item">
			<div><label><?php print t('Icon Design Status'); ?></label></div>
			<div class="data"><?php print $field_icon_design_status[0]['view'] ?></div>
		</div>
		
				
		<?php $image1 = $field_main_icon_image[0]['filepath'];  ?>
		<?php $image2 = $field_old_icon_image[0]['filepath'];  ?>
		<?php $image3 = $field_alternative_icon_images[0]['filepath'];  ?>
		<?php $image4 = $field_4_alternative_icon_image[0]['filepath'];  ?>
		<?php $image5 = $field_5_alternative_icon_image[0]['filepath'];  ?>
		<?php $preferred = $field_preferred_icon[0]['view']; ?>
		<?php $icon_count = 0; // to count how many icons ?>
		
		
		
		<?php // need to insert imagecached thumbnails too ?>
		
		
		<?php if ($image1 > '') { ?>
			<div class="greenicon <?php if ($preferred == '1') { print 'preferred'; } ?>"><?php print theme('imagecache', iconlarge,  $image1) ; ?><?php print theme('imagecache', iconsmall,  $image1) ; ?><br />1. New Version 3 Image</div>
			<?php $icon_count ++; ?>
		<?php } ?>	
		<?php if ($image2 > '') { ?>
			<div class="greenicon <?php if ($preferred == '2') { print 'preferred'; } ?>"><?php print theme('imagecache', iconlarge,  $image2) ; ?><?php print theme('imagecache', iconsmall,  $image2) ; ?><br />2. Existing Version 2 Image</div>
			<?php $icon_count ++; ?>
		<?php } ?>	
		<?php if ($image3 > '') { ?>
			<div class="greenicon <?php if ($preferred == '3') { print 'preferred'; } ?>"><?php print theme('imagecache', iconlarge,  $image3) ; ?><?php print theme('imagecache', iconsmall,  $image3) ; ?><br />3. Alternative</div>
			<?php $icon_count ++; ?>
		<?php } ?>	
		<?php if ($image4 > '') { ?>
			<div class="greenicon <?php if ($preferred == '4') { print 'preferred'; } ?>"><?php print theme('imagecache', iconlarge,  $image4) ; ?><?php print theme('imagecache', iconsmall,  $image4) ; ?><br />4. Alternative</div>
			<?php $icon_count ++; ?>
		<?php } ?>	
		<?php if ($image5 > '') { ?>
			<div class="greenicon <?php if ($preferred == '5') { print 'preferred'; } ?>"><?php print theme('imagecache', iconlarge,  $image5) ; ?><?php print theme('imagecache', iconsmall,  $image5) ; ?><br />5. Alternative</div>
			<?php $icon_count ++; ?>
		<?php } ?>
		
		<?php if ($icon_count == 0) { print '<p>' . t('There are no images for this Icon') . '</p>' ; } ?>
		<?php if ($icon_count > 0) { print '<div class="iconinfo old">' . t('The current favorite Icon has the green border - number ') . $preferred .  '</div>' ; } ?>

	
	</fieldset>
	
	
	
	<fieldset class="collapsible"><legend><?php print t('Icon Definitions'); ?></legend>
		
		<div class="item">
			<div><label><?php print t('New Definition'); ?></label></div>
			<div class="data"><?php print $field_definition[0]['view'] ; ?>&nbsp;</div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Old Definition'); ?></label></div>
			<div class="data old"><?php print $field_old_definition[0]['view'] ; ?>&nbsp;</div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Definition Status'); ?></label></div>
			<div class="data"><?php print $field_title_status[0]['view'] ; ?>&nbsp;</div>
		</div>

		<div class="item">
			<div><label><?php print t('Usage Notes'); ?></label></div>
			<div class="data"><?php print $field_usage_notes[0]['view'] ; ?>&nbsp;</div>
		</div>
		
		<?php if ($field_provenance[0]['view'] > '') { ?>
		<div class="item">
			<div><label><?php print t('Origin'); ?></label></div>
			<div class="data"><?php print $field_provenance[0]['view'] ; ?>&nbsp;</div>
		</div>
		<?php } ?>
				
	</fieldset>


	<?php // sort out all the different taxonomy terms into genre, category & theme. Do a for each and assign to appropriate variables. ?>
	
	<?php 
	$categories = taxonomy_node_get_terms($nid);
	
	
	foreach ($categories as $item) { 
		 if ($item->vid == 11) {
		 	// if vid = 11 then it's a genre taxonomy
			$icongenre = $item->name;
		 }
		 elseif ($item->vid == 12) {
		 	// if vid = 12 then it's a category taxonomy
			$iconcategory = $item->name;
		 }
		 elseif ($item->vid == 13) {
		 	// if vid = 13 then it's a theme taxonomy - could be multiple
			if ($icontheme > '') {
				$icontheme .= ", " . $item->name;
			}
			else {
				$icontheme = $item->name;
			}
		 }

	 } 	
	
	?>

	<fieldset class="collapsible collapsed"><legend><?php print t('Icon Categorization'); ?></legend>
		
		<div class="item">
			<div><label><?php print t('Genre'); ?></label></div>
			<div class="data"><?php print $icongenre ; ?> &nbsp; </div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Category'); ?></label></div>
			<div class="data"><?php print $iconcategory ; ?> &nbsp; </div>
		</div>


		<div class="item">
			<div><label><?php print t('Themes'); ?></label></div>
			<div class="data"><?php print $icontheme ; ?> &nbsp; </div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Sets'); ?></label></div>
			<div class="data">
				<?php foreach ((array)$field_sets as $item) { ?>
					 <?php print $item['view']  ; ?>
				<?php } ?>&nbsp;
			</div>
		</div>
		
		
		<?php if ($field_local_icon[0]['view'] == 'yes') { ?>
		<div class="item">
			<div><label><?php print t('Local Icon'); ?></label></div>
			<div class="data"><?php print $field_local_icon[0]['view'] ; ?></div>
		</div>
		<?php } ?>


		<?php if ($field_to_be_scrapped[0]['view'] == 'yes') { ?>
		<div class="item">
			<div><label><?php print t('To Be Scrapped'); ?></label></div>
			<div class="data"><?php print $field_to_be_scrapped[0]['view'] ; ?></div>
		</div>
		<?php } ?>
		
		<div class="item">
			<div><label><?php print t('Version'); ?></label></div>
			<div class="data"><?php print $field_existing_icon[0]['view'] ; ?>&nbsp;</div>
		</div>
						
		
		
	</fieldset>


	<fieldset class="collapsible collapsed"><legend><?php print t('Icon Font'); ?></legend>
		
		<div class="item">
			<div><label><?php print t('Keystroke'); ?></label></div>
			<div class="data"><?php print $field_keystroke[0]['view'] ; ?>&nbsp;</div>
		</div>
		
		<div class="item">
			<div><label><?php print t('Deci Number'); ?></label></div>
			<div class="data"><?php print $field_deci_number[0]['view'] ; ?>&nbsp;</div>
		</div>


				
	</fieldset>


<pre>
<?php //  print_r ($node); ?>
</pre>


</div> <?php // end iconpage div ?>

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
		
		
<?php } // end else showing full node ?>
<!--/node-content_icon.tpl.php-->
