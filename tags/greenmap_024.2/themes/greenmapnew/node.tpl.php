<style type="text/css">
#desktophide {display: none !important;}
</style>

<!--node.tpl.php-->
  <div class="node<?php if ($sticky) { print " sticky"; } ?>">
    <?php if ($picture) {
      print $picture;
    }?>
    <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
    <div class="content"><?php print $content?></div>
	  <div class="links">
	  	<?php print $links; ?>
	  </div>
    <?php
	    $rss = '<a class="rss" href="'.base_path().'blog/' . $uid . '/feed" title="subscribe to this users blog">RSS</a>';
		
		if (($submitted) || ($taxonomy)) {
	    print '<div class="styledbox postinfo">';
	    	if ($taxonomy) { print $terms; }
//	    	if ($submitted) { print $submitted; }  changed this to remove time from submitted by information - TT - 14th March 2007
			if ($submitted) {
				print  t('Submitted by') . '&nbsp;' . theme('username', $node) . '&nbsp;' . t('on') . '&nbsp;' . format_date($node->created, 'custom', 'jS M Y') . '&nbsp;' . $rss;
			}
	    print '</div>';
	    } ?>
	 </div>
<!--/node.tpl.php-->
