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
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_tableName'] =  'civicrm_membership_block';
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_fields'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_links'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export'] =  null;
$GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Member_DAO_MembershipBlock extends CRM_Core_DAO {
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
    * Name for Membership Status
    *
    * @var string
    */
    var $entity_table;
    /**
    * FK to civicrm_contribution_page.id
    *
    * @var int unsigned
    */
    var $entity_id;
    /**
    * Membership types to be exposed by this block
    *
    * @var string
    */
    var $membership_types;
    /**
    * Optional foreign key to membership_type
    *
    * @var int unsigned
    */
    var $membership_type_default;
    /**
    * Display minimum membership fee
    *
    * @var boolean
    */
    var $display_min_fee;
    /**
    * Should membership transactions be processed separately
    *
    * @var boolean
    */
    var $is_separate_payment;
    /**
    * Title to display at top of block
    *
    * @var string
    */
    var $new_title;
    /**
    * Text to display below title
    *
    * @var text
    */
    var $new_text;
    /**
    * Title for renewal
    *
    * @var string
    */
    var $renewal_title;
    /**
    * Text to display for member renewal
    *
    * @var text
    */
    var $renewal_text;
    /**
    * Is membership sign up optional
    *
    * @var boolean
    */
    var $is_required;
    /**
    * Is this membership_block enabled
    *
    * @var boolean
    */
    var $is_active;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_membership_block
    */
    function CRM_Member_DAO_MembershipBlock() 
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
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_links'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_links'] = array(
                'entity_id'=>'civicrm_contribution_page:id',
                'membership_type_default'=>'civicrm_membership_type:id',
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_fields'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_fields'] = array(
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
                'membership_types'=>array(
                    'name'=>'membership_types',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Membership Types') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'membership_type_default'=>array(
                    'name'=>'membership_type_default',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'title'=>ts('Membership Type Default') ,
                ) ,
                'display_min_fee'=>array(
                    'name'=>'display_min_fee',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Display Min Fee') ,
                ) ,
                'is_separate_payment'=>array(
                    'name'=>'is_separate_payment',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'new_title'=>array(
                    'name'=>'new_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('New Title') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'new_text'=>array(
                    'name'=>'new_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('New Text') ,
                ) ,
                'renewal_title'=>array(
                    'name'=>'renewal_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Renewal Title') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'renewal_text'=>array(
                    'name'=>'renewal_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Renewal Text') ,
                ) ,
                'is_required'=>array(
                    'name'=>'is_required',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Required') ,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                    'title'=>ts('Is Active') ,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import'] = array();
            $fields = &CRM_Member_DAO_MembershipBlock::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import']['membership_block'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export'])) {
            $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export'] = array();
            $fields = &CRM_Member_DAO_MembershipBlock::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export']['membership_block'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MEMBER_DAO_MEMBERSHIPBLOCK']['_export'];
    }
}
?>