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

/**
 * This class holds all the Pseudo constants that are specific to Mass mailing. This avoids
 * polluting the core class and isolates the mass mailer class
 */
$GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'] = null;
$GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'] = null;

class CRM_Member_PseudoConstant extends CRM_Core_PseudoConstant {

    /**
     * membership types
     * @var array
     * @static
     */
    

    /**
     * membership types
     * @var array
     * @static
     */
    

    /**
     * Get all the membership types
     *
     * @access public
     * @return array - array reference of all membership types if any
     * @static
     */
      function &membershipType($id = null)
    {
        if ( ! $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'],
                                               'CRM_Member_DAO_MembershipType' );
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'])) {
                return $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipType'];
    }

    /**
     * Get all the membership statuss
     *
     * @access public
     * @return array - array reference of all membership statuss if any
     * @static
     */
      function &membershipStatus($id = null)
    {
        if ( ! $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'] ) {
            CRM_Core_PseudoConstant::populate( $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'],
                                               'CRM_Member_DAO_MembershipStatus' );
        }
        if ($id) {
            if (array_key_exists($id, $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'])) {
                return $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'][$id];
            } else {
                return null;
            }
        }
        return $GLOBALS['_CRM_MEMBER_PSEUDOCONSTANT']['membershipStatus'];
    }
    
}

?>
