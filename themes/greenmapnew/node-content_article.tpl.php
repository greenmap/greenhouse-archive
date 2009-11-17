<!--node-content_article.tpl.php-->
<?php 
// if viewing teaser show limited info.
if ($teaser) {

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
	print ' By ' . $field_author[0]['value']; 
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

if ($taxonomy) { print '(' . $terms . ')'; }

print '<br />';

?>

 




<?php 
}
// if it's not a teaser, then show full page ------------------------------------------------------
else {






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
	print ' By ' . $field_author[0]['value']; 
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

if ($taxonomy) { print '(' . $terms . ')'; }

print '<br />';

// end else, for showing full page view.
}
?>
<!--/node-content_article.tpl.php-->
