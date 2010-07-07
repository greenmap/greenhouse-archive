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

/**
 * Themes the cart block
 */
function phptemplate_cart_display_block() {
  global $user;
  $output = '';

  /**
   * Until Drupal can handle partial page caching, We should only display a
   * View Cart link for anonymous users and the full fancy items and total cart
   * for authenticated users since those pages aren't cached.
   */
  if ($user->uid == 0 && variable_get('cache', 0)) {
    $output .= l(t('View your cart'), 'cart/view');
  }
  else {

    $item = cart_get_items();
    $item_count = count($item);
    $item_suffix = ($item_count == 1) ? t('item') : t('items');

    $output .= '<div class="item-count">'. t("%item_count %item_suffix in %your_cart", array("%item_count" => $item_count, "%item_suffix" => $item_suffix, "%your_cart" => l(t("your cart"), "cart/view"))). "</div>\n";

    if (!empty($item)) {
      $output .= '<div class="items">';
      foreach ($item as $i) {
        $node = node_load($i->nid);
        if (product_has_quantity($node)) {
          $total += ($i->price * $i->qty) + product_get_specials($i, 'cart', true);
          $output .= l("$node->title x $i->qty", 'node/'. ($node->pparent ? $node->pparent : $node->nid)). "<br />";
        }
        else {
          $i->qty = 1;
          $total += $i->price+product_get_specials($i, 'cart', true);
          $output .= l("$node->title", 'node/'. ($node->pparent ? $node->pparent : $node->nid)). "<br />";
        }
      }
      $output .= "</div><div class=\"total\">". payment_format($total) . "</div>";
      $output .= '<div class="checkout">'. t('Ready to <a href="%checkout-url">checkout</a>?', array('%checkout-url' => url('cart/checkout'))) 
        .' | '
        .l(t('Cancel order'), 'cart/view')
        .'</div>';
    }
  }

  return $output;
}

function phptemplate_cart_review_form(&$form) {
  $content = '';

  $content = '<p>'. t('You can cancel your order by <a href="%cart_url">returning to your cart</a> and removing all items.', array("%cart_url" => url("cart/view"))) .'</p>';

  $f =& $form['cart'];

  $header = array(t('Qty'), t('Item'), t('Price'), t('Subtotal'), '');
  $rows = array();
  if ($f['items']) {
    foreach ($f['items'] as $key => $line) {
      if (is_numeric($key)) {
        $rows[] = array(
          $line['qty']['#value'],
          $line['item']['#value']->title,
          array('data' => payment_format($line['price']['#value']), 'align' => 'right'),
          array('data' => payment_format($line['subtotal']['#value']), 'align' => 'right'),
          $line['options']['#value']
        );
      }
    }
  }

  $rows[] = array('', '', '', '', '');
  foreach ($f['totals'] as $id => $line) {
    if (is_numeric($id)) {
      $rows[] = array(
        '',
        "<b>{$line['#title']}</b>",
        '',
        array('data' => payment_format($line['#value']), 'align' => 'right'),
        ''
      );
    }
  }

  $content .= theme('table', $header, $rows);

  return theme('box', t('Order Summary'), $content);
}

/**
 * Returns a themed shopping cart form.
 */
function phptemplate_cart_view($form) {
  $output = '<p>'. t('You can cancel your order at any time by removing all items from your shopping cart.') .'</p>';

  $total = 0;
  $header = array(t('Items'), t('Qty.'), '');
  $extra = array_filter($form['items'], '_cart_form_filter_extra');
  if ($extra) {
    $header[] = '';
  }

  foreach (element_children($form['items']) as $nid) {
    $total+= $form['items'][$nid]['#total'];
    $total+= $form['items'][$nid]['#specials'];
    $desc = form_render($form['items'][$nid]['title']) .'<br />';
    if ($form['items'][$nid]['recurring']) {
      $desc.= '<div class="recurring-details">'. form_render($form['items'][$nid]['recurring']) .'</div>';
    }
    if ($form['items'][$nid]['availability']) {
      $desc.= form_render($form['items'][$nid]['availability']);
    }
    $desc.= '<p>'. payment_format($form['items'][$nid]['#total']+$form['items'][$nid]['#specials']) .'</p>';

    $row = array(
      array('data' => $desc),
      array('data' => $form['items'][$nid]['qty'] ? form_render($form['items'][$nid]['qty']) : '', 'align' => 'center'),
    );
    if ($extra && $form['items'][$nid]['extra']) {
      $row[] = array('data' => form_render($form['items'][$nid]['extra']));
    }
    elseif ($extra) {
      $row[] = '';
    }
    $row[] = array('data' => l(t('Remove'), "cart/delete/$nid"));
    $rows[] = $row;
  }
  $rows[] = array(array("data" => "<strong>". t('Subtotal:') . '</strong> ' . payment_format($total), "colspan" => $extra ? 4 : 3, "align" => "right"));
  $output.= theme('table', $header, $rows);
  $output.= form_render($form);
  return $output;
}


function gm_getrecent_photo($uid) {
	$result = db_query("SELECT nid FROM {node} WHERE type='content_photo' AND uid=%d ORDER BY created LIMIT 1", $uid);
	$nid = db_result($result);
	if (!$nid){
		return false;
	}
	$node = node_load($nid);
	return $node->field_photo[0][filepath];
}



function greenmapnew_user_picture($account) {
  
  global $user;
  $ret = NULL;
  $max_h = 130; //max pixels

 
  if (variable_get('user_pictures', 0)) {
    
    $imageinfo = image_get_info($account->picture);
 
    if ($account->picture && file_exists($account->picture)) {
      $picture = file_create_url($account->picture);
    }
    else if (variable_get('user_picture_default', '')) {
      $picture = variable_get('user_picture_default', '');
    }

    if (isset($picture)) {
      $alt = t('%user\'s picture', array('%user' => $account->name ? $account->name : variable_get('anonymous', 'Anonymous')));
      
      $attributes = array();
      
      if ($imageinfo['height'] > $max_h) {
      	$attributes['height'] = $max_h;
      }
      
      $picture = theme('image', $picture, $alt, $alt, $attributes, false);
      
      if (!empty($account->uid) && user_access('access user profiles')) {
        $picture = l($picture, "user/$account->uid", array('title' => t('View user profile.')), NULL, NULL, FALSE, TRUE);
      }
      
      $ret = "<div class=\"picture\">$picture</div>";
    }
    else {
      $picture = "images/placeholder.jpg";
      $picture = theme('image', $picture, $alt, $alt, '', false);
      
      if($account->uid && ( $account->uid == $user->uid)){
       $ret = l("<div class=\"picture\">$picture</div>", "user/" . $user->uid . '/edit', array('title' => t('click to add a profile picture')), NULL, NULL, NULL, TRUE);
      }
      else{
      	$ret = "<div class=\"picture\">$picture</div>";
      }
    }
  }
  return $ret;
}

function greenmapnew_menu_bar ( $pid, $depth=0 ) {
  $menu = menu_get_menu();
  $output = '';
  if( $depth == 0 ) {
    $output .= '<div id="navcontainer"> <ul id="navlist"><li id="home" ><a href="'. base_path() .'"></a></li>'. "\n";
  }
  else {
    $output .= "\n". '<ul class="submenu" id="submenu-' .$pid .'">';
  }
  if (isset($menu['visible'][$pid]) && $menu['visible'][$pid]['children']) {
    foreach ($menu['visible'][$pid]['children'] as $mid) {
          $children_array = isset($menu['visible'][$mid]['children']) ? $menu['visible'][$mid]['children'] : NULL;
    $is_children = ( count($children_array) > 0 );
        $children = $is_children ? theme('menu_bar', $mid, $depth+1) : NULL;
    if( $depth == 0 ) {
        $class = 'class="menu-header"';
    }
    elseif( $is_children ) {
    	$mouseover = "document.getElementById('submenu-" .$mid ."').style.display='block'";
    	$mouseout = "document.getElementById('submenu-" .$mid ."').style.display='none'";
        $class = 'class="submenu-header" id="submenu-p' .$mid .'" onMouseOver=' .$mouseover .'; onMouseOut=' .$mouseout .';';
    }
    else {
        $class = 'class="leaf" id="leaf-' .$mid .'"';
    }
      $output .= "<li $class>". menu_item_link($mid) . $children ."</li>\n";
    }
  }
  if( $depth == 0 ) {
    $output .= '<li id="last-menu-item"></li>';
  }
  $output .= '</ul>';
  if( $depth == 0 ) {
    $output .= '</div>';
  }
  return $output;
}




