<!--user_profile.tpl.php-->
<?php
drupal_add_js('misc/collapse.js');
global $i18n_langpath;

global $base_path;

// we set $_SESSION['just_logged_in'] at sync_user function (hook_user)
// it just makes sure that drupal_goto is run only once.
// we can't call drupal_goto from hook_user (for some reason)

$new_roles = array('new unauthenticated user');


if (is_array($user->roles)) {
  if (!count(array_intersect($user->roles, $new_roles)) > 0) {

    if((  $user->profile_terms_and_conditions == 0 ||
        $user->profile_terms_and_conditions == null ||
        !isset($user->profile_terms_and_conditions) ||
        empty($user->profile_terms_and_conditions) ||
        !$user->profile_terms_and_conditions)  &&
        $_SESSION['just_logged_in'] == 1)
      {
        $_SESSION['just_logged_in'] = 0; // clear the session
        $_SESSION['just_logged_in'] = null; // double check
        unset($_SESSION['just_logged_in']); // triple ...

        drupal_goto('mapmakers_agreement');
      }
      }
}



$allowed_editor = FALSE;
if ((user_access('administer users') || $GLOBALS['user']->uid == $user->uid)) {
  $allowed_editor = TRUE;
}

$is_admin = FALSE;
if (user_access('administer users')) {
  $is_admin = TRUE;
}


$approved_roles = array('new unauthenticated user');

if (is_array($user->roles)) {
  if (count(array_intersect($user->roles, $approved_roles)) > 0) {
    $new_user = TRUE;
  } else {
    $new_user = FALSE;
}}

$not_hidden = TRUE;
if ($new_user && !$allowed_editor) {
  $not_hidden = FALSE;
}

// check if lapsing

$lapsing_roles = array('lapsing');
$lapsed_roles = array('lapsed user');

if (is_array($user->roles)) {
  if (count(array_intersect($user->roles, $lapsed_roles)) > 0) {
    $lapsed_user = TRUE;
  } elseif (count(array_intersect($user->roles, $lapsing_roles)) > 0) {
    $lapsing_user = TRUE;
  }
}

// check if supporting or sustaining and set variable ?>


  <?php if($user->profile_supporting_fee_paid == 1) { ?>
    <?php $supporting = '<img src="' . base_path() . 'misc/icon_support.gif" width="12" height="12" title="Supporting Mapmaker" class="supporting" />';
   }?>

  <?php if($user->profile_sustaining_fee_paid == 1) { ?>
    <?php $sustaining = '<img src="' . base_path() . 'misc/icon_sustain.gif" width="26" height="12" title="Sustaining Mapmaker" class="supporting" />';
   }?>



<?php
// if viewing teaser show limited info. Hide if the profile is not a registered user
if ($teaser && !$new_user) {
?>

<fieldset>

<legend><?php print $user->name ?></legend>

<?php if(($user->profile_project_area_english) || ($user->profile_project_area_local) ||($user->profile_state) ||
  ($user->profile_project_country) || ($user->profile_project_continent)) { ?>
<div class="item"><div><label><?php print t('Location'); ?>:</label></div>
<div class="data"><?php print check_plain($user->profile_project_area_english) ?>
  <?php if($user->profile_project_area_local) { ?>
    (<?php print check_plain($user->profile_project_area_local) ?>)
  <?php }?>
  <?php if($user->profile_state) { ?>
    - <?php print check_plain($user->profile_state) ?>
  <?php }?>
  <?php if($user->profile_project_country) { ?>
    - <?php print check_plain($user->profile_project_country) ?>
  <?php }?>
  <?php if($user->profile_project_continent) { ?>
    - <?php print check_plain($user->profile_project_continent) ?>
  <?php }?>
</div></div>
<?php }?>

<?php if($user->profile_introduction) { ?>
<div class="item">
    <div><label><?php print t('About'); ?>:</label></div><div class="data">
     <?php print check_plain($user->profile_introduction) ?></div></div>
<?php }?>



</fieldset>

<?php
}
// if it's not a teaser, then show full page
elseif ($not_hidden) {

// Get all variables for user, and set to false if not completed, or set to their printed value if available. Set up flags if that variable makes a group red or green. Set up flag if all OK.



$latitude = $user -> gmap_location_latitude;
$longitude = $user -> gmap_location_longitude;
$location_set = (($latitude > '') && ($longitude > '')) ? TRUE : FALSE;

$profile_organization_name = $user->profile_organization_name;
$profile_org_name_local = $user->profile_org_name_local;
$profile_organization_type = $user->profile_organization_type;
$profile_project_status = $user->profile_project_status;
$profile_introduction = $user->profile_introduction;
$profile_organization_email = $user->profile_organization_email;
$profile_organization_email_public = $user->profile_organization_email_public;
$profile_organization_phone = $user->profile_organization_phone;
$profile_organization_phone_public = $user->profile_organization_phone_public;
$profile_organization_website = $user->profile_organization_website;
$profile_project_area_english = $user->profile_project_area_english;
$profile_project_area_local = $user->profile_project_area_local;
$profile_state = $user->profile_state;
$profile_project_country = $user->profile_project_country;
$profile_project_continent = $user->profile_project_continent;
$profile_facebook = $user->profile_facebook;
$profile_twitter = $user->profile_twitter;
$profile_youtube = $user->profile_youtube;
$profile_flickr = $user->profile_flickr;
$profile_hi5 = $user->profile_hi5;
$profile_othersocial1 = $user->profile_othersocial1;
$profile_othersocial2 = $user->profile_othersocial2;
$profile_othersocial3 = $user->profile_othersocial3;

$organization_complete = ( $profile_organization_name   &&  $profile_organization_type  && $profile_project_status && $profile_introduction
                && $profile_project_area_english &&
                 $profile_state && $profile_project_country && $profile_project_continent ) ? TRUE : FALSE;

$profile_project_name_last = $user->profile_project_name_last;
$profile_project_name_first = $user->profile_project_name_first;
$profile_project_name_salutation = $user->profile_project_name_salutation;
$profile_project_name_salutation_other = $user->profile_project_name_salutation_other;
$profile_project_leader_email = $user->profile_project_leader_email;
$profile_project_email_public = $user->profile_project_email_public;
$profile_project_leader_phone = $user->profile_project_leader_phone;
$profile_mapmaker_phone_public = $user->profile_mapmaker_phone_public;
$profile_contact_other = $user->profile_contact_other;
$profile_othercontact_public = $user->profile_othercontact_public;
$profile_project_address = $user->profile_project_address;
$profile_project_role = $user->profile_project_role;
$profile_mapmaker_role_other = $user->profile_mapmaker_role_other;
$profile_project_profession = $user->profile_project_profession;
$profile_mapmaker_profession_other = $user->profile_mapmaker_profession_other;
$profile_languages = $user->profile_languages;
$profile_mapmaker_firstlanguage_other = $user->profile_mapmaker_firstlanguage_other;
$profile_langues_other = $user->profile_langues_other;

$mapmaker_complete = ( $profile_project_name_last && $profile_project_name_first && $profile_project_name_salutation && $profile_project_leader_email
             && $profile_project_email_public && $profile_project_leader_phone && $profile_mapmaker_phone_public && $profile_project_address
             && $profile_project_role && $profile_project_profession  ) ? TRUE : FALSE;

$profile_statement_of_purpose = $user->profile_statement_of_purpose;
$statement_complete = ($profile_statement_of_purpose > '') ? TRUE : FALSE;


$profile_team_skills = $user->profile_team_skills;
$profile_background_big_issues = $user->profile_background_big_issues;
$profile_background_other_resources = $user->profile_background_other_resources;
$profile_check_greenmap = $user->profile_check_greenmap;
$profile_check_local = $user->profile_check_local;
$profile_how_find_out = $user->profile_how_find_out;
$profile_consultant = $user->profile_consultant;
$profile_business = $user->profile_business;


$reginfo_complete = ( $profile_team_skills && $profile_background_big_issues && $profile_check_greenmap && $profile_how_find_out  ) ? TRUE : FALSE;

$profile_terms_and_conditions = $user->profile_terms_and_conditions;
$profile_release_form_agreement = $user->profile_release_form_agreement;

$agreement_complete  = (  $profile_terms_and_conditions && $profile_release_form_agreement  ) ? TRUE : FALSE;

$profile_payment_fee = $user->profile_payment_fee;
$profile_fees_organization_type = $user->profile_fees_organization_type;
$profile_fees_term = $user->profile_fees_term;
$profile_fee_double = $user->profile_fee_double;
$profile_fee_treble = $user->profile_fee_treble;
$profile_admin_donate = $user->profile_admin_donate;
$profile_fee_purchase_kit = $user->profile_fee_purchase_kit;
$profile_fee_total = $user->profile_fee_total;
$profile_fee_reduce_fees = $user->profile_fee_reduce_fees;
$profile_fee_afford_to_pay = $user->profile_fee_afford_to_pay;
$profile_service = $user->profile_service;
$profile_tax_letter = $user->profile_tax_letter;
$profile_payment_method = $user->profile_payment_method;
$profile_fee_otherpayment = $user->profile_fee_otherpayment;

$fees_complete = ( $profile_payment_fee && $profile_fees_organization_type && $profile_fees_term && $profile_fee_total ) ? TRUE : FALSE;
$fees_complete = ( !$profile_service && ( $profile_fee_reduce_fees || $profile_fee_afford_to_pay) ) ? FALSE :  $fees_complete; // if they're requested to reduce fee they have to tell about service

$profile_grammerspelling = $user->profile_grammerspelling;
$profile_pending = $user->profile_pending;
// *************************** Get rest of admin stuff for admin box
$profile_pending_reason = $user->profile_pending_reason;
$profile_registration_comments = $user->profile_registration_comments;

$admin_complete = ($profile_grammerspelling) ? TRUE : FALSE;


$profile_exchange_consulting = $user->profile_exchange_consulting;
$profile_exchange_consulting_public = $user->profile_exchange_consulting_public;
$profile_exchange_offline = $user->profile_exchange_offline;
$profile_exchange_offline_public = $user->profile_exchange_offline_public;
$profile_exchange_visiting = $user->profile_exchange_visiting;


$profile_local_overview = $user->profile_local_overview;


// check all required variables, and set $complete = FALSE if their application is not complete
$complete = TRUE;
$complete = $user->picture ? $complete : FALSE;
$complete = $location_set ? $complete : FALSE;
$complete = $organization_complete ? $complete : FALSE;
$complete = $mapmaker_complete ? $complete : FALSE;
$complete = $statement_complete ? $complete : FALSE;
$complete = $reginfo_complete ? $complete : FALSE;
$complete = $agreement_complete ? $complete : FALSE;
$complete = $fees_complete ? $complete : FALSE;
$complete = $admin_complete ? $complete : FALSE;

// set up an array of attributes for l() containing class=required
$attributes_required = array('class' => 'required');
$attributes_mapmakers = array('class' => 'mapmakers');
?>

<div id="top">

<?php if(($profile_project_area_english) || ($profile_project_area_local) ||($profile_state) ||
  ($profile_project_country) || ($profile_project_continent || $allowed_editor )) { ?>

<div class="item <?php if ((!$profile_project_area_english || !$profile_state || !$profile_project_country || !$profile_project_continent ) && $allowed_editor) { print 'required'; } ?>">

<div class="data">
  <?php print check_plain($profile_project_area_english) ?>
  <?php if (!$profile_project_area_english && $allowed_editor) { print l(t('Set your location*'),'user/'. $user -> uid .'/edit/A.+Organization+details',$attributes_required);  } ?>

  <?php if($profile_project_area_local || $allowed_editor) { ?>
    (<?php print check_plain($profile_project_area_local) ?>
    <?php if (!$profile_project_area_local && $allowed_editor) { print l(t('Set the local name of location if different '),'user/'. $user -> uid .'/edit/A.+Organization+details');  } ?>)
  <?php }?>


  <?php if($profile_state || $allowed_editor) { ?>
    - <?php print check_plain($profile_state) ?>
    <?php if (!$profile_state && $allowed_editor) { print l(t('Set your state*'),'user/'. $user -> uid .'/edit/A.+Organization+details',$attributes_required);  } ?>
  <?php }?>


  <?php if($profile_project_country || $allowed_editor) { ?>
    - <?php print check_plain($profile_project_country) ?>
    <?php if (!$profile_project_country && $allowed_editor) { print l(t('Set your country*'),'user/'. $user -> uid .'/edit/A.+Organization+details',$attributes_required);  } ?>
  <?php }?>



  <?php if($profile_project_continent || $allowed_editor) { ?>
<?php
$dictc = array(
 'Africa' => 'maps/list/continent/africa',
 'Europe' => 'maps/list/continent/europe',
 'Latin America' => 'maps/list/continent/latin america',
 'North America' => 'maps/list/continent/north america',
 'Oceania' => 'maps/list/continent/oceania',
 );
?>

<?php if (!$profile_project_continent && $allowed_editor) { print 'required'; } ?>
    - <?php print l(check_plain(ucwords(check_plain($profile_project_continent))),
           $dictc[$profile_project_continent]);
      ?>
<?php }?>



</div></div>
<?php }?>
</div>


<dic id="whole">
<div id="leftprofile_topleft">


<!-- > USER PROFILE PICTURE -->

<?php // print user picture

$user_picture = theme('user_picture',$user);
print $user_picture;
   


// set the messages to allow them to add another map, or add 1st map, if user is viewing own account
if ($allowed_editor && !$new_user) {
$add_first_map = '<a class="mapmakers" href="' . base_path()  .  $i18n_langpath . '/node/add/content_map">' . t('Add a Green Map') . '</a>';
$add_a_map = '<br /><a class="mapmakers" href="' . base_path() . $i18n_langpath . '/node/add/content_map">' . t('Add another Green Map') . '</a>';
}
?>
</div>



<div id="leftprofile_topright">

<fieldset <?php if (!$mapmaker_complete) { print 'required'; } ?>><legend><?php print t('Mapmaker Profile'); ?></legend>

<?php if($profile_organization_name || $allowed_editor) { ?>
<div class="item <?php if (!$profile_organization_name && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Organization'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_organization_name)   . $sustaining . $supporting ?>
    <?php if (!$profile_organization_name && $allowed_editor) { print l(t('Add your organization name*'),'user/'. $user -> uid .'/edit/A.+Organization+details',$attributes_required);  } ?>
  </div>
</div>
<?php }?>

<?php if($profile_org_name_local || $allowed_editor) { ?>
<div class="item">
  <div><label>&nbsp;</label></div>
  <div class="data">
    <?php print check_plain($profile_org_name_local);  ?>
    <?php if (!$profile_org_name_local && $allowed_editor) { print l(t('Add your organization name in your local language (if different)'),'user/'. $user -> uid .'/edit/A.+Organization+details');  } ?>
  </div>
</div>
<?php }?>



<?php if($profile_organization_email || $allowed_editor) { ?>
  <?php if($profile_organization_email_public == 'Public') { ?>
    <div class="item"><div><label><?php print t('Org Email'); ?>:</label></div>
    <div class="data">
          <?php print check_plain($profile_organization_email) ?>
          <?php if (!$profile_organization_email && $allowed_editor) { print l(t('Add an email contact for your organization. You have the option to keep this private'),'user/'. $user -> uid .'/edit/B.+Contact+information');  } ?>
    </div></div>
  <?php }  else { ?>

      <?php if($profile_organization_email_public == 'Mapmakers') { ?>
        <?php $approved_roles = array('admin user', 'authenticated user'); ?>
      <?php }  else { ?>
        <?php $approved_roles = array('admin user'); ?>
      <?php } ?>

      <?php  if ((count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) || $allowed_editor ) { ?>
        <div class="item"><div><label><?php print t('Org Email'); ?>:</label></div>
        <div class="data">
          <?php print check_plain($profile_organization_email) ?>
          <?php if (!$profile_organization_email && $allowed_editor) { print l(t('Add an email contact for your organization. You have the option to keep this private'),'user/'. $user -> uid .'/edit/B.+Contact+information');  } ?>
        </div></div>
      <?php } ?>

  <?php } ?>
<?php }?>


<?php if($profile_organization_phone || $allowed_editor) { ?>
  <?php if($profile_organization_phone_public == 'Public') { ?>
    <div class="item"><div><label><?php print t('Org Phone'); ?>:</label></div>
    <div class="data">
      <?php print check_plain($profile_organization_phone) ?>
      <?php if (!$profile_organization_phone && $allowed_editor) { print l(t('Add a phone number for your organization. You have the option to keep this private'),'user/'. $user -> uid .'/edit/B.+Contact+information');  } ?>
    </div></div>
  <?php }  else { ?>

      <?php if($profile_organization_phone_public == 'Mapmakers') { ?>
        <?php $approved_roles = array('admin user', 'authenticated user'); ?>
      <?php }  else { ?>
        <?php $approved_roles = array('admin user'); ?>
      <?php } ?>

      <?php  if ((count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) || $allowed_editor ) { ?>
        <div class="item"><div><label><?php print t('Org Phone'); ?>:</label></div>
        <div class="data">
          <?php print check_plain($profile_organization_phone) ?>
          <?php if (!$profile_organization_phone && $allowed_editor) { print l(t('Add a phone number for your organization. You have the option to keep this private'),'user/'. $user -> uid .'/edit/B.+Contact+information');  } ?>
        </div></div>
      <?php } ?>

  <?php } ?>
<?php }?>




<?php if($profile_project_name_first || $profile_project_name_last || $allowed_editor) { ?>
<div class="item <?php if ((!$profile_project_name_first || !$profile_project_name_last) && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Mapmaker'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_project_name_first) . '&nbsp;' . check_plain($profile_project_name_last); ?>
    <?php if ((!$profile_project_name_first || !$profile_project_name_last) && $allowed_editor) { print l(t('Add your name*'),'user/'. $user -> uid .'/edit/B.+Contact+information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_project_leader_email || $allowed_editor) { ?>
  <?php if($profile_project_email_public == 'Public') { ?>
    <div class="item <?php if (!$profile_project_leader_email && $allowed_editor) { print 'required'; } ?>"><div><label><?php print t('Email'); ?>:</label></div><div class="data"> <?php print check_plain($profile_project_leader_email) ?></div></div>
  <?php }  else { ?>

      <?php if($profile_project_email_public == 'Mapmakers') { ?>
        <?php $approved_roles = array('admin user', 'authenticated user'); ?>
      <?php }  else { ?>
        <?php $approved_roles = array('admin user'); ?>
      <?php } ?>

      <?php  if ((count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) || $allowed_editor ) { ?>
        <div class="item <?php if (!$profile_project_leader_email && $allowed_editor) { print 'required'; } ?>"><div><label><?php print t('Email'); ?>:</label></div>
        <div class="data">
          <?php print check_plain($profile_project_leader_email) ?>
          <?php if (!$profile_project_leader_email && $allowed_editor) { print l(t('Add your email address* '),'user/'. $user -> uid .'/edit/B.+Contact+information',$attributes_required) . t('This should be different to the email you registered with. You have the option to keep this private');  } ?>
        </div></div>
      <?php } ?>

  <?php } ?>
<?php }?>


<?php if($profile_project_leader_phone || $allowed_editor) { ?>
  <?php if($profile_mapmaker_phone_public == 'Public') { ?>
    <div class="item <?php if (!$profile_project_leader_phone && $allowed_editor) { print 'required'; } ?>"><div><label><?php print t('Phone'); ?>:</label></div><div class="data">
      <?php print check_plain($profile_project_leader_phone) ?></div></div>
  <?php }  else { ?>

      <?php if($profile_mapmaker_phone_public == 'Mapmakers') { ?>
        <?php $approved_roles = array('admin user', 'authenticated user'); ?>
      <?php }  else { ?>
        <?php $approved_roles = array('admin user'); ?>
      <?php } ?>

      <?php  if ((count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) || $allowed_editor ) { ?>
        <div class="item <?php if (!$profile_project_leader_phone && $allowed_editor) { print 'required'; } ?>"><div><label><?php print t('Phone'); ?>:</label></div>
        <div class="data">
          <?php print check_plain($profile_project_leader_phone) ?>
          <?php if (!$profile_project_leader_phone && $allowed_editor) { print l(t('Add your phone number* '),'user/'. $user -> uid .'/edit/B.+Contact+information',$attributes_required) ;  } ?>
        </div></div>
      <?php } ?>

  <?php } ?>
<?php }?>



<?php if($profile_contact_other || $allowed_editor) { ?>
  <?php if($profile_othercontact_public == 'Public') { ?>
    <div class="item"><div><label><?php print t('Contact'); ?>:</label></div><div class="data">
      <?php print check_plain($profile_contact_other) ?></div></div>
  <?php }  else { ?>

      <?php if($profile_othercontact_public == 'Mapmakers') { ?>
        <?php $approved_roles = array('admin user', 'authenticated user'); ?>
      <?php }  else { ?>
        <?php $approved_roles = array('admin user'); ?>
      <?php } ?>

      <?php  if ((count(array_intersect($GLOBALS['user']->roles, $approved_roles)) > 0) || $allowed_editor ) { ?>
        <div class="item"><div><label><?php print t('Contact'); ?>:</label></div>
        <div class="data">
          <?php print check_plain($profile_contact_other) ?>
          <?php if (!$profile_contact_other && $allowed_editor) { print l(t('Add any other contact details '),'user/'. $user -> uid .'/edit/B.+Contact+information') ;  } ?>
        </div></div>
      <?php } ?>

  <?php } ?>
<?php }?>




<?php if($profile_mapmaker_role_other) { ?>
  <div class="item"><div><label><?php print t('Role'); ?>:</label></div><div class="data"> <?php print check_plain($profile_mapmaker_role_other) ?></div></div>
<?php } elseif($profile_project_role || $allowed_editor) { ?>
  <div class="item <?php if (!$profile_project_role && $allowed_editor) { print 'required'; } ?>">
    <div><label><?php print t('Role'); ?>:</label></div>
    <div class="data">
      <?php print check_plain($profile_project_role) ?>
      <?php if (!$profile_project_role && $allowed_editor) { print l(t('Add your role*'),'user/'. $user -> uid .'/edit/C.+Mapmaker+information',$attributes_required); } ?>
    </div></div>
<?php }?>


<?php if($profile_mapmaker_firstlanguage_other || $profile_languages || $allowed_editor) { ?>
  <div class="item"><div><label><?php print t('First Language'); ?>:</label></div><div class="data">
    <?php if ($profile_mapmaker_firstlanguage_other) {
      print check_plain($profile_mapmaker_firstlanguage_other) . '&nbsp;' ;
    } ?>
    <?php if ($profile_languages && ($profile_languages != 'Other')) {
        print check_plain($profile_languages);
    } ?>
    <?php if (!$profile_languages && $allowed_editor) { print l(t('Add your first language'),'user/'. $user -> uid .'/edit/C.+Mapmaker+information'); } ?>
  </div></div>
<?php } ?>


<?php if($profile_langues_other || $allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Languages'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_langues_other);  ?>
    <?php if (!$profile_langues_other && $allowed_editor) { print l(t('Add other languages you speak'),'user/'. $user -> uid .'/edit/C.+Mapmaker+information');  } ?>
  </div>
</div>
<?php }?>



<?php if($profile_project_address && $allowed_editor) { ?>
<div class="item <?php if (!$profile_project_address && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Address'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_project_address) { ?>
      <?php print check_markup($profile_project_address); ?>
    <?php } ?>
    <?php if (!$profile_project_address && $allowed_editor) { print l(t('Add your address*'),'user/'. $user -> uid .'/edit/B.+Contact+information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>





<?php if($profile_organization_website || $allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Website'); ?>:</label></div>
  <div class="data">
    <?php
    if ($profile_organization_website) {
      $profile_organization_website = check_plain($profile_organization_website);
      if (substr($profile_organization_website,0,7) != 'http://' &&
          substr($profile_organization_website,0,8) != 'https://') {
        $profile_organization_website = 'http://'. $profile_organization_website;
      }
      printf('<a href="%s">%s</a>', $profile_organization_website, $profile_organization_website);
    }
    else {
      print l(t('Add your website'),'user/'. $user -> uid .'/edit/A.+Organization+details');
    }
    ?>
  </div>
</div>
<?php }?>


</fieldset>


</div><!-- > leftprofile_topright ends -->


<div id="leftprofile">

<!-- > ABOUT THE ORG -->

<fieldset>
<?php if($profile_introduction || $allowed_editor) { ?>
<?php if (!$profile_introduction) { print 'required'; } ?><legend><?php print t('About this Mapmaker'); ?></legend>

<div class="item">
  <?php if ($profile_introduction) { print check_markup($profile_introduction); }
    else { ?>

    <?php print check_plain($profile_introduction); ?>
    <?php if (!$profile_introduction && $allowed_editor) { print l(t('Write an introduction to your project*'),'user/'. $user -> uid .'/edit/D.+Statement+of+Purpose',$attributes_required);  } ?>
  <?php } ?>
</div>
<?php }?>
</fieldset>

<!-- > STATEMENT OF PURPOSE -->

<fieldset>
<?php if($profile_statement_of_purpose || $allowed_editor) { ?>

<?php if (!$statement_complete) { print 'required'; } ?><legend><?php print t('Statement of Purpose'); ?></legend>

<div class="item">
   
   <?php if ($profile_statement_of_purpose)  { print '<div class="scrollbar">' .check_markup($profile_statement_of_purpose) . "</div>"; }
    else { ?>

      <?php if (!$profile_statement_of_purpose && $allowed_editor) { print l(t('Add your statement of purpose*'),'user/'. $user -> uid .'/edit/D.+Statement+of+Purpose', $attributes_required);  } ?>
  
  <?php } ?>
</div>
<?php }?>
</fieldset>


<!-- > LOCAL LANGUAGE OVERVIEW -->

<fieldset>
<?php if($profile_local_overview || $allowed_editor) { ?>

<?php if(!$profile_local_overview)?><legend><?php print t('Local Language Overview'); ?></legend>

<div class="item">
    <?php if ($profile_local_overview) { 
    
   
    print '<div class="scrollbar">' .check_markup($profile_local_overview) . "</div>"; }

    else { ?>
    
      <?php if (!$profile_local_overview && $allowed_editor) { print l(t('Add an overview of your project in your local language'),'user/'. $user -> uid .'/edit/D.+Statement+of+Purpose');  } ?>
  
  <?php } ?>
</div>
<?php }?>
</fieldset>

<?php
  $latitude = $user -> gmap_location_latitude;
  $longitude = $user -> gmap_location_longitude;
  if(($latitude > '') && ($longitude > '')) { $location_set = TRUE; }

?>


<!-- > BLOGS -->

<fieldset>
<?php if(!$new_user) { // don't show blog box if they're a new user ?>
<legend><?php print t('Blogs'); ?></legend>
<div class="blog">

<?php // set the messages to allow them to add another blog post, or add 1st post, if user is viewing own account
if ($allowed_editor && !$new_user) {
$add_first_blog = '<a class="mapmakers" href="' . base_path() . $i18n_langpath . '/node/add/blog">' . t('Add a blog post') . '</a>';
$add_a_blog = '<br /><a class="mapmakers" href="' . base_path() . $i18n_langpath . '/node/add/blog">' . t('Add another blog post') . '</a>';
}
?>

<?php $userid=$user->uid; ?>
<?php $result = db_query("SELECT n.created, n.title, n.nid, n.changed FROM node n WHERE n.uid = $userid AND n.type = 'blog' AND n.status = 1 ORDER BY n.changed DESC LIMIT 4");
$num_rows = db_num_rows($result);?>

<?php $output .= "<div class=\"plain-list\"><ul>\n"; ?>

<?php $list = node_title_list($result); ?>
<?php $output .= strip_tags($list) ? $list . $add_a_blog : t('No Blog Postings') . '<br />' . $add_first_blog; ?>

<?php $output .= "</ul></div>"; ?>
<?php
  print ($output);
  if($num_rows > 3) {
    print l(t('see all blogs') . '...','mapmaker_blogs/' . $userid);
  }
  ?>
  </div>
<?php } // end if that's hiding blogs for new user ?>

</fieldset>


</div> <!-- > Left Profile Div End -->



<!-- > RIGHT PROFILE -->

<div id="rightprofile">

<?php if ($allowed_editor) { ?>
    <fieldset>
    <?php print l(t('Edit Your Profile'), 'user/' . $user->uid . '/edit');?>
    </fieldset>
<?php } ?>


<?php if ($lapsing_user && $allowed_editor) { ?>
  <fieldset class="collapsible required"><legend><?php print t('YOUR MAPMAKER FEE IS NOW DUE'); ?></legend>
    <div class="required">
      <p><?php print t('Your Mapmaker Fee is now due. Please follow the instructions below. If you believe there has been a mistake, please ') . l(t('contact us'),'contact'); ?></p>
      <p><?php print t('If your project is complete and you wish to terminate your Mapmaker License, please %link. Otherwise follow the steps below to continue:', array('%link' => l(t('click here'),'user/terminate'))); ?></p>
      <ol>
        <li><?php print t('Use the calculator to check your Mapmaker Fee for this year. The figure below shows the Fee you calculated last year: ') . l(t('Click to use the calculator'),'user/' . $user->uid . '/edit/F.+Fees'); ?></li>
        <li><?php print t('Use the link below to pay the Mapmaker Fee that you have calculated. If you are unable to pay using Visa/Mastercard/Paypal please ') . l(t('contact us'),'contact'); ?>
          <?php // find some way to insert the paypal link ?>
          <div>
            <form action="http://www.paypal.com/cgi-bin/webscr" method="post" >

            <input name="amount"  id="donationinput" value="<?php print $profile_fee_total; ?>"/>
            <input type="submit" name="submit" value="Pay" />
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="info@greenmap.org">
            <input type="hidden" name="item_name" value="Mapmaker Fee Renewal Payment for Green Map System - <?php print $user->name; ?>">
            <input type="hidden" name="notify_url" value="http://greenmap.org/greenhouse/lm_paypal/ipn">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="return" value="http://greenmap.org/greenhouse/pay/thanks">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="custom" value="<?php print $user->uid; ?>">

            </form>
          </div>
        </li>
        <li><?php print t('If you are unable to pay your full Mapmaker Fee, please complete the form below to tell us about what services you have provided in the last year to Green Map System, and what services you will be able to provide next year. Green Map System will respond within a week. Things you can help with include translation, outreach, poster design, newsletter design, etc. Please give details about languages and technical skills. ') ?>
          <div>
            <?php // insert form ?>
            <?php $block = module_invoke('feepay', 'block', 'view', 0);
            print $block['content']; ?>
          </div>
        </li>
      </ol>
    </div>
  </fieldset>
<?php } ?>

<?php if ($allowed_editor && $new_user) { // message for new users ?>
  <fieldset class="collapsible"><legend><?php print t('INSTRUCTIONS'); ?></legend>
  <div><strong>
  <?php if (!$complete && !$profile_pending) { ?>
    <?php print t('IMPORTANT: Your application has not been submitted yet. You need to fill in the information below.'); ?><br><br><span class="red">
    <?php
      if ( ! $user->picture ) {
        print t('You must upload a profile picture. Click Edit Your Profile (above, in blue) and scroll down to add your logo, photo of your community or group. Everything with a red asterisk is required. Blue links are optional. These links are not visible to the public. You can edit your information at any time. ');
      }
     ?>
     </span><br><br>
    <?php print t('Once all the required information is complete you will be able to click the "Submit to Green Map" button at the bottom of the page. '); ?>
  <?php } elseif ($complete && !$profile_pending) { ?>
    <?php print t('Your application is now complete. You must click the "Submit to Green Map" button at the bottom of the page.'); ?><br><br>
  <?php } elseif ($complete && $profile_pending && !($profile_pending_reason > '')) { ?>
    <?php print t('Your application has been submitted for review by Green Map Sytem. If you have not heard back in two working days please email greenhouse@greenmap.org.'); ?><br><br>
  <?php }  elseif ($complete && $profile_pending && ($profile_pending_reason == 'Payment requested') ) { ?>
    <?php print t('You have been emailed by Green Map System with instructions on how to pay your Mapmaker Fee. Once Green Map System has received your payment your account will be approved.  If you have not received the email please contact greenhouse@greenmap.org.'); ?><br><br>
  <?php }  elseif ($complete && $profile_pending && ($profile_pending_reason > '') ) { ?>
    <?php print t('You have been emailed by Green Map System with instructions on how to complete your application. Once you have made these changes please click the <em>Resubmit</em> button below. If you have done this and not heard back from Green Map within two working days please email greenhouse@greenmap.org.'); ?><br><br>
    <?php // insert Resubmit button here
    $block = module_invoke('greenmap', 'block', 'view', 3);
    print $block['content'];?>
  <?php } ?>
  </strong></div>
  </fieldset>
<?php } // end of new user message ?>


<?php if ($lapsed_user && !$allowed_editor) { ?>
  <fieldset class="collapsible required"><legend><?php print t('No Longer an Active Project'); ?></legend>
    <div class="required">
      <?php print t('This is no longer an active project. If you would like to start a Green Map project in this community, please go to the %link section of the website and register.', array('%link' => l(t('Participate'),'participate'))) ; ?>
    </div>
  </fieldset>
<?php } ?>

<?php if ($lapsed_user && $allowed_editor) { ?>
  <fieldset class="collapsible required"><legend><?php print t('YOUR PROJECT IS NO LONGER ACTIVE'); ?></legend>
    <div class="required">
      <p>
      <?php print t('As your project is no longer active and your Mapmaker Fee has not been paid, other people will now be able to make a Green Map
            in this community. If you wish to resume your project, or if you believe there has been a mistake, please ') . l(t('contact us'),'contact'); ?>
      </p>
      <p>
      <?php print t('Your Mapmaker License Agreement is now terminated. As agreed when you registered with Green Map System, this means that you no longer
              have rights to use GMSs Licensed Materials, nor have the right to print or publish any new versions or editions as an official Green
              Map. Any Green Map created during your Licensed Term can be displayed and disseminated "as is", without any updating. From your notice
              of termination, you may not promote, announce or solicit funds or develop your Green Map. You may not in any way profit from your
              terminated license (although you may offer your research, base maps, expertise, etc. on a voluntary basis to a new Mapmaker in your area).'); ?>
      </p>
      <p>
      <?php print t('If you wish to re-start this project please ') . l(t('contact us'),'contact'); ?>
      </p>
    </div>
  </fieldset>
<?php } ?>




<?php // Set up a collapsible block for admins showing all info they need for a new user ?>

<?php if ($is_admin) { ?>
  <fieldset class="collapsible collapsed"><legend><?php print t('Administration Information for New Users'); ?></legend>
    <div class="item">
      <div><label><?php print t('Username'); ?></label></div>
      <div class="data"><?php print $user->name . ' [' .  l(t('edit'),'user/' . $user->uid . '/edit/G.+Administration') . ']'; ?></div>
    </div>
    <div class="item">
      <div><label><?php print t('Real Name'); ?></label></div>
      <div class="data"><?php print $profile_project_name_first . '&nbsp;' . $profile_project_name_last; ?></div>
    </div>
    <div class="item">
      <div><label><?php print t('Email'); ?></label></div>
      <div class="data"><?php print $user->mail; ?></div>
    </div>
    <div class="item">
      <div><label><?php print t('User ID'); ?></label></div>
      <div class="data"><?php print $user->uid; ?></div>
    </div>
    <div class="item">
      <div><label><?php print t('Fee'); ?></label></div>
      <div class="data"><?php print $profile_fee_total . t(' (total)'); ?>
        <?php if ($profile_fee_afford_to_pay > '') { print ', ' . $profile_fee_afford_to_pay . t(' (can afford)'); } ?>
      </div>
    </div>
    <div class="item">
      <div><label><?php print t('Term'); ?></label></div>
      <div class="data"><?php print $profile_fees_term ; ?></div>
    </div>

    <?php if ($profile_pending_reason > '') { ?>
    <div class="item">
      <div><label><?php print t('Pending'); ?></label></div>
      <div class="data"><?php print $profile_pending_reason ; ?></div>
    </div>
    <?php } ?>
    <?php if ($profile_registration_comments > '') { ?>
    <div class="item">
      <div><label><?php print t('Comments'); ?></label></div>
      <div class="data"><?php print $profile_registration_comments ; ?></div>
    </div>
    <?php } ?>
    <div class="item">
      <div><label><?php print t('Payment link'); ?></label></div>
      <?php $username_safe = $user->name;
      $username_safe = str_replace (" ", "", $username_safe); // remove spaces from username for using in url ?>
      <div class="data"><?php print 'http://www.greenmap.org/greenhouse/pay?amount=' . $profile_fee_total . '&uid=' . $user->uid . '&username=' . $username_safe; ?></div>
    </div>
    <div class="item">
      <div><label><?php print t('Useful links'); ?></label></div>
      <div class="data">
        <a href="<?php print file_create_url('/gms/admin/en/1._New_Mapmaker_Inquiries.doc'); ?>" target="_blank"><?php print t('1. New Mapmaker Inquiries'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/1._New_Mapmaker_Inquiries_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/1._New_Mapmaker_Inquiries_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/1._New_Mapmaker_Inquiries_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/1._New_Mapmaker_Inquiries_ja.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/1._New_Mapmaker_Inquiries.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>
      <div class="data">
        <a href="<?php print file_create_url('gms/admin/en/2.1._Welcome_New_Mapmakers.rtf'); ?>" target="_blank"><?php print t('2.1 Welcome New Mapmakers'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/2.1._Welcome_New_Mapmakers_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/2.1._Welcome_New_Mapmakers_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/2.1._Welcome_New_Mapmakers_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/2.1._Welcome_New_Mapmakers_ja.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/2.1._Welcome_New_Mapmakers.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>
      <div class="data">
        <a href="<?php print file_create_url('gms/admin/en/2.2_You_are_Approved_Existing_Mapmaker.rtf'); ?>" target="_blank"><?php print t('2.2 You Are Approved Existing Mapmaker'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/2.2._Your_are_Approved_Existing_Mapmaker_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/2.2_You_are_Approved_Existing_Mapmaker_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/2.2_You_are_Approved_Existing_Mapmaker_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/2.2_approved_existing_mapmaker_JP.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/2.2_You_are_Approved_Existing_Mapmaker.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>
      <div class="data">
        <a href="<?php print file_create_url('gms/admin/en/2._Welcome_Please_Pay_Fee.doc'); ?>" target="_blank"><?php print t('2. Welcome Please Pay Fee'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/2._Welcome-Please_Pay_Fee-May_07_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/2._Welcome-Please_Pay_Fee-May_07_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/2._Welcome-Please_Pay_Fee-May_07_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/2_please_pay_JP.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/2._Welcome-Please_Pay_Fee.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>
      <div class="data">
        <a href="<?php print file_create_url('gms/admin/en/3_Mapmakers_Intro_Attachment.doc'); ?>" target="_blank"><?php print t('3. Mapmakers Intro Attachment'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/3._Mapmakers_Intro_Attachment_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/3._Mapmakers_Intro_Attachment_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/3._Mapmakers_Intro_Attachment_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/3_mapmakers_intro_attachJP.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/3_mapmakers_intro_attachID.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>
      <div class="data">
        <a href="<?php print file_create_url('gms/admin/en/4._Please_change_user_name.doc'); ?>" target="_blank"><?php print t('4. Please Change User Name'); ?></a>
        <a href="<?php print file_create_url('gms/admin/es/4._Please_change_user_name_ES.doc'); ?>" target="_blank"><?php print t('(ES)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/zh/4._Please_change_user_name_cn_s.doc'); ?>" target="_blank"><?php print t('(CNS)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/cnt/4._Please_change_user_name_cn_t.doc'); ?>" target="_blank"><?php print t('(CNT)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/ja/4._change_user_name_JP.doc'); ?>" target="_blank"><?php print t('(JA)'); ?></a>
        <a href="<?php print file_create_url('gms/admin/id/4._Please_change_user_name.doc'); ?>" target="_blank"><?php print t('(ID)'); ?></a>
      </div>

    </div>
  </fieldset>
<?php } ?>


<?php if($supporting || $sustaining) { ?>
  <fieldset class="collapsible"><legend>Support to Green Map System</legend>
  <div>
  <?php print $user->name; ?> is a <?php if($supporting) { print 'supporting'; } else { print 'sustaining' ; } ?> Mapmaker.
  <?php print $supporting . $sustaining ; // print stars ?>
  </div>
  </fieldset>

<?php } // end supporting/sustaining fieldset ?>




<?php if($allowed_editor) { ?>
  <fieldset class="collapsible collapsed" <?php if (!$reginfo_complete) { print 'required'; } ?>><legend><?php print t('Your Registration Information'); ?></legend>

<?php if($profile_team_skills || $allowed_editor) { ?>
<div class="item <?php if (!$profile_team_skills && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Team Skills'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_team_skills); ?>
    <?php if (!$profile_team_skills && $allowed_editor) { print l(t('Add your team skills*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_background_big_issues || $allowed_editor) { ?>
<div class="item <?php if (!$profile_background_big_issues && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Issues'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_background_big_issues); ?>
    <?php if (!$profile_background_big_issues && $allowed_editor) { print l(t('Add information about the big issues in your area*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_background_other_resources || $allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Resources'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_background_other_resources);  ?>
    <?php if (!$profile_background_other_resources && $allowed_editor) { print l(t('Add details of other resources you have'),'user/'. $user -> uid .'/edit/E.+Registration+Information');  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_check_greenmap || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_check_greenmap && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Other Projects'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_check_greenmap); ?>
    <?php if (!$profile_check_greenmap && $allowed_editor) { print l(t('Have you checked for other local projects?*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>



<?php if($allowed_editor && $new_user) { ?>
<div class="item">
  <div><label><?php print t('Local Projects'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_check_local);  ?>
    <?php if (!$profile_check_local && $allowed_editor) { print l(t('If there is a local project already, please describe how you will work with them'),'user/'. $user -> uid .'/edit/E.+Registration+Information');  } ?>
  </div>
</div>
<?php }?>




<?php if($profile_how_find_out || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_how_find_out && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Marketing'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_how_find_out); ?>
    <?php if (!$profile_how_find_out && $allowed_editor) { print l(t('How did you hear about Green Map?*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_consultant || $allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Consultancy'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_consultant);  ?>
    <?php if (!$profile_consultant && $allowed_editor) { print l(t('If you are a consultant please provide details of your work'),'user/'. $user -> uid .'/edit/E.+Registration+Information');  } ?>
  </div>
</div>
<?php }?>



<?php if($profile_business || $allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Business'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_business);  ?>
    <?php if (!$profile_business && $allowed_editor) { print l(t('If you are a business please tell us about your Environmental and CSR policies'),'user/'. $user -> uid .'/edit/E.+Registration+Information');  } ?>
  </div>
</div>
<?php }?>
<?php } ?>
</fieldset>



<?php if($allowed_editor) { ?>
  <fieldset class="collapsible collapsed <?php if (!$agreement_complete) { print 'required'; } ?>"><legend><?php print t('Terms &amp; Conditions'); ?></legend>

<?php if($profile_terms_and_conditions || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_terms_and_conditions && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('T &amp; Cs'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_terms_and_conditions == '1') { print t('Agreed'); } ?>
    <?php if (!$profile_terms_and_conditions && $allowed_editor) { print l(t('Click here to read and agree to the Terms and Conditions*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_release_form_agreement || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_release_form_agreement && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Release Form'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_release_form_agreement == '1') { print t('Agreed'); } ?>
    <?php if (!$profile_release_form_agreement && $allowed_editor) { print l(t('Click here to read and agree to the Release Form*'),'user/'. $user -> uid .'/edit/E.+Registration+Information',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


  </fieldset>
<?php } ?>




<?php if($allowed_editor) { ?>
  <fieldset class="collapsible collapsed <?php if (!$fees_complete) { print 'required'; } ?>"><legend><?php print t('Fees'); ?></legend>

<?php if($profile_payment_fee || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_payment_fee && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Calculated Fee'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_payment_fee) { ?>
      <?php print check_plain($profile_payment_fee) . ' - ' . t('This is your Service Support Fee based on your location, organization type, term of project, and whether you chose to double or triple your payment to become a supporting or sustaining mapmaker'); ?>
    <?php } ?>
    <?php if (!$profile_payment_fee && $allowed_editor) { print l(t('Calculate your Service Support Fee*'),'user/'. $user -> uid .'/edit/F.+Fees',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($profile_fees_organization_type || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_fees_organization_type && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Organization'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_fees_organization_type); ?>
    <?php if (!$profile_fees_organization_type && $allowed_editor) { print l(t('Enter your organization type to calculate your fee*'),'user/'. $user -> uid .'/edit/F.+Fees',$attributes_required);  } ?>
  </div>
</div>
<?php }?>

<?php if($profile_fees_term || $allowed_editor) {  ?>
<div class="item <?php if (!$profile_fees_term && $allowed_editor) { print 'required'; } ?>">
  <div><label><?php print t('Term'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_fees_term) { ?>
      <?php print t('You have requested to pay for ') . check_plain($profile_fees_term) . t(' year(s)'); ?>
    <?php } ?>
    <?php if (!$profile_fees_term && $allowed_editor) { print l(t('Enter how many years you wish to pay for*'),'user/'. $user -> uid .'/edit/F.+Fees',$attributes_required);  } ?>
  </div>
</div>
<?php }?>


<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Support'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_fee_double && !$profile_fee_treble && $new_user) { print l(t('Double or treble your fee to become a Supporting or Sustaining Mapmaker.
          Your support will be recognised on the website.'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_fee_double && $allowed_editor) { print t('You have DOUBLED your fee to become a Supporting Mapmaker - Thanks!');  } ?>
    <?php if ($profile_fee_treble && $allowed_editor) { print t('You have TREBLED your fee to become a Sustaining Mapmaker - Thanks!');  } ?>
    <?php if (!$profile_fee_double && !$profile_fee_treble && !$new_user) { print t('You did not choose to become a Supporting or Sustaining Mapmaker when you registered.
          You can donate double or triple your Fee at any time to become a Supporting or Sustaining Mapmaker - just use the box on the right');  } ?>
  </div>
</div>
<?php }?>

<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Donate'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_admin_donate && $new_user) { print l(t('Click to donate money to Green Map'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_admin_donate && $allowed_editor) { print check_plain($profile_admin_donate);  } ?>
    <?php if (!$profile_admin_donate && !$new_user) { print t('You did not choose to donate extra money to Green Map System when you registered.
          You can donate  at any time to become a Supporting or Sustaining Mapmaker - just use the box on the right');  } ?>
  </div>
</div>
<?php }?>

<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Mapmaker Kit'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_fee_purchase_kit && $new_user) { print l(t('Click to buy a Mapmaker Kit when you register'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_fee_purchase_kit == '1' && $allowed_editor) { print t('You have requested a Mapmaker Kit');  } ?>
    <?php if (!$profile_fee_purchase_kit && !$new_user) { print t('You did not choose to buy a Mapmaker Kit when you registered.
          You can buy one  at any time  - just contact info@greenmap.org');  } ?>
  </div>
</div>
<?php }?>

<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Total Fee'); ?>:</label></div>
  <div class="data">
    <?php if ($profile_fee_total) { print check_plain($profile_fee_total) . ' - ' . t('This is the total including all donations, the Mapmaker Kit, etc.'); } else { print '&nbsp;'; } ?>
  </div>
</div>
<?php }?>

<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Fee Reduction'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_fee_reduce_fees && $new_user) { print l(t('Are you unable to pay the full fee?'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_fee_reduce_fees == '1' && $allowed_editor) { print t('You have requested to pay a reduced fee');  } ?>
    <?php if (!$profile_fee_reduce_fees && !$new_user) { print t('No');  } ?>
  </div>
</div>
<?php }?>

<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Reduced Fee'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_fee_afford_to_pay && $new_user) { print l(t('What can you afford to pay?'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_fee_afford_to_pay && $allowed_editor) { print check_plain($profile_fee_afford_to_pay);  } ?>
  </div>
</div>
<?php }?>


<?php if($allowed_editor) {  ?>
<div class="item <?php if (!$profile_service && $allowed_editor && ($profile_fee_afford_to_pay  || $profile_fee_reduce_fees )) { print 'required'; } ?>">
  <div><label><?php print t('Services'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_service); ?>
    <?php if (!$profile_service && $allowed_editor && ($profile_fee_afford_to_pay  || $profile_fee_reduce_fees )) { print l(t('Tell us about the services you can provide to the Green Map Network. As you have requested to pay
                                  a reduced fee this information is required*'),'user/'. $user -> uid .'/edit/F.+Fees',$attributes_required);  }
    elseif (!$profile_service && $allowed_editor) { print l(t('Tell us about the services you can provide to the Green Map Network.'),'user/'. $user -> uid .'/edit/F.+Fees');}?>
  </div>
</div>
<?php }?>


<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Tax Letter'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_tax_letter && $new_user) { print l(t('Would you like a letter acknowledging payment from GMS?'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if ($profile_tax_letter == '1' && $allowed_editor) { print t('You have requested a tax letter');  } ?>
    <?php if (!$profile_tax_letter && !$new_user) { print t('No');  } ?>
  </div>
</div>
<?php }?>



<?php if($allowed_editor) { ?>
<div class="item">
  <div><label><?php print t('Payment'); ?>:</label></div>
  <div class="data">
    <?php if (!$profile_payment_method && $new_user) { print l(t('Choose your payment method'),'user/'. $user -> uid .'/edit/F.+Fees');  } ?>
    <?php if (($profile_payment_method || $profile_fee_otherpayment) && $allowed_editor) { print check_plain($profile_payment_method) . '&nbsp;' . check_plain ($profile_fee_otherpayment);  } ?>
  </div>
</div>
<?php }?>

  </fieldset>
<?php } ?>


<?php if($allowed_editor) { ?>
  <fieldset class="collapsible collapsed <?php if (!$profile_grammerspelling) { print 'required'; } ?>"><legend><?php print t('Administration'); ?></legend>


<div class="item <?php if (!$profile_grammerspelling) { print 'required'; } ?>">
  <div><label><?php print t('Spell Check'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_grammerspelling); ?>
    <?php if (!$profile_grammerspelling && $allowed_editor) { print l(t('Would you like your spelling and grammar checked?*'),'user/'. $user -> uid .'/edit/G.+Administration',$attributes_required);  } ?>
  </div>
</div>

</fieldset>
<?php } ?>


<?php if($allowed_editor) { ?>
  <fieldset class="collapsible collapsed"><legend><?php print t('Services'); ?></legend>


<div class="item">
  <div><label><?php print t('Consultancy'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_exchange_consulting); ?>
    <?php if (!$profile_exchange_consulting && $allowed_editor) { print l(t('What consultancy do you offer?'),'user/'. $user -> uid .'/edit/H.+Exchange');  } ?>
  </div>
</div>

<div class="item">
  <div><label><?php print t('Presentations'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_exchange_offline); ?>
    <?php if (!$profile_exchange_offline && $allowed_editor) { print l(t('What presentations can you give?'),'user/'. $user -> uid .'/edit/H.+Exchange');  } ?>
  </div>
</div>

<div class="item">
  <div><label><?php print t('Hospitality'); ?>:</label></div>
  <div class="data">
    <?php print check_plain($profile_exchange_visiting); ?>
    <?php if (!$profile_exchange_visiting && $allowed_editor) { print l(t('What hospitality can you offer visiting Mapmakers?'),'user/'. $user -> uid .'/edit/H.+Exchange');  } ?>
  </div>
</div>


  </fieldset>
<?php } ?>



<?php if($allowed_editor && (!$user_picture || !$location_set)) { ?>
  <fieldset class="collapsible collapsed required"><legend><?php print t('Final Details'); ?></legend>

<?php if (!$user_picture) { ?>
<div class="item required">
  <div><label><?php print t('Picture'); ?>:</label></div>
  <div class="data">
    <?php print l(t('You need to add a picture of your organization*'),'user/' . $user->uid . '/edit',$attributes_required);   ?>
  </div>
</div>
<?php } ?>


<?php if (!$location_set) { ?>
<div class="item required">
  <div><label><?php print t('Location'); ?>:</label></div>
  <div class="data">
    <?php print l(t('You need to enter your location*'),'user/'. $user -> uid .'/edit/gmap_user',$attributes_required);   ?>
  </div>
</div>
<?php } ?>
  </fieldset>
<?php } ?>






<!-- > MAPS BY MAPMAKER -->
<?php if(!$new_user) { // don't show maps box if they're a new user ?>
<fieldset><legend><?php print t('Maps by this Mapmaker'); ?></legend>

<?php
$userid=$user->uid;

// $result = pager_query($sql, $nlimitmap);
$result = db_query("SELECT n.created, n.title, n.nid, n.changed FROM node n WHERE n.uid = $userid AND n.type = 'content_map' AND n.status = 1 ORDER BY n.changed DESC LIMIT 10");

$num_rows = db_num_rows($result);
$num_rows_map = $num_rows;

$rows = array();
if ( function_exists('sync_fetch_ogm_maps') ) {
  $ogm_maps = sync_fetch_ogm_maps($user->uid);
}
else {
  watchdog('sync', "A call to a sync function in user_profile.tpl.php (in the theme) failed.");
}


// Loading OGM maps
if (is_array($ogm_maps) && count($ogm_maps)) {
  print "Open Green Maps";
  foreach ($ogm_maps as $ogm_map) {
    $rows[] = l($ogm_map->title, 'http://www.opengreenmap.org/'. $ogm_map->alias,
        array('class' => 'external', 'target' => '_blank'));
  }
  $output = theme_item_list($rows);
  print '<div class="plain-list ogm-maps">'.$output.'</div>';
}

// Loading GM maps
$rows = array();
if($num_rows > 0) {
  while ($this_node = db_fetch_object($result)) {
    // $this_node = node_load(array('nid' => $this_node->nid));
    $rows[] = l($this_node->title,'node/' . $this_node->nid);
  }

  $output = theme_item_list($rows);
  ?>
  
  <div class="plain-list">
   
  <?php
  print "Green Maps";
  print ($output);
  
  if($num_rows > 9) {
    print l(t('more') . '...','maps/by/user/' . $userid);
  }
  print $add_a_map;
  ?>

  </div>
  <?php
}
else {
  print t('No Green Maps Added') . '<br />' . $add_first_map ;
}
?>
</fieldset>
<?php } // end if that's hiding maps for new user ?>

<!-- > LOCATION MAP -->

<?php if ($location_set || $allowed_editor) : ?>
<fieldset <?php if (!$location_set) { print 'required'; } ?> ><legend><?php print t('Location'); ?></legend>
  <div id="gmap">
  <?php

  if($location_set) {

    $macro = '[gmap |id=map |center=' . $latitude . ', ' . $longitude ;
    $macro .= ' |zoom=0 |width=100% |height=150 |control=Small |type=Map |tcontrol=off | markers=greenhouse/icon_greenmap_google::';
    $macro .= $latitude . ',' . $longitude . ']';

    $mymap = gmap_parse_macro($macro);
    print gmap_draw_map($mymap);
   } elseif ($allowed_editor) {
      $url = base_path() . $i18n_langpath . '/user/' . $user->uid . '/edit/gmap_user'; ?>
      <?php print t('You have not set your location on the map.'); ?> 
      <a class="mapmakers required" href="<?php print $url; ?>">
      <?php print t('Click here to set your location*'); ?></a>
  <?php } ?>
  </div>
</fieldset>
<?php endif ?>


<!-- > ORGANIZATION DETAILS -->


<fieldset <?php if (!$organization_complete) { print 'required'; } ?>>
<legend><?php print t('Related Organization'); ?></legend>


<div class="related_org">
<?php if($profile_organization_type || $allowed_editor) { ?>

<?php

$dict = array(
 'business' => 'mapmakers/list/organization/business',
 'community/grass roots' => 'mapmakers/list/organization/community',
 'governmental agency' => 'mapmakers/list/organization/individual',
 'individual' => 'mapmakers/list/organization/individual',
 'non-profit' => 'mapmakers/list/organization/nonprofit',
 'school' => 'mapmakers/list/organization/school',
 'tourism agency' => 'mapmakers/list/organization/tourism',
 'university/college' => 'mapmakers/list/organization/university',
 'youth' => 'mapmakers/list/organization/youth',
 'other ' => 'mapmakers/list/organization/other',
);
?>

<div class="item <?php if (!$profile_organization_type && $allowed_editor) { print 'required'; } ?>">
  <div class="data">
    <?php
     print l(check_plain(ucwords(check_plain($profile_organization_type))),
           $dict[$profile_organization_type]);
    ?>
    <?php if (!$profile_organization_type && $allowed_editor) { print l(t('Add your organization type*'),'user/'. $user -> uid .'/edit/A.+Organization+details',$attributes_required);  } ?>
  </div>
</div>

<?php } else {
  print t('No Organization Type Added');
}
?>

</div>
</fieldset>



<!-- > SOCIAL NETWORK CONNECT -->

<?php // Social Networks Fieldset in User profile?>
<?php if( $profile_facebook || $profile_twitter || $profile_youtube || $profile_flickr || $profile_hi5 || $profile_othersocial1 || $profile_othersocial2 || $profile_othersocial3)
  print t('<fieldset ><legend>Connect with Mapmaker</legend>' ); ?>

<div id="socialnetwork_img">

<?php if( $profile_facebook )
  print '<div><a href="'. $profile_facebook .'"><img src="'. $base_path . 'images/facebook.png'.'"></a></div>' ;?>

<?php if( $profile_twitter )
  print '<div><a href="'. $profile_twitter.'"><img src="'. $base_path . 'images/twitter.png'.'"</a></div>'; ?>
  
<?php if( $profile_youtube )
  print '<div><a href="'. $profile_youtube.'"><img src="'. $base_path . 'images/youtube.png'.'"</a></div>'; ?>
  
<?php if( $profile_flickr )
  print '<div><a href="'. $profile_flickr.'"><img src="'. $base_path . 'images/flickr.png'.'"</a></div>'; ?>
  
<?php if( $profile_hi5 )
  print '<div><a href="'. $profile_hi5.'"><img src="'. $base_path . 'images/other_sns_bubble.png'.'"</a></div>'; ?>

<?php if( $profile_othersocial1 )
  print '<div><a href="'. $profile_othersocial1.'"><img src="'. $base_path . 'images/other_sns_bubble.png'.'"</a></div>'; ?>

<?php if( $profile_othersocial2 )
  print '<div><a href="'. $profile_othersocial2.'"><img src="'. $base_path . 'images/other_sns_bubble.png'.'"</a></div>'; ?>

<?php if( $profile_othersocial3 )
  print '<div><a href="'. $profile_othersocial3.'"><img src="'. $base_path . 'images/other_sns_bubble.png'.'"</a></div>'; ?>

</div>

<?php if( $profile_facebook || $profile_twitter || $profile_youtube || $profile_flickr || $profile_hi5 || $profile_othersocial1 || $profile_othersocial2 || $profile_othersocial3)
  print t( '</fieldset>'); ?>
<?php // end Social Newtorks collapsible ?>



<!-- > ALBUMS -->
<div id="albums"><fieldset>

<?php
$photo_link = gm_getrecent_photo($userid);

if ($photo_link) {
	$recent_photo = ' <img src="' . $base_path . $photo_link .'" height="100px">';
}else{
	$recent_photo = false;
}



print "<legend>";
print t('Albums'); 
print "</legend>";


if ($allowed_editor && !$new_user) {
  	print l(t('Add an album'),'node/add/content_gallery',array('class' => 'mapmakers'));
  	print "<br/>";
} 

	
if($recent_photo){
   print l($recent_photo,'mapmaker_albums/' . $userid, null, null, null, null, true);
}  else {
   print t("No Albums Added");
}
?>

</fieldset></div>



<!-- > THINGS YOU NEED TO DO (for logged in users) -->

<?php if ($allowed_editor && !$new_user) { ?>
  <fieldset class="collapsible mapmakersbg"><legend><?php print t('Things You Need to Do'); ?> </legend>

  <?php
  $todo = 0;

  // add message to tell user to add self to Greenmap discussion in Organic Groups

    $groups = $user->og_groups;
  if($groups){
    $joined = FALSE;
    foreach($groups as $group){
      if($group[nid] == 2929) {
        $joined = TRUE;
      }
    }
  }
  else {
    $joined = FALSE;
  }

  if(!$joined) {
    ?><p class="mapmakers"><?php print t('You have not joined the Mapmakers Discussion group. This is where you can ask questions of other mapmakers, and
    share ideas. Posts here are automatically emailed to everyone in the group, so it is a great way to get help. ')
    . l(t('Click here to join'),'og/subscribe/2929',NULL,'destination=node/2929'); ?></p><?php
  }



//  $num_rows_map = mysql_num_rows($resultmap);
  if ($num_rows_map == 0) {
    $url = base_path() . $i18n_langpath . '/node/add/content_map'; ?>
  <p class="mapmakers"><?php print t('You have not added any Green Maps to your profile. Even if you just started developing your map, you can let everyone
  (including potential supporters) know about the goals of your work in progress.'); ?>
  <a href="<?php print $url; ?>"><?php print t('Click here to add a Green Map'); ?></a>.</p>
  <?php $todo = $todo + 1; ?>
  <?php }

  if(!($latitude > '') || !($longitude > '')) {
      $url = base_path() . $i18n_langpath . '/user/' . $user->uid . '/edit/gmap_user'; ?>
      <p class="mapmakers"><?php print t('You have not set your location on the map.'); ?> <a href="<?php print $url; ?>"><?php print t('Click here to set your location'); ?></a>.</p>
    <?php $todo = $todo + 1; ?>
  <?php } ?>

  <?php if (!($user->profile_exchange_consulting) && !($user->profile_exchange_offline) && !($user->profile_exchange_visiting)) {
    $url = base_path() . $i18n_langpath . '/user/' . $user->uid . '/edit/H.+Exchange+Services'; ?>
  <p class="mapmakers"><?php print t('You have not added anything to the Green Map Exchange. Adding this information lets other Green Mapmakers know about consultancy and other services that you offer, as well as any hospitality you can offer to visiting Mapmakers. '); ?>
  <a href="<?php print $url; ?>"><?php print t('Click here to add your Mapmakers Exchange information'); ?></a>.</p>
  <?php $todo = $todo + 1; ?>
  <?php } ?>

  <?php if($todo == 0) { ?>
    <p class="mapmakers"><?php print t('You have done all of the things that you need to do - thanks! You can still write more blog articles and add photos to your albums.'); ?></p>
  <?php } ?>

    </fieldset>
<?php } // end fieldset for things the user needs to do ?>


<?php if($new_user && $allowed_editor) { // print a form for the "Submit to Green Map" button ?>
<p></p>

  <?php if($complete && !$profile_pending) { '<p>' . print t('You are now ready to submit your Green Map registration form. Click the button below') . '</p>';
    $block = module_invoke('greenmap', 'block', 'view', 0);
    print $block['content'];
  } elseif (!$complete && !$profile_pending) { ?>

    <?php  print '<p>' .  t('You can not submit your application yet because you have not completed all required information') . '</p>' ; ?>
    <form><input name="submit" type="submit" id="submit" value="<?php print t('Submit to Green Map'); ?>" disabled ></form>

  <?php } elseif ($profile_pending) { ?>
    <?php  print '<p>' .  t('Your application has been submitted to Green Map System and is being checked. If you have not had a reply in over two working days please email ') .
           'greenhouse@greenmap.org</p>' ; ?>
  <?php } // end message if not complete ?>
<?php } // end submit form for new mapameker ?>

<p></p>
</div>

</div> 

<?php
// end else, for showing full page view.
}
elseif (!$teaser && !$not_hidden) { // if someone's trying to view a profile of an unregistered user then say this ?>
<p>This Mapmaker is in the process of registering. Please check back soon to find out more about what they are doing</p>
<?php }
?>

<style type="text/css">


#content fieldset{
  border: none;
}

#top{
  margin-left: -92px;
  margin-top: -16px;
}

#content h1 {
margin-left: 34px;
margin-top: -3px;
}

#content legend {
font-size: 15px;
margin-left: -3px;
}

#content fieldset legend, 
#content fieldsetrequired legend{
font-size: 15px;
margin-left: -3px;
color: #8CC63F;
}

#content {
	background-color:#ffffff;
	color: #4D4D4D;
	line-height: 1.5em;
	height: auto;
	font-size: 11.5px;
	margin-left: 40px;
	margin-top: 6px;
	padding-top: 25px;
	position: absolute;
	width: 820px;
	float: left;
	background-image: url("<?php print $base_path ?>images/mapmaker_icon.gif");
	background-repeat: no-repeat;
	background-position: 9px 19px; 
}

#rightprofile {
    margin-top: 10px;
}

html.js fieldset.collapsible, html.js fieldset.fakecollapsible {
  border: none;
}


html.js #content fieldset.required {
  border: none;
}

#content p a:hover, #content div.data a:hover, a:hover{
  color: #2E67B1;
  text-decoration: underline;
}

.plain-list ul li {
  list-style-image: url("<?php print $base_path ?>images/list.gif");
  margin: 0 0 0.15em;
  padding: 1px 0;
}

.plain-list ul {
	margin-left: 13px;
}

.blog .plain-list ul {
	margin-left: 7px;
}

#content p a, #content div.data a, a {
  font-size: 11.5px;
  font-weight: normal;
  text-decoration: none;
  color: #2E67B1;
}

ul.primary {
  border-collapse: collapse;
  display: none;
  padding: 0 0 0 1em;
  white-space: nowrap;
  list-style: none;
  margin: 0 0 15px -160px;
  height: auto;
  line-height: normal;
  border-bottom: 1px solid #F78F1E;
}

.red {
	color: red;
}

#content #socialnetwork_img img {
  float: left;
}

#content .scrollbar {
  width: 470px;
  height: 180px;
  overflow: auto;
  padding: 5px;
  border: solid 1px #999;
}



.related_org .item .data {
  margin-left: 0px;
}

#footer_gh {
visibility: hidden;
}

</style>

<!--[if IE 6]>
	<style type="text/css">
#content {
	margin-left: -70px !important;
	margin-top: -15px !important;
	width:900px;
	}
	
#rightprofile {margin-top: -330px;}

	</style>
<![endif]-->

<!--[if IE 7]>
	<style type="text/css">
#content {
	left: 100px !important;
	margin-top: -15px !important;
	width:900px;
	background: transparent;
	}
	
#rightprofile {margin-top: -330px;}

	</style>
<![endif]-->

<!--/user_profile.tpl.php-->
