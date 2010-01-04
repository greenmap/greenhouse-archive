<!--php_include_list_all_maps.php-->
<?php // Adds DP collapsible fieldsets functionality
drupal_add_js('misc/collapse.js');

$debug = FALSE;
$debug = true;

// try to fetch from cache
$cid = 'node:3820';
$cache = cache_get($cid);
$expiration_limit = 60*60; // time in seconds (1 hour)
if ($cache && $cache->data && (($cache->created + $expiration_limit) > time()) && !$debug) {
  print unserialize($cache->data);
  return;
}

$output = '';

// DB query to get all map info
$map_result = db_query("SELECT
    u.uid
    , n.nid
    , n.title Title
    , filepath
    , pvcity.value City
    , pvlocal_city.value LocalCity
    , pvstate.value State
    , pvcountry.value Country
    , pvregion.value Region
  FROM
    node n
    INNER JOIN users u ON u.uid=n.uid
    INNER JOIN node_content_map n_c_m ON n.vid=n_c_m.vid
    LEFT JOIN files f ON f.fid=n_c_m.field_pdf_of_map_fid
    INNER JOIN profile_values pvcity ON pvcity.uid = n.uid
    INNER JOIN profile_values pvlocal_city ON pvlocal_city.uid = n.uid
    INNER JOIN profile_values pvstate ON pvstate.uid = n.uid
    INNER JOIN profile_values pvcountry ON pvcountry.uid = n.uid
    INNER JOIN profile_values pvregion ON pvregion.uid = n.uid
  WHERE
    u.uid > 0
    AND u.uid != 106
    AND n.type = 'content_map'
    AND pvcity.fid = '19'
    AND pvlocal_city.fid = '20'
    AND pvstate.fid = '21'
    AND pvcountry.fid = '22'
    AND pvregion.fid = '23'
    AND n.status = 1
  ORDER BY
    pvregion.value
    , pvcountry.value
    , pvcity.value
    , n.title");

$lastRegion = null;
$lastCountry = null;
$lastState = null;
$lastCity = null;

// these numbers are invalid Role IDs that should not show up on the list -
// admins, new unapproved, lapsed, and staff
$invalid_rids = array(3,4,5,6,7);

// get the list mapping gm.org map nid's with ogm.org map nid's
$ogm_maps = sync_fetch_all_ogm_maps();

// find first valid map
while ($map = db_fetch_array($map_result)) {
  // exclude invalid user roles
  $mapmaker_roles_result = db_query("SELECT rid FROM users_roles WHERE uid = %d", $map['uid']);
  $valid_user = TRUE;
  while ($role = db_fetch_object($mapmaker_roles_result)) {
    if (in_array($role->rid, $invalid_rids)) {
      $valid_user = FALSE;
      break;
    }
  }
  if ($valid_user) {
    break;
  }
}

$currRegion = $map["Region"];
$currCountry = $map["Country"];
$currState = $map["State"];
$currCity = $map["City"];

while($map){

  // open fieldsets where necessary
  if( $lastRegion != $currRegion ){
    $output .= '<fieldset class="collapsible collapsed"><legend>'.$currRegion.'</legend>';
  }
  if( $lastCountry != $currCountry ){
    $output .= '<fieldset class="collapsible collapsed"><legend>'.$currCountry.'</legend>';
  }
  /*if( $lastState != $currState ){
    $output .= '<fieldset class="collapsible collapsed"><legend>'.$currState.'</legend>';
  }*/
  if( $lastCity != $currCity ){
    $output .= '<fieldset class="collapsible collapsed"><legend>'.$currCity.'</legend>';
  }
  if( $lastCountry != $currCountry || $lastRegion != $currRegion || $lastCity != $currCity ){
    $output .= '<div class="staticlist">';
  }

  // print map information
  $download_link = $map['filepath'] ?
    sprintf('<a href="%s" target="_blank"><img src="%s" alt="%s" title="%s" class="maplist" /></a>',
      file_create_url($map['filepath']),
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_download.png',
      t('Download Green Map'), t('Download Green Map')) :
    sprintf('<img src="%s" alt="" title="" class="maplist" />',
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_blank.png');
  $ogm_link = $ogm_maps[$map['nid']] ?
    sprintf('<a href="%s" target="_blank"><img src="%s" alt="%s" title="%s" class="maplist" /></a>',
      'http://www.opengreenmap.org/'. $ogm_maps[$map['nid']]->alias,
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_ogm.png',
      t('Open Green Map'), t('Open Green Map')) :
    sprintf('<img src="%s" alt="" title="" class="maplist" />',
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_blank.png');
  $output .= sprintf('%s%s<a href="%s"><img src="%s" alt="%s" title="%s" class="maplist" /></a> %s<br />'."\n",
      $ogm_link,
      $download_link,
      url('user/'.$map['uid']),
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_profile.png',
      t('Go to Mapmaker Profile'), t('Go to Mapmaker Profile'),
      l($map['Title'], 'node/'.$map['nid']) );

  // update last map info
  $lastRegion = $map['Region'];
  $lastCountry = $map['Country'];
  $lastState = $map['State'];
  $lastCity = $map['City'];

  // find next valid map
  while ($map = db_fetch_array($map_result)) {
    //$output .= "<li>found potentially valid next map from mapmaker uid={$map['uid']} name={$map['name']}";
    // exclude invalid user roles
    $mapmaker_roles_result = db_query("SELECT rid FROM users_roles WHERE uid = %d", $map['uid']);
    $valid_user = TRUE;
    while ($role = db_fetch_object($mapmaker_roles_result)) {
      if (in_array($role->rid, $invalid_rids)) {
        $valid_user = FALSE;
        break;
      }
    }
    if ($valid_user) {
      break;
    }
  }

  // update current map info
  $currRegion = $map["Region"];
  $currCountry = $map["Country"];
  $currState = $map["State"];
  $currCity = $map["City"];

  // close fieldsets where necessary
  if( $lastCountry != $currCountry || $lastRegion != $currRegion || $lastCity != $currCity ){
    $output .= '</div>';
  }
  if( $lastCity != $currCity ){
    $output .= '</fieldset>';
  }
  /*if( $lastState != $currState ){
    $output .= '</fieldset>';
  }*/
  if( $lastCountry != $currCountry ){
    $output .= '</fieldset>';
  }
  if( $lastRegion != $currRegion ){
    $output .= '</fieldset>';
  }

} // End while

cache_set($cid, serialize($output), CACHE_TEMPORARY);
print $output;
return;

?>
<!--php_include_list_all_maps.php-->
