<?php

/**
 * @file
 * This file stores basic but essential Drupal site-specific settings. 
 */

#
# Instructions:
#
#   You will need to set the values of two mandatory variables in this file.
#   The first concerns your database connection and the second tells Drupal
#   where you website will be located. Optionally, you can specify additional
#   PHP settings at the end of this file.
#

#
# 1. Set your database connection and optional prefix.
#
#   The database connection string tells Drupal how to connect to your database,
#   where it's located and what its name is.
#
#   Some examples are:
#     $db_url = 'mysql://user:password@hostname/database';
#     $db_url = 'pgsql://user:password@hostname/database'; 
#
#   You should be able to get this information from your webhost or systems
#   administrator. Drupal cannot retreive or set this information for you.
#
#   Advanced users: To specify multiple connections for your site (i.e. for 
#   complex custom modules) you can also specify an associative array of $db_url 
#   variables with the 'default' element used until otherwise requested.
#
#   To set the value of the variable, please fill in a value:
$db_url['default'] = 'mysql://greenma2:q2n7yGEm@localhost/greenma2_greenhouse';
// $db_url['civicrm'] = 
'mysql://greenmap_12:p9A5zCGm@localhost/greenmap_greenhouse';

// $db_url['default'] = 'mysql://greenmap_12:p9A5zCGm@db82a.pair.com/greenmap_greenhouse';
// $db_url['civicrm'] = 'mysql://greenmap_12:p9A5zCGm@db82a.pair.com/greenmap_greenhouse';

#   Optional: If you would like to prefix the database tables used for this 
#   Drupal site, you may specify an alphanumeric prefix string. This setting
#   can be helpful if you are working with only one database.
#
#   Some examples could be:
#     $db_prefix = 'demosite_';
#     $db_prefix = 'userblog_';
#
#   If you do not want to prefix your tables, set the value to an empty string "".
# Note: the CiviCRM part of the database is not affected by the db prefix.
$db_prefix = '';

#
#  2. Set your site address:
#
#   The $base_url tells Drupal where to look for your website files. The value
#   should be a standard URL without a slash ("/") on the end. 
#
#   Some examples are:
#   $base_url = 'http://www.hostname.org';
#   $base_url = 'http://www.hostname.com/drupalsite';
# $base_url = 'http://www.greenmap.org/greenhouse';
#    $base_url = 'http://qs1844.pair.com/greenma2/greenhouse';

#
# 3. Advanced PHP settings:
#
#   Normally, you will not need to change your PHP settings. However, if you would 
#   like to make changes, take a look at the .htaccesss file in Drupal's root 
#   directory for an idea of the settings to override. If you get unexpected 
#   warnings or errors, double-check your PHP settings.

#   If required, you may set an alternate path to include your PEAR directory.
#   Simply remove the comment slashes ("//") and replace ".:/path/to/pear" with
#   the location of your PEAR directory.
# // ini_set("include_path", ".:/path/to/pear");
ini_set('session.cookie_lifetime',200000);
ini_set('session.gc_maxlifetime', 1814400);
ini_set('memory_limit', '128M');
# ini_set('session.save_handler', 'user');
# ini_set('session.use_only_cookies',1);
# ini_set('session.use_trans_sid', 0);

$conf = array(
#   'site_offline' => 's:1:"1";',
);

?>
