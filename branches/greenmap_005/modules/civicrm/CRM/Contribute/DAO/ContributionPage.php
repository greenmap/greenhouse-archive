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
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_tableName'] =  'civicrm_contribution_page';
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_fields'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_links'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export'] =  null;
$GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Contribute_DAO_ContributionPage extends CRM_Core_DAO {
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
    * Contribution Id
    *
    * @var int unsigned
    */
    var $id;
    /**
    * Which Domain owns this page
    *
    * @var int unsigned
    */
    var $domain_id;
    /**
    * Contribution Page title. For top of page display
    *
    * @var string
    */
    var $title;
    /**
    * Text and html allowed. Displayed below title.
    *
    * @var text
    */
    var $intro_text;
    /**
    * default Contribution type assigned to contributions submitted via this page, e.g. Contribution, Campaign Contribution
    *
    * @var int unsigned
    */
    var $contribution_type_id;
    /**
    * if true - processing logic must reject transaction at confirmation stage if pay method != credit card
    *
    * @var boolean
    */
    var $is_credit_card_only;
    /**
    * if true, page will include an input text field where user can enter their own amount
    *
    * @var boolean
    */
    var $is_allow_other_amount;
    /**
    * the default amount allowed.
    *
    * @var float
    */
    var $default_amount;
    /**
    * if other amounts allowed, user can configure minimum allowed.
    *
    * @var float
    */
    var $min_amount;
    /**
    * if other amounts allowed, user can configure maximum allowed.
    *
    * @var float
    */
    var $max_amount;
    /**
    * The target goal for this page, allows people to build a goal meter
    *
    * @var float
    */
    var $goal_amount;
    /**
    * Title for Thank-you page (header title tag, and display at the top of the page).
    *
    * @var string
    */
    var $thankyou_title;
    /**
    * text and html allowed. displayed above result on success page
    *
    * @var text
    */
    var $thankyou_text;
    /**
    * Text and html allowed. displayed at the bottom of the success page. Common usage is to include link(s) to other pages such as tell-a-friend, etc.
    *
    * @var text
    */
    var $thankyou_footer;
    /**
    * if true, receipt is automatically emailed to contact on success
    *
    * @var boolean
    */
    var $is_email_receipt;
    /**
    * FROM email name used for receipts generated by contributions to this contribution page.
    *
    * @var string
    */
    var $receipt_from_name;
    /**
    * FROM email address used for receipts generated by contributions to this contribution page.
    *
    * @var string
    */
    var $receipt_from_email;
    /**
    * comma-separated list of email addresses to cc each time a receipt is sent
    *
    * @var string
    */
    var $cc_receipt;
    /**
    * comma-separated list of email addresses to bcc each time a receipt is sent
    *
    * @var string
    */
    var $bcc_receipt;
    /**
    * text to include above standard receipt info on receipt email. emails are text-only, so do not allow html for now
    *
    * @var text
    */
    var $receipt_text;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $is_active;
    /**
    * Text and html allowed. Displayed at the bottom of the first page of the contribution wizard.
    *
    * @var text
    */
    var $footer_text;
    /**
    * Is this property active?
    *
    * @var boolean
    */
    var $amount_block_is_active;
    /**
    * Should this contribution have the thermometer block enabled?
    *
    * @var boolean
    */
    var $is_thermometer;
    /**
    * Title for thermometer block.
    *
    * @var string
    */
    var $thermometer_title;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_contribution_page
    */
    function CRM_Contribute_DAO_ContributionPage() 
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
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_links'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_links'] = array(
                'domain_id'=>'civicrm_domain:id',
                'contribution_type_id'=>'civicrm_contribution_type:id',
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_fields'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_fields'] = array(
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
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'intro_text'=>array(
                    'name'=>'intro_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Intro Text') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'contribution_type_id'=>array(
                    'name'=>'contribution_type_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'is_credit_card_only'=>array(
                    'name'=>'is_credit_card_only',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_allow_other_amount'=>array(
                    'name'=>'is_allow_other_amount',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'default_amount'=>array(
                    'name'=>'default_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Default Amount') ,
                ) ,
                'min_amount'=>array(
                    'name'=>'min_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Min Amount') ,
                ) ,
                'max_amount'=>array(
                    'name'=>'max_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Max Amount') ,
                ) ,
                'goal_amount'=>array(
                    'name'=>'goal_amount',
                    'type'=>CRM_UTILS_TYPE_T_MONEY,
                    'title'=>ts('Goal Amount') ,
                ) ,
                'thankyou_title'=>array(
                    'name'=>'thankyou_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Thank-you Title') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'thankyou_text'=>array(
                    'name'=>'thankyou_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Thank-you Text') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'thankyou_footer'=>array(
                    'name'=>'thankyou_footer',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Thank-you Footer') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'is_email_receipt'=>array(
                    'name'=>'is_email_receipt',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'receipt_from_name'=>array(
                    'name'=>'receipt_from_name',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Receipt From Name') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'receipt_from_email'=>array(
                    'name'=>'receipt_from_email',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Receipt From Email') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'cc_receipt'=>array(
                    'name'=>'cc_receipt',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Cc Receipt') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'bcc_receipt'=>array(
                    'name'=>'bcc_receipt',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Bcc Receipt') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
                'receipt_text'=>array(
                    'name'=>'receipt_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Receipt Text') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'is_active'=>array(
                    'name'=>'is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'footer_text'=>array(
                    'name'=>'footer_text',
                    'type'=>CRM_UTILS_TYPE_T_TEXT,
                    'title'=>ts('Footer Text') ,
                    'rows'=>6,
                    'cols'=>50,
                ) ,
                'amount_block_is_active'=>array(
                    'name'=>'amount_block_is_active',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'is_thermometer'=>array(
                    'name'=>'is_thermometer',
                    'type'=>CRM_UTILS_TYPE_T_BOOLEAN,
                ) ,
                'thermometer_title'=>array(
                    'name'=>'thermometer_title',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Thermometer Title') ,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import'] = array();
            $fields = &CRM_Contribute_DAO_ContributionPage::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import']['contribution_page'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export'])) {
            $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export'] = array();
            $fields = &CRM_Contribute_DAO_ContributionPage::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export']['contribution_page'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_CONTRIBUTE_DAO_CONTRIBUTIONPAGE']['_export'];
    }
}
?>