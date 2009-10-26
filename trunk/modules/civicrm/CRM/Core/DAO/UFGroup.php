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
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_tableName'] =  'civicrm_uf_group';
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_fields'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_links'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export'] =  null;
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['_log'] =  false;
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['enums'] =  array(
            'form_type',
        );
$GLOBALS['_CRM_CORE_DAO_UFGROUP']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Core_DAO_UFGroup extends CRM_Core_DAO {
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
    * Unique table ID
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this form.
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Is this form currently active? If false, hide all related fields for all sharing contexts.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Type of form.
    *
    * @var enum('CiviCRM Profile')
    */
    var $form_type;
    /**
    * Form title.
    *
    * @var string
    */
    var $title;
    /**
    * Will this group be in collapsed or expanded mode on initial display ?
    *
    * @var int unsigned
    */
    var $collapse_display;
    /**
    * Description and/or help text to display before fields in form.
    *
    * @var text
    */
    var $help_pre;
    /**
    * Description and/or help text to display after fields in form.
    *
    * @var text
    */
    var $help_post;
    /**
    * Group id, foriegn key from civicrm_group
    *
    * @var int unsigned
    */
    var $limit_listings_group_id;
    /**
    * Redirect to URL.
    *
    * @var string
    */
    var $post_URL;
    /**
    * foreign key to civicrm_group_id
    *
    * @var int unsigned
    */
    var $add_to_group_id;
    /**
    * Should a CAPTCHA widget be included this Profile form.
    *
    * @var boolean
    */
    var $add_captcha;
    /**
    * Do we want to map results from this profile.
    *
    * @var boolean
    */
    var $is_map;
    /**
    * Redirect to URL when Cancle button clik .
    *
    * @var string
    */
    var $cancel_URL;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_uf_group
    */
    function CRM_Core_DAO_UFGroup() 
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
        if (!($GLOBALS['_CRM_CORE_DAO_UFGROUP']['_links'])) {
            $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'limit_listings_group_id'=>'civicrm_group:id',
                'add_to_group_id'=>'civicrm_group:id',
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFGROUP']['_fields'])) {
            $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_fields'] = array(
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
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'form_type'=>array(
                    'name'=>'form_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Form Type') ,
                ) ,
                'title'=>array(
                    'name'=>'title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Title') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'collapse_display'=>array(
                    'name'=>'collapse_display',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Collapse Display') ,
                ) ,
                'help_pre'=>array(
                    'name'=>'help_pre',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Pre') ,
                    'rows'=>4,
                    'cols'=>80,
                ) ,
                'help_post'=>array(
                    'name'=>'help_post',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Help Post') ,
                    'rows'=>4,
                    'cols'=>80,
                ) ,
                'limit_listings_group_id'=>array(
                    'name'=>'limit_listings_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'post_URL'=>array(
                    'name'=>'post_URL',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Post Url') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'add_to_group_id'=>array(
                    'name'=>'add_to_group_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'add_captcha'=>array(
                    'name'=>'add_captcha',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Add Captcha') ,
                ) ,
                'is_map'=>array(
                    'name'=>'is_map',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'cancel_URL'=>array(
                    'name'=>'cancel_URL',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Cancel Url') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import'])) {
            $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import'] = array();
            $fields = &CRM_Core_DAO_UFGroup::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import']['uf_group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export'])) {
            $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export'] = array();
            $fields = &CRM_Core_DAO_UFGroup::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export']['uf_group'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_uf_group table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['enums'];
    }
    /**
    * returns a ts()-translated enum value for display purposes
    *
    * @param string $field  the enum field in question
    * @param string $value  the enum value up for translation
    *
    * @return string  the display value of the enum
    */
     function tsEnum($field, $value) 
    {
        
        if (!$GLOBALS['_CRM_CORE_DAO_UFGROUP']['translations']) {
            $GLOBALS['_CRM_CORE_DAO_UFGROUP']['translations'] = array(
                'form_type'=>array(
                    'CiviCRM Profile'=>ts('CiviCRM Profile') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CORE_DAO_UFGROUP']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_uf_group
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Core_DAO_UFGroup::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Core_DAO_UFGroup::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>