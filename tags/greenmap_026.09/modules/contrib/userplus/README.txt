*******************************************************
    README.txt for userplus.module for Drupal
*******************************************************

This module was developed by Marc Poris (marcp) and Bill Fitzgerald (bonobo)
of Funny Monkey to make the user administration process more efficient for
administrators.

The userplus module supplements Drupal's user administration with the
following features:

   1. "add multiple users" on a single form
   2. "assign user roles" to multiple users on a single form
   3. "delete multiple users" on a single form
   4. "role switching" makes it easy to move multiple users to a different role

These features can be found alongside Drupal's user administration on the
"user +" tab at admin/user/userplus.

INSTALLATION:

Put the module in your modules directory.
Enable it via admin/modules.
[optional] Copy the contents of userplus.css and paste it into your theme's
style.css.

CONFIGURATION:

It is not necessary to do any configuration, however you may customize the
number of rows that will appear on each of the userplus administration screens
by visiting admin/settings/userplus.

TECHNICAL NOTES:

During "add multiple users" user validation bypasses user.module because
errors that occur are reported through form_set_error().  Since our form
contains different fields than the standard "add user" form, it doesn't make
sense to raise errors on the standard fields.  Also, and this is the main
reason, if multiple errors occur in either 'name' or 'mail' when using the
standard user validation process, we will lose errors past the first one
because they get ignored in form_set_error().  To get around this, we do
our own validation in _userplus_validate_user(), however, since we don't
call hook_user('validate', ...) there is a good chance that this module
will not play nicely with modules that implement and depend on
hook_user('validate', ...).

TO DO:

1. Think about how to possibly separate out core functionality from UI
in user.module so we can reuse more code there.

2. Provide a confirmation form for "delete multiple users" as a safety net.

