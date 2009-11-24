<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.5                                                |
 +--------------------------------------------------------------------+
 | Copyright (c) 2005 Donald A. Lobo                                  |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the Affero General Public License Version 1,    |
 | March 2002.                                                        |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the Affero General Public License for more details.            |
 |                                                                    |
 | You should have received a copy of the Affero General Public       |
 | License along with this program; if not, contact the Social Source |
 | Foundation at info[AT]socialsourcefoundation[DOT]org.  If you have |
 | questions about the Affero General Public License or the licensing |
 | of CiviCRM, see the Social Source Foundation CiviCRM license FAQ   |
 | at http://www.openngo.org/faqs/licensing.html                      |
 +--------------------------------------------------------------------+
*/

/**
 * This file contains the various menus of the CiviCRM module
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

define( 'CRM_CORE_MENU_CALLBACK',4);
define( 'CRM_CORE_MENU_NORMAL_ITEM',22);
define( 'CRM_CORE_MENU_LOCAL_TASK',128);
define( 'CRM_CORE_MENU_DEFAULT_LOCAL_TASK',640);
define( 'CRM_CORE_MENU_ROOT_LOCAL_TASK',1152);
$GLOBALS['_CRM_CORE_MENU']['_items'] =  null;
$GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'] =  null;
$GLOBALS['_CRM_CORE_MENU']['_localTasks'] =  null;
$GLOBALS['_CRM_CORE_MENU']['_params'] =  null;
$GLOBALS['_CRM_CORE_MENU']['processed'] =  false;

require_once 'CRM/Core/I18n.php';

class CRM_Core_Menu {
    /**
     * the list of menu items
     * 
     * @var array
     * @static
     */
    

    /**
     * the list of root local tasks
     *
     * @var array
     * @static
     */
    

    /**
     * the list of local tasks
     *
     * @var array
     * @static
     */
    

    /**
     * The list of dynamic params
     *
     * @var array
     * @static
     */
    

    /**
     * This is a super super gross hack, please fix sometime soon
     *
     * using constants from DRUPAL/includes/menu.inc, so that we can reuse 
     * the same code in both drupal and joomla
     */
    
                       
                   
                   
           
             
    
    /**
     * This function defines information for various menu items
     *
     * @static
     * @access public
     */
     function &items( ) {
        // helper variable for nicer formatting
        require_once 'CRM/Core/Permission.php';
        $drupalSyncExtra = ts('Synchronize Users to Contacts:') . ' ' . ts('CiviCRM will check each user record for a contact record. A new contact record will be created for each user where one does not already exist.') . '\n\n' . ts('Do you want to continue?');
        $backupDataExtra = ts('Backup Your Data:') . ' ' . ts('CiviCRM will create an SQL dump file with all of your existing data, and allow you to download it to your local computer. This process may take a long time and generate a very large file if you have a large number of records.') . '\n\n' . ts('Do you want to continue?');
 
        if ( ! $GLOBALS['_CRM_CORE_MENU']['_items'] ) {
            // This is the minimum information you can provide for a menu item.
            $GLOBALS['_CRM_CORE_MENU']['_items'] =
                array(
                      array(
                            'path'    => 'civicrm/admin',
                            'title'   => ts('Administer CiviCRM'),
                            'query'   => 'reset=1',
                            'access'  => CRM_Core_Permission::check('administer CiviCRM') &&
                                         CRM_Core_Permission::check( 'access CiviCRM' ),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_NORMAL_ITEM,
                            'weight'  => 9000,
                            ),

                      array(
                            'path'    => 'civicrm/admin/access',
                            'title'   => ts('Access Control'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/03.png',
                            'weight'  => 110
                            ),

                      array(
                            'path'    => 'civicrm/admin/backup',
                            'title'   => ts('Backup Data'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'extra' => 'onclick = "return confirm(\'' . $backupDataExtra . '\');"',
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/14.png',
                            'weight'  => 120
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/synchUser',
                            'title'   => ts('Synchronize Users-to-Contacts'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'extra' => 'onclick = "if (confirm(\'' . $drupalSyncExtra . '\')) this.href+=\'&amp;confirmed=1\'; else return false;"',
                            'adminGroup' => ts('Manage'),
                            'icon'    => 'admin/Synch_user.png',
                            'weight'  => 130
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/activityType',
                            'title'   => ts('Activity Types'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/05.png',
                            'weight'  => 210
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/uf/group',
                            'title'   => ts('CiviCRM Profile'),
                            'query'   => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/Profile.png',
                            'weight'  => 220
                            ),
                      
                      array(
                            'path'   => 'civicrm/admin/uf/group/field',
                            'title'  => ts('CiviCRM Profile Fields'),
                            'query'  => 'reset=1',
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_CALLBACK,
                            'weight' => 221
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/custom/group',
                            'title'   => ts('Custom Data'),
                            'query'   => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/custm_data.png',
                            'weight'  => 230
                            ),
                      
                      array(
                            'path'   => 'civicrm/admin/custom/group/field',
                            'title'  => ts('Custom Data Fields'),
                            'query'  => 'reset=1',
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_CALLBACK,
                            'weight' => 231
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/locationType',
                            'title'   => ts('Location Types (Home, Work...)'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/13.png',
                            'weight'  => 240
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/tag',
                            'title'   => ts('Tags (Categories)'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/11.png',
                            'weight'  => 260
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/mapping',
                            'title'   => ts('Import/Export Mapping'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/import_export_map.png',
                            'weight'  => 290
                            ),
                      
                      array(
                            'path'    => 'civicrm/contact/domain',
                            'title'   => ts('Edit Domain Information'),
                            'query'  => 'reset=1&action=update',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/domain.png',
                            'weight'  => 270
                            ),

                      array(
                            'path'    => 'civicrm/admin/reltype',
                            'title'   => ts('Relationship Types'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/rela_type.png',
                            'weight'  => 250
                            ),
                      array(
                            'path'    => 'civicrm/admin/optionGroup',
                            'title'   => ts('Options'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/option.png',
                            'weight'  => 280
                            ),
                      array(
                            'path'    => 'civicrm/admin/dupematch',
                            'title'   => ts('Duplicate Matching'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Configure'),
                            'icon'    => 'admin/duplicate_matching.png',
                            'weight'  => 239
                            ),

                      array(
                            'path'    => 'civicrm/admin/gender',
                            'title'   => ts('Gender Options (Male, Female...)'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/01.png',
                            'weight'  => 310
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/IMProvider',
                            'title'   => ts('Instant Messenger Services'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/07.png',
                            'weight'  => 320
                            ),

                      array(
                            'path'    => 'civicrm/admin/mobileProvider',
                            'title'   => ts('Mobile Phone Providers'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/08.png',
                            'weight'  => 339
                            ),
    
                      array(
                            'path'    => 'civicrm/admin/prefix',
                            'title'   => ts('Individual Prefixes (Ms, Mr...)'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/title.png',
                            'weight'  => 340
                            ),
                      
                      array(
                            'path'    => 'civicrm/admin/suffix',
                            'title'   => ts('Individual Suffixes (Jr, Sr...)'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'adminGroup' => ts('Setup'),
                            'icon'    => 'admin/10.png',
                            'weight'  => 350
                            ),

                      array(
                            'path'     => 'civicrm',
                            'title'    => ts('CiviCRM'),
                            'access'   => CRM_Core_Permission::check( 'access CiviCRM' ),
                            'callback' => 'civicrm_invoke',
                            'type'     => CRM_CORE_MENU_NORMAL_ITEM,
                            'crmType'  => CRM_CORE_MENU_CALLBACK,
                            'weight'   => 0,
                            ),

                      array( 
                            'path'    => 'civicrm/quickreg', 
                            'title'   => ts( 'Quick Registration' ), 
                            'access'  => 1,
                            'type'    => CRM_CORE_MENU_CALLBACK,  
                            'crmType' => CRM_CORE_MENU_CALLBACK,  
                            'weight'  => 0,  
                            ),

                      array( 
                            'path'    => 'civicrm/file', 
                            'title'   => ts( 'Browse Uploaded files' ), 
                            'access'  => CRM_Core_Permission::check( 'access uploaded files' ),
                            'type'    => CRM_CORE_MENU_CALLBACK,  
                            'crmType' => CRM_CORE_MENU_CALLBACK,  
                            'weight'  => 0,  
                            ),

                      array(
                            'path'   => 'civicrm/dashboard',
                            'title'  => ts('CiviCRM Home'),
                            'query'  => 'reset=1',
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_NORMAL_ITEM,
                            'access' => CRM_Core_Permission::check( 'access CiviCRM' ),
                            'weight' => 0,
                            ),

                      array(
                            'path'    => 'civicrm/contact/search',
                            'title'   => ts('Contacts'),
                            'query'   => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_ROOT_LOCAL_TASK,
                            'access'  => CRM_Core_Permission::check( 'access CiviCRM' ),
                            'weight'  => 10,
                            ),
        
                      array(
                            'path'    => 'civicrm/contact/search/basic',
                            'title'   => ts('Find Contacts'),
                            'query'   => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_DEFAULT_LOCAL_TASK| CRM_CORE_MENU_NORMAL_ITEM,
                            'access'  => CRM_Core_Permission::check( 'access CiviCRM' ),
                            'weight'  => 1
                            ),

                      array(
                            'path'    => 'civicrm/contact/search/advanced',
                            'query'   => 'reset=1',
                            'title'   => ts('Advanced Search'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 2
                            ),

                      array(
                            'path'    => 'civicrm/contact/search/builder',
                            'title'   => ts('Search Builder'),
                            'query'  => 'reset=1',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 3
                            ),


                      array(
                            'path'   => 'civicrm/contact/add',
                            'title'  => ts('New Contact'),
                            'query'  => 'reset=1',
                            'access' => CRM_Core_Permission::check('add contacts') &&
                                        CRM_Core_Permission::check( 'access CiviCRM' ),
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_CALLBACK,
                            'weight' => 1
                            ),
                
                      array(
                            'path'    => 'civicrm/contact/view',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('View Contact'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_ROOT_LOCAL_TASK,
                            'weight'   => 0,
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/basic',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Contact Summary'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_DEFAULT_LOCAL_TASK,
                            'weight'  => 0
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/activity',
                            'query'   => 'show=1&reset=1&cid=%%cid%%',
                            'title'   => ts('Activities'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 3
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/rel',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Relationships'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 4
                            ),
        
                      array(
                            'path'    => 'civicrm/contact/view/group',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Groups'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 5
                            ),
                      
                      array(
                            'path'    => 'civicrm/contact/view/note',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Notes'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 6
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/tag',
                            'query'   => 'reset=1&cid=%%cid%%',
                            'title'   => ts('Tags'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_LOCAL_TASK,
                            'weight'  => 7
                            ),

                      array(
                            'path'    => 'civicrm/contact/view/cd',
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),
                     
                      array(
                            'path'   => 'civicrm/group',
                            'title'  => ts('Manage Groups'),
                            'query'  => 'reset=1',
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_NORMAL_ITEM,
                            'access' => CRM_Core_Permission::check( 'access CiviCRM' ),
                            'weight' => 30,
                            ),

                      array(
                            'path'   => 'civicrm/group/search',
                            'title'  => ts('Group Members'),
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType'=> CRM_CORE_MENU_CALLBACK,
                            ),
        
                      array(
                            'path'    => 'civicrm/group/add',
                            'title'   => ts('Create New Group'),
                            'access' => CRM_Core_Permission::check('edit groups') &&
                            CRM_Core_Permission::check( 'access CiviCRM' ),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),
        
                      array(
                            'path'   => 'civicrm/import',
                            'title'  => ts( 'Import' ),
                            'query'  => 'reset=1',
                            'access' => CRM_Core_Permission::check( 'import contacts' ) &&
                                        CRM_Core_Permission::check( 'access CiviCRM' ),
                            'type'   =>  CRM_CORE_MENU_CALLBACK,
                            'crmType'=>  CRM_CORE_MENU_NORMAL_ITEM,
                            'weight' =>  400,
                            ),
                      array( 
                             'path'    => 'civicrm/import/contact',
                             'query'   => 'reset=1',
                             'title'   => ts( 'Contacts' ), 
                             'access'  => CRM_Core_Permission::check('administer CiviCRM') &&
                                          CRM_Core_Permission::check( 'access CiviCRM' ), 
                             'type'    => CRM_CORE_MENU_CALLBACK,  
                             'crmType' => CRM_CORE_MENU_NORMAL_ITEM,  
                             'weight'  => 410,
                             ),
                       array( 
                             'path'    => 'civicrm/import/activityHistory', 
                             'query'   => 'reset=1',
                             'title'   => ts( 'Activity History' ), 
                             'access'  => CRM_Core_Permission::check('administer CiviCRM') &&
                                          CRM_Core_Permission::check( 'access CiviCRM' ),
                             'type'    => CRM_CORE_MENU_CALLBACK,  
                             'crmType' => CRM_CORE_MENU_NORMAL_ITEM,  
                             'weight'  => 420,  
                             ),

                      array(
                            'path'   => 'civicrm/export/contact',
                            'title'  => ts('Export Contacts'),
                            'type'   => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),
                      
                      array(
                            'path'    => 'civicrm/history/activity/detail',
                            'title'   => ts('Activity Detail'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/history/activity/delete',
                            'title'   => ts('Delete Activity'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/history/email',
                            'title'   => ts('Sent Email Message'),
                            'type'    => CRM_CORE_MENU_CALLBACK,
                            'crmType' => CRM_CORE_MENU_CALLBACK,
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/profile',
                            'title'   => ts( 'Contact Information' ),
                            'access'  => CRM_Core_Permission::check( 'profile listings and forms'),
                            'type'    => CRM_CORE_MENU_CALLBACK, 
                            'crmType' => CRM_CORE_MENU_CALLBACK, 
                            'weight'  => 0, 
                            ),

                      array(
                            'path'    => 'civicrm/profile/create',
                            'title'   => ts( 'Add Contact Information' ),
                            'access'  => CRM_Core_Permission::check( 'profile listings and forms'),
                            'type'    => CRM_CORE_MENU_CALLBACK, 
                            'crmType' => CRM_CORE_MENU_CALLBACK, 
                            'weight'  => 0,
                            ),

                      array(
                            'path'    => 'civicrm/profile/note',
                            'title'   => ts( 'Notes about the Person' ),
                            'access'  => CRM_Core_Permission::check( 'profile listings and forms'),
                            'type'    => CRM_CORE_MENU_CALLBACK, 
                            'crmType' => CRM_CORE_MENU_CALLBACK, 
                            'weight'  => 0,
                            ),

                      );

            require_once 'CRM/Core/Component.php';
            $items =& CRM_Core_Component::menu( );
            $GLOBALS['_CRM_CORE_MENU']['_items'] = array_merge( $GLOBALS['_CRM_CORE_MENU']['_items'], $items );
            
            CRM_Core_Menu::initialize( );
        }
        
        return $GLOBALS['_CRM_CORE_MENU']['_items'];
    }

    /**
     * create the local tasks array based on current url
     *
     * @param string $path current url path
     * 
     * @return void
     * @access static
     */
     function createLocalTasks( $path ) {
        CRM_Core_Menu::items( );

        $config =& CRM_Core_Config::singleton( );
        if ( $config->userFramework == 'Joomla' ) {
            
            if ( ! $GLOBALS['_CRM_CORE_MENU']['processed'] ) {                
                $GLOBALS['_CRM_CORE_MENU']['processed'] = true;
                foreach ( $GLOBALS['_CRM_CORE_MENU']['_items'] as $key => $item ) {
                    if ( $item['path'] == $path ) {
                        CRM_Utils_System::setTitle( $item['title'] );
                        break;
                    }
                }
            }
        }

        foreach ( $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'] as $root => $dontCare ) {
            if ( strpos( $path, $GLOBALS['_CRM_CORE_MENU']['_items'][$root]['path'] ) !== false ) {
                $localTasks = array( );
                foreach ( $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'][$root]['children'] as $dontCare => $item ) {
                    $index = $item['index'];
                    $klass = '';
                    if ( strpos( $path, $GLOBALS['_CRM_CORE_MENU']['_items'][$index]['path'] ) !== false ||
                         ( $GLOBALS['_CRM_CORE_MENU']['_items'][$root ]['path'] == $path && CRM_Utils_Array::value( 'isDefault', $item ) ) ) {
                        $extra = CRM_Utils_Array::value( 'extra', $GLOBALS['_CRM_CORE_MENU']['_items'][$index] );
                        if ( $extra ) {
                            foreach ( $extra as $k => $v ) {
                                if ( CRM_Utils_Array::value( $k, $_GET ) == $v ) {
                                    $klass = 'active';
                                }
                            }
                        } else {
                            $klass = 'active';
                        }
                    }
                    $qs  = CRM_Utils_Array::value( 'query', $GLOBALS['_CRM_CORE_MENU']['_items'][$index] );
                    if ( $GLOBALS['_CRM_CORE_MENU']['_params'] ) {
                        foreach ( $GLOBALS['_CRM_CORE_MENU']['_params'] as $n => $v ) {
                            $qs = str_replace( "%%$n%%", $v, $qs );
                        }
                    }
                    $url = CRM_Utils_System::url( $GLOBALS['_CRM_CORE_MENU']['_items'][$index]['path'], $qs );
                    $localTasks[$GLOBALS['_CRM_CORE_MENU']['_items'][$index]['weight']] =
                        array(
                              'url'    => $url, 
                              'title'  => $GLOBALS['_CRM_CORE_MENU']['_items'][$index]['title'],
                              'class'  => $klass
                              );
                }
                ksort( $localTasks );
                $template =& CRM_Core_Smarty::singleton( );
                $template->assign_by_ref( 'localTasks', $localTasks );
                return;
            }
        }
    }

    /**
     * Add an item to the menu array
     *
     * @param array $item a menu item with the appropriate menu properties
     *
     * @return void
     * @access public
     * @static
     */
     function add( &$item ) {
        // make sure the menu system is initialized before we add stuff to it
        CRM_Core_Menu::items( );

        $GLOBALS['_CRM_CORE_MENU']['_items'][] = $item;
        CRM_Core_Menu::initialize( );
    }

    /**
     * Add a key, value pair to the params array
     *
     * @param string $key  
     * @param string $value
     *
     * @return void
     * @access public
     * @static
     */
     function addParam( $key, $value ) {
        if ( ! $GLOBALS['_CRM_CORE_MENU']['_params'] ) {
            $GLOBALS['_CRM_CORE_MENU']['_params'] = array( );
        }
        $GLOBALS['_CRM_CORE_MENU']['_params'][$key] = $value;
    }

    /**
     * intialize various objects in the meny array to make further processing simpler
     *
     * @return void
     * @static
     * @access private
     */
     function initialize( ) {
        $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'] = array( );
        for ( $i = 0; $i < count( $GLOBALS['_CRM_CORE_MENU']['_items'] ); $i++ ) {
            // this item is a root_local_task and potentially more
            if ( ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_CORE_MENU']['_items'][$i] ) & CRM_CORE_MENU_ROOT_LOCAL_TASK) &&
                 ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_CORE_MENU']['_items'][$i] ) >= CRM_CORE_MENU_ROOT_LOCAL_TASK) ) {
                $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'][$i] = array(
                                                   'root'     => $i,
                                                   'children' => array( )
                                                   );
            } else if ( ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_CORE_MENU']['_items'][$i] ) &  CRM_CORE_MENU_LOCAL_TASK) &&
                        ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_CORE_MENU']['_items'][$i] ) >= CRM_CORE_MENU_LOCAL_TASK) ) {
                // find parent of the local task
                foreach ( $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'] as $root => $dontCare ) {
                    if ( strpos( $GLOBALS['_CRM_CORE_MENU']['_items'][$i]['path'], $GLOBALS['_CRM_CORE_MENU']['_items'][$root]['path'] ) !== false &&
                         CRM_Utils_Array::value( 'access', $GLOBALS['_CRM_CORE_MENU']['_items'][$i], true ) ) {
                        $isDefault =
                            ( CRM_Utils_Array::value( 'crmType', $GLOBALS['_CRM_CORE_MENU']['_items'][$i] ) == CRM_CORE_MENU_DEFAULT_LOCAL_TASK) ? true : false;
                        $GLOBALS['_CRM_CORE_MENU']['_rootLocalTasks'][$root]['children'][] = array( 'index'     => $i,
                                                                             'isDefault' => $isDefault );
                    }
                }
            }
        }
    }

    /**
     * Get the breadcrumb for a give menu task
     *
     * @param string $path the current path for which we need the bread crumb
     *
     * @return string       the breadcrumb for this path
     *
     * @static
     * @access public
     */
      function &breadcrumb( $args ) {

        // we dont care about the current menu item
        array_pop( $args );

        $menus =& CRM_Core_Menu::items( );

        $crumbs      = array( );
        $currentPath = null;
        foreach ( $args as $arg ) {
            $currentPath = $currentPath ? "{$currentPath}/{$arg}" : $arg;

            foreach ( $menus as $menu ) {
                if ( $menu['path'] == $currentPath ) {
                    $crumbs[] = array('title' => $menu['title'], 
                                      'url'   => CRM_Utils_System::url( $menu['path'] ) );
                }
            }
        }

        return $crumbs;
        // CRM_Core_Error::debug( 'bc', $crumbs );
    }

    /**
     * Get children for a particular menu path sorted by ascending weight
     *
     * @param  string        $path  parent menu path
     * @param  int|array     $type  menu types
     *
     * @return array         $menus
     *
     * @static
     * @access public
     */
      function getChildren($path, $type)
    {

        $childMenu = array();

        $path = trim($path, '/');

        // since we need children only
        $path .= '/';
        
        foreach (CRM_Core_Menu::items() as $menu) {
            if (strpos($menu['path'], $path) === 0) {
                // need to add logic for menu types
                $childMenu[] = $menu;
            }
        }
        return $childMenu;
    }


    /**
     * Get max weight for a path
     *
     * @param  string $path  parent menu path
     *
     * @return int    max weight for the path           
     *
     * @static
     * @access public
     */
      function getMaxWeight($path)
    {

        $path = trim($path, '/');

        // since we need children only
        $path .= '/';

        $maxWeight  = -1024;   // weights can have -ve numbers hence cant initialize it to 0
        $firstChild = true;

        foreach (CRM_Core_Menu::items() as $menu) {
            if (strpos($menu['path'], $path) === 0) {
                if ($firstChild) {
                    // maxWeight is initialized to the weight of the first child
                    $maxWeight = $menu['weight'];
                    $firstChild = false;
                } else {
                    $maxWeight = ($menu['weight'] > $maxWeight) ? $menu['weight'] : $maxWeight;
                }
            }
        }

        return $maxWeight;
    }


}

?>
