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
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_tableName'] =  'civicrm_membership_type';
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_fields'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_links'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_log'] =  false;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['enums'] =  array(
            'duration_unit',
            'period_type',
        );
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['translations'] =  null;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Member_DAO_MembershipType extends CRM_Core_DAO {
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
    * Name of Membership Type
    *
    * @var string
    */
    var $name;
    /**
    * Description of Membership Type
    *
    * @var string
    */
    var $description;
    /**
    * Owner organization for this membership type. FK to Contact ID
    *
    * @var int unsigned
    */
    var $member_of_contact_id;
    /**
    * If membership is paid by a contribution - what contribution type should be used. FK to Contribution Type ID
    *
    * @var int unsigned
    */
    var $contribution_type_id;
    /**
    * Minimum fee for this membership (0 for free/complimentary memberships).
    *
    * @var float
    */
    var $minimum_fee;
    /**
    * Unit in which membership period is expressed.
    *
    * @var enum('day', 'month', 'year', 'lifetime')
    */
    var $duration_unit;
    /**
    * Number of duration units in membership period (e.g. 1 year, 12 months).
    *
    * @var int
    */
    var $duration_interval;
    /**
    * Rolling membership period starts on signup date. Fixed membership periods start on fixed_period_start_day.
    *
    * @var enum('rolling', 'fixed')
    */
    var $period_type;
    /**
    * For fixed period memberships, month and day (mmdd) on which subscription/membership will start. Period start is back-dated unless after rollover day.
    *
    * @var int
    */
    var $fixed_period_start_day;
    /**
    * For fixed period memberships, signups after this day (mmdd) rollover to next period.
    *
    * @var int
    */
    var $fixed_period_rollover_day;
    /**
    * FK to Relationship Type ID
    *
    * @var int unsigned
    */
    var $relationship_type_id;
    /**
    *
    * @var string
    */
    var $visibility;
    /**
    *
    * @var int
    */
    var $weight;
    /**
    * Is this membership_type enabled
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_membership_type
    */
    function CRM_Member_DAO_MembershipType() 
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
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_links'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'member_of_contact_id'=>'civicrm_contact:id',
                'contribution_type_id'=>'civicrm_contribution_type:id',
                'relationship_type_id'=>'civicrm_relationship_type:id',
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_fields'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_fields'] = array(
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
                'description'=>array(
                    'name'=>'description',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Description') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'member_of_contact_id'=>array(
                    'name'=>'member_of_contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contribution_type_id'=>array(
                    'name'=>'contribution_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'minimum_fee'=>array(
                    'name'=>'minimum_fee',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Minimum Fee') ,
                ) ,
                'duration_unit'=>array(
                    'name'=>'duration_unit',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Duration Unit') ,
                ) ,
                'duration_interval'=>array(
                    'name'=>'duration_interval',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Duration Interval') ,
                ) ,
                'period_type'=>array(
                    'name'=>'period_type',
                    'type'=>CRM_UTILS_TYPE_T_ENUM,
                    'title'=>ts('Period Type') ,
                ) ,
                'fixed_period_start_day'=>array(
                    'name'=>'fixed_period_start_day',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Fixed Period Start Day') ,
                ) ,
                'fixed_period_rollover_day'=>array(
                    'name'=>'fixed_period_rollover_day',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Fixed Period Rollover Day') ,
                ) ,
                'relationship_type_id'=>array(
                    'name'=>'relationship_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'visibility'=>array(
                    'name'=>'visibility',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Visible') ,
                    'maxlength'=>64,
                    'size'=>CRM_UTILS_TYPE_BIG,
                ) ,
                'weight'=>array(
                    'name'=>'weight',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Weight') ,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Active') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import'] = array();
            $fields = &CRM_Member_DAO_MembershipType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import']['membership_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export'] = array();
            $fields = &CRM_Member_DAO_MembershipType::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export']['membership_type'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['_export'];
    }
    /**
    * returns an array containing the enum fields of the civicrm_membership_type table
    *
    * @return array (reference)  the array of enum fields
    */
     function &getEnums() 
    {
        
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['enums'];
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
        
        if (!$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['translations']) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['translations'] = array(
                'duration_unit'=>array(
                    'day'=>ts('day') ,
                    'month'=>ts('month') ,
                    'year'=>ts('year') ,
                    'lifetime'=>ts('lifetime') ,
                ) ,
                'period_type'=>array(
                    'rolling'=>ts('rolling') ,
                    'fixed'=>ts('fixed') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPTYPE']['translations'][$field][$value];
    }
    /**
    * adds $value['foo_display'] for each $value['foo'] enum from civicrm_membership_type
    *
    * @param array $values (reference)  the array up for enhancing
    * @return void
    */
     function addDisplayEnums(&$values) 
    {
        $enumFields = &CRM_Member_DAO_MembershipType::getEnums();
        foreach($enumFields as $enum) {
            if (isset($values[$enum])) {
                $values[$enum.'_display'] = CRM_Member_DAO_MembershipType::tsEnum($enum, $values[$enum]);
            }
        }
    }
}
?>