<?php
// $Id: shipping.inc,v 1.2.4.4 2007/02/26 09:16:41 sime Exp $

function shipping_charge_methods() {
  $methods = array();

  $methods['shipping'] = array(
    '#title' => t('Shipping'),
    '#description' => t('Shipping rates based on weight, size and destination.'),
  );
  $methods['shipping']['simple'] = array(
    '#title' => t('Simple shipping'),
    '#description' => t('Weight and region based simple shipping.'),
  );
  return $methods;
}

/**
 * This hook is called by flexicharge_form_alter() to allow modules to add.
 *
 */
function shipping_flexicharge_attributes($form_id, &$form) {
  $measure = store_name_measure('weight', variable_get('ec_measure_weight', 'LB'));
  $fields = array();
  $fields['weight'] = array(
    '#type' => 'textfield',
    '#title' => t('Product weight'),
    '#description' => t('The weight of the product (in %unit)', array('%unit'=> t($measure))),
    '#default_value' => $form['#node']->flexicharge_methods['shipping']['weight'],
  );
  return $fields;
}

/**
 * _flexicharge_form_elements hook.
 *
 * This function is called so that the charge provider can add
 * required fields to the new charge form.
 *
 */
function shipping_flexicharge_form_elements(&$form, $op, $method) {

  $measure = variable_get('ec_measure_weight', 'LB');

  $regions = ec_region_get_regions('', 'fl_shipping');

  foreach ($regions AS $r => $region) {
    $form['elements'][$r] = array(
      '#type' => 'fieldset',
      '#title' => t('Region: ') . t($region['region_name']),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#weight' => 5,
      '#tree' => TRUE,
    );
    $form['elements'][$r][$r.'_'.'use'] = array(
      '#type' => 'checkbox',
      '#title' => t('Enable charge for this region.'),
    );
    $form['elements'][$r][$r.'_'.'base'] = array(
      '#type' => 'textfield',
      '#required' => true,
      '#title' => t('Base cost'),
      '#description' => t('This amount forms the base shipping cost, regardless of weight.'),
    );
    $form['elements'][$r][$r.'_'.'rate'] = array(
      '#type' => 'textfield',
      '#required' => true,
      '#title' => t('Cost per '. $measure),
      '#description' => t('Used to calculate shipping cost.'),
    );
  }
  // Need some defaults as well.
  $form['elements'][0] = array(
    '#type' => 'fieldset',
    '#title' => t('Unallocated locations'),
    '#description' => t('These are the locations which have not been allocated to a region.
                         You can edit your regions in the !ec_regions page.',
                         array('!ec_regions'=>l(t('Shipping regions configuration'),'admin/store/settings/regions/fl_shipping'))),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 6,
    '#tree' => TRUE,
  );
  $form['elements'][0]['0_use'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable charge for this region.'),
  );
  $form['elements'][0]['0_base'] = array(
    '#type' => 'textfield',
    '#required' => true,
    '#title' => t('Base cost'),
    '#description' => t('This amount forms the base shipping cost, regardless of weight.'),
  );
  $form['elements'][0]['0_rate'] = array(
    '#type' => 'textfield',
    '#required' => true,
    '#title' => t('Cost per '. $measure),
    '#description' => t('Used to calculate shipping cost.'),
  );

  $form['module']['#collapsed'] = TRUE;
  unset($form['module']['operator']);
  unset($form['module']['rate']);

  return TRUE;
}

function shipping_flexicharge_form_validate($form_id, $form) {
  switch ($method) {
    case 'simple':
  }
  return $form;
}

/**
 * Implementation of hook_flexicharge_calculate.
 *
 * We are just catching the 'review' operation of the checkoutapi.
 * This is where most misc calculations will want to work. On the
 * review screen.
 *
 */
function shipping_flexicharge_review(&$txn, $charge) {

  switch ($charge->method) {
    case 'simple':
         $misc = array(
           'type' => 'fl_'. $charge->chid,
           'chid' => $charge->chid,
           'description' => $charge->display,
           'operator' => $charge->operator,
           'rate' => $charge->rate,
           'subtotal_before' => $charge->subtotal_before,
           'subtotal_after' => $charge->subtotal_before,
           'already_added' => $charge->already_added,
           'hide_if_zero' => $charge->hide_if_zero,
           'weight' => $charge->position,
           'method' => $charge->method,
           'callback' => 'simple_shipping_flexicharge_calculate',
           'settings' => $charge->settings,
         );
      break;
  }
  return $misc;
}

/**
 * 'General' charge calculation
 *
 * FLEXICHARGE_CHARGE                 +/-
 * FLEXICHARGE_CHARGE_PCT_SUBTOTAL    % of current total
 * FLEXICHARGE_CHARGE_PCT_ITEMTOTAL   % of item total
 *
 */
function simple_shipping_flexicharge_calculate(&$txn, $misc, $total) {

  $realm = 'fl_shipping';

  // Determine what region items are shipping to.
  $user_country = $txn->address['shipping']->country;
  $user_state = $txn->address['shipping']->state;
  $geo_code = $user_country .'.'. $user_state;

  // get the region for this geo code (eg. what region is 'us.NY' in?)
  $this_region = ec_region_get_configuration($realm, '', '', $geo_code);
  // If no reference to this state, look for country.
  if (!count($this_region)) {
    $this_region = ec_region_get_configuration($realm, '', '', $user_country);
  }

  $regid = ($this_region[0]->regid) ? $this_region[0]->regid : 0;

  if (isset($misc->settings[$regid .'_use']) && $misc->settings[$regid .'_use']) {
    $base = $misc->settings[$regid .'_base'];
    $rate_per_unit_measure = $misc->settings[$regid .'_rate'];
  }
  else {
    return;
  }
  // Calculate total weight
  foreach ($txn->items AS $item) {
    $weight += $item->qty * $item->flexicharge_methods['shipping']['weight'];
  }

  $rate = $base;
  $rate += ($weight * $rate_per_unit_measure);

  if ($rate === 0 && $misc->hide_if_zero) {
    // modify the txn to hide this charge if required.
    foreach ($txn->misc AS $m) {
      if ($m->chid == $misc->chid) {
        $txn->misc[$m->chid]->seen = TRUE;
      }
    }      
  }

  return $rate;
}

