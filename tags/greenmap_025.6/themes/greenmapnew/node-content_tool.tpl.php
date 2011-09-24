<!--node-content_tool.tpl.php-->


<?php
drupal_add_js('misc/collapse.js');


?>

<?php 
// if viewing teaser show limited info.
if ($teaser) {
?><fieldset><legend class="toollegend">
<?php $check_official = check_official_gms($node->uid) ; //
if($check_official) { ?>
	<img class="gmsicon" src="<?php print base_path(); ?>/misc/GMS_icon.gif" width="15" height="15" alt="Official Green Map System tool" />
<?php } ?>
	<a href="<?php print $node_url ?>"><?php print $title ?></a></legend>

<?php 
 // Load author details
$author = user_load(array('uid' => $node->uid));
?>


 
<?php print $field_thumbnail_of_the_resource[0]['view'] ?>

<?php if (content_format('field_description_of_tool', $field_description_of_tool[0]) > '') : ?>
 <div class="item">
  <?php foreach ($field_description_of_tool as $item) { ?>
    <?php print content_format('field_description_of_tool', $item) ?>
  <?php } ?>
<?php endif; ?>

 <div class="item">
  Created by: <?php print $name ?> 
 </div>
 
</fieldset>

<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {
// limit viewing of this page to logged in users
$approved_roles = array('admin user', 'authenticated user');
if (count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0 ) {
	?>
	
	
	
	<?php print $field_thumbnail_of_the_resource[0]['view'] ?>
	
	
	<div class="field field-type-text field-field-description-of-tool">  <div class="field-items">  <?php print $field_description_of_tool[0]['value'] ?> </div></div><br />
	
	
	<?php if (content_format('field_tool_file', $field_tool_file[0]) > '') : ?> 
		<div class="item">  <dt><label class="download">Download File:</label></dt>  
		<?php foreach ($field_tool_file as $item) { ?>    
			<dd> <?php print content_format('field_tool_file', $item) ?> </dd>  
		<?php } ?> </div><br />
	<?php endif; ?>
	
	<?php if (content_format('field_link_to_tool', $field_link_to_tool[0]) > '') : ?> 
		<div class="item">  <dt><label>Link to Tool:</label></dt>  
		<?php foreach ($field_link_to_tool as $item) { ?> 
		   <dd> <?php print content_format('field_link_to_tool', $item) ?> </dd>  
		<?php } ?> </div><br />
	<?php endif; ?>
	
	<div class="field field-type-text field-field-code-to-embed-youtube-vid">  <div class="field-items">  
		<?php print $field_code_to_embed_youtube_vid[0]['value'] ?> 
	</div></div><br />
	
	
	
	
	
		
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
	// end viewing tool for logged in
} else {
	// show access denied message for non-logged in
	print t('Access denied') . ' - ' . l(t('please log in to access this tool'),'user/login');

	// end access denied for non logged in
}
// end else, for showing full page view.
}
?>
<!--/node-content_tool.tpl.php-->
