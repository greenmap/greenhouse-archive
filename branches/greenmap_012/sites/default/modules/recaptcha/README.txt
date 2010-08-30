$Id: README.txt,v 1.13.2.1 2007/08/01 00:46:06 kthagen Exp $

reCAPTCHA for Drupal
====================

The reCAPTCHA module uses the reCAPTCHA web service to
improve the CAPTCHA system and protect email addresses. For
more information on what reCAPTCHA is, please visit:
    http://recaptcha.net


INSTALLATION
------------

1. Extract the reCAPTCHA module to your modules
   directory.
   
2. Download the reCAPTCHA PHP Library from: 
       http://recaptcha.net/plugins/php

3. Extract the files to: modules/recaptcha/recaptcha
   So that recaptchalib.php is available at:
       modules/recaptcha/recaptcha/recaptchalib.php


CONFIGURATION
-------------
   
1. Enable both the reCAPTCHA and CAPTCHA modules in:
       admin/modules
   
2. You'll now find a reCAPTCHA administration page
   available at:
       admin/settings/recaptcha

3. Register for a public and private reCAPTCHA key at:
       http://recaptcha.net/api/getkey

4. Input the keys into the reCAPTCHA settings. The rest of
   the settings should be fine as their defaults.

5. Visit the Captcha administration page and set where you
   want the reCAPTCHA form to be presented:
       admin/settings/captcha


MAILHIDE INPUT FORMAT
---------------------

The reCAPTCHA module also comes with an input format to
protect email addresses. This, of course, is optional to
use and is only there if you want it. The following is how
you use that input filter:

1. Head over to your input format settings:
       admin/filters

2. Edit your default input format and add the reCAPTCHA
   Mailhide filter.
   
3. Click on the Configure tab and put in a public and
   private Mailhide key obtained from:
       http://mailhide.recaptcha.net/apikey

4. Use the Rearrange tab to rearrange the weight of the
   filter depending on what filters already exist.

Note: You will require the installation of the mcrypt
      PHP module in your web server for Mailhide to work:
         http://uk2.php.net/manual/en/ref.mcrypt.php


MULTI-DOMAIN SUPPORT
--------------------

Since reCAPTCHA uses API keys that are unique to each
domain, if you're using a multi-domain system using the
same database, the reCAPTCHA module won't work when
querying the reCAPTCHA web service.  If you put the
following into your sites/mysite/settings.php file for
each domain, it will override the API key values and make
it so multi-domain systems are capable.

  $conf = array(
    'recaptcha_public_key' =>  'my other public key',
    'recaptcha_private_key' =>  'my other private key',
  );


CHANGELOG
---------

July 20, 2007 - Version 2.0
 - Update to the Captcha release 3.x
 - Documentation fixes
 - Patch #160630 by cedo: Mailhide demands of encryption

July 15, 2007
 - Documentation for multiple domain support (christefano)

July 12, 2007
 - Patch #154215: Upgrade to latest version of Captcha
 - Patch #158131 by olax: Norwegian Bokmål Translation

June 11, 2007
 - Patch #149200: Show Error in reCAPTCHA Form
 - Patch #150799: No server settings
 - Patch #150803: Switched package to "SPAM Control"

June 8th, 2007 - Version 1.0
 - Patch #147924: reCAPTCHA Mailhide Input Filter

June 5th, 2007
 - Put the reCAPTCHA server settings into a fieldset
 - Patch #149513: Help topics in admin/help/recaptcha
 - Patch #149427 by kengggg: Thai translation

June 4th, 2007
 - Patch #149230: Display error when PHP library is not present
 - Patch #147907 by lennart: Split up form CSS fix
 - Patch #148347: License issue fix
 - Patch #149283: Uninstaller to remove module variables

May 31st, 2007
 - Patch #148042 by Takafumi: Japanese translation 
 - Removal of title appearing before reCAPTCHA
 - Some Drupal coding standards fixes
 - Documentation

May 30th, 2007
 - First Release


AUTHORS
-------

 * Rob Loach (http://www.robloach.net)
 * Japanese translation by Takafumi (http://drupal.jp)
 * CSS fix by lennart (http://zensci.com)
 * Thai translation by kengggg (http://www.keng.ws)


THANK YOU
---------

 * Thank you goes to the reCAPTCHA team for all their
   help, support and their amazing Captcha solution
       http://www.recaptcha.net
