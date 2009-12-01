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
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_tableName'] =  'civicrm_mailing_event_queue';
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_fields'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_links'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export'] =  null;
$GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_log'] =  false;

require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Mailing_Event_DAO_Queue extends CRM_Core_DAO {
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
    * FK to Job
    *
    * @var int unsigned
    */
    var $job_id;
    /**
    * FK to Email
    *
    * @var int unsigned
    */
    var $email_id;
    /**
    * FK to Contact
    *
    * @var int unsigned
    */
    var $contact_id;
    /**
    * Security hash
    *
    * @var string
    */
    var $hash;
    /**
    * class constructor
    *
    * @access public
    * @return civicrm_mailing_event_queue
    */
    function CRM_Mailing_Event_DAO_Queue() 
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
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_links'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_links'] = array(
                'job_id'=>'civicrm_mailing_job:id',
                'email_id'=>'civicrm_email:id',
                'contact_id'=>'civicrm_contact:id',
            );
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_links'];
    }
    /**
    * returns all the column names of this table
    *
    * @access public
    * @return array
    */
    function &fields() 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_fields'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_fields'] = array(
                'id'=>array(
                    'name'=>'id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'job_id'=>array(
                    'name'=>'job_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'email_id'=>array(
                    'name'=>'email_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'contact_id'=>array(
                    'name'=>'contact_id',
                    'type'=>CRM_UTILS_TYPE_T_INT,
                    'required'=>true,
                ) ,
                'hash'=>array(
                    'name'=>'hash',
                    'type'=>CRM_UTILS_TYPE_T_STRING,
                    'title'=>ts('Hash') ,
                    'required'=>true,
                    'maxlength'=>255,
                    'size'=>CRM_UTILS_TYPE_HUGE,
                ) ,
            );
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_fields'];
    }
    /**
    * returns the names of this table
    *
    * @access public
    * @return string
    */
    function getTableName() 
    {
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_tableName'];
    }
    /**
    * returns if this table needs to be logged
    *
    * @access public
    * @return boolean
    */
    function getLog() 
    {
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_log'];
    }
    /**
    * returns the list of fields that can be imported
    *
    * @access public
    * return array
    */
    function &import($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import'] = array();
            $fields = &CRM_Mailing_Event_DAO_Queue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('import', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import']['mailing_event_queue'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_import'];
    }
    /**
    * returns the list of fields that can be exported
    *
    * @access public
    * return array
    */
    function &export($prefix = false) 
    {
        if (!($GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export'])) {
            $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export'] = array();
            $fields = &CRM_Mailing_Event_DAO_Queue::fields();
            foreach($fields as $name=>$field) {
                if (CRM_Utils_Array::value('export', $field)) {
                    if ($prefix) {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export']['mailing_event_queue'] = &$fields[$name];
                    } else {
                        $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export'][$name] = &$fields[$name];
                    }
                }
            }
        }
        return $GLOBALS['_CRM_MAILING_EVENT_DAO_QUEUE']['_export'];
    }
}
?>