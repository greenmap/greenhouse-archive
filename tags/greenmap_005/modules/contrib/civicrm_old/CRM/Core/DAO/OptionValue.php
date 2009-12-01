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
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_tableName'] =  'civicrm_option_value';
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_OptionValue extends CRM_Core_DAO {
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
    * Option ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Group which this option belongs to.
    *
    * @var int unsigned
    */
    var $option_group_id;
    /**
    * Option string as displayed to users - e.g. the label in an HTML OPTION tag.
    *
    * @var string
    */
    var $label;
    /**
    * The actual value stored (as a foreign key) in the data record. Functions which need lookup option_value.title should use civicrm_option_value.option_group_id plus civicrm_option_value.value as the key.
    *
    * @var int unsigned
    */
    var $value;
    /**
    * May be used to store an option string that is different from the display title. One use case is when a non-translated value needs to be set / sent to another application (e.g. for Credit Card type).
    *
    * @var string
    */
    var $name;
    /**
    * Use to sort and/or set display properties for sub-set(s) of options within an option group. EXAMPLE: Use for college_interest field, to differentiate partners from non-partners.
    *
    * @var string
    */
    var $grouping;
    /**
    * Bitwise logic can be used to create subsets of options within an option_group for different uses.
    *
    * @var int unsigned
    */
    var $filter;
    /**
    * Is this the default option for the group?
    *
    * @var boolean
    */
    var $is_default;
    /**
    * Controls display sort order.
    *
    * @var int unsigned
    */
    var $weight;
    /**
    * Optional description.
    *
    * @var string
    */
    var $description;
    /**
    * Is this row simply a display header? Expected usage is to render these as OPTGROUP tags within a SELECT field list of options?
    *
    * @var boolean
    */
    var $is_optgroup;
    /**
    * Is this a predefined system object?
    *
    * @var boolean
    */
    var $is_reserved;
    /**
    * Is this option active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_option_value
    */
    function CRM_Core_DAO_OptionValue() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_links'] = array(
                'option_group_id'=>'civicrm_option_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'option_group_id'=>array(
                    'name'=>'option_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'label'=>array(
                    'name'=>'label',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Option Label') ,
                    'required'=>true,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'value'=>array(
                    'name'=>'value',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Option Value') ,
                    'required'=>true,
                ) ,
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Option Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'grouping'=>array(
                    'name'=>'grouping',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Option Grouping Name') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'filter'=>array(
                    'name'=>'filter',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Filter') ,
                    'required'=>true,
                ) ,
                'is_default'=>array(
                    'name'=>'is_default',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                    'required'=>true,
                ) ,
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'is_optgroup'=>array(
                    'name'=>'is_optgroup',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_reserved'=>array(
                    'name'=>'is_reserved',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import'] = array();
            $fields = &CRM_Core_DAO_OptionValue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import']['option_value'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export'] = array();
            $fields = &CRM_Core_DAO_OptionValue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export']['option_value'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_OPTIONVALUE']['_export'];
    }
}
?>