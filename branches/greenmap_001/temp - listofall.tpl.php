<?php  // do query to get all maps associated with user
$result = db_query("
								SELECT u.uid, u.name, m.uid, m.type, m.title, ncm.nid
								From users u
									LEFT JOIN node m on u.uid = m.uid
									LEFT JOIN node_content_map ncm on m.nid = ncm.nid
								ORDER BY u.name, ncm.vid DESC
								LIMIT 200
							"); 
	$number = mysql_numrows($result); 
	print 'number: ' . $number;
	$i = 0; // used to loop through all the users and maps from teh database query
	$current_user = mysql_result($result,0,"u.name"); // set the first fieldset to be the first result
	
	?><fieldset class="collapsible"><legend><?php print $current_user; ?></legend><div><?php // open first fieldset 
	
	while($number > $i){
	
		$user_title = mysql_result($result,$i,"u.name"); // user node title (their name)
		$map_title = mysql_result($result,$i,"m.title"); // tool title
		$user_uid = mysql_result($result,$i,"u.uid"); // user uid  -  will use for link at some point
		$map_nid = mysql_result($result,$i,"ncm.nid");
		
		if($user_title != $current_user) {
		
			// print tool term in collapsible fieldset ?>
			</div></fieldset>
			<fieldset class="collapsible"><legend><?php print $user_title; ?></legend><div>
			
			<?php $current_user = $user_title; ?>
		<?php }
		// print title of the tool ?>
		<?php if ($map_nid > '' && $current_nid != $map_nid) { 
			print l($map_title, 'node/' . $map_nid) . '<br />' ; 
			$current_nid = $map_nid;
		} ?>
  <?php // end looping row
  $i++;
  }	?>
  </div></fieldset> <?php // close last fieldset ?>
