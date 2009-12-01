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
$GLOBALS['_CRM_CORE_DAO_LOG']['_tableName'] =  'civicrm_log';
$GLOBALS['_CRM_CORE_DAO_LOG']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOG']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOG']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOG']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_LOG']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_Log extends CRM_Core_DAO {
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
    * Log ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Name of table where item being referenced is stored.
    *
    * @var string
    */
    var $entity_table;
    /**
    * Foreign key to the referenced item.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * Updates does to this object if any.
    *
    * @var text
    */
    var $data;
    /**
    * FK to Contact ID of person under whose credentials this data modification was made.
    *
    * @var int unsigned
    */
    var $modified_id;
    /**
    * When was the referenced entity created or modified or deleted.
    *
    * @var datetime
    */
    var $modified_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_log
    */
    function CRM_Core_DAO_Log() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_LOG']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_LOG']['_links'] = array(
                'modified_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOG']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_LOG']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'data'=>array(
                    'name'=>'data',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Data') ,
                ) ,
                'modified_id'=>array(
                    'name'=>'modified_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'modified_date'=>array(
                    'name'=>'modified_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Modified Date') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOG']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_LOG']['_import'] = array();
            $fields = &CRM_Core_DAO_Log::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOG']['_import']['log'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOG']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_LOG']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_LOG']['_export'] = array();
            $fields = &CRM_Core_DAO_Log::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_LOG']['_export']['log'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_LOG']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_LOG']['_export'];
    }
}
?>