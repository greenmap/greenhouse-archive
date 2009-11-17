<!--node-content_faq.tpl.php-->


<?php 
// if viewing teaser show limited info.
if ($teaser) {

print '<a href="#' . $nid . '">' . $title . '</a>';

print '<br />';

?>

 




<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else { 

	$allowed_editor = FALSE;
	if (user_access('administer users')) {
		$allowed_editor = TRUE;
	}
	
	?>
	
	<div class="faq">
	
	<?php print '<a name="' . $nid . '"></a>';
	
	if($allowed_editor) {
		print '<h2>' . l($title, 'node/' . $nid . '/edit') . '</h2>';
		print '<p>' . l('Edit this FAQ','node/' . $nid . '/edit') . '</p>'; 
	}
	else {
		print '<h2>' . $title . '</h2>';
	}
	
	if (content_format('field_answer', $field_answer[0]) > '') { 
		// print check_markup($field_answer[0]['view']);  // bug - this way of viewing field doesn't show html formats properly
		 print $field_answer[0]['view']; 
		// print content_format('field_answer', $field_answer[0]); // bug - this didn't work except for admins

	} ?>
	
	<p><a href="#top">Back to top</a></p>
	<p>&nbsp;</p>
	</div>

<?php // end else, for showing full page view.
}
?>
<!--/node-content_faq.tpl.php-->
