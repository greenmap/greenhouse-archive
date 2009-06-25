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
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_tableName'] =  'civicrm_membership_log';
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_fields'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_links'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_log'] =  true;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Member_DAO_MembershipLog extends CRM_Core_DAO {
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
    *
    * @var int unsigned
    */
    var $id;
    /**
    * FK to Membership table
    *
    * @var int unsigned
    */
    var $membership_id;
    /**
    * New status assigned to membership by this action. FK to Membership Status
    *
    * @var int unsigned
    */
    var $status_id;
    /**
    * New membership period start date
    *
    * @var date
    */
    var $start_date;
    /**
    * New membership period expiration date.
    *
    * @var date
    */
    var $end_date;
    /**
    * FK to Contact ID of person under whose credentials this data modification was made.
    *
    * @var int unsigned
    */
    var $modified_id;
    /**
    * Date this membership modification action was logged.
    *
    * @var date
    */
    var $modified_date;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_membership_log
    */
    function CRM_Member_DAO_MembershipLog() 
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
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_links'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_links'] = array(
                'membership_id'=>'civicrm_membership:id',
                'status_id'=>'civicrm_membership_status:id',
                'modified_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_fields'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'membership_id'=>array(
                    'name'=>'membership_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'status_id'=>array(
                    'name'=>'status_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Membership Status') ,
                    'required'=>true,
                ) ,
                'start_date'=>array(
                    'name'=>'start_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Start Date') ,
                ) ,
                'end_date'=>array(
                    'name'=>'end_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('End Date') ,
                ) ,
                'modified_id'=>array(
                    'name'=>'modified_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                ) ,
                'modified_date'=>array(
                    'name'=>'modified_date',
                    'type'=>CRM_UTILS_TYPE_T_DATE,
                    'title'=>ts('Membership Change Date') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import'] = array();
            $fields = &CRM_Member_DAO_MembershipLog::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import']['membership_log'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export'] = array();
            $fields = &CRM_Member_DAO_MembershipLog::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export']['membership_log'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPLOG']['_export'];
    }
}
?>