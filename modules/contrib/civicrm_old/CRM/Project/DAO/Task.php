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
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_tableName'] =  'civicrm_task';
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_fields'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_links'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_import'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_export'] =  null;
$GLOBALS['_CRM_PROJECT_DAO_TASK']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Project_DAO_Task extends CRM_Core_DAO {
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
    * Which Domain owns this record.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Task name.
    *
    * @var string
    */
    var $title;
    /**
    * Optional verbose description of the Task. May be used for display - HTML allowed.
    *
    * @var string
    */
    var $description;
    /**
    * Configurable task type values (e.g. App Submit, App Review...). FK to civicrm_option_value.
    *
    * @var int unsigned
    */
    var $task_type_id;
    /**
    * Name of table where Task owner being referenced is stored (e.g. civicrm_contact or civicrm_group).
    *
    * @var string
    */
    var $owner_entity_table;
    /**
    * Foreign key to Task owner (contact, group, etc.).
    *
    * @var int unsigned
    */
    var $owner_entity_id;
    /**
    * Name of table where optional Task parent is stored (e.g. civicrm_project, or civicrm_task for sub-tasks).
    *
    * @var string
    */
    var $parent_entity_table;
    /**
    * Optional foreign key to Task Parent (project, another task, etc.).
    *
    * @var int unsigned
    */
    var $parent_entity_id;
    /**
    * Task due date.
    *
    * @var datetime
    */
    var $due_date;
    /**
    * Configurable priority value (e.g. Critical, High, Medium...). FK to civicrm_option_value.
    *
    * @var int unsigned
    */
    var $priority_id;
    /**
    * Optional key to a process class related to this task (e.g. CRM_Quest_PreApp).
    *
    * @var string
    */
    var $task_class;
    /**
    * Is this record active? For tasks: can it be assigned, does it appear on open task listings, etc.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_task
    */
    function CRM_Project_DAO_Task() 
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
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASK']['_links'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASK']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'task_type_id'=>'civicrm_option_value:value',
                'priority_id'=>'civicrm_option_value:id',
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASK']['_fields'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASK']['_fields'] = array(
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
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'task_type_id'=>array(
                    'name'=>'task_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Task Type') ,
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
                    'title'=>ts('Task Owner ID') ,
                    'required'=>true,
                ) ,
                'parent_entity_table'=>array(
                    'name'=>'parent_entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Parent Entity Table') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'parent_entity_id'=>array(
                    'name'=>'parent_entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Task Parent') ,
                ) ,
                'due_date'=>array(
                    'name'=>'due_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Due Date') ,
                ) ,
                'priority_id'=>array(
                    'name'=>'priority_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Priority') ,
                ) ,
                'task_class'=>array(
                    'name'=>'task_class',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Task Class') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Active?') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASK']['_import'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASK']['_import'] = array();
            $fields = &CRM_Project_DAO_Task::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_TASK']['_import']['task'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_TASK']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_PROJECT_DAO_TASK']['_export'])) {
            $GLOBALS['_CRM_PROJECT_DAO_TASK']['_export'] = array();
            $fields = &CRM_Project_DAO_Task::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_PROJECT_DAO_TASK']['_export']['task'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_PROJECT_DAO_TASK']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_PROJECT_DAO_TASK']['_export'];
    }
}
?>