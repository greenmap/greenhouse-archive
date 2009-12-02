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
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_tableName'] =  'civicrm_membership_status';
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_fields'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_links'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_log'] =  false;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['enums'] =  array(
            'start_event',
            'start_event_adjust_unit',
            'end_event',
            'end_event_adjust_unit',
        );
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Member_DAO_MembershipStatus extends CRM_Core_DAO {
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
    * Membership Id
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this contact
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Name for Membership Status
    *
    * @var string
    */
    var $name;
    /**
    * Event when this status starts.
    *
    * @var enum('start_date', 'end_date', 'join_date')
    */
    var $start_event;
    /**
    * Unit used for adjusting from start_event.
    *
    * @var enum('day', 'month', 'year')
    */
    var $start_event_adjust_unit;
    /**
    * Status range begins this many units from start_event.
    *
    * @var int
    */
    var $start_event_adjust_interval;
    /**
    * Event after which this status ends.
    *
    * @var enum('start_date', 'end_date', 'join_date')
    */
    var $end_event;
    /**
    * Unit used for adjusting from the ending event.
    *
    * @var enum('day', 'month', 'year')
    */
    var $end_event_adjust_unit;
    /**
    * Status range ends this many units from end_event.
    *
    * @var int
    */
    var $end_event_adjust_interval;
    /**
    * Does this status aggregate to current members (e.g. New, Renewed, Grace might all be TRUE... while Unrenewed, Lapsed, Inactive would be FALSE).
    *
    * @var boolean
    */
    var $is_current_member;
    /**
    * Is this status for admin/manual assignment only.
    *
    * @var boolean
    */
    var $is_admin;
    /**
    *
    * @var int
    */
    var $weight;
    /**
    * Assign this status to a membership record if no other status match is found.
    *
    * @var boolean
    */
    var $is_default;
    /**
    * Is this membership_status enabled.
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_membership_status
    */
    function CRM_Member_DAO_MembershipStatus() 
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
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_links'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_fields'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_fields'] = array(
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
                'name'=>array(
                    'name'=>'name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Name') ,
                    'maxlength'=>128,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'start_event'=>array(
                    'name'=>'start_event',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Start Event') ,
                ) ,
                'start_event_adjust_unit'=>array(
                    'name'=>'start_event_adjust_unit',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Start Event Adjust Unit') ,
                ) ,
                'start_event_adjust_interval'=>array(
                    'name'=>'start_event_adjust_interval',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Start Event Adjust Interval') ,
                ) ,
                'end_event'=>array(
                    'name'=>'end_event',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('End Event') ,
                ) ,
                'end_event_adjust_unit'=>array(
                    'name'=>'end_event_adjust_unit',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('End Event Adjust Unit') ,
                ) ,
                'end_event_adjust_interval'=>array(
                    'name'=>'end_event_adjust_interval',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('End Event Adjust Interval') ,
                ) ,
                'is_current_member'=>array(
                    'name'=>'is_current_member',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Current Membership?') ,
                ) ,
                'is_admin'=>array(
                    'name'=>'is_admin',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Admin Assigned Only?') ,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                ) ,
                'is_default'=>array(
                    'name'=>'is_default',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Default Status?') ,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Active') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import'] = array();
            $fields = &CRM_Member_DAO_MembershipStatus::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import']['membership_status'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export'] = array();
            $fields = &CRM_Member_DAO_MembershipStatus::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export']['membership_status'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_membership_status table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['enums'];
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
        
        if (!$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['translations']) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['translations'] = array(
                'start_event'=>array(
                    'start_date'=>ts('start_date') ,
                    'end_date'=>ts('end_date') ,
                    'join_date'=>ts('join_date') ,
                ) ,
                'start_event_adjust_unit'=>array(
                    'day'=>ts('day') ,
                    'month'=>ts('month') ,
                    'year'=>ts('year') ,
                ) ,
                'end_event'=>array(
                    'start_date'=>ts('start_date') ,
                    'end_date'=>ts('end_date') ,
                    'join_date'=>ts('join_date') ,
                ) ,
                'end_event_adjust_unit'=>array(
                    'day'=>ts('day') ,
                    'month'=>ts('month') ,
                    'year'=>ts('year') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPSTATUS']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_membership_status
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Member_DAO_MembershipStatus::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Member_DAO_MembershipStatus::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>