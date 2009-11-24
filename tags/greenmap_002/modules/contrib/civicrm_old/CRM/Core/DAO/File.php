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
$GLOBALS['_CRM_CORE_DAO_FILE']['_tableName'] =  'civicrm_file';
$GLOBALS['_CRM_CORE_DAO_FILE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_FILE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_FILE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_FILE']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_FILE']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_File extends CRM_Core_DAO {
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
    * Unique ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Type of file (e.g. Transcript, Income Tax Return, etc). FK to civicrm_option_value.
    *
    * @var int unsigned
    */
    var $file_type_id;
    /**
    * mime type of the document
    *
    * @var string
    */
    var $mime_type;
    /**
    * uri of the file on disk
    *
    * @var string
    */
    var $uri;
    /**
    * contents of the document
    *
    * @var mediumblob
    */
    var $document;
    /**
    * Additional descriptive text regarding this attachment (optional).
    *
    * @var string
    */
    var $description;
    /**
    * Date and time that this attachment was uploaded or written to server.
    *
    * @var datetime
    */
    var $upload_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_file
    */
    function CRM_Core_DAO_File() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_FILE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_FILE']['_links'] = array(
                'file_type_id'=>'civicrm_option_value:value',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_FILE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_FILE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'file_type_id'=>array(
                    'name'=>'file_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'mime_type'=>array(
                    'name'=>'mime_type',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Mime Type') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'uri'=>array(
                    'name'=>'uri',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Uri') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'document'=>array(
                    'name'=>'document',
                    'type'=>CRM_UTILS_TYPE_T_MEDIUMBLOB,
                    'title'=>ts('Document') ,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'upload_date'=>array(
                    'name'=>'upload_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE+CRM_UTILS_TYPE_T_TIME,
                    'title'=>ts('Upload Date') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_FILE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_FILE']['_import'] = array();
            $fields = &CRM_Core_DAO_File::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_FILE']['_import']['file'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_FILE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_FILE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_FILE']['_export'] = array();
            $fields = &CRM_Core_DAO_File::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_FILE']['_export']['file'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_FILE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_FILE']['_export'];
    }
}
?>