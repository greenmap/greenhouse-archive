<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 1.5                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2006                                |
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
* @copyright CiviCRM LLC (c) 2004-2006
* $Id$
*
*/
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_tableName'] =  'civicrm_task_status';
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_fields'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_links'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Project_DAO_TaskStatus extends CRM_Core_DAO {
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
    * Task ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Status is for which task.
    *
    * @var int unsigned
    */
    var $task_id;
    /**
    * Entity responsible for this task_status instance (table where entity is stored e.g. civicrm_contact or civicrm_group).
    *
    * @var string
    */
    var $responsible_entity_table;
    /**
    * Foreign key to responsible entity (contact, group, etc.).
    *
    * @var int unsigned
    */
    var $responsible_entity_id;
    /**
    * Optional target entity for this task_status instance, i.e. review this membership application-prospect member contact record is target (table where entity is stored e.g. civicrm_contact or civicrm_group).
    *
    * @var string
    */
    var $target_entity_table;
    /**
    * Foreign key to target entity (contact, group, etc.).
    *
    * @var int unsigned
    */
    var $target_entity_id;
    /**
    * Encoded array of status details used for programmatic progress reporting and tracking.
    *
    * @var text
    */
    var $status_detail;
    /**
    * Configurable status value (e.g. Not Started, In Progress, Completed, Deferred...). FK to civicrm_option_value.
    *
    * @var int unsigned
    */
    var $status_id;
    /**
    * Date this record was created (date work on task started).
    *
    * @var datetime
    */
    var $create_date;
    /**
    * Date-time of last update to this task_status record.
    *
    * @var datetime
    */
    var $modified_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_task_status
    */
    function CRM_Project_DAO_TaskStatus() 
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
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_links'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_links'] = array(
                'task_id'=>'civicrm_task:id',
                'status_id'=>'civicrm_option_value:value',
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_fields'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'task_id'=>array(
                    'name'=>'task_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'responsible_entity_table'=>array(
                    'name'=>'responsible_entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Responsible Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'responsible_entity_id'=>array(
                    'name'=>'responsible_entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Responsible') ,
                    'required'=>true,
                ) ,
                'target_entity_table'=>array(
                    'name'=>'target_entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Target Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'target_entity_id'=>array(
                    'name'=>'target_entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Target') ,
                    'required'=>true,
                ) ,
                'status_detail'=>array(
                    'name'=>'status_detail',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Status Details') ,
                ) ,
                'status_id'=>array(
                    'name'=>'status_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Status') ,
                ) ,
                'create_date'=>array(
                    'name'=>'create_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Created') ,
                ) ,
                'modified_date'=>array(
                    'name'=>'modified_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Last Modified') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import'] = array();
            $fields = &CRM_Project_DAO_TaskStatus::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import']['task_status'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export'] = array();
            $fields = &CRM_Project_DAO_TaskStatus::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export']['task_status'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASKSTATUS']['_export'];
    }
}
?>