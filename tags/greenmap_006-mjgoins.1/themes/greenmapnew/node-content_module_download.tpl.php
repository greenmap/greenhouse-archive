<!--node-content_module_download.tpl.php-->


<?php



// check if page has already been viewed. If not then lets give them the modules
$stats = statistics_get($nid);
if($stats['totalcount'] < 1){
	// let's mail it to wendy
	$mailbody = $title . '<br>' . $content . '<br>' . 'http://www.greenmap.org/greenhouse/node/' . $node->nid;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= 'From: Green Map <greenhouse@greenmap.org>' . "\r\n";
	user_mail('web@greenmap.org', 'User requested EEE Module', $mailbody, $headers);
	// let's embed a block 
	$block = module_invoke('block', 'block', 'view', 27);
	print $block['content'];
} else {
	print t('This page has expired. ') . l(t('Please submit a new request.'), 'node/add/content_module_download');

}

// limit viewing of this details to admins
$approved_roles = array('admin user');
if (count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0 ) { ?>
	<div class="content">
		<?php print $content; ?>
	</div>
<?php }

?>
<!--/node-content_module_download.tpl.php-->
