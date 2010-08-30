ecivicrm.module

Please refer to the README.txt of the 4.7 version:
http://cvs.drupal.org/viewcvs/drupal/contributions/modules/ecommerce/contrib/ecivicrm/?only_with_tag=DRUPAL-4-7

********************************************************************
ADDED NOTES FOR E-COMMERCE 4.8:

1. Copy Transactions.tpl to {civicrm}/templates/CRM/Contact/Page/View. The
   Recommended method is to create a link, then any updates to the
   Transactions.tpl will be automatically installed. This will enable the
   userto view the transactions that have been created for this contact, and
   in the case of a contact which has no user then this is the only method
   of viewing the transactions for a contact.
