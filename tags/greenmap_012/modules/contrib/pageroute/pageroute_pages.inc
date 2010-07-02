<?php
/*
 * Loads a page. Called from pageroute_load_page()
 */
function pageroute_load_page_inc(&$route, &$page) {

  switch ($page->type) {
    case 'add':
      if ($page->title) {
        drupal_set_title(check_plain($page->title));
      }

      pageroute_invoke('load', $page);
      //show add form
      return node_add($page->options['content-type']);

    case 'edit':
      if ($page->title) {
        drupal_set_title(check_plain($page->title));
      }
      pageroute_invoke('load', $page);

      $nid = pageroute_page_arg($page, 1);
      if (empty($nid) && $page->options['content-type']) {
        return node_add($page->options['content-type']);
      }
      else if (!is_numeric($nid) || 
               !($node = node_load($page->options['content-type'] ? array('nid' => $nid, 'type' => $page->options['content-type']) : $nid)) ) {
        drupal_not_found();
        return;
      }
      //show edit form
      if ($_POST['op'] == t('Delete')) {
        if ($_REQUEST['destination']) {
          $destination = drupal_get_destination();
          unset($_REQUEST['destination']);
        }
        drupal_goto('node/'. $node->nid .'/delete', $destination);
      }
      if (node_access('update', $node)) {
        //show edit form
        return node_form($node);
      }
      break;

    case 'manage':
      if ($page->title) {
        drupal_set_title(check_plain($page->title));
      }
      //show manage page
      return pageroute_page_manage($route, $page->options['content-type']);

    case 'view':
        if ($page->options['nid'] == 0) {
          $page->options['nid'] = intval(pageroute_page_arg($page, 1));
        }
        $node = node_load(array('nid' => $page->options['nid']));
        if ($node->nid && node_access('view', $node)) {
          $page->title ? drupal_set_title(check_plain($page->title)) : drupal_set_title(check_plain($node->title));
          node_tag_new($node->nid);
          
          pageroute_invoke('load', $page);

          //add tabs and buttons
          pageroute_get_tabs($page, $form);
          pageroute_get_buttons($page, $form);
          $form['buttons']['#weight'] = 10;
          $form['node'] = array('#value' => node_view($node, FALSE, TRUE, FALSE));
          $form['op'] = array('#type' => 'value');
          return drupal_get_form('pageroute_'. $page->name, $form, 'pageroute_page_form');
        }
        else if (db_result(db_query('SELECT nid FROM {node} WHERE nid = %d', $page->options['nid']))) {
          drupal_access_denied();
        }
        else {
          drupal_not_found();
        }
      break;
    default:
     return 'Invalid page type.';      
  }
}



/*
 * Implementation of hook_form_alter().
 */
function pageroute_form_alter($form_id, &$form) { 
  global $page;

  if (isset($form['type']) && $form['type']['#value'] == $page->options['content-type'] &&
      $form['type']['#value'] .'_node_form' == $form_id) {
    //this is a node form viewed during a pageroute
 
    $preview = $form['preview'];
    //write into $form['preview'], so that the buttons get rendered at the bottom of the page

    //add/hide buttons buttons
    pageroute_get_tabs($page, $form, TRUE, ($page->type == 'manage') ? 'op2' : 'op');
    pageroute_get_buttons($page, $form, TRUE, ($page->type == 'manage') ? 'op2' : 'op');
    $form['preview'] = $form['buttons'];
    unset($form['buttons']);
    
    if ($page->type != 'manage') {
      $options = &$page->options;
    }
    else {
      $options = $form['#node']->nid ? $page->options['edit'] : $page->options['add'];
      $form['submit']['#name'] = 'op2';
    }

    if (!$options['submit']) {
      unset($form['submit']);
    }
    if ($options['nodelete'] && $form['delete']) {
      unset($form['delete']);
    }
    if ($options['preview']) {
      $submit['submit'] = $form['submit'];
      $submit['preview'] = $preview;
      $form['submit'] = $submit;
    }
    
    //change author if the passed uid is not 0
    if (user_access('administer nodes') && pageroute_page_arg($page, 0)) {
      if ($account = user_load(array('uid' => pageroute_page_get_uid($page)))) {
        $form['author']['name']['#default_value'] = $account->name;
      }
    }
    //register functions
    $form['op'] = array('#type' => 'value');
    $form['#validate']['pageroute_page_form_validate'] = array();
    $form['#submit']['pageroute_page_form_submit'] = array();
  }
}


/*
 * Shows a node management page for the given content type
 * It determines what has to be displayed (overview, add/edit/delete form).
 *
 * This function may be invoked during the display of other pages to display the overview, in this case
 * set $sub_page to TRUE
 */
function pageroute_page_manage(&$route, $content_type, $sub_page = FALSE) {
  global $user, $page;

  $arg = pageroute_arg($route, 1);
  
  if (!$arg || is_numeric($arg)) {
    if (!$sub_page) {
      pageroute_invoke('load', $page);
    }
    $form = pageroute_page_manage_overview($content_type, $form, $sub_page, pageroute_page_get_uid($page));

    if ($form && !$sub_page) {
      return drupal_get_form('pageroute_page_form_manage_'. $content_type, $form, 'pageroute_page_form');
    }
    else if ($sub_page) {
      return $form;
    }
    else {
      //there are no nodes, so show the add form
      return pageroute_get_tabs($page, $form_1, FALSE) . node_add($content_type) . pageroute_get_buttons($page, $form2, FALSE);
    }
  }
  else if ($sub_page) {
    drupal_not_found();
    exit;
  }

  switch ($arg) { 
    case 'add':
      $page->arg_offset = 2;
      pageroute_invoke('load', $page);
      return node_add($content_type);
      
    case 'edit':
      if (!is_numeric(pageroute_arg($route, 2)) || !($node = node_load(pageroute_arg($route, 2)))) {
        drupal_not_found();
        return;
      }
      $page->arg_offset = 3;
      pageroute_invoke('load', $page);

      if ($_POST['op'] == t('Delete')) {
        if ($_REQUEST['destination']) {
          $destination = drupal_get_destination();
          unset($_REQUEST['destination']);
        }
        drupal_goto(_pageroute_create_path($page, $page->name .'/delete/'. $node->nid), $destination);
      }
      if (node_access('update', $node)) {
        //show edit form
        return node_form($node);
      }
      drupal_not_found();
      return;
    
    case 'delete':
      if (!is_numeric(pageroute_arg($route, 2)) || !($node = node_load(pageroute_arg($route, 2)))) {
        drupal_not_found();
        return;
      }
      $page->arg_offset = 3;
      pageroute_invoke('load', $page);
      return pageroute_node_delete_confirm($node);

    default:
      drupal_not_found();
      return;      
  }
}

/*
 * Implementation of hook_nodeapi
 */
function pageroute_nodeapi(&$node, $op, $teaser = NULL, $page = NULL) {
  global $page;
  //if a node is created with the page type node edit or node add, we append the new nid as argument to the pageroute
  if ($op == 'insert' && $page && in_array($page->type, array('add', 'edit'))) {
    pageroute_page_new_arg($page, $node->nid, 1);
  }
}


function pageroute_page_manage_overview($content_type, &$form, $sub_page = FALSE, $uid) {
  global $page;
  
  $result = db_query(db_rewrite_sql("SELECT nid FROM {node} n WHERE n.type = '%s' AND n.uid = %d AND n.status > 0 ".
            "ORDER BY n.created"), $content_type, $uid);

  $output = '';

  $i = 1;
  while ($row = db_fetch_object($result)) {
    $node = node_load($row->nid);
    
    $access = array();
    if (node_access('update', $node)) {
      $access[] = 'edit';
    }
    if (node_access('delete', $node)) {
      $access[] = 'delete';
    }

    if ($access) {
      $form[$node->nid]['buttons'] = theme('pageroute_page_manage_buttons', $node, $i, $access);
      $buttons = form_render($form[$node->nid]['buttons']);
    }
    $form['output'][$node->nid] = array('#value' => theme('pageroute_page_manage_node', $node, $i++, $buttons));
  }

  if ($i == 1 && $page->options['empty_add'] && !$sub_page) {
    return array();
  }
  else if ($i == 1) {
    $types = node_get_types();
    $form['output'] = array('#value' => t('There is no %type.', array('%type' => $types[$content_type])));
  }
  
  if (!$sub_page) {
    pageroute_get_tabs($page, $form);
  }
  
  //add buttons
  if ($page->options['add_button'] && (!module_exist('nodefamily') || nodefamily_content_type_get_max($page->options['content-type']) != $i-1 || $i == 1)
     && !($i == 1 && $page->options['empty_add'])) {

    $form['add_button'] = theme('pageroute_page_manage_add_button', $content_type, $page->options['add_button']);
  }

  if (!$sub_page) {
    $form['op'] = array('#type' => 'value');
    pageroute_get_buttons($page, $form);
  }

  return $form;
}

  
  
/*
 * Theme the display of a pageroute node management page
 */
function theme_pageroute_page_manage_node(&$node, $number, &$buttons) {

  $output = node_view($node, FALSE, TRUE, FALSE);
  $output .= $buttons;
  
  $types = node_get_types();
  $fieldset = array(
    '#title' => $types[$node->type]. ' '. $number,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#children' => $output,
  );
  return theme('fieldset', $fieldset);
}

/*
 * Theme the display of the edit/delete buttons of an existing node
 */
function theme_pageroute_page_manage_buttons($node, $number, $buttons) {
  
  foreach ($buttons as $key => $name) {
    $form[$name]['#attributes']['class'] = 'pageroute-'. $name;
    $form[$name]['#type'] = 'submit';
    $form[$name]['#value'] = t($name);
    $form[$name]['#name'] = 'op_'. $node->nid;
    $form[$name]['#weight'] = $key;
  }
  $form['#prefix'] = '<span class="pageroute_manage_buttons">';
  $form['#suffix'] = '</span>';        

  return $form;
}

/*
 * Theme the add node button
 */
function theme_pageroute_page_manage_add_button($content_type, $label) {
  
  $form_element['#attributes']['class'] = 'pageroute-add';
  $form_element['#type'] = 'submit';
  $form_element['#value'] = t($label);
  $form_element['#prefix'] = '<span class="pageroute_manage_add_button">';
  $form_element['#suffix'] = '</span>';
  return $form_element;
}


/* 
 * Provide an extra delete page to keep control about the destination parameter
 */
function pageroute_node_delete_confirm(&$node) {
  global $page;

  if (node_access('delete', $node)) {  
    $form['nid'] = array('#type' => 'value', '#value' => $node->nid);
    
    if ($page && $page->route->options['destination'] && isset($_REQUEST['destination'])) {
      $destination = drupal_get_destination();
    }
    if ($page) {
      $path = _pageroute_get_path($page);
    }
    
    //we can't use confirm_form() as this doesn't allow links with a query, so rebuild it
    drupal_set_title(t('Are you sure you want to delete %title?', array('%title' => theme('placeholder', $node->title))));
    $form['#attributes'] = array('class' => 'confirmation');
    $form['description'] = array('#value' => t('This action cannot be undone.'));
    $form['confirm'] = array('#type' => 'hidden', '#value' => 1);
    $form['actions'] = array('#prefix' => '<div class="container-inline">', '#suffix' => '</div>');
    $form['actions']['submit'] = array('#type' => 'submit', '#value' => t('Delete'));
    $form['actions']['cancel'] = array('#value' => l(t('Cancel'), $path, array(), $destination));
    return drupal_get_form('pageroute_node_delete_confirm', $form, 'confirm_form');
  }
  drupal_access_denied();
}

function pageroute_node_delete_confirm_submit($form_id, &$form_values) {
  global $page;

  if ($form_values['confirm']) {
    node_delete($form_values['nid']);
  }

  if ($page && $page->route->options['destination'] && isset($_REQUEST['destination'])) {
    $destination = drupal_get_destination();
    unset($_REQUEST['destination']);
    return array(_pageroute_get_path($page), $destination);
  }
  else if ($page) {
    return _pageroute_get_path($page);
  }
}
