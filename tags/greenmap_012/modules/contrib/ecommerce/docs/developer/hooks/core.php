<?php
// $Id: core.php,v 1.9.2.2.2.4 2007/02/21 00:31:15 neclimdul Exp $

/**
 * @file
 * These are the hooks that are invoked by the Drupal ecommerce package.
 *
 * Core hooks are typically called in all modules at once using
 * module_invoke_all().
 */

/**
 * @defgroup ecommerce E-Commerce
 * @{
 * The Drupal E-Commerce system.
 *
 * Welcome to the Drupal developers documentation for the E-Commerce package.
 */

/**
 * @ingroup hooks
 * @{
 */

/**
 * Manipulate the checkout process, including injecting form pages.
 *
 * Checkoutapi can be implemented by any module. It can be used to insert a
 * page into into the checkout process and even validate/save the form data.
 * Another feature of the API is the ability to push data onto the final review
 * page before final checkout. Note that the order of the form pages is controlled
 * via http://example.com/index.php?q=admin/store/checkout
 *
 * @param &$txn
 *   The transaction object for an order. This keeps growing in data from screen
 *   to screen.
 * @param $op
 *   What kind of action is being performed. Possible values:
 *   - "form": Inject a form page into the checkout process. Don't forget to add
 *     a submit button.
 *   - "save": The injected form page has been submitted. Save your data in
 *     this hook. IMPORTANT: $txn->screen must be incremented here in order to
 *     go to the next screen!
 *        $txn->screen++;
 *   - "validate": The customer has just finished editing the form page and is
 *     trying to submit it. This hook can be used to check or even modify the
 *     transaction object. Errors should be set with form_set_error().
 *   - "review": The last page of the checkout process is being viewed before
 *     the order is placed.
 *   - "review_validate": validation for review page.  Called within the form
 *     validate hook so has same requirements.
 *   - "review_save": save section of the review page.  Called within the form
 *     submit hook and has same requirements.
 * @param $arg3
 *   - Optional parameter to pass along.
 * @param $arg4
 *   - Optional parameter to pass along.
 * @return
 *   This varies depending on the operation.
 *   - The "save" and "validate" operations have no return value.
 *   - The "form" returns a form array to build the modules checkout screen.
 *   - The "review" operation should return a form array.  The themeing is done
 *     by theme_hook_review_form
 *   - The "review_validate" operations have no return value.
 *   - The "review_submit" operations have no return value.
 */
function hook_checkoutapi(&$txn, $op, $arg3 = NULL, $arg4 = NULL) {
  $output = '';
  switch ($op) {
    case 'form':
      if ($form = payment_view_methods()) {
        drupal_set_title(t('Please select a payment method'));
        $form[] = array(
          '#type' => 'submit',
          '#value' => t('Continue'),
          );
        return $form;
      }
      else {
        foreach (payment_get_methods() as $module) {
          if (module_invoke($module, 'paymentapi', $txn, 'display name')) {
            $txn->payment_method = $module;
            break;
          }
        }
        return false;
      }

    case 'validate':
      if (!$txn->payment_method) {
        form_set_error('payment_method', t('Please choose a payment method.'));
      }
      break;

    case 'save':
      $txn->screen++;
      break;

    case 'review':
      $form['payment'] = array('#value' => module_invoke($txn->payment_method, 'paymentapi', $txn, 'display name'));
      return $form;

    case 'review_validate':
      break;

    case 'review_save':
      break;
  }
}

/**
 * Add a payment method.
 *
 * The customer can choose one of several payment methods on checkout if more
 * than one method is enabled.
 *
 * @param &$txn
 *   The transaction object for an order. This keeps growing in data from screen
 *   to screen.
 * @param $op
 *   What kind of action is being performed. Possible values:
 *   - "display name": The name of the method displayed to customers.  This is purely
 *     for display purposes and my be descriptive.
 *   - "on checkout": Called after the customer selects their payment method.  This
 *     can be used for any specific validation the payment method needs to impose.
 *     Be sure to call form_set_error() to raise a warning to the system.
 *   - "form": Called durring the checkout process.  This is used to display options to
 *     the user for choosing between payment options.  Nothing wil be displayed if only
 *     one payment option exists.
 *   - "update/insert": Called after the user has submitted the payment page so
 *     any additional payment details can be stored in the database.
 *   - "payment page": Display the form for accepting credit card information or
 *     redirect to a third party payment processor.
 *   - "delete": Called when the transaction is being deleted.
 * @param $arg3
 *   - Optional parameter to pass along.
 * @return
 *   This varies depending on the operation.
 *   - The "display name" operations return a string.
 *   - The "on checkout" operation should use form_set_error() if validation fails.
 *   - The "form" operation should return a valid form array to be merged with the
 *     full form on the payment checkout screen.
 *   - The "update/insert/delete" and "on checkout" operations have no return value.
 *   - The "payment page" operations should return a URI string or nothing at all.
 */
function hook_paymentapi(&$txn, $op, $arg3 = '') {

  switch ($op) {
    case 'display name':
      return t('PayPal');

    case 'on checkout':
      paypal_verify_checkout($txn);
      break;

    case 'form':
      break;

    case 'update':
    case 'insert':
      paypal_save($txn);
      break;

    case 'payment page':
      if ($txn->gross > 0) {
        return paypal_goto($txn);
      }
      break;

    case 'delete':
      paypal_delete($txn);
      break;
    }
}

/**
 * The productapi is an api implemented by modules that provide a product node type. 
 *
 * @param &$node
 *   The node object for the product.
 *   Depending on $op:
 *   - "adjust_price", "attributes", "delete": fully loaded node object
 *   - "form": when creating a node, minimally loaded node object,
 *      otherwise fully loaded node object
 *   - "load": minimally loaded node object
 *   - "wizard select": product type name
 * @param $op
 *   What kind of action is being performed.  Possible values:
 *   - "adjust_price": called to provide a price adjustment to the product.  No changes
 *     to node->price should be made.
 *   - "attributes": called to find out properties about the product.
 *   - "cart add item":  called when trying to add a product to a shopping cart.  This
 *     allows the product to limit the addition of items.  This is optional as a null
 *     return will be treated as true and the item will be added.
 *   - "cart form": Called from invoicing module and cart view where the
 *     product can additional fields to the cart form.
 *   - "delete":
 *   - "form":
 *   - "load":
 *   - "on payment completion": called on payment completion
 *   - "subproduct_types": called by subproduct to get a list of supported subproducts
 *   - "transaction": I can only guess.  the only place I see this is coupon.module
 *   - "wizard_select": called when trying to create a product instance
 * @param $arg3
 *   Depending on $op:
 *   - "adjust_price": passes a current price here.
 *   - "attributes": Values possibly passed include any return type.  passed values mean it
 *       the attribute is the one being looked for.
 * @param $arg4
 * @return
 *   This value varies depending on the operation.
 *   - "attributes": An array of attributes that show certain properties about a product.
 *     The attribute passed is the one that needs to be returned if needed but any
 *     attribute can be returned without penalty(ie. if a product is always in_stock) 
 *     - "in_stock": inventory level checked on this product,
 *     - "no_quantity": product is sold or not, without a quantity,
 *     - "no_discounts": self-explanatory
 *     - "is_shippable": self-explanatory
 *     - "registered_user": not available for anon purchase (still valid, but obsolescent)
 *   - The "adjust_price" operation returns a new price.
 *   - The "cart add item" operation should return a bool value.  True or NULL will add
 *     to cart and false will redirect.  You must provide you own drupal_set_message
 *     failure message.
 *   - The 'insert'
 *   - The "load" operation should return an associative array of "property => value" pairs
 *     to be merged in to the transaction object.
 *     (Note: do not return an object, as you would with hook_load())
 *   - The "wizard_select" operation should return an array of product types provided by
 *     the module.  The key should uniquely identify the type and the value should be a
 *     translated description.
 */
function hook_productapi(&$node, $op, $arg3 = NULL, $arg4 = NULL) {

  switch($op) {
    case 'wizard_select':
      return array('coupon' => t('Gift Certificate'));

    case 'cart add item':
      break;

    case 'attributes':
      return array('in_stock', 'no_quantity', 'no_discounts');

    case 'transaction':
      break;

    case 'adjust_prices':
      if (!((float)$node->price)) {
        return $node->gc_price;
      }
      break;
    case 'subproduct_types':
      return array('sandwich');
    case 'fields':
      break;

    case 'validate':
      break;

    case 'load':
      break;

    case 'insert':
      break;

    case 'update':
      break;

    case 'delete':
      break;
  }
}

/**
 * Handle store transaction actions.
 * 
 * @param &$txn
 *   A transaction object, passed by reference.
 * @param $op
 *   A string containing the name of the ec_transactionapi operation.
 *   Possible values:
 *   - "insert":
 *       A new transaction is being created.
 *       Called by e.g. store_transaction_save(), with $txn an object containing edit fields 
 *       Standard records in ec_transaction etc. have already been inserted. No return value.
 *   - "load":
 *       A transaction is being loaded from the database.
 *       Called by e.g. store_transaction_load(), with $txn containing the transaction loaded so far.
 *   - "update":
 *       A transaction is being updated. 
 *       Called by e.g. store_transaction_save(), with $txn an object containing edit fields 
 *       Standard records in ec_transaction etc. have already been updated. No return value.
 *   - "delete":
 *       A transaction is being deleted.
 *       The parameter $txn contains all the transaction information,
 *       since the standard records in ec_transaction etc. have already been deleted. No return value.
 *   - "validate":
 *       Transaction $txn is being inserted. Argument $a3 contains the section to validate.
 *       Errors should be set with form_set_error(). No return value.
 *       Called by e.g. store_transaction_validate(), from e.g.
 *       Menu: ?q=admin/store with $_POST['op'] == [ t('Update transaction') or t('Create new transaction') ]
 *       on submission of a form to create a new transaction or update an existing transaction.
 * @param $a3
 *   Additional argument, depending on $op.
 *   - For "validate", this is the section to validate, in upper case. 
 *     Possible values include:
 *     - 'OVERVIEW':
 *     - 'ADDRESSES':
 *     - 'ITEMS':
 *     - 'ALL' (default): Validate all sections.
 * @param $a4
 *   Additional argument, depending on $op. (Not currently used?)
 * @return
 *   The returned value of the invoked hooks, depending on $op.
 *   - The "load" operation should return an associative array of "property => value" pairs
 *     to be merged in to the loaded transaction object.
 *     (Note: do not return an object, as you would with hook_load(), 
 *     since store_invoke_ec_transactionapi() will ignore it)
 */
function hook_ec_transactionapi(&$txn, $op, $a3 = NULL, $a4 = NULL) {
  switch ($op) {
    case 'insert':
      // Empty the cart for this user.
      // Note that user must be logged in at this point.
      cart_empty($txn->uid);
  }
}

/**
 * Ecommerceapi for "on payment completion".
 * 
 * Example taken from ec_useracc.
 * 
 * @param &$txn
 *   A transaction object, passed by reference.
 * @param $op
 *   A string containing the name of the ecommerceapi operation.
 *   Possible values:
 *   - "on payment completion":
 *     Allows modules to hook into the payment completion event.
 */
function hook_ecommerceapi(&$txn, $op) {
  global $user;

  switch ($op) {
    case 'on payment completion':
      if ($user->uid == $txn->uid) {
        return;
      }
      
      // Go through each of the products purchased
      for ($i = 0; $i < count($txn['items']); $i++) {      
        $node =& $txn['items'][$i]; // easy referencing
        
        //ec_useracc_load($node);

        if ($node->useracc['create']) {
          if (!$txn->uid) {
            ec_useracc_create($txn, $node);
          } else {
            ec_useracc_unblock($txn->uid);
          }
          break;
        }
      }
     
      //ec_roles_purchase
      break;
  }
}

/**
 * Create a special for products.
 *
 * If you have products which have a special/discount site wide before the
 * checkout process begins. This can be used for things like timed specials,
 * or discounts based upon the users roles.
 *
 * @param $node
 *  This is the node for the product that we need to know the specials
 *  for.
 *
 * @param $specials
 *  Because this hook can be used by multiple modules at the same time it
 *  is possible that if a special has already been placed on an order the
 *  it may affect the current special.
 *
 * @param $txn
 *  If the special is going to be added to a transaction such as a cart 
 *  item, or an invoice then the $txn will be past so that it can be used to 
 *  determine the correct user or other information.
 * 
 * @return
 *  This will return an array which has a list of the specials by the key
 *  which will appear in misc, and the actual value of the discount. This
 *  will usually be a negative value.
 * 
 */
function hook_product_specials($node, $specials, $txn) {
  return array('special' => -5);
}

/**
 * Determine shipping methods implemented by a module for shipcalc.module.
 * 
 * For useage example, see shipcalc.module and the .inc files in its partners folder.
 * 
 * @return
 *  An array of shipping methods. 
 *
 */
function hook_shipping_methods() {
  $methods['ups'] = array(
    '#title' => t('UPS'),
    '#description' => t('United Parcel Service of America, Inc.')
  );
  $methods['ups']['1DM'] = array(
    '#title' => t('Next Day Air Early AM'),
  );
  // <snip />
  
  return $methods;    
}

/**
 * Add email data to be used within ecommerce modules.
 * 
 * This hook allows us to add ecommerce emails. Also, this can be used
 * in conjunction with store_email_form method that renders email
 * customization and preview forms.
 * 
 * @param $messageid
 *  A string that identifies the message. We need to check if this match
 *  the messages we're additing, using an if() or switch() statement.
 * 
 * @return
 *  Return an indexed array describing the message data (body, subject and variables).
 */
function hook_store_email_text($messageid) {
  if ($messageid == 'shipping_notification') {
    return array(
      'subject' => t("Your %site order has shipped (#%txnid)"),
      'body' => t("Hello %first_name,\n\nWe have shipped the following item(s) from Order #%txnid, received  %order_date.\n\nItems(s) Shipped:\n%items\n%shipping_to\nQuestions about your order? Please contact us at %email.\n\nThanks for shopping at %site.  We hope to hear from you again real soon!\n\n%uri"),
      'variables' => array('%order_date', '%txnid', '%billing_name', '%first_name', '%user_data', '%billing_to', '%shipping_to', '%items', '%email', '%site', '%uri', '%uri_brief', '%date')
    );
  }
}

/**
 * Alter one or many ecommerce emails data.
 * 
 * With this hook we can alter ecommerce emails, the parameters goes as
 * reference, so we can alter eighter the message data (body, subject and
 * variables) and the message variables before sending the email.
 * 
 * @param $messageid
 *  A string that identifies the message. We need to check if this match
 *  the messages we're altering, using an if() or switch() statement.
 * 
 * @param $message
 *  An indexed array describing with the message data (body, subject and variables).
 * 
 * @param $variables
 *  An indexed array with the variables available for this message and its
 *  respective values.
 * 
 * @return
 *  This hook has no return value.
 */
function hook_store_email_alter($messageid, &$message, &$variables) {
  if ($messageid == 'shipping_notification') {
    $message->subject = t("Your %site order has shipped");
    $variables['%site'] = 'drupal.org'; 
  }
}

/**
 * Send a ecommerce email using other mechanism than the default.
 * 
 * This hook abstracts the sending email process. This can be used
 * to send a html/mime email or to put the message in a queue.
 * 
 * @param $from
 *  The email address to be used as sender.
 * 
 * @param $to
 *  The recipient where to send this email.
 * 
 * @param $subject
 *  The subject of this email message.
 * 
 * @param $body
 *  The parsed message body string.
 *  
 * @param $headers
 *  Optional email headers to be added to the email.
 * 
 * @return
 *  This should return TRUE indicating that the message was sucessful delivered,
 *  FALSE if an error occurred while delivering the message and none if this
 *  implementation doesn't override the email delivering process.
 */
function hook_store_email_send($from, $to, $subject, $body, $headers) {
  return mail($to, $subject, $body, $headers);
}

/**
 * Implementation of hook_recurringapi().
 *
 * @param $op Event the hook is reacting to
 *    'on expiry': called when a product has expired
 *    'on purchase': called when a product is purchased
 *    'get previous purchase': called so modules can set the 
 *          $node->recurring['prevpurchase'] value and override the system default
 *          WARNING: Do this with great caution and ensure the format of the value
 *          matches that of the default or you'll break the system!
 *    'expiry schedule changed': called when a product schedule has changed
 *    'cron report': called so modules can implement their own reporting code utilizing
 *          values in $GLOBALS['expirations']
 * @param $obj Reference to data specific to the event
 *    'on expiry': Node of the expired product. In addition to the node fields
 *          a $node->expired_schedule member is set to be the row from the
 *          ec_recurring_expiration table. NOTE: you must be careful to check the status
 *          field of this row before performing operations. The product may be renewed
 *          (i.e have a value of ECRECURRING_STATUS_RENEWED) and may not need any
 *          additional processing other than setting the status to expired. The system
 *          does that automatically.
 *    'on purchase': Transaction
 *    'get previous purchase': Node for the current purchase
 *    'expiry schedule changed': Product node with $node->oldsid set to the previous
 *          schedule ID
 *    'cron report': $GLOBALS['expirations'] containing values collected during
 *          expiration processing
 * @param $val1: First extra value specific to the event
 *    'on expiry': The expiry timestamp
 *    'on purchase': The node ID for the purchased product
 *    'get previous purchase': User ID of the customer
 *    'expiry schedule changed': NULL
 *    'cron report': NULL
 * @param $val2: Second extra value specific to the event
 *    'on expiry': NULL
 *    'on purchase': TRUE if this is a renewal of the product
 *    'get previous purchase': NULL
 *    'expiry schedule changed': NULL
 *    'cron report': NULL 
 */
function hook_recurringapi($op, &$obj, $val1 = NULL, $val2 = NULL) {
  switch ($op) {
    case 'on expiry':
      ec_recurring_on_expiry($obj, $val1);
      break;
    case 'on purchase':
      break;
    case 'get previous purchase':
      break;
    case 'expiry schedule changed':
      break;
    case 'cron report':
      // This is intended for use in the cron mail
      print t("Processed %nprocessed expired products\n%nauto automated payments processed\n\n", array('%nprocessed' => $obj['products_processed'], '%nauto' => $obj['autopay']));
      print t("Processed %nprocessed expired reminders\nSent %nsent reminders\n%nfailed reminders failed\n\n", array('%nprocessed' => $obj['reminders_processed'], '%nsent' => $obj['reminders_sent'], '%nfailed' => $obj['reminders_failed']));
      break;
  }
}

/**
 * Define the type of Mail that can be sent.
 *
 * FIXME: add rest of Description
 */
function hook_mail_types() {
  return array(
    ECMAIL_TYPE_CUSTOMER_INVOICE => t('Customer invoice'),
    ECMAIL_TYPE_PROCESSING_ERROR => t('Processing error notification'),
    ECMAIL_TYPE_CANCEL_TXN => t('Transaction cancelled notice'),
    ECMAIL_TYPE_ASK_CUSTOMER => t('Query to customer'),
  );
}

/**
 * FIXME: Add Description that means something
 */
function hook_mail_reset($type) {
  $mids = array();
  $mid = NULL;
  $var = NULL;
  
  switch ($type) {
    case ECMAIL_TYPE_CUSTOMER_INVOICE:
      $defsub = t('Your %site order');
      $defbody = t("Dear %billing_name,\n\nThanks for your recent purchase from %site.  This message includes important information about your order. Please take a moment to read it closely, and be sure to save a copy for future reference.\n\n********************************\nBilling and Shipping Information\n********************************\n%user_data\n********************************\nOrder Details\n********************************\n%items\nQuestions about your order? Please contact us at %email\n\n********************************\nShipping Instructions\n********************************\nWe will notify you by email as soon as your order ships.\n\nThanks for shopping at %site.  We hope to hear from you again real soon!\n\n%uri");
      $mid = ec_mail_import_old_mail('Default customer invoice', $type, 'store_email_customer_invoice_subject', $defsub, 'store_email_customer_invoice_body', $defbody);
      $var = MAILVAR_CUSTOMER_INVOICE;
      break;
    case ECMAIL_TYPE_PROCESSING_ERROR:
      $defsub = t('Purchase problem, %site');
      $defbody = t("Dear Customer\n\nIt seems there was a problem while processing your order (%txnid). Please contact us at %email for further details.\n\nRegards,\n%site team\n%uri");
      $mid = ec_mail_import_old_mail('Default processing error', $type, 'store_email_processing_error_subject', $defsub, 'store_email_processing_error_body', $defbody);
      $var = MAILVAR_PROCESSING_ERROR;
      break;
    case ECMAIL_TYPE_CANCEL_TXN:
      $defsub = t('Your %site order has been canceled');
      $defbody = t("Dear %billing_name,\n\nYour order (%txnid) has been canceled. Please contact us at %email for further details.\n\nRegards,\n%site team\n%uri");
      $mid = ec_mail_import_old_mail('Default order cancellation notice', $type, 'store_email_cancel_transaction_subject', $defsub, 'store_email_cancel_transaction_body', $defbody);
      $var = MAILVAR_CANCEL_TXN;
      break;
    case ECMAIL_TYPE_ASK_CUSTOMER:
      $defsub = t('Questions regarding your order from %site');
      $defbody = t("Dear %billing_name,\n\nWe have some questions regarding your order from %site.\n\nRegards,\n%site team\n%uri");
      $mid = ec_mail_import_old_mail('Default query to customer', $type, 'store_email_ask_customer_template_subject', $defsub, 'store_email_ask_customer_template_body', $defbody);
      $var = MAILVAR_ASK_CUSTOMER;
      break;
  }
  
  if ($var) {
    ec_mail_variable_change($var, $mid, TRUE);
  }

  if ($mid) {
    $mids[] = $mid;
  }
  
  return $mids;
}

/**
 * @} End of "ingroup hooks".
 */

/**
 * @} End of "defgroup ecommerce"
 */

