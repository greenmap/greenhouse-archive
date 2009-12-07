<!--php_include_list_all_maps.php-->
<?php // Adds DP collapsible fieldsets functionality
drupal_add_js('misc/collapse.js');


// try to fetch from cache
$cid = 'node:3820';
$cache = cache_get($cid);
$expiration_limit = 60*60; // time in seconds (1 hour)
if ($cache && $cache->data && (($cache->created + $expiration_limit) > time())) {
  print unserialize($cache->data);
  return;
}

$output = '';

// DB query to get all map info
$result = db_query("SELECT
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

$resultArray = db_fetch_array($result);
$currRegion = $resultArray["Region"];
$currCountry = $resultArray["Country"];
$currState = $resultArray["State"];
$currCity = $resultArray["City"];
$lastRegion = null;
$lastCountry = null;
$currState = null;
$lastCity = null;

while( $resultArray ){

  if( $lastRegion != $currRegion ){
    $output .= '<fieldset class="collapsible collapsed"><legend>'.$currRegion.'</legend>';
  }
  if( $lastCountry != $currCountry || $lastRegion != $currRegion ){
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

  $download_link = $resultArray['filepath'] ?
    sprintf('<a href="%s"><img src="%s" alt="%s" title="%s" class="maplist" /></a>',
      file_create_url($resultArray['filepath']),
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_download.png',
      t('Download Green Map'), t('Download Green Map')) :
    sprintf('<img src="%s" alt="" title="" class="maplist" />',
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_blank.png');
  $output .= sprintf('%s<a href="%s"><img src="%s" alt="%s" title="%s" class="maplist" /></a> %s<br />'."\n",
      $download_link,
      url('user/'.$resultArray['uid']),
      base_path().drupal_get_path('theme', 'greenmapnew').'/img/icon_map_profile.png',
      t('Go to Mapmaker Profile'), t('Go to Mapmaker Profile'),
      l($resultArray['Title'], 'node/'.$resultArray['nid']));

  $lastRegion = $resultArray['Region'];
  $lastCountry = $resultArray['Country'];
  $lastState = $resultArray['State'];
  $lastCity = $resultArray['City'];
  $resultArray = db_fetch_array($result);
  $currRegion = $resultArray['Region'];
  $currCountry = $resultArray['Country'];
  $currState = $resultArray['State'];
  $currCity = $resultArray['City'];

  if( $lastCountry != $currCountry || $lastRegion != $currRegion || $lastCity != $currCity ){
    $output .= '</div>';
  }
  if( $lastCity != $currCity ){
    $output .= '</fieldset>';
  }
  /*if( $lastState != $currState ){
    $output .= '</fieldset>';
  }*/
  if( $lastCountry != $currCountry || $lastRegion != $currRegion ){
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
