<!--node-content_map_add.tpl.php-->
<p>Step 1: Complete this form for each Green Map you create. It's the basic information needed to introduce your map to the public. </p>

<p>Step 2: Provide more information about your Map. Once you have submitted this form just click 'Edit' at the top of the Map's page.  </p>


<div id="maptitle"><?php print form_render($form['title']); ?></div>

<div id="maptaxonomy"><?php print form_render($form['taxonomy']['3']); ?></div>

<?php  $form['locations']['#title'] = t('Click on the map to set your location'); ?>
<div id="maplocations"><?php print form_render($form['locations']); ?></div>

<?php  $form['group_map_information']['field_taglineslogan']['0']['value']['#title'] = 'Map Introduction'; ?>
<div id="mapsentence"><?php print form_render($form['group_map_information']['field_taglineslogan']['0']['value']); ?></div>

<?php  $form['group_map_information']['field_about_this_map']['0']['value']['#title'] = 'About this Green Map'; ?>
<div id="mapabout"><?php print form_render($form['group_map_information']['field_about_this_map']['0']['value']); ?></div>

<?php  $form['group_map_information']['field_publishing_status']['key']['#title'] = 'Publication Status'; ?>
<div id="mapstatus"><?php print form_render($form['group_map_information']['field_publishing_status']); ?></div>

<?php  $form['group_map_information']['field_start_date']['0']['value']['#title'] = 'Map Start Date'; ?>
<div id="mapstartdate"><?php print form_render($form['group_map_information']['field_start_date']); ?></div>

<?php  $form['group_publication_information']['field_main_map_image']['#title'] = 'Image'; ?>
<div id="mapstartdate"><?php print form_render($form['group_publication_information']['field_main_map_image']); ?></div>

<div id="buttons"><?php print form_render($form['submit']); ?></div>


<?php // print_r(array_values($form)) // uncomment this line if need to see all variables ?>

<div id="hiddenbitsofform" class="hide"><?php print form_render($form); ?> </div>
<!--/node-content_map_add.tpl.php-->
