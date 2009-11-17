<!--node-content_articles.tpl.php-->



<div class="newsarticle">
<?php 
if (content_format('field_link_to_article', $field_link_to_article[0]) > '') { 
	$url = $field_link_to_article[0]['url']; 
}
elseif (content_format('field_pdf_of_article', $field_pdf_of_article[0]) > '') { 
	$url = $field_pdf_of_article[0]['filepath']; 
}


if(isset($url)) {
	print l($title,$url); 
}
else { print $title;
}


if (content_format('field_author', $field_author[0]) > '') { 
	print ' by ' . $field_author[0]['value']; 
}

if (content_format('field_publication_0', $field_publication_0[0]) > '') { 
	print ', ' . $field_publication_0[0]['value']; 
}

if (content_format('field_country', $field_country[0]) > '') { 
	print ', ' . $field_country[0]['value']; 
}

if (content_format('field_date', $field_date[0]) > '') { 
	print ', ' . $field_date[0]['view']; 
}

if ($taxonomy) { print ' (' . $terms . ')'; }


$allowed_editor = FALSE;
if (user_access('administer users')) {
	$allowed_editor = TRUE;
}

if ($allowed_editor) {
	// if page is being viewed by an admin, then print an edit link ?>
	<a href="<?php print $node_url . '/edit' ?>" class="mapmakers" >[Edit]</a> <?php 
} 

print '<br />';

?>

</div> 




<!--/node-content_articles.tpl.php-->
