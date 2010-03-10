<!--node-content_map.tpl.php-->


<?php
drupal_add_js('misc/collapse.js');

?>



<?php
$author = user_load(array('uid' => $node->uid));
global $base_path;


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

 <div class="item">
  <div><label><?php print t('Themes'); ?>:</label></div>
    <div class="data"> <p><?php print $terms; ?></p></div>
 </div>

</fieldset>

<?php
}
// if it's not a teaser, then show full page ----------------------------------
else {

$allowed_editor = FALSE;
if ((user_access('administer users') || $GLOBALS['user']->uid == $node->uid)) {
  $allowed_editor = TRUE;
}

?>


<div id="top">
 <div class="item">
    <div class="data"> <?php print "by" ?> <?php print $name ?>
     </div>
 </div>
</div>

<div id="leftmap">


<!-- > MAP IMAGE (PROBABLY-CHECK) -->
<div id="map_img">
<legend><?php print t('    '); ?></legend>
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
</div>


<!-- > (HOW TO) GET THIS MAP -->

<?php if ((content_format('field_other_ways_to_get_this_ma', $field_other_ways_to_get_this_ma[0]) > '') ||
    (content_format('field_pdf_of_map', $field_pdf_of_map[0]) > '') ||
    (content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') ||
    (content_format('field_more_details_of_how_to_ge', $field_more_details_of_how_to_ge[0]) > '') ||
    (content_format('field_cost_per_map_0', $field_cost_per_map_0[0]) > '')
    ) : ?>

<fieldset class="get_this_map"><legend><?php print t('Get this Map'); ?></legend>

 <div id="getmap_space">

<?php if ($field_pdf_of_map[0]['fid']) : ?>
 <div class="item">

  <?php foreach ($field_pdf_of_map as $item) { ?>
    <a href="<?php print file_create_url($item['filepath']); ?>" target="_blank"><?php print t('Download Here'); ?></a>

    
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') : ?>
 <div class="item">

  <?php foreach ($field_link_to_online_map as $item) { ?>
 
	<?php 
	//print content_format('field_link_to_online_map', $item) 
	?>
	<? print l(t('View Online'), $item['url']);?>
                
  <?php } ?>
 </div>
<?php endif; ?>



<?php if (content_format('field_your_website_about_this_m', $field_your_website_about_this_m[0]) > '') : ?>

 <div class="item">
 
   <?php foreach ($field_your_website_about_this_m as $item) { ?>

  <?php 
  //print content_format('field_your_website_about_this_m', $item);
  print l(t('Website'), $item['url']);
   ?>
  
  <?php } ?>
 </div>
<?php endif; ?>

</div>
<?php if (  !(content_format('field_pdf_of_map', $field_pdf_of_map[0]) > '') &&
    !(content_format('field_link_to_online_map', $field_link_to_online_map[0]) > '') ) : // print a message if the map's not available yet ?>
 <div class="item">
  <div>
      <label><?php print t('Availability'); ?>:</label>
    </div>
  <?php print t('This map is not available for download yet'); ?>
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


<!-- > INTRODUCTION -->

<?php if (content_format('field_taglineslogan', $field_taglineslogan[0]) > '') : ?>
 <fieldset>
  <legend><?php print t('Introduction'); ?></legend>
  <?php foreach ($field_taglineslogan as $item) { ?>
    <div class="data"> <?php print content_format('field_taglineslogan', $item) ?> </div>
  <?php } ?>
<?php endif; ?>
</fieldset>


<!-- > ABOUT THIS MAP -->

<?php if (content_format('field_about_this_map', $field_about_this_map[0]) > '') { ?>
<fieldset>
<legend><?php print t('About this Map'); ?></legend>
  <?php foreach ($field_about_this_map as $item) { ?>
    <div class="scrollbar"><?php print check_markup(content_format('field_about_this_map', $item)) ?></div>
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
  <fieldset><legend><?php print t('About this Map'); ?></legend>
  <div class="item mapmakersbg">
    <?php $url = 'node/' . $nid . '/edit'; ?>
    <?php $attributes = array("class" => "mapmakers"); ?>
    <?php print l(t('Add a description of this Green Map'),$url,$attributes); ?>
  </div>
  </fieldset>
<?php } ?>


<!-- > COMMUNITY OUTCOMES -->

<?php if (content_format('field_outcomes_on_community', $field_outcomes_on_community[0]) > '') : ?>
<fieldset>

<legend><?php print t('Community Outcomes'); ?></legend>
  <?php foreach ($field_outcomes_on_community as $item) { ?>
    <div class="scrollbarshort"> <?php print check_markup(content_format('field_outcomes_on_community', $item)) ?>
  <?php } ?>
 </div></fieldset>
<?php endif; ?>



<!-- > RESULTS AND IMPACTS -->

<?php if (
    (content_format('field_awards', $field_awards[0]) > '') ||
    (content_format('field_press', $field_press[0]) > '') ||
    (content_format('field_training__experience_gain', $field_training__experience_gain[0]) > '') ||
    (content_format('field_spin_offs', $field_spin_offs[0]) > '') ||
    (content_format('field_links_to_other_resources', $field_links_to_other_resources[0]) > '') ||
    (content_format('field_link_to_other_resources', $field_link_to_other_resources[0]) > '') ||
    (content_format('field_support_to_other_green_ma', $field_support_to_other_green_ma[0]) > '') ||
    (content_format('field_wishlist', $field_wishlist[0]) > '')
    ) : ?>

<fieldset class="collapsible collapsed"><legend>Impacts and Results</legend>

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


<!-- > PUBLICATION INFORMATION -->

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


<!-- > PRESS RESOURCES -->


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



<!-- > OTHER MAP INFORMATION 2 -->

<fieldset class="collapsible collapsed"><legend>Other Map Information</legend>

<?php if (content_format('field_publishing_status', $field_publishing_status[0]) > '') : ?>
 <div class="item">
  <div><label><?php print t('Status'); ?>:</label></div>
  <?php foreach ($field_publishing_status as $item) { ?>
    <div class="data"> <?php print content_format('field_publishing_status', $item) ?> </div>
  <?php } ?>
 </div>
<?php endif; ?>



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


<!-- > INFORMATION FOR OTHER MAPMAKERS -->

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



<!-- > LOCAL LANGUAGE OVERVIEW -->


<?php if (content_format('field_1_local_language_overview', $field_1_local_language_overview[0]) > '') : ?>
<fieldset class="collapsible collapsed"><legend>Local Language Overview</legend>

  <?php foreach ($field_1_local_language_overview as $item) { ?>
    <?php print check_markup(content_format('field_1_local_language_overview', $item)) ?>
  <?php } ?>

</fieldset>
<?php endif; ?>



</div> <!-- > End of LEFTMAP -->


<!-- > RIGHTMAP -->

<div id="rightmap">



<?php // insert add/edit link if this person is allowed to do so ?>
<?php if ($allowed_editor) { ?>
    <fieldset>
    <?php $url = 'node/' . $nid . '/edit'; ?>
    <?php $attributes = array("class" => "mapmakers"); ?>
    <?php print l(t('Edit Map Profile'),$url,$attributes); ?>
    </fieldset>

<?php } ?>



<!-- > NO LONGER ACTIVE PROJECT -->


<?php if($lapsed){ ?>

  <fieldset class="collapsible required"><legend><?php print t('No Longer an Active Project'); ?></legend>
    <div class="required">
      <?php print t('This is no longer an active project. If you would like to start a Green Map project in this community, please go to the %link section of the website and register.', array('%link' => l(t('Participate'),'participate'))) ; ?>
    </div>
  </fieldset>

<?php } ?>




<!-- > MORE MAPS BY MAPMAKER -->

<?php 
// print a list of all the mapmaker's other maps by inserting a view
// show all the maps for this user by inserting a view 'maps_list_user'

  global $maplist_view;
  $currentnid=$node->nid; // get nid for current map


  $maplist_view->args[0]=$node->uid;  // pass uid as argument
  $maplist_view->args[1]=$currentnid; // pass current nid to exclude current map from list
  $viewmaplist = views_get_view('maps_list_user');
  
  $maplist = views_build_view('embed', $viewmaplist, $maplist_view->args, false, false);

  $rows = array();
  $output = '';
  $ogm_maps = sync_fetch_ogm_maps($node->uid);
  
  
  
  if (is_array($ogm_maps) && count($ogm_maps)) {
    
    foreach ($ogm_maps as $ogm_map) {
      $rows[] = l($ogm_map->title, 'http://www.opengreenmap.org/'. $ogm_map->alias,
          array('class' => 'external', 'target' => '_blank'));
    }
    $output = theme_item_list($rows);
    $output = '<div class="plain-list ogm-maps">'.$output.'</div>';
  }
  
  
  if ($maplist > '' || $output) { ?>
      <fieldset><legend><?php print t('More Maps by ') . $node->name; ?></legend>
      
      <div class="plain-list">
      <?php if ($output){ print "Open Green Maps";print $output; } ?>
      <?php if ($maplist){ print "Green Maps";print $maplist; } ?>
      
      </div>
    </fieldset>
  <?php }
  

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


<!-- > SEE MAPMAKER PROFILE -->

<?php if (content_format('field_outcomes_on_community', $field_outcomes_on_community[0]) > '') : ?>
<fieldset>

<legend><?php print t('See Mapmaker Profile'); ?></legend>

<div class="link_to_profile">
<?php 
$user_profile = user_load(array('uid'=>$node->uid));
print theme('user_picture', $user_profile);
?>
</div>

</fieldset>
<?php endif; ?>




<!-- > LOCATION MAP -->



<?php
  $latitude = $locations[0]['latitude'];
  $longitude = $locations[0]['longitude'];
?>

<?php if ((($latitude > '') && ($longitude > '')) || $allowed_editor) : ?>
<fieldset><legend><?php print t('Location'); ?></legend>

  <div class="data">
  <?php print check_plain($author->profile_project_area_local) . " -"?>
  <?php print check_plain($author->profile_state) . " -"?>
  <?php print check_plain($author->profile_project_country) . " -" ?>

   
  <?php if($author->profile_project_continent) { ?>
<?php
$dictc = array(
 'Africa' => 'maps/list/continent/africa',
 'Europe' => 'maps/list/continent/europe',
 'Latin America' => 'maps/list/continent/latin america',
 'North America' => 'maps/list/continent/north america',
 'Oceania' => 'maps/list/continent/oceania',
 );
?>


   <?php print l(check_plain(ucwords(check_plain($author->profile_project_continent))),
           $dictc[$author->profile_project_continent]);
   ?>
<?php }?>
</div>



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





<!-- > TAXONOMY -->
<fieldset>
<legend><?php print t('Related Maps by Theme'); ?></legend>
   <div class="theme-list"> <?php
      if ($taxonomy) {
        print $terms;
      } ?></div>
<?php
} ?>
</fieldset>



<div class="links">
	<?php print $links; ?>
</div>

    <?php
	    if ($submitted) {
	    print '<div class="styledbox postinfo">';
//	    	if ($submitted) { print $submitted; }  changed this to remove time from submitted by information - TT - 14th March 2007
			if ($submitted) {
				print  t('Submitted by') . '&nbsp;' . theme('username', $node) . '&nbsp;' . t('on') . '&nbsp;' . format_date($node->created, 'custom', 'jS M Y') . '&nbsp;' . $rss;
			}
	    print '</div>';
	    } ?>		



<!--[if IE 6]>
	<style type="text/css">
#content {
	margin-top: -15px !important;
	width:870px;
	left: 0;
	}
	
#rightmap {
	margin-top: 0px !important;
}	
	</style>
<![endif]-->
	
<!--[if IE 7]>
	<style type="text/css">
#content {
margin-left: -150px !important;
	}
	
#rightmap {
	margin-top: 0px !important;
	}
	</style>
<![endif]-->

<style type="text/css">


#content fieldset{
  border: none;
}


#top{
  margin-left: -92px;
  margin-top: -16px;
}

#content h1 {
  margin-left: 34px;
  margin-top: -3px;
}

#content legend {
  font-size: 15px;
  margin-left: -3px;
}

#content {
	background-color:transparent;
	color: #4D4D4D;
	line-height: 1.5em;
	height: auto;
	font-size: 11.5px;
	margin-left: 40px;
	margin-top: 6px;
	padding-top: 25px;
	position: absolute;
	width: 75%;
	min-width: 830px;
	float: left;
	background-image: url("<?php print $base_path ?>images/map_icon.gif");
	background-repeat: no-repeat;
	background-position: 9px 20px; 
}	

#rightmap {
    margin-top: 10px;
}

html.js fieldset.collapsible, html.js fieldset.fakecollapsible {
  border: none;
}


#content p a:hover, #content div.data a:hover, a:hover{
  color: #2E67B1;
  text-decoration: underline;
}

.plain-list ul li {
  list-style-image: url("<?php print $base_path ?>images/list.gif");
  margin: 0 0 0.15em;
  padding: 1px 0;
}

.plain-list ul {
	margin-left: 13px;
}


#content .item-list ul li {
 
  margin-left: -1px;
}

#content .theme-list ul li {
  list-style: none;
  margin-left: -40px;
}

#content p a, #content div.data a, a {
  font-size: 11.5px;
  font-weight: normal;
  text-decoration: none;
  color: #2E67B1;
}

ul.primary {
  border-collapse: collapse;
  display: none;
  padding: 0 0 0 1em;
  white-space: nowrap;
  list-style: none;
  margin: 0 0 15px -160px;
  height: auto;
  line-height: normal;
  border-bottom: 1px solid #F78F1E;
}

#content .scrollbar {
  width: 470px;
  height: 110px;
  overflow: auto;
  padding: 5px;
  border: solid 1px #999;
}

#content #map_img {
	margin-top: 5px;
	margin-bottom: 20px;
	margin-left: 60px;
}

#content fieldset.get_this_map .item a{
  font-size: 14px;
  font-weight: bolder;
  text-decoration: none;
  color: #2E67B1;
}

#content fieldset.get_this_map .item a:hover{
  font-size: 14px;
  font-weight: bolder;
  text-decoration: underline;
  color: #2E67B1;
}

#content .scrollbarshort {
  width: 470px;
  height: 60px;
  overflow: auto;
  padding: 5px;
  border: solid 1px #999;
}

#content .link_to_profile {
	float: left;
	*float: none;
	_float: none;
}

#getmap_space {
	margin-bottom: 18px;
}

#footer_gh {
visibility: hidden;
}

</style>
<!--/node-content_map.tpl.php-->
