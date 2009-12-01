<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 1.1                                                |
+--------------------------------------------------------------------+
| Copyright (c) 2005 Social Source Foundation                        |
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
* @copyright Donald A. Lobo 01/15/2005
* $Id$
*
*/
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_tableName'] =  'civicrm_project';
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_fields'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_links'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Project_DAO_Project extends CRM_Core_DAO {
    /**
    * static instance to hold the table name
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the field values
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the FK relationships
    *
    * @var string
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be imported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * static instance to hold the values that can
    * be exported / apu
    *
    * @var array
    * @static
    */
    
    /**
    * static value to see if we should log any modifications to
    * this table in the civicrm_log table
    *
    * @var boolean
    * @static
    */
    
    /**
    * Project ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this record.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Project name.
    *
    * @var string
    */
    var $title;
    /**
    * Optional verbose description of the project. May be used for display - HTML allowed.
    *
    * @var text
    */
    var $description;
    /**
    * Full or relative URL to optional uploaded logo image for project.
    *
    * @var string
    */
    var $logo;
    /**
    * Name of table where project owner being referenced is stored (e.g. civicrm_contact or civicrm_group).
    *
    * @var string
    */
    var $owner_entity_table;
    /**
    * Foreign key to project owner (contact, group, etc.).
    *
    * @var int unsigned
    */
    var $owner_entity_id;
    /**
    * Project start date.
    *
    * @var datetime
    */
    var $start_date;
    /**
    * Project end date.
    *
    * @var datetime
    */
    var $end_date;
    /**
    * Is this record active? For Projects: can tasks be created for it, does it appear on project listings, etc.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Configurable status value (e.g. Planned, Active, Closed...). FK to civicrm_option_value.
    *
    * @var int unsigned
    */
    var $status_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_project
    */
    function CRM_Project_DAO_Project() 
    {
        parent::CRM_Core_DAO();
    }
    /**
    * return foreign links
    *
    * @access public
    * @return array
    */
    function &links() 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_links'])) {
            $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'status_id'=>'civicrm_option_value:value',
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_fields'])) {
            $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'domain_id'=>array(
                    'name'=>'domain_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'title'=>array(
                    'name'=>'title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Title') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Description') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'logo'=>array(
                    'name'=>'logo',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Logo') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'owner_entity_table'=>array(
                    'name'=>'owner_entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Owner Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'owner_entity_id'=>array(
                    'name'=>'owner_entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Project Owner ID') ,
                    'required'=>true,
                ) ,
                'start_date'=>array(
                    'name'=>'start_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Start Date') ,
                ) ,
                'end_date'=>array(
                    'name'=>'end_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('End Date') ,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Active?') ,
                ) ,
                'status_id'=>array(
                    'name'=>'status_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Status') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import'])) {
            $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import'] = array();
            $fields = &CRM_Project_DAO_Project::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import']['project'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export'])) {
            $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export'] = array();
            $fields = &CRM_Project_DAO_Project::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export']['project'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_PROJECT']['_export'];
    }
}
?>