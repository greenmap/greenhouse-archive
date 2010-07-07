<!--php_include_list_all_maps_mapmakers.php-->

<p>
<?php
print t('This page lists all Green Mapmakers who have registered with the website.  Not all projects are on the website, but a <a href="%url">complete list is available to download</a>.',
    array('%url' => file_create_url('files/citylist.pdf')));
?>
</p>

<p>
<?php print t("Click on the green titles to view a Mapmaker's profile, or click on the grey title to view their Green Map."); ?>
</p>

<?php  

// try to fetch from cache
$cid = 'node:1731';
$cache = cache_get($cid);
$expiration_limit = 60*60; // time in seconds (1 hour)
if ($cache && $cache->data && (($cache->created + $expiration_limit) > time())) {
  print unserialize($cache->data);
  return;
}

$output = '';

// these numbers are invalid Role IDs that should not show up on the list -
// admins, new unapproved, lapsed, and staff
$invalid_rids = array(3,4,5,6,7);

// fetch all mapmakers
$mapmakers_result = db_query("
    SELECT
      n.nid as nid
      , n.uid as uid
      , u.name as name
      , pvcity.value as city
      , pvcitylocal.value as citylocal
      , pvstate.value as state
      , pvcountry.value as country
    FROM
      node n 
      INNER JOIN users u ON n.uid=u.uid
      LEFT JOIN profile_values pvcity ON n.uid = pvcity.uid
      LEFT JOIN profile_values pvcitylocal ON n.uid = pvcitylocal.uid
      LEFT JOIN profile_values pvstate ON n.uid = pvstate.uid
      LEFT JOIN profile_values pvcountry ON n.uid = pvcountry.uid                 
    WHERE
      n.type = 'usernode'
      AND pvcity.fid = 19
      AND pvcitylocal.fid = 20
      AND pvstate.fid = 21
      AND pvcountry.fid = 22
    ORDER BY name ASC
    ");

while ($mapmaker = db_fetch_object($mapmakers_result)) {
  //$output .= "<li>found mapmaker uid={$mapmaker->uid} name={$mapmaker->name}";
  // exclude invalid user roles
  $mapmaker_roles_result = db_query("SELECT rid FROM users_roles WHERE uid = %d", $mapmaker->uid);
  $valid_user = TRUE;
  while ($role = db_fetch_object($mapmaker_roles_result)) {
    if (in_array($role->rid, $invalid_rids)) {
      $valid_user = FALSE;
      break;
    }
  }

  if ($valid_user) {
    // fetch list of maps
    $mapmaker_maps_result = db_query("SELECT nid, title 
        FROM node WHERE type = 'content_map' AND uid = %d AND status = 1", $mapmaker->uid);
    $maps = '';
    while ($map = db_fetch_object($mapmaker_maps_result)) {
      $maps .= "<li>". l($map->title, 'node/'.$map->nid);
    }

    $output .= sprintf('<fieldset class="collapsible"><legend>%s%s%s%s%s</legend>%s</fieldset>'."\n",
        l($mapmaker->name, 'user/'.$mapmaker->uid),
        $mapmaker->city ? ", ".trim($mapmaker->city) : '',
        drupal_strtolower($mapmaker->city) != drupal_strtolower($mapmaker->citylocal) ? $mapmaker->citylocal ? " (".$mapmaker->citylocal.")" : '' : '',
        $mapmaker->state ? ", ".$mapmaker->state : '',
        $mapmaker->country ? ", ".$mapmaker->country : '',
        $maps ? "<ul>$maps</ul>" : ""
        );
  }

}

cache_set($cid, serialize($output), CACHE_TEMPORARY);
print $output;
return;

/*
// do query to get all maps associated with user
$result = db_query("
    SELECT
      u.uid
      , u.name
      , m.type
      , m.title
      , ncm.nid
      , pvcity.value
      , pvcitylocal.value
      , pvstate.value
      , pvcountry.value
      , ur.rid
    FROM
      users u
      LEFT JOIN profile_values pvcity ON u.uid = pvcity.uid
      LEFT JOIN profile_values pvcitylocal ON u.uid = pvcitylocal.uid
      LEFT JOIN profile_values pvstate ON u.uid = pvstate.uid
      LEFT JOIN profile_values pvcountry ON u.uid = pvcountry.uid									
      LEFT JOIN node m ON u.uid = m.uid
      LEFT JOIN node_content_map ncm ON m.nid = ncm.nid
      LEFT JOIN users_roles ur ON ur.uid = u.uid
    WHERE
      u.uid > 0
      AND pvcity.fid = 19
      AND pvcitylocal.fid = 20
      AND pvstate.fid = 21
      AND pvcountry.fid = 22
      AND ( m.type = 'content_map' OR m.type = 'usernode' )
    ORDER BY
      u.name
      , m.nid DESC
  ");

$number = mysql_numrows($result);
$i = 0; // used to loop through all the users and maps from teh database query

$invalid_rid = array (3,4,5,6,7); // these numbers are invalid Role IDs that should not show up on the list - admins, new unapproved, lapsed, and staff

// check and make sure that first result alphabetically is a legitimate user, i.e. RID is not 5 (pending) or 3 (admin) or 4 (lapsed)
while ($number > $i) {
  $current_rid = mysql_result($result,$i,"ur.rid"); // set the first fieldset to be the first result
  if (in_array($current_rid,$invalid_rid)) {
    $i++;
  }
  else {
    $n = $i;
    break;
  }

}

// set the first results based on row n, where n is the first row that is a legitimate user to be shown
$current_user = mysql_result($result,$n,"u.name"); // set the first fieldset to be the first result
$current_uid = mysql_result($result,$n,"u.uid"); // set the first fieldset to be the first result
$current_city = mysql_result($result,$n,"pvcity.value"); // set the first fieldset to be the first result
$current_city_local = mysql_result($result,$n,"pvcitylocal.value"); // set the first fieldset to be the first result
$current_state = mysql_result($result,$n,"pvstate.value"); // set the first fieldset to be the first result
$current_country = mysql_result($result,$n,"pvcountry.value"); // set the first fieldset to be the first result

?><fieldset class="collapsible"><legend><?php print l( $current_user, 'user/' . $current_uid) . ' ' . $user_city ; ?>
    <?php if ($current_city_local > '') { print ' (' . $current_city_local . ') ' ; } ?>
    <?php if ($current_state > '') { print ' ' . $current_state . ' ' ; } ?>
    <?php if ($current_country > '') { print ' ' . $current_country . ' ' ; } ?>
</legend><div><?php // open first fieldset


while($number > $i){

  $user_title = mysql_result($result,$i,"u.name"); // user node title (their name)
  $map_title = mysql_result($result,$i,"m.title"); // tool title
  $user_uid = mysql_result($result,$i,"u.uid"); // user uid  -  will use for link at some point
  $map_nid = mysql_result($result,$i,"ncm.nid");
  $user_city = mysql_result($result,$i,"pvcity.value");
  $user_city_local = mysql_result($result,$i,"pvcitylocal.value");
  $user_state = mysql_result($result,$i,"pvstate.value");
  $user_country = mysql_result($result,$i,"pvcountry.value");
  $user_rid = mysql_result($result,$i,"ur.rid");

  // check if they're a valid user
  if(in_array($user_rid,$invalid_rid)) {
    $valid_user = FALSE;
  }
  else {
    $valid_user = TRUE;
  }

  // NOW FIND A WAY OF REMOVING NON-VALID FOLK, THEN REMVOING STAFF - PROB ADD NEW ROLE AND RID

  if($user_title != $current_user && $valid_user) {

    // print name in collapsible fieldset ?>
    </div></fieldset>
    <fieldset class="collapsible "><legend><?php print l( $user_title, 'user/' . $user_uid) . ' ' . $user_city  ; ?>
    <?php if ($user_city_local > '') { print ' (' . $user_city_local . ') ' ; } ?>
    <?php if ($user_state > '') { print ' ' . $user_state . ' ' ; } ?>
    <?php if ($user_country > '') { print ' ' . $user_country . ' ' ; } ?>

    <?php print $user_rid; // TEMP ************************ ?>
    </legend><div>


  <?php }
  // print title of the tool ?>
  <?php if ($map_nid > '' && $current_nid != $map_nid) {
    print l($map_title, 'node/' . $map_nid) . '<br />' ;
    $current_nid = $map_nid;
  } ?>
<?php // end looping row
$current_user = $user_title;
$i++;
}	?>
</div></fieldset> <?php // close last fieldset ?>

*/
?>
<!--/php_include_list_all_maps_mapmakers.php-->
