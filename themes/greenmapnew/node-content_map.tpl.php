<!--node-content_map.tpl.php-->


<?php
drupal_add_js('misc/collapse.js');
?>

<?php 

// if viewing list of map thumbnails then show that - used at the main maps overview page, and a dedicated views page
if ((arg(0) == 'maps') && (arg(1) != 'list')) { ?>
	<div class="mapthumb">
		<?php 
		
		foreach ((array)$field_main_map_image as $item) { 
		  if ($item['filepath'] != '') {
			  ?>
			  <?php print '<a href="' . $node_url . '">'; ?>
			  <?php print theme('imagecache', galleryhomepage, $item['filepath']) ?>
			  <?php print '</a>'; ?>
			  <?php // print content_format('field_main_map_image', $item) ?>
			  <?php 
		  }
       } ?>
	</div>

<? }

// else if viewing teaser show limited info.
elseif ($teaser) {
?><fieldset><legend><a href="<?php print $node_url ?>"><?php print $title ?></a></legend>

<?php 
 // Load author details
$author = user_load(array('uid' => $node->uid));
$lapsed_roles = array('lapsed user');

if (is_array($author->roles)) {
  if (count(array_intersect($author->roles, $lapsed_roles)) > 0) {
    $lapsed = TRUE;
  } else {
    $lapsed = FALSE;
}}



?>

 <div class="item">
  <div><label><?php print t('Created by'); ?>:</label></div>
    <div class="data"> <?php print $author->name ?> </div>
 </div>

<?php if($lapsed) { ?>
 <div class="item">
  <div><label><?php print t('Availability'); ?>:</label></div>
    <div class="data"> <?php print t('This is no longer an active project. If you would like to start a Green Map project in this community, please go to the participate section of the website and register.');  ?> </div>
 </div>
<?php } ?>

<?php if (content_format('field_taglineslogan', $field_taglineslogan[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Introduction'); ?>: </label></div>
  <?php foreach ($field_taglineslogan as $item) { ?>
    <div class="data"> <?php print content_format('field_taglineslogan', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_scale', $field_scale[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Scale of Map'); ?>:</label></div>
  <?php foreach ($field_scale as $item) { ?>
    <div class="data"> <?php print content_format('field_scale', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_publishing_status', $field_publishing_status[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Status'); ?>:</label></div>
  <?php foreach ($field_publishing_status as $item) { ?>
    <div class="data"> <?php print content_format('field_publishing_status', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

 <div class="item">
  <div><label><?php print t('Themes'); ?>:</label></div>
    <div class="data"> <p><?php print $terms; ?></p></div>
 </div>
 
</fieldset>

<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {

$allowed_editor = FALSE;
if ((user_access('administer users') || $GLOBALS['user']->uid == $node->uid)) {
	$allowed_editor = TRUE;
}

?>

<div id="leftmap">

  <div class="field-items">
    <?php foreach ((array)$field_main_map_image as $item) { 
	  if ($item['filepath'] != '') {
		  ?>
		  
		  <div class="field-item">
		  <?php print content_format('field_main_map_image', $item) ?></div>
		  <?php 
		  }
	  	  elseif ($allowed_editor) { 
			  $url = $nid . '/edit#edit[field_main_map_image_upload]'; ?>
			  <fieldset class="collapsible"><legend><?php print t('Map Image'); ?></legend>
			  <div class="mapmakersbg">
			  <?php print t('You have not added an image of this map'); ?>. <a class="mapmakers" href="<?php print $url; ?>"><?php print t('Click here to add an image'); ?></a>.
			  </div>
			  </fieldset>	
	  <?php }
      } ?>
  </div>
  
<?php
  $latitude = $locations[0]['latitude'];
  $longitude = $locations[0]['longitude'];
?>
<?php if ((($latitude > '') && ($longitude > '')) || $allowed_editor) : ?>
<fieldset class="collapsible"><legend><?php print t('Location'); ?></legend>
  <div id="gmap">
  <?php 
  
  if(($latitude > '') && ($longitude > '')) { 

	  $macro = '[gmap |id=map |center=' . $latitude . ', ' . $longitude ;
	  $macro .= ' |zoom=0 |width=100% |height=150 |control=Small |type=Map |tcontrol=off | markers=greenhouse/icon_greenmap_google::';
	  $macro .= $latitude . ',' . $longitude . ']';
	  
	  $mymap = gmap_parse_macro($macro);
	  print gmap_draw_map($mymap);
   } elseif ($allowed_editor) { 
   	  $url = $nid . '/edit#edit[locations][0][country]'; ?>
  	  <div class="mapmakersbg"><?php print t('You have not set the location of this map. If you do not set the location, this Map will not show up
	  on the homepage of GreenMap.org!'); ?> <a class="mapmakers" href="<?php print $url; ?>"><?php print t('Click here to add the location'); ?></a>.</div>
  <?php } ?>
  </div>
</fieldset>  
<?php endif ?>  





<?php $currentnid=$node->nid; // get nid for current map 

if ($currentnid > '') {  // in some cases nid isn't set (ie when first adding a map) so don't show photos or do query
	
	 $currentuid=$node->uid; // get nid for current map ?>
	<?php  // do query to get all albums & photos associated with map
	$resultgallery = db_query("
									SELECT p.field_photo_alt, ng.title, ng.nid
									From node_content_photo p
										INNER JOIN node np on p.nid = np.nid
										INNER JOIN node ng on p.field_album_via_computed_value = ng.nid
										INNER JOIN node_content_gallery am on am.nid = ng.nid
									WHERE am.field_associated_map_nid = $currentnid
									ORDER BY ng.title, p.nid
									LIMIT 100
								"); 
								
		$number = mysql_numrows($resultgallery); 
		
	// if there's no associated albums, then check if the user has any other albums not associated with a map
	if ($number == 0) {
		$resultgallery = db_query("
									SELECT p.field_photo_alt, ng.title, ng.nid
									From {node_content_photo} p
										INNER JOIN {node} np on p.nid = np.nid
										INNER JOIN {node} ng on p.field_album_via_computed_value = ng.nid
										INNER JOIN {node_content_gallery} am on am.nid = ng.nid
									WHERE am.field_associated_map_nid = 0 AND ng.uid = %d
									ORDER BY ng.title, p.nid
									LIMIT 100
								", $currentuid); 
								
		$number = mysql_numrows($resultgallery); 
	
	}
	
	// if there's still no albums or photos then hide the whole photos fieldset, unless the viewer is the page owner or an admin, in which case print a message allowing them to add an album
	if (($number != 0) || $allowed_editor) {
		?>
		
	<fieldset class="collapsible"><legend><?php print t('Photos'); ?></legend>
	<div id="albums">
	
		<?php $i = 0; // used to loop through all the photos from teh database query
		$current_gallery = 0; // this variable checks as we loop to see if we've moved onto new gallery, and shows title & Link if so.
		
		while($number > $i){
		
			$item[$i]['value'] = 'files/albumphotos/' . mysql_result($resultgallery,$i,"field_photo_alt"); // photo url
			$item[$i]['title'] = mysql_result($resultgallery,$i,"title"); // gallery title
			$item[$i]['nid'] = mysql_result($resultgallery,$i,"nid"); // gallery nid
			
			if($item[$i]['nid'] != $current_gallery) {
				// print gallery title & link ?>
				<?php print l($item[$i]['title'], 'node/' . $item[$i]['nid']) ?>
				<?php $current_gallery = $item[$i]['nid']; ?>
				<?php $album_photo_number = 1; ?>
			<?php }
			// print photo thumbnail ?>
			<?php if($album_photo_number < 11) { ?>
				<a href="<?php print base_path() ?>node/<?php print $item[$i]['nid'] ?>" title="<?php print t('click to view album'); ?>" class="img">
				<?php print theme('imagecache', gallerythumb, $item[$i]['value'])   ?></a>
			<?php } ?>
	  <?php // end looping row
	  $i++;
	  $album_photo_number++;
	  }	
	
	if ($allowed_editor) {
		// give link to add an album
		$attributes = array("class" => "mapmakers");
		print l(t('Add an album'),'node/add/content_gallery',$attributes); 
	}
	?>
	
	</div>
	</fieldset>
	<?php // end hiding of fieldset if no photos present
	} 
}	 // end of hiding photos & query if no node nid is set
  ?>
  

<?php // print a list of all the mapmaker's other maps by inserting a view ?>



<?php // show all the maps for this user by inserting a view 'maps_list_user'

  global $maplist_view;
  $maplist_view->args[0]=$node->uid;	// pass uid as argument
  $maplist_view->args[1]=$currentnid; // pass current nid to exclude current map from list
  $viewmaplist = views_get_view('maps_list_user');  
  $maplist = views_build_view('embed', $viewmaplist, $maplist_view->args, false, false);
  
  if ($maplist > '') { ?>
  		<fieldset class="collapsible collapsed"><legend><?php print t('Other Maps by ') . $node->name; ?></legend>		
  		<?php print $maplist; ?>
		</fieldset>
  <?php } ?>




</div>


<div id="rightmap">


<?php 
 // Load author details
$author = user_load(array('uid' => $node->uid));
$lapsed_roles = array('lapsed user');

if (is_array($author->roles)) {
  if (count(array_intersect($author->roles, $lapsed_roles)) > 0) {
    $lapsed = TRUE;
  } else {
    $lapsed = FALSE;
}}

?>

<?php if($lapsed){ ?>

	<fieldset class="collapsible required"><legend><?php print t('No Longer an Active Project'); ?></legend>
		<div class="required">
			<?php print t('This is no longer an active project. If you would like to start a Green Map project in this community, please go to the %link section of the website and register.', array('%link' => l(t('Participate'),'participate'))) ; ?>
		</div>
	</fieldset>

<?php } ?>

<fieldset class="collapsible"><legend title="<?php print $title ?>"><?php print trim_text($title, 72) ?></legend>



 <div class="item">
  <div><label><?php print t('Created by'); ?>:</label></div>
    <div class="data"> <?php print $name ?> </div>
 </div>
 


<?php if (content_format('field_taglineslogan', $field_taglineslogan[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Introduction'); ?>:</label></div>
  <?php foreach ($field_taglineslogan as $item) { ?>
    <div class="data"> <?php print content_format('field_taglineslogan', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_your_website_about_this_m', $field_your_website_about_this_m[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Website'); ?>:</label></div>
  <?php foreach ($field_your_website_about_this_m as $item) { ?>
	<?php $item = trim_url($item) ?>
	<div class="data"> <?php print content_format('field_your_website_about_this_m', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if ($field_pdf_of_map[0]['fid']) : ?>
 <div class="item">
  <div>
      <label><?php print t('Download PDF'); ?>:</label>
    </div>
  <?php foreach ($field_pdf_of_map as $item) { ?>
    <div class="data"><a href="<?php print file_create_url($item['filepath']); ?>" target="_blank"><?php print file_create_url($item['filepath']); ?></a> <?php print size_hum_read($item['filesize']) ?></div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') : ?>
 <div class="item">
  <div><label>Online Map</label></div>
  <?php foreach ($field_link_to_online_map as $item) { ?>
	<?php $item = trim_url($item) ?>
    <div class="data"> <?php print content_format('field_link_to_online_map', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_publishing_status', $field_publishing_status[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Status'); ?>:</label></div>
  <?php foreach ($field_publishing_status as $item) { ?>
    <div class="data"> <?php print content_format('field_publishing_status', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (	!(content_format('field_pdf_of_map', $field_pdf_of_map[0]) > '') && 
		!(content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') ) : // print a message if the map's not available yet ?>
 <div class="item">
  <div>
      <label><?php print t('Availability'); ?>:</label>
    </div>
  <?php print t('This map is not available for download yet'); ?>
 </div>
<?php endif; ?>


<?php // insert add/edit link if this person is allowed to do so ?>
<?php if ($allowed_editor) { ?>
	<div class="item mapmakers">
		<?php $url = 'node/' . $nid . '/edit'; ?>
		<?php $attributes = array("class" => "mapmakers"); ?>
		<div class="data" ><?php print l(t('Add or edit these details'),$url,$attributes); ?></div>
	</div>

<?php } ?>

</fieldset>



<?php if (content_format('field_about_this_map', $field_about_this_map[0]) > '') { ?>
<fieldset class="collapsible"><legend><?php print t('About this Map'); ?></legend>
  <?php foreach ($field_about_this_map as $item) { ?>
    <?php print check_markup(content_format('field_about_this_map', $item)) ?>
  <?php } ?>
  
<?php // insert add/edit link if this person is allowed to do so ?>
<?php if ($allowed_editor) { ?>
	<div class="item mapmakers">
		<?php $url = 'node/' . $nid . '/edit'; ?>
		<?php $attributes = array("class" => "mapmakers"); ?>
		<?php print l(t('Edit this description'),$url,$attributes); ?>
	</div>

<?php } ?>


</fieldset>
<?php } elseif ($allowed_editor) { ?>
	<fieldset class="collapsible"><legend><?php print t('About this Map'); ?></legend>
	<div class="item mapmakersbg">
		<?php $url = 'node/' . $nid . '/edit'; ?>
		<?php $attributes = array("class" => "mapmakers"); ?>
		<?php print l(t('Add a description of this Green Map'),$url,$attributes); ?>
	</div>
	</fieldset>
<?php } ?>



<fieldset class="collapsible collapsed"><legend><?php print t('Map Details'); ?></legend>

  <div class="item">
  <div><label><?php print t('Themes'); ?>:</label></div>
    <div class="data"> <?php print $terms; ?></div>
 </div>
 
 
<?php 
if (content_format('field_scale_of_map_other', $field_scale_of_map_other[0]) > '') { ?>
 <div class="item">
  <div><label><?php print t('Scale'); ?>:</label></div>
  <?php foreach ($field_scale_of_map_other as $item) { ?>
    <div class="data"> <?php print content_format('field_scale_of_map_other', $item) ?> </div>
  <?php } ?>
 </div>
<?php }

elseif (content_format('field_scale', $field_scale[0]) > '') { ?>
 <div class="item">
  <div><label><?php print t('Scale'); ?>:</label></div>
  <?php foreach ($field_scale as $item) { ?>
    <div class="data"> <?php print content_format('field_scale', $item) ?> </div>
  <?php } ?>
 </div>
<?php } ?>



<?php if (content_format('field_start_date', $field_start_date[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Start Date'); ?>:</label></div>
  <?php foreach ($field_start_date as $item) { ?>
    <div class="data"> <?php print content_format('field_start_date', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_target_publication_date', $field_target_publication_date[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Publication'); ?>:</label></div>
  <?php foreach ($field_target_publication_date as $item) { ?>
    <div class="data"> <?php print content_format('field_target_publication_date', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_map_languages', $field_map_languages[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Language(s)'); ?>:</label></div>
  <?php foreach ($field_map_languages as $item) { ?>
    <div class="data"> <?php print content_format('field_map_languages', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_your_website_about_this_m', $field_your_website_about_this_m[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Website'); ?>:</label></div>
  <?php foreach ($field_your_website_about_this_m as $item) { ?>
	<?php $item = trim_url($item) ?>
	<div class="data"> <?php print content_format('field_your_website_about_this_m', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

</fieldset>


<?php if ((content_format('field_medium', $field_medium[0]) > '') || (content_format('field_size_of_printed_map', $field_size_of_printed_map[0]) > '') || 
	(content_format('field_copies_printed_0', $field_copies_printed_0[0]) > '') || (content_format('field_printing_choices', $field_printing_choices[0]) > '') ||
	(content_format('field_number_of_editions_0', $field_number_of_editions_0[0]) > '') || (content_format('field_number_of_green_sites', $field_number_of_green_sites[0]) > '0') || 
	(content_format('field_number_of_green_map_icons', $field_number_of_green_map_icons[0]) > '0') || (content_format('field_were_locally_designed_ico', $field_were_locally_designed_ico[0]) > '') 
	){ ?>
<fieldset class="collapsible collapsed"><legend>Publication Information</legend>


<?php if (content_format('field_medium', $field_medium[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Medium'); ?>:</label></div>
  <?php foreach ($field_medium as $item) { ?>
    <div class="data"> <?php print content_format('field_medium', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_size_of_printed_map', $field_size_of_printed_map[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Size'); ?>:</label></div>
  <?php foreach ($field_size_of_printed_map as $item) { ?>
    <div class="data"> <?php print content_format('field_size_of_printed_map', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_copies_printed_0', $field_copies_printed_0[0]) > '') : ?>
 <div class="item">
  <div>
      <label title="Copies Printed/Estimated Downloads"><?php print t('Copies'); ?>:</label>
    </div>
  <?php foreach ($field_copies_printed_0 as $item) { ?>
    <div class="data"> <?php print content_format('field_copies_printed_0', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_printing_choices', $field_printing_choices[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Printing'); ?>:</label></div>
  <?php foreach ($field_printing_choices as $item) { ?>
    <div class="data"> <?php print content_format('field_printing_choices', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_number_of_editions_0', $field_number_of_editions_0[0]) > '') : ?>
 <div class="item">
  <div>
      <label><?php print t('Editions'); ?>:</label>
    </div>
  <?php foreach ($field_number_of_editions_0 as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_editions_0', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_number_of_green_sites', $field_number_of_green_sites[0]) > '0') : ?>
 <div class="item">
  <div>
      <label><?php print t('Green Sites'); ?>:</label>
    </div>
  <?php foreach ($field_number_of_green_sites as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_green_sites', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_number_of_green_map_icons', $field_number_of_green_map_icons[0]) > '0') : ?>
 <div class="item">
  <div>
      <label><?php print t('Icons'); ?>:</label>
    </div>
  <?php foreach ($field_number_of_green_map_icons as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_green_map_icons', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_were_locally_designed_ico', $field_were_locally_designed_ico[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Local Icons'); ?>:</label></div>
  <?php foreach ($field_were_locally_designed_ico as $item) { ?>
    <div class="data"> <?php print content_format('field_were_locally_designed_ico', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_image_of_local_icons', $field_image_of_local_icons[0]) > '') : ?>

    <?php foreach ((array)$field_image_of_local_icons as $item) { 
	  if ($item['filepath'] != '') {
		  ?>
		  <?php print content_format('field_image_of_local_icons', $item) ?>
		  <?php 
		  }
      } ?>

<?php endif; ?>


</fieldset>
<?php } ?>



<?php if ((content_format('field_other_ways_to_get_this_ma', $field_other_ways_to_get_this_ma[0]) > '') ||
		(content_format('field_pdf_of_map', $field_pdf_of_map[0]) > '') ||
		(content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') ||
		(content_format('field_more_details_of_how_to_ge', $field_more_details_of_how_to_ge[0]) > '') ||
		(content_format('field_cost_per_map_0', $field_cost_per_map_0[0]) > '') 
		) : ?>

<fieldset class="collapsible collapsed"><legend><?php print t('How to Get the Map'); ?></legend>



<?php if (content_format('field_other_ways_to_get_this_ma', $field_other_ways_to_get_this_ma[0]) > '') : ?>
 <div class="item">
  <div><label>Get This Map:</label></div>
  <?php foreach ($field_other_ways_to_get_this_ma as $item) { ?>
    <div class="data"> <?php print content_format('field_other_ways_to_get_this_ma', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>




<?php if ($field_pdf_of_map[0]['fid']) : ?>
 <div class="item">
  <div>
      <label><?php print t('Download PDF'); ?>:</label>
    </div>
  <?php foreach ($field_pdf_of_map as $item) { ?>
    <div class="data"><a href="<?php // print base_path() . $item['filepath']; ?><?php print file_create_url($item['filepath']); ?>" target="_blank"><?php print file_create_url($item['filepath']); ?></a> <?php print size_hum_read($item['filesize']) ?></div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') : ?>
 <div class="item">
  <div><label>Online Map</label></div>
  <?php foreach ($field_link_to_online_map as $item) { ?>
	<?php $item = trim_url($item) ?>
    <div class="data"> <?php print content_format('field_link_to_online_map', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>






<?php if (content_format('field_more_details_of_how_to_ge', $field_more_details_of_how_to_ge[0]) > '') : ?>
 <div class="item">
  <div><label>Details:</label></div>
  <?php foreach ($field_more_details_of_how_to_ge as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_more_details_of_how_to_ge', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_cost_per_map_0', $field_cost_per_map_0[0]) > '') : ?>
 <div class="item">
  <div><label>Cost:</label></div>
  <?php foreach ($field_cost_per_map_0 as $item) { ?>
    <div class="data"> <?php print content_format('field_cost_per_map_0', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


</fieldset>
<?php endif; ?>


<?php if (
		(content_format('field_awards', $field_awards[0]) > '') ||
		(content_format('field_press', $field_press[0]) > '') ||
		(content_format('field_outcomes_on_community', $field_outcomes_on_community[0]) > '') ||
		(content_format('field_training__experience_gain', $field_training__experience_gain[0]) > '') ||
		(content_format('field_spin_offs', $field_spin_offs[0]) > '') ||
		(content_format('field_links_to_other_resources', $field_links_to_other_resources[0]) > '') ||
		(content_format('field_link_to_other_resources', $field_link_to_other_resources[0]) > '') ||
		(content_format('field_support_to_other_green_ma', $field_support_to_other_green_ma[0]) > '') ||
		(content_format('field_wishlist', $field_wishlist[0]) > '')		
		) : ?>
		
<fieldset class="collapsible collapsed"><legend>Results and Impacts</legend>




<?php if (content_format('field_awards', $field_awards[0]) > '') : ?>
 <div class="item">
  <div><label>Awards:</label></div>
  <?php foreach ($field_awards as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_awards', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_press', $field_press[0]) > '') : ?>
 <div class="item">
  <div><label>Press Coverage:</label></div>
  <?php foreach ($field_press as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_press', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_outcomes_on_community', $field_outcomes_on_community[0]) > '') : ?>
 <div class="item">
  <div><label title="Outcomes on Community">Community Outcomes:</label></div>
  <?php foreach ($field_outcomes_on_community as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_outcomes_on_community', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_training__experience_gain', $field_training__experience_gain[0]) > '') : ?>
 <div class="item">
  <div><label title="Training and Experience Gained">Experience:</label></div>
  <?php foreach ($field_training__experience_gain as $item) { ?>
    <div class="data"> <?php print content_format('field_training__experience_gain', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_spin_offs', $field_spin_offs[0]) > '') : ?>
 <div class="item">
  <div><label title="Spin Offs from this Green Map">Spin Offs:</label></div>
  <?php foreach ($field_spin_offs as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_spin_offs', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_links_to_other_resources', $field_links_to_other_resources[0]) > '') : ?>
 <div class="item">
  <div><label>Resources:</label></div>
  <?php foreach ($field_links_to_other_resources as $item) { ?>
	<?php $item = trim_url($item) ?>
    <div class="data"> <?php print content_format('field_links_to_other_resources', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_link_to_other_resources', $field_link_to_other_resources[0]) > '') : ?>
 <div class="item">
  <div><label>Resources:</label></div>
  <?php foreach ($field_link_to_other_resources as $item) { ?>
	<?php $item = trim_url($item) ?>
    <div class="data"> <?php print content_format('field_link_to_other_resources', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_support_to_other_green_ma', $field_support_to_other_green_ma[0]) > '') : ?>
 <div class="item">
  <div><label title="Support to Other Green Maps">Support:</label></div>
  <?php foreach ($field_support_to_other_green_ma as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_support_to_other_green_ma', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_wishlist', $field_wishlist[0]) > '') : ?>
 <div class="item">
  <div><label>Wishlist:</label></div>
  <?php foreach ($field_wishlist as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_wishlist', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



</fieldset>
<?php endif; ?>





<?php if ((content_format('field_press_release', $field_press_release[0]) > '') || (content_format('field_available_to_press', $field_available_to_press[0]) > '') || 
	(content_format('field_high_resolution_image', $field_high_resolution_image[0]) > '')  
	){ ?>
<fieldset class="collapsible collapsed"><legend>Press Resources</legend>
<?php if (content_format('field_available_to_press', $field_available_to_press[0]) > '') : ?>
 <div class="item">
  <div><label>Press Info:</label></div>
  <?php foreach ($field_available_to_press as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_available_to_press', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_press_release', $field_press_release[0]) > '') : ?>
 <div class="item">
  <div>
      <label>Press Release:</label>
    </div>
  <?php foreach ($field_press_release as $item) { ?>
    <div class="data"> <?php print content_format('field_press_release', $item) ?> <?php print size_hum_read($item['filesize']) ?></div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_high_resolution_image', $field_high_resolution_image[0]) > '') : ?>
 <div class="item">
  <div>
      <label>Hi-Res Image:</label>
    </div>
  <?php foreach ($field_high_resolution_image as $item) { ?>
    <div class="data"> <a href="<?php print base_path() . $item['filepath'] ?>" target="_blank">Download Image</a>
	<?php print size_hum_read($item['filesize']) ?>  </div>
  <?php } ?>
 </div>
<?php endif; ?>



</fieldset>
<?php } ?>





<fieldset class="collapsible collapsed"><legend>Other Map Information</legend>


<?php if (content_format('field_how_was_this_map_made', $field_how_was_this_map_made[0]) > '') : ?>
 <div class="item">
  <div><label>Mapmaking:</label></div>
  <?php foreach ($field_how_was_this_map_made as $item) { ?>
    <div class="data"> <?php print content_format('field_how_was_this_map_made', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_more_details_of_how_map_w', $field_more_details_of_how_map_w[0]) > '') : ?>
 <div class="item">
  <div><label>&nbsp;</label></div>
  <?php foreach ($field_more_details_of_how_map_w as $item) { ?>
    <div class="data"> <?php print content_format('field_more_details_of_how_map_w', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_participation', $field_participation[0]) > '') : ?>
 <div class="item">
  <div><label>Participation:</label></div>
  <?php foreach ($field_participation as $item) { ?>
    <div class="data"> <?php print content_format('field_participation', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_more_details_of_participa', $field_more_details_of_participa[0]) > '') : ?>
 <div class="item">
  <div><label>&nbsp;</label></div>
  <?php foreach ($field_more_details_of_participa as $item) { ?>
    <div class="data"> <?php print content_format('field_more_details_of_participa', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_number_of_people_involved', $field_number_of_people_involved[0]) > '' && content_format('field_number_of_people_involved', $field_number_of_people_involved[0]) > 0) : ?>
 <div class="item">
  <div><label>People:</label></div>
  <?php foreach ($field_number_of_people_involved as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_people_involved', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_number_of_paid_staffconsu', $field_number_of_paid_staffconsu[0]) > '') : ?>
 <div class="item">
  <div><label title="Number of paid staff or consultants">Paid Staff:</label></div>
  <?php foreach ($field_number_of_paid_staffconsu as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_paid_staffconsu', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_number_of_people_involv_0', $field_number_of_people_involv_0[0]) > '') : ?>
 <div class="item">
  <div><label title="People involved under 18 years old">Under 18:</label></div>
  <?php foreach ($field_number_of_people_involv_0 as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_people_involv_0', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_number_of_people_involv_1', $field_number_of_people_involv_1[0]) > '') : ?>
 <div class="item">
  <div><label title="People involved over 60 years old">Over 60:</label></div>
  <?php foreach ($field_number_of_people_involv_1 as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_people_involv_1', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_number_of_direct_jobs_cre', $field_number_of_direct_jobs_cre[0]) > '') : ?>
 <div class="item">
  <div><label title="Jobs Created">Jobs:</label></div>
  <?php foreach ($field_number_of_direct_jobs_cre as $item) { ?>
    <div class="data"> <?php print content_format('field_number_of_direct_jobs_cre', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_key_people', $field_key_people[0]) > '') : ?>
 <div class="item">
  <div><label>Key People:</label></div>
  <?php foreach ($field_key_people as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_key_people', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_unique_fact', $field_unique_fact[0]) > '') : ?>
 <div class="item">
  <div><label>Unique Fact:</label></div>
  <?php foreach ($field_unique_fact as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_unique_fact', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_quote', $field_quote[0]) > '') : ?>
 <div class="item">
  <div><label>Quote:</label></div>
  <?php foreach ($field_quote as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_quote', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_links_to_other_gms_pages_', $field_links_to_other_gms_pages_[0]) > '') : ?>
 <div class="item">
  <div><label>Links:</label></div>
  <?php foreach ($field_links_to_other_gms_pages_ as $item) { ?>
	<?php $item = trim_url($item) ?>
    <div class="data"> <?php print content_format('field_links_to_other_gms_pages_', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_software_used', $field_software_used[0]) > '') : ?>
 <div class="item">
  <div><label>Software:</label></div>
  <?php foreach ($field_software_used as $item) { ?>
    <div class="data"> <?php print content_format('field_software_used', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_other_software_used', $field_other_software_used[0]) > '') : ?>
 <div class="item">
  <div><label>Other:</label></div>
  <?php foreach ($field_other_software_used as $item) { ?>
    <div class="data"> <?php print content_format('field_other_software_used', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_software_used_and_why', $field_software_used_and_why[0]) > '') : ?>
 <div class="item">
  <div><label>Why Used:</label></div>
  <?php foreach ($field_software_used_and_why as $item) { ?>
    <div class="data"> <?php print content_format('field_software_used_and_why', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>




<?php if (content_format('field_hardware_used', $field_hardware_used[0]) > '') : ?>
 <div class="item">
  <div><label>Hardware:</label></div>
  <?php foreach ($field_hardware_used as $item) { ?>
    <div class="data"> <?php print content_format('field_hardware_used', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_other_hardware_used', $field_other_hardware_used[0]) > '') : ?>
 <div class="item">
  <div><label>Other:</label></div>
  <?php foreach ($field_other_hardware_used as $item) { ?>
    <div class="data"> <?php print content_format('field_other_hardware_used', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_map_projection', $field_map_projection[0]) > '') : ?>
 <div class="item">
  <div><label>Base Map:</label></div>
  <?php foreach ($field_map_projection as $item) { ?>
    <div class="data"> <?php print content_format('field_map_projection', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_map_projection_0', $field_map_projection_0[0]) > '') : ?>
 <div class="item">
  <div><label>Projection:</label></div>
  <?php foreach ($field_map_projection_0 as $item) { ?>
  	<?php if (content_format('field_map_projection_0', $item) != 'Other') { ?>
    	<div class="data"> <?php print content_format('field_map_projection_0', $item) ?> </div>
	<?php } ?>
	<?php if (content_format('field_map_projection_0', $item) == 'Other') { ?>
			<?php if (content_format('field_other_map_projection', $field_other_map_projection[0]) > '') : ?>
			  <?php foreach ($field_other_map_projection as $item) { ?>
				<div class="data"> <?php print content_format('field_other_map_projection', $item) ?> </div>
			  <?php } ?>
			<?php endif; ?>
	<?php } ?>
  <?php } ?>
 </div>
<?php endif; ?>



</fieldset>




<?php $approved_roles = array('admin user', 'authenticated user'); ?>
<?php  if (count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) { ?>
<fieldset class="collapsible collapsed"><legend>Information For Other Mapmakers</legend>
<?php $information = 0; ?>

<?php if (content_format('field_weaknesses', $field_weaknesses[0]) > '') : ?>
<?php $information ++; ?>
 <div class="item">
  <div><label>Weaknesses:</label></div>
  <?php foreach ($field_weaknesses as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_weaknesses', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_your_funding_experience', $field_your_funding_experience[0]) > '') : ?>
<?php $information ++; ?>
 <div class="item">
  <div><label>Funding:</label></div>
  <?php foreach ($field_your_funding_experience as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_your_funding_experience', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>

<?php if (content_format('field_actual_cost_per_map_if_kn', $field_actual_cost_per_map_if_kn[0]) > '') : ?>
<?php $information ++; ?>
 <div class="item">
  <div><label>Cost/Map:</label></div>
  <?php foreach ($field_actual_cost_per_map_if_kn as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_actual_cost_per_map_if_kn', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>


<?php if (content_format('field_advice_to_mapmakers', $field_advice_to_mapmakers[0]) > '') : ?>
<?php $information ++; ?>
 <div class="item">
  <div><label>Advice:</label></div>
  <?php foreach ($field_advice_to_mapmakers as $item) { ?>
    <div class="data"> <?php print check_markup(content_format('field_advice_to_mapmakers', $item)) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



<?php // insert add/edit link if this person is allowed to do so ?>
<?php if ($allowed_editor && ($information == 0)) { ?>
	<div class="item mapmakersbg">
		<?php $url = 'node/' . $nid . '/edit'; ?>
		<?php $attributes = array("class" => "mapmakers"); ?>
		<?php print t('You have not added any advice for other mapmakers. This information is really appreciated, so please take some time to share your experience.'); ?>
		 <?php print l(t('Add some advice for other Mapmakers'),$url,$attributes); ?>
	</div>

<?php } ?>



</fieldset>
<?php }?>


<?php if (content_format('field_1_local_language_overview', $field_1_local_language_overview[0]) > '') : ?>
<fieldset class="collapsible collapsed"><legend>Local Language Overview</legend>

  <?php foreach ($field_1_local_language_overview as $item) { ?>
    <?php print check_markup(content_format('field_1_local_language_overview', $item)) ?>
  <?php } ?>

</fieldset>
<?php endif; ?>


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
