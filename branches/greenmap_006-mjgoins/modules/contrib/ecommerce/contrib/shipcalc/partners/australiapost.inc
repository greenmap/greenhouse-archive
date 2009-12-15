<?php
// $Id: australiapost.inc,v 1.2.2.2 2007/01/20 04:25:57 gordon Exp $

/**
* @file
* Functions to communicate with shipcalc.module
*
* Provides integration with Australia Posts Online Postage calculator.
* Requires the ecommerce suite of modules
* and shipcalc.module installed.
*
* this works with drupal 4.7
*
* NOTES;
*
* Upload australiapost.inc file into your modules/ecommerce/contrib/shipcalc/partners folder.
*
* Adjust countries and shipping charges per zone at admin -> store -> settings -> shipcalc -> international
*
* Make this shipping method available to products by configuring at admin -> settings -> content types
*
* Once enabled for content types (products) a new form will appear when editing
* products that allows you to include this shipping method.
*
*/

define('AUSTRALIAPOST_URL', 'http://drc.edeliver.com.au/ratecalc.asp');
define('AUSTRALIAPOST_MAX_KGS', 20);
define('AUSTRALIAPOST_MAX_CMS', 105);
define('AUSTRALIAPOST_MIN_GIRTH_CMS', 16);
define('AUSTRALIAPOST_BUFFER_PCT', 20);

/**
* Shipcalc _shipping_methods hook.
*
* Define the international shipping methods.
*/

function australiapost_shipping_methods($type = 'all') {

  $methods = array();

  $methods['australiapost'] = array(
    '#title' => t('Australia Post'),
    '#description' => t('Australia Post'),
    '#product_attributes' => array('weight', 'length', 'width', 'depth'),
  );

  if ($type == 'domestic' || $type == 'all') {
    $methods['australiapost']['STANDARD'] = array(
      '#title' => t('Standard Domestic Delivery'),
    );
    $methods['australiapost']['EXPRESS'] = array(
      '#title' => t('Express Post Domestic Delivery'),
    );
  }
  if ($type == 'international' || $type == 'all') {
    $methods['australiapost']['AIR'] = array(
      '#title' => t('International Air Delivery'),
    );
    $methods['australiapost']['SEA'] = array(
      '#title' => t('International Surface Delivery'),
    );
    $methods['australiapost']['ECI_D'] = array(
      '#title' => t('Express Courier International Document'),
    );
    $methods['australiapost']['ECI_M'] = array(
      '#title' => t('Express Courier International Merchandise'),
    );
    $methods['australiapost']['EPI'] = array(
      '#title' => t('Express Post International'),
    );
  }

//  dpr($methods); die();

  return $methods;
}

/**
 * Shipcalc _settings_form hook.
 */

function australiapost_settings_form(&$form) {
  $form['australiapost'] = array(
    '#type' => 'fieldset',
    '#title' => t('Australia Post settings')
  );

  $form['australiapost']['australiapost_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Australia Post server/page URL'),
    '#description' => t('Enter the fully qualified URL of the Australia Post shipping rate server, as provided by Australia Post API docs.'),
    '#default_value' => variable_get('shipcalc_australiapost_url', AUSTRALIAPOST_URL),
    '#required' => TRUE,
  );

  $form['australiapost']['australiapost_postalcode'] = array(
    '#type' => 'textfield',
    '#title' => t('Post Code'),
    '#description' => t('This is the Post Code of your business and is used for calculating shipping costs.'),
    '#default_value' => variable_get('shipcalc_australiapost_postalcode', ''),
    '#required' => TRUE,
  );

  $form['australiapost']['australiapost_turnaround'] = array(
    '#type' => 'textfield',
    '#title' => t('Turn Around Time (Hours)'),
    '#description' => t('This is the turn around time between receiving the order and shipping the product. (ie. enter 24 for a 24 hour turn around time.)'),
    '#default_value' => variable_get('shipcalc_australiapost_turnaround', 24),
    '#required' => TRUE,
  );

  $form['australiapost']['australiapost_regprice'] = array(
    '#type' => 'textfield',
    '#title' => t('Domestic Registered Post Cost'),
    '#description' => t('Enter the current cost of registering a domestic parcel.'),
    '#default_value' => variable_get('shipcalc_australiapost_regprice', ''),
    '#required' => TRUE,
  );

/*
  $form['australiapost']['australiapost_combine'] = array(
    '#type' => 'checkbox',
    '#title' => t('Combine items together for shipping charge calculation?'),
    '#default_value' => variable_get('australiapost_combine', FALSE),
    '#options' => array(t('Optional'), t('Required')),
    '#disabled' => TRUE,
    '#description' => t('Should the system find the total weight and the approximate
                         shipment dimensions for calculating the shipping cost?
                         Please research the your choice based on a typical shipment
                         by your business and using '.
                         l('Australia Posts\'s', 'http://www1.auspost.com.au/pac/') .'
                         online tools for calculating postage.
                         The combined dimensions are estimated by summing the volume
                         of each item, adding '. AUSTRALIAPOST_BUFFER_PCT .'% and
                         then calculating the cubed root which becomes width, length and height.'),
  );
*/

}
/**
 * Shipcalc _settings_form_submit hook.
 *
 * Save data from our Australia Post-specific configuration form.
 */
function australiapost_settings_form_submit(&$form) {
  global $form_values;
  $op = $_POST['op'];

  if ($form_values['shipping_partner'] == 'australiapost') {
    variable_set('shipcalc_australiapost_postalcode', $form_values['australiapost_postalcode']);
    variable_set('shipcalc_australiapost_turnaround', $form_values['australiapost_turnaround']);
    variable_set('shipcalc_australiapost_regprice', $form_values['australiapost_regprice']);
  }
}

/**
 * Shipcalc _product_attributes hook.
 *
 * Update the product form with fields that we need.  It is possible for
 * multiple carriers to define the same field -- that is fine.  So long as
 * the field as the same name (e.g. 'weight'), it will only be displayed
 * once, and the data will be saved and restored for use by all shipping
 * partners that define it.
 */
function australiapost_product_attributes($form) {
  $fields = array();
  $fields['weight'] = array(
    '#type' => 'textfield',
    '#title' => t('Product Weight'),
    '#description' => t('The weight of the product (in Kilograms)'),
    '#default_value' => $form['#node']->product_attributes['weight']
  );

  $fields['length'] = array(
    '#type' => 'textfield',
    '#title' => t('Product Length'),
    '#description' => t('The length of the product (in Centimeters).'),
    '#default_value' => $form['#node']->product_attributes['length']
  );

  $fields['height'] = array(
    '#type' => 'textfield',
    '#title' => t('Product Height'),
    '#description' => t('The height of the product (in Centimeters)'),
    '#default_value' => $form['#node']->product_attributes['height']
  );

  $fields['depth'] = array(
    '#type' => 'textfield',
    '#title' => t('Product Width'),
    '#description' => t('The width of the product (in Centimeters)'),
    '#default_value' => $form['#node']->product_attributes['depth']
  );

  return $fields;
}

/**
 * Shipcalc _get_rates_form hook.
 *
 * Request rates from Australia Post for the current transaction.  Return a form of all
 * shipping options that the shipcalc module will display during the checkout
 * process.
 *
 * The shipping option form only comfortably displays a simple set of shippig
 * options. So first simplicity, the current procedure is to only offer a
 * shipping method when all items can be delivered this way.
 *
 * Additionally, the current process will price each item separately or together
 * based on a global option. Grouping items together will currently simply sum
 * the volume of each item. It is the store owners responsibility
 * to determine whether the shipping price will be more accurate with all products
 * packaged together, or all separate.
 *
 */

function australiapost_get_rates(&$txn) {

  // Iterate through the items in the shipment, combine them into packages if appropriate.
  // If any items fall out of the norm, return and set an error.

  // Make a copy of the transaction items and pass over it making some adjustments
  // and calculations and doing some checks. Mainly we are determining valid
  // shipping methods.
  $txn_items[0] = $txn->items;
  $standard_methods = australiapost_shipping_methods('domestic');  //TODO International, not much to do
  $standard_methods = $standard_methods['australiapost'];

  foreach ($txn_items[0] AS $item) {
    if (!product_is_shippable($item->vid)) {
      // Ignore non-shippable products.
      unset($txn_items[0][$item->nid]);
    }
    else {
      // Keep count of the Australia Post shipping methods applicable to each item.
      foreach ($item->shipping_methods['australiapost'] as $item_method) {

        if (array_key_exists($item_method, $standard_methods)) {
          $standard_methods[$item_method]['count']++;
        }
      }
    }
  }

  // If there are no shippable items after the above, then return empty.
  if (!count($txn_items[0])) {
    return;
  }
  foreach (element_children($standard_methods) AS $method) {
    // Only keep methods that are valid for ALL items.
    if ($standard_methods[$method]['count'] < count($txn_items[0]) || !isset($standard_methods[$method]['count'])) {
      unset($standard_methods[$method]);
    }
  }

  // If we don't have any methods left, then we can't offer shipping.
  if (!count($standard_methods)) {
    return;
  }

  // We now have an array of shippable items and an array of shipping
  // methods and each item is valid for each shipping method and vice-versa.
  // Hence all items will have weight/length/depth/height

  // Calculate the total weight, volume and total volume
  foreach ($txn_items[0] AS $item) {
    $txn_items[0][$item->nid]->product_attributes['volume'] = $item->product_attributes['length'] * $item->product_attributes['depth'] * $item->product_attributes['height'];
    $txn_items[0]['#total_weight'] = $total_weight + $item->product_attributes['weight'];
    $txn_items[0]['#total_volume'] = $total_volume + $item->product_attributes['volume'];
  }

  // Get rates for each item, or for items combined, depending on the combine setting.
  // TODO:
  // Flesh this out properly for EC5
  if (variable_get('australiapost_combine', FALSE)) {
    if ($total_weight > AUSTRALIAPOST_MAX_KGS) {
      // Here we will pass control to a function that breaks our $txn_items into packages
      // expressed as additional elements on the $txn_items array.
      // Volume and weight are recalculated for each package.
      $txn_items = australiapost_group_by_weight($txn_items); // <-- does not exist yet.
    }

    // Calculate length, width and height for each package.
    // TODO: Currently no check for over-sized package. (Packages based on weight).
    foreach ($txn_items AS $key => $items) {
      $items['#total_volume'] += $items['#total_volume'] * (AUSTRALIAPOST_BUFFER_PCT / 100); // Create a buffer for air and error.
      $cuberoot = round(pow($items['#total_volume']), 1 / 3);
      $txn_items[$key]['#total_length'] = $cuberoot;
      $txn_items[$key]['#total_height'] = $cuberoot;
      $txn_items[$key]['#total_width'] = $cuberoot;
    }
  }

  // For calculation by item. Make a call to Australia Post for each item.
  // TODO, slightly differnt logic for using package totals.

  foreach (element_children($standard_methods) AS $method) {
    $this_rate = array(
      '#service' => 'australiapost',
      '#key' => $method,
      '#cost' => 0,
      '#hours' => variable_get('shipcalc_australiapost_turnaround', 24),
      '#currency' => NULL,
      '#method' => $standard_methods[$method]['#title'],
		);
    foreach (element_children($txn_items[0]) as $key) {
      $item = $txn_items[0][$key];
      $url = variable_get('shipcalc_australiapost_url', AUSTRALIAPOST_URL);
      $opts = array(
        'Pickup_Postcode' => variable_get('shipcalc_australiapost_postalcode', ''),
        'Destination_Postcode' => $txn->address['shipping']->zip,
        'Country' => strtoupper($txn->address['shipping']->country),
        'Weight' => round($item->product_attributes['weight'] * 1000),
        'Service_Type' => $method,
        'Length' => round($item->product_attributes['length'] * 10),
        'Width' => round($item->product_attributes['depth'] * 10),
        'Height' =>round($item->product_attributes['height'] * 10),
        'Quantity' => 1,
      );

      $ap_return = drupal_http_request(url($url, drupal_query_string_encode($opts)));
      parse_str(str_replace("\r\n", "&", $ap_return->data), $charge_data);

      if (trim($charge_data['err_msg']) == 'OK') {
        $this_rate['#cost'] += $charge_data['charge'];
        $this_rate['#hours'] = max($this_rate['#hours'], $charge_data['days'] * 24) + variable_get('shipcalc_australiapost_turnaround', 24);
        $error = 0; // No error
      }
      else {
        drupal_set_message(t('%description (code %code)', array('%code' => $ap_return->code, '%description' => $charge_data['err_msg'])), 'error');
        $error = -1; // negative charges indicates an error
      }
    }

    if (!$error) {
      $rates[] = $this_rate;
    }
  }

  return (count($rates)) ? $rates : -1;
}


