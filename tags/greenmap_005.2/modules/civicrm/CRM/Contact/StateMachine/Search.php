<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.5                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2006                                  |
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


require_once 'CRM/Core/StateMachine.php';
require_once 'CRM/Core/Action.php';
require_once 'CRM/Contact/Task.php';

class CRM_Contact_StateMachine_Search extends CRM_Core_StateMachine {

    /**
     * The task that the wizard is currently processing
     *
     * @var string
     * @protected
     */
    var $_task;

    /**
     * class constructor
     */
    function CRM_Contact_StateMachine_Search( $controller, $action = CRM_CORE_ACTION_NONE ) {
        parent::CRM_Core_StateMachine( $controller, $action );

        $this->_pages = array( );
        if ( $action == CRM_CORE_ACTION_ADVANCED ) {
            $this->_pages['CRM_Contact_Form_Search_Advanced'] = null;
            list( $task, $result ) = $this->taskName( $controller, 'Advanced' );
        } else if ( $action == CRM_CORE_ACTION_PROFILE ) {
            $this->_pages['CRM_Contact_Form_Search_Builder'] = null;
            list( $task, $result ) = $this->taskName( $controller, 'Builder' );
        } else {
            $this->_pages['CRM_Contact_Form_Search'] = null;
            list( $task, $result ) = $this->taskName( $controller, 'Search' );
        }
        $this->_task    = $task;
        if ( is_array( $task ) ) {
            foreach ( $task as $t ) {
                $this->_pages[$t] = null;
            }
        } else {
            $this->_pages[$task] = null;
        }

        if ( $result ) {
            $this->_pages['CRM_Contact_Form_Task_Result'] = null;
        }

        $this->addSequentialPages( $this->_pages, $action );
    }

    /**
     * Determine the form name based on the action. This allows us
     * to avoid using  conditional state machine, much more efficient
     * and simpler
     *
     * @param CRM_Core_Controller $controller the controller object
     *
     * @return string the name of the form that will handle the task
     * @access protected
     */
    function taskName( $controller, $formName = 'Search' ) {
        // total hack, check POST vars and then session to determine stuff
        // fix value if print button is pressed
        if ( CRM_Utils_Array::value( '_qf_' . $formName . '_next_print', $_POST ) ) {
            $value = CRM_CONTACT_TASK_PRINT_CONTACTS;
        } else {
            $value = CRM_Utils_Array::value( 'task', $_POST );
        }
        if ( ! isset( $value ) ) {
            $value = $this->_controller->get( 'task' );
        }
        $this->_controller->set( 'task', $value );

        return CRM_Contact_Task::getTask( $value );
    }

    /**
     * return the form name of the task
     *
     * @return string
     * @access public
     */
    function getTaskFormName( ) {
        return CRM_Utils_String::getClassName( $this->_task );
    }

}

?>