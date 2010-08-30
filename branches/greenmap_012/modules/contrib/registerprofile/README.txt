Registerprofile module.
=======================

NOTE: For this module to work, you must have nodeprofile.module installed and working first.

This module adds profile nodes on to the register page and creates a node for new user when registration is done.  

It will work with rolesignup.module to allow per-role register pages with different profiles.


How to use
==========

1) Install nodeprofile and set up as per its readme.
2) under admin > access control check the 'anonymous user' box under 'registerprofile module' for each nodeprofile type you want to be shown on the register page.
3) (optional) if you have rolesignup.module installed then you can check content types the roles you allow users to sign up for.  This allows you to show content type a to 1 role and content type b to another.


Issues
======

The main problem that I can think of is that profiles are published before the user is authenticated.  This allows users to create content on your site before they are 'real' users.  If I can find a way to only publish the nodes after the user logs in for the first time then I will add it.

Please create issues with ideas and feedback (and patches ;) ) in the modules issue que.