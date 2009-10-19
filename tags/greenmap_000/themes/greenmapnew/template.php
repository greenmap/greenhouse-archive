<?php

function phptemplate_links($links) {
  if (!is_array($links)) {
    return '';
  }
	$output = '<ul>';
	foreach ($links as $primarylink) {
		$output .= '<li>' . $primarylink . '</li>';
	}
	$output .= '</ul>';
	return $output;
}


/**
* Catch the theme_profile_profile function, and redirect through the template api
*/
function phptemplate_user_profile($user, $fields = array()) {
  // Pass to phptemplate, including translating the parameters to an associative array. The element names are the names that the variables
  // will be assigned within your template.
  /* potential need for other code to extract field info */
return _phptemplate_callback('user_profile', array('user' => $user, 'fields' => $fields));
}



function phptemplate_search_theme_form($form) {
  /**
   * This snippet catches the default searchbox and looks for
   * search-theme-form.tpl.php file in the same folder
   * which has the new layout.
   */
  return _phptemplate_callback('search-theme-form', array('form' => $form));
}


function greenmapnew_regions() {
  return array(
    'left' => t('left sidebar'),
    'right' => t('right sidebar'),
    'content' => t('content'),
    'messages' => t('messages'),

    'languagebar' => t('language bar'),
    'footerlinks' => t('footer links')
  );
}

// duplicate of above to set themes in test theme (greenmap3)
function greenmap3_regions() {
  return array(
    'left' => t('left sidebar'),
    'right' => t('right sidebar'),
    'content' => t('content'),
    'messages' => t('messages'),

    'languagebar' => t('language bar'),
    'footerlinks' => t('footer links')
  );
}

// Theme the map node add form to simplify it....
if ((arg(0) == 'node') && (arg(1) == 'add') && (arg(2) == 'content_map')){
function phptemplate_node_form($form) {
return _phptemplate_callback('node-content_map_add', array('user' => $user, 'form' => $form));
}
}
// Add Form End.................

// Theme the map node EDIT form to simplify it....
// Edit Form Start...........Dublin Drupaller..
// if ((arg(0) == 'node') && (arg(2) == 'edit')){
//     $node = node_load(array('nid' => arg(1)));
// function phptemplate_node_form($form) {
//           return _phptemplate_callback('node-content_map_edit', array('user' => $user, 'form' => $form));
// }
// }
// Edit Form End........
// Add Form End.................




function trim_url($item, $length=20) {
	if(strlen($item['url']) > $length) {
		$item['title'] = substr($item['url'], 0, $length-3);
		$item['title'] .= '...';
	} 
	return $item;
}

function trim_text($item, $length=30) {
	if(strlen($item) > $length) {
		$item = substr($item, 0, $length-3);
		$item .= '...';
	} 
	return $item;
}

function size_hum_read($size){
/*
Returns a human readable size
*/
  $i=0;
  $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
  while (($size/1024)>1) {
    $size=$size/1024;
    $i++;
  }
  return substr($size,0,strpos($size,'.')).$iec[$i];
}
// Usage : size_hum_read(filesize($file));




// function to check if tool's added by official GMS staff
$official_gms = array(1,9,28); // list of UID's for official GMS staff - 9=GMS, 28=Risa

function check_official_gms($check_uid) {
	if($check_uid=='1' || $check_uid=='9' || $check_uid=='28') {
		return TRUE;
	}
	else { return FALSE; }
}


?>