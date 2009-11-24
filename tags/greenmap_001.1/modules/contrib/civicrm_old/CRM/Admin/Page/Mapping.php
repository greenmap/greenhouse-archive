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
 | at http://www.openngo.org/faqs/licensing.html                       |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_ADMIN_PAGE_MAPPING']['_links'] =  null;

require_once 'CRM/Core/Page/Basic.php';

/**
 * Page for displaying list of categories
 */
class CRM_Admin_Page_Mapping extends CRM_Core_Page_Basic 
{

    /**
     * The action links that we need to display for the browse screen
     *
     * @var array
     * @static
     */
    

    /**
     * Get BAO
     *
     * @return string Classname of BAO.
     */
    function getBAOName() 
    {
        return 'CRM_Core_BAO_Mapping';
    }


    /**
     * Get action Links
     *
     * @return array (reference) of action links
     */
    function &links()
    {
        if (!($GLOBALS['_CRM_ADMIN_PAGE_MAPPING']['_links'])) {
            // helper variable for nicer formatting
            $deleteExtra = ts('Are you sure you want to delete this mapping? This operation can not be undone');
            $GLOBALS['_CRM_ADMIN_PAGE_MAPPING']['_links'] = array(
                                  CRM_CORE_ACTION_UPDATE  => array(
                                                                    'name'  => ts('Edit'),
                                                                    'url'   => 'civicrm/admin/mapping',
                                                                    'qs'    => 'action=update&id=%%id%%&reset=1',
                                                                    'title' => ts('Edit Mapping') 
                                                                    ),
                                  CRM_CORE_ACTION_DELETE  => array(
                                                                    'name'  => ts('Delete'),
                                                                    'url'   => 'civicrm/admin/mapping',
                                                                    'qs'    => 'action=delete&id=%%id%%',
                                                                    'title' => ts('Delete Mapping'), 
                                                                    ),
                                 );
        }
        return $GLOBALS['_CRM_ADMIN_PAGE_MAPPING']['_links'];
    }
    
    /**
     * Get name of edit form
     *
     * @return string Classname of edit form.
     */
    function editForm() 
    {
        return 'CRM_Admin_Form_Mapping';
    }
    
    /**
     * Get form name for edit form
     *
     * @return string name of this page.
     */
    function editName() 
    {
        return 'Mapping';
    }
    
    /**
     * Get form name for delete form
     *
     * @return string name of this page.
     */
    function deleteName() 
    {
        return 'Mapping';
    }
    
    /**
     * Get user context.
     *
     * @return string user context.
     */
    function userContext( $mode = null ) 
    {
        return 'civicrm/admin/mapping';
    }
    
    /**
     * Get name of delete form
     *
     * @return string Classname of delete form.
     */
   function deleteForm() 
   {
       return 'CRM_Admin_Form_Mapping';
   }
   
   /**
     * Run the basic page
     *
     * @return void
     */
   function run() 
   {
       $sort = 'mapping_type asc';
       parent::run($sort);
   }
}
?>