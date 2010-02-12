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

define( 'CRM_CORE_BLOCK_MENU',1);
define( 'CRM_CORE_BLOCK_SHORTCUTS',2);
define( 'CRM_CORE_BLOCK_SEARCH',4);
define( 'CRM_CORE_BLOCK_ADD',8);
define( 'CRM_CORE_BLOCK_CONTRIBUTE',16);
$GLOBALS['_CRM_CORE_BLOCK']['_properties'] =  null;
$GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] =  null;

require_once 'CRM/Core/Menu.php';

/**
 * defines a simple implemenation of a drupal block.
 * blocks definitions and html are in a smarty template file
 *
 */
class CRM_Core_Block {

    /**
     * the following blocks are supported
     *
     * @var int
     */
    
                 
            
               
                  
          
    
    /**
     * template file names for the above blocks
     */
    

    /**
     * class constructor
     *
     */
    function CRM_Core_Block( ) {
    }

    /**
     * initialises the $_properties array
     * @return void
     */
     function initProperties()
    {
        if (!($GLOBALS['_CRM_CORE_BLOCK']['_properties'])) {
            $GLOBALS['_CRM_CORE_BLOCK']['_properties'] = array(
                                       CRM_CORE_BLOCK_SHORTCUTS=> array( 'template' => 'Shortcuts.tpl',
                                                                   'info'     => ts('CiviCRM Shortcuts'),
                                                                   'subject'  => ts('CiviCRM Shortcuts'),
                                                                   'active'   => true ),
                                       CRM_CORE_BLOCK_ADD=> array( 'template' => 'Add.tpl',
                                                                   'info'     => ts('CiviCRM Quick Add'),
                                                                   'subject'  => ts('New Individual'),
                                                                   'active'   => true ),
                                       CRM_CORE_BLOCK_SEARCH=> array( 'template' => 'Search.tpl',
                                                                   'info'     => ts('CiviCRM Search'),
                                                                   'subject'  => ts('Contact Search'),
                                                                   'active'   => true ),
                                       CRM_CORE_BLOCK_MENU=> array( 'template' => 'Menu.tpl',
                                                                   'info'     => ts('CiviCRM Menu'),
                                                                   'subject'  => ts('CiviCRM'),
                                                                   'active'   => true ),
                                       CRM_CORE_BLOCK_CONTRIBUTE=> array( 'template' => 'Contribute.tpl',
                                                                   'info'     => ts( 'CiviContribute Progress Meter' ),
                                                                   'subject'  => ts( 'CiviContribute Progress Meter' ),
                                                                   'active'   => true ),
                                       );
        }
    }

    /**
     * returns the desired property from the $_properties array
     *
     * @params int    $id        one of the class constants (ADD, SEARCH, etc.)
     * @params string $property  the desired property
     *
     * @return string  the value of the desired property
     */
     function getProperty($id, $property)
    {
        if (!($GLOBALS['_CRM_CORE_BLOCK']['_properties'])) {
            CRM_Core_Block::initProperties();
        }
        return $GLOBALS['_CRM_CORE_BLOCK']['_properties'][$id][$property];
    }

    /**
     * sets the desired property in the $_properties array
     *
     * @params int    $id        one of the class constants (ADD, SEARCH, etc.)
     * @params string $property  the desired property
     * @params string $value     the value of the desired property
     *
     * @return void
     */
     function setProperty($id, $property, $value)
    {
        if (!($GLOBALS['_CRM_CORE_BLOCK']['_properties'])) {
            CRM_Core_Block::initProperties();
        }
        $GLOBALS['_CRM_CORE_BLOCK']['_properties'][$id][$property] = $value;
    }

    /**
     * returns the whole $_properties array
     * @return array  the $_properties array
     */
     function properties()
    {
        if (!($GLOBALS['_CRM_CORE_BLOCK']['_properties'])) {
            CRM_Core_Block::initProperties();
        }
        return $GLOBALS['_CRM_CORE_BLOCK']['_properties'];
    }

    /**
     * Creates the info block for drupal
     *
     * @return array 
     * @access public
     */
     function getInfo( ) {
        $block = array( );
        foreach ( CRM_Core_Block::properties() as $id => $value ) {
             if ( $value['active'] ) {
                 if ( ( $id == CRM_CORE_BLOCK_ADD|| $id == CRM_CORE_BLOCK_SHORTCUTS) &&
                      ( ! CRM_Core_Permission::check('add contacts') ) && ( ! CRM_Core_Permission::check('edit groups') ) ) {
                     continue;
                 }
                 $block[$id]['info'] = $value['info'];
            }
        }
        return $block;
    }

     function hideContributeBlock( ) {
        // make sure it is a transactions and online contributions is enables
        $config =& CRM_Core_Config::singleton( );
        $args = explode ( '/', $_GET[$config->userFrameworkURLVar] );
        if ( $args[1] != 'contribute' ||
             $args[2] != 'transact'   ||
             ! CRM_Core_Permission::check( 'make online contributions' ) ) {
            return true;
        }

        // also make sure that there is a pageID and that page has thermometer enabled
        $session =& CRM_Core_Session::singleton( );
        $id = $session->get( 'pastContributionID' );
        if ( ! $id ||  
             ! $session->get( 'pastContributionThermometer' ) ) {
            return true;
        }
        
        $title = CRM_Core_DAO::getFieldValue( 'CRM_Contribute_DAO_ContributionPage', $id, 'thermometer_title');
        $GLOBALS['_CRM_CORE_BLOCK']['_properties'][CRM_CORE_BLOCK_CONTRIBUTE]['subject'] = $title;

        return false;
    }

    /**
     * set the post action values for the block.
     *
     * php is lame and u cannot call functions from static initializers
     * hence this hack
     *
     * @return void
     * @access private
     */
     function setTemplateValues( $id ) {
        if ( $id == CRM_CORE_BLOCK_SHORTCUTS) {
            CRM_Core_Block::setTemplateShortcutValues( );
        } else if ( $id == CRM_CORE_BLOCK_ADD) {
            require_once 'CRM/Core/BAO/LocationType.php';
            $defaultLocation = CRM_Core_BAO_LocationType::getDefault( );
            $values = array( 'postURL' => CRM_Utils_System::url( 'civicrm/contact/add', 'reset=1&amp;ct=Individual' ), 
                             'primaryLocationType' => $defaultLocation->id ); 
            CRM_Core_Block::setProperty( CRM_CORE_BLOCK_ADD,
                               'templateValues',
                               $values );
        } else if ( $id == CRM_CORE_BLOCK_SEARCH) {
            $urlArray = array(
                'postURL'           => CRM_Utils_System::url( 'civicrm/contact/search/basic',
                                                              'reset=1' ) ,
                'advancedSearchURL' => CRM_Utils_System::url( 'civicrm/contact/search/advanced',
                                                              'reset=1' )
            );
            CRM_Core_Block::setProperty( CRM_CORE_BLOCK_SEARCH, 'templateValues', $urlArray );
        } else if ( $id == CRM_CORE_BLOCK_MENU) {
            CRM_Core_Block::setTemplateMenuValues( );
        } else if ( $id == CRM_CORE_BLOCK_CONTRIBUTE) {
            CRM_Core_Block::setTemplateContributeValues( );
        }
    }

    /**
     * create the list of shortcuts for the application and format is as a block
     *
     * @return void
     * @access private
     */
     function setTemplateShortcutValues( ) {
        
        
        if (!($GLOBALS['_CRM_CORE_BLOCK']['shortCuts'])) {
            if (CRM_Core_Permission::check('add contacts')) {
                $GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] = array( array( 'path'  => 'civicrm/contact/add',
                                           'query' => 'ct=Individual&reset=1',
                                           'title' => ts('New Individual') ),
                                    array( 'path'  => 'civicrm/contact/add',
                                           'query' => 'ct=Organization&reset=1',
                                           'title' => ts('New Organization') ),
                                    array( 'path'  => 'civicrm/contact/add',
                                           'query' => 'ct=Household&reset=1',
                                           'title' => ts('New Household') ),
                                    );
            }

            if( CRM_Core_Permission::check('edit groups')) {
                $GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] = array_merge($GLOBALS['_CRM_CORE_BLOCK']['shortCuts'], array( array( 'path'  => 'civicrm/group/add',
                                                                   'query' => 'reset=1',
                                                                   'title' => ts('New Group') ) ));
            }

            if (! CRM_Core_Permission::check( 'add contacts' )  &&  ! CRM_Core_Permission::check('edit groups')) {
                return null;
            }

        }

        $values = array( );

        foreach ( $GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] as $short ) {
            $value = array( );
            $value['url'  ] = CRM_Utils_System::url( $short['path'], $short['query'] );
            $value['title'] = $short['title'];
            $values[] = $value;
        }
        CRM_Core_Block::setProperty( CRM_CORE_BLOCK_SHORTCUTS, 'templateValues', array( 'shortCuts' => $values ) );
    }

    /**
     * create the list of mail urls for the application and format is as a block
     *
     * @return void
     * @access private
     */
     function setTemplateMailValues( ) {
        
        
        if (!($GLOBALS['_CRM_CORE_BLOCK']['shortCuts'])) {
             $GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] = array( array( 'path'  => 'civicrm/mailing/send',
                                        'query' => 'reset=1',
                                        'title' => ts('Send Mailing') ),
                                 array( 'path'  => 'civicrm/mailing/browse',
                                        'query' => 'reset=1',
                                        'title' => ts('Browse Sent Mailings') ),
                                 );
        }

        $values = array( );
        foreach ( $GLOBALS['_CRM_CORE_BLOCK']['shortCuts'] as $short ) {
            $value = array( );
            $value['url'  ] = CRM_Utils_System::url( $short['path'], $short['query'] );
            $value['title'] = $short['title'];
            $values[] = $value;
        }
        CRM_Core_Block::setProperty( CRM_CORE_BLOCK_MAIL, 'templateValues', array( 'shortCuts' => $values ) );
    }

    /**
     * create the list of shortcuts for the application and format is as a block
     *
     * @return void
     * @access private
     */
     function setTemplateMenuValues( ) {
        $config =& CRM_Core_Config::singleton( );
        $items  =& CRM_Core_Menu::items( );
        $values =  array( );

        foreach ( $items as $item ) {
            if ( ! CRM_Utils_Array::value( 'crmType', $item ) ) {
                continue;
            }

            if ( ( $item['crmType'] &  CRM_CORE_MENU_NORMAL_ITEM ) &&
                 ( $item['crmType'] >= CRM_CORE_MENU_NORMAL_ITEM ) &&
                 $item['access'] ) {
                $value = array( );
                $value['url'  ]  = CRM_Utils_System::url( $item['path'], CRM_Utils_Array::value( 'query', $item ) );
                $value['title']  = $item['title'];
                $value['path']   = $item['path'];
                $value['class']  = 'leaf';
                $value['parent'] = null;
                $value['start']  = $value['end'] = null;

                if ( strpos( CRM_Utils_Array::value( $config->userFrameworkURLVar, $_REQUEST ), $item['path'] ) === 0 ) {
                    $value['active'] = 'class="active"';
                } else {
                    $value['active'] = '';
                }
                
                // check if there is a parent
                foreach ( $values as $weight => $v ) {
                    if ( strpos( $item['path'], $v['path'] ) !== false) {
                        $value['parent'] = $weight;

                        // only reset if still a leaf
                        if ( $values[$weight]['class'] == 'leaf' ) {
                            $values[$weight]['class'] = 'collapsed';
                        }

                        // if a child or the parent is active, expand the menu
                        if ( $value['active'] || $values[$weight]['active'] ) {
                            $values[$weight]['class'] = 'expanded';
                        }

                        // make the parent inactive if the child is active
                        if ( $value['active'] && $values[$weight]['active'] ) { 
                            $values[$weight]['active'] = '';
                        }

                    }
                }
                
                $values[$item['weight'] . '.' . $item['title']] = $value;
            }
        }

        // remove all collapsed menu items from the array
        $activeChildren = array( );
        foreach ( $values as $weight => $v ) {
            if ( $v['parent'] ) {
                if ( $values[$v['parent']]['class'] == 'collapsed' ) {
                    unset( $values[$weight] );
                } else {
                    $activeChildren[] = $weight;
                }
            }
        }
        
        // add the start / end tags
        $len = count($activeChildren) - 1;
        if ( $len >= 0 ) {
            $values[$activeChildren[0   ]]['start'] = true;
            $values[$activeChildren[$len]]['end'  ] = true;
        }

        ksort($values);

        CRM_Core_Block::setProperty( CRM_CORE_BLOCK_MENU, 'templateValues', array( 'menu' => $values ) );
    }

    /**
     * set the contribute values for a given page
     *
     * @return void
     * @access private
     */
     function setTemplateContributeValues( ) {
        require_once 'CRM/Contribute/BAO/Contribution.php';
        
        $session =& CRM_Core_Session::singleton( );
        $pageID = $session->get( 'pastContributionID' );
        list( $goal, $current ) = CRM_Contribute_BAO_Contribution::getCurrentandGoalAmount( $pageID );
        CRM_Core_Block::setProperty( CRM_CORE_BLOCK_CONTRIBUTE, 'templateValues', array( 'goal'    => $goal,
                                                                      'current' => $current ) );
    }

    /**
     * Given an id creates a subject/content array
     *
     * @param int $id id of the block
     *
     * @return array
     * @access public
     */
     function getContent( $id ) {
        if ( ! CRM_Core_Block::getProperty( $id, 'active' ) ) {
            return null;
        }

        if ( $id == CRM_CORE_BLOCK_CONTRIBUTE) {
            if ( CRM_Core_Block::hideContributeBlock( ) ) {
                return null;
            }
        } else if ( ! CRM_Core_Permission::check( 'access CiviCRM' ) ) {
            return null;
        } else if ( ( $id == CRM_CORE_BLOCK_ADD|| $id == CRM_CORE_BLOCK_SHORTCUTS) &&
                    ( ! CRM_Core_Permission::check( 'add contacts' ) ) && ( ! CRM_Core_Permission::check('edit groups') ) ) {
            return null;
        }


        CRM_Core_Block::setTemplateValues( $id );

        $block = array( );
        $block['name'   ] = 'block-civicrm';
        $block['id'     ] = $block['name'] . '_' . $id;
        $block['subject'] = CRM_Core_Block::fetch( $id, 'Subject.tpl',
                                         array( 'subject' => CRM_Core_Block::getProperty( $id, 'subject' ) ) );
        $block['content'] = CRM_Core_Block::fetch( $id, CRM_Core_Block::getProperty( $id, 'template' ),
                                         CRM_Core_Block::getProperty( $id, 'templateValues' ) );
        
        return $block;
    }

    /**
     * Given an id and a template, fetch the contents
     *
     * @param int    $id         id of the block
     * @param string $fileName   name of the template file
     * @param array  $properties template variables
     *
     * @return array
     * @access public
     */
     function fetch( $id, $fileName, $properties ) {
        $template =& CRM_Core_Smarty::singleton( );

        if ( $properties ) {
            $template->assign( $properties );
        }

        return $template->fetch( 'CRM/Block/' . $fileName );
    }

}

?>