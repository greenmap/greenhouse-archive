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
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_tableName'] =  'civicrm_entity_file';
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_EntityFile extends CRM_Core_DAO {
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
    * primary key
    *
    * @var int unsigned
    */
    var $id;
    /**
    * physical tablename for entity being joined to file, e.g. civicrm_contact
    *
    * @var string
    */
    var $entity_table;
    /**
    * FK to entity table specified in entity_table column.
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * FK to civicrm_file
    *
    * @var int unsigned
    */
    var $file_id;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_entity_file
    */
    function CRM_Core_DAO_EntityFile() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_links'] = array(
                'file_id'=>'civicrm_file:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'entity_table'=>array(
                    'name'=>'entity_table',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Entity Table') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'entity_id'=>array(
                    'name'=>'entity_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'file_id'=>array(
                    'name'=>'file_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import'] = array();
            $fields = &CRM_Core_DAO_EntityFile::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import']['entity_file'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export'] = array();
            $fields = &CRM_Core_DAO_EntityFile::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export']['entity_file'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_ENTITYFILE']['_export'];
    }
}
?>