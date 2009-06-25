<?php

/**
 * Checks that the given dependencies are installed
 * prior to updating. All subsequent updates are also
 * prevented from running if dependencies are not met. 
 */
function store_deps_update(&$ret, $module, &$deps) {
  return store_deps($ret, $module, $deps, FALSE);
}

/**
 * Checks that the given dependencies are installed
 * prior to installation.
 */
function store_deps_install($module, &$deps) {
  $ret = array();
  return store_deps($ret, $module, $deps, TRUE);
}

function store_check_deps(&$deps) {
  foreach ($deps as $key => $value) {
    if (module_exist($value)) {
      unset($deps[$key]);
    }
  }
}

function store_deps(&$ret, $module, &$deps, $install = TRUE) {
  store_check_deps($deps);
  
  if (count($deps)) {
    $op = $install ? t('install') : t('update');
    $errormsg = t('Can not %op the %module module until the following modules are installed:', array('%op' => $op, '%module' => $module));
    $errormsg .= '<ul><li>'.implode('</li><li>', $deps).'</li></ul>';
    drupal_set_message($errormsg, 'error');
    
    if ($install) {
      // reset the module to uninstalled state
      drupal_set_installed_schema_version($module, SCHEMA_UNINSTALLED);
      db_query("UPDATE {system} SET status = 0 WHERE type = 'module' AND name = '%s'", $module);
    } else {
      // remove updates for this module from the list of updates and report the error
      foreach ($_SESSION['update_remaining'] as $key => $value) {
        if ($value['module'] == $module) {
          unset($_SESSION['update_remaining'][$key]);
        }
      }
      $ret[] = array('success' => FALSE, 'query' => $errormsg);
      $ret['#finished'] = FALSE;
    }
    
    return FALSE;
  }
  
  return TRUE;
}