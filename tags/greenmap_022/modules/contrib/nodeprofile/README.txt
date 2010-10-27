$Id: README.txt,v 1.21 2006/09/02 20:32:42 fago Exp $

Nodeprofile Module
------------------------
by Wolfgang Ziegler, nuppla@zites.net


With this module you can build user profiles with nodes. To achieve this
a couple of other modules are really useful:

Short module overview:
---------------------
nodeprofile.module - Marks content types as profiles

usernode.module - Automatically creation of usernodes
nodefamily.module - Builds nodefamilies based on content types and author information
pageroute.module - Allows the creation of pageroutes.
views_fusion.module - Provides fusing of multiple views.



nodeprofile.module
-----------------
This module allows you to mark content types as user profiles, do this
at 'admin/settings/content-types'. 
It uses the nodefamily module to restrict the node population and it to set 
a relation between the content type of usernodes and a user profile, so that
it is possible to easily get all profile nodes and display them at the usernode.


usernode.module
---------------
http://drupal.org/project/usernode

This module tries to make users nodes. It cares for automatically creation and 
deletion of a node for each user, the so called usernode.

You need not use this module if you want to build nodeprofiles, however it is 
suggested to do so.

It allows you to
    * Use views to build user listings or even searches. Usernode provides an 
      easy customizeable default view.
    * Makes building of nodeprofiles easier. You may use it to present the users
      nodeprofile to the public.
    * Use features, which other modules provide for nodes, with users. Think of
      comments, taxonomy...


How do usernodes interact with nodeprofiles?
----------------------------------------------
The default display of the usernode shows links to all child nodes of any existing
nodefamily relation. This will list nodes with a content type marked as 
nodeprofile.
So you can use the usernode for viewing all profiles of an user.

By using the nodefamily relations you are able to theme the display of the usernode
to display the whole content of a nodeprofile or to use the information from multiple
child nodes to theme your usernode attractive. Have a look at the nodefamily README
for further instructions on how to do this.


Links to other useful modules for building nodeprofiles
-------------------------------------------------------
http://drupal.org/project/cck
http://drupal.org/project/pageroute
http://drupal.org/project/views
http://drupal.org/project/views_fusion


Installation 
------------
 * Download and install the nodefamily module. (http://drupal.org/project/nodefamily)
 * Copy the nodeprofile module to your modules directory and activate it.
 * Optionally download and install the usernode module too.
 * Optionally activate further modules you want to use for building nodeprofiles
   (cck, views, views_fusion, pageroute)



How to build a user profile with this stuff?
--------------------------------------------

First I describe how a more simple user profile, which consists only of one content type,
can be built:

 * Create your content type you want to use for your profile, e.g. with the CCK.
 * Mark your content type as user profile at 'admin/settings/content-types'
 * If you don't like the usual node forms for editing the profile remove the usual 
   'create content' link using the menu module. Use a new link pointing at 
   'nodefamily/CONTENT_TYPE' or an url alias of it.
 * For building user listings and user searches use the views module together with the
   usernode module. If the view should also contain profile information use the views
   fusion module.


To build a more advanced user profile, which consists of several node types:

 * Create your content types you want to use for your profiles, e.g. with the CCK.

 * Mark a content type as user profile at 'admin/settings/content-types' and set
   appropriate relations between the content types at 'admin/settings/nodefamily'.

   To achieve greatest flexibility it is suggested to mark only one content type
   as user profile. Set nodefamily relations between this type and the other content
   types. Use the node view of this type to build the display of your user profile
   using the nodefamily relations (instructions are provided in the nodefamily readme).

 * Theme your usernodes
 
   If you have only one nodeprofile, just load the node view of your parent content
   type of your nodeprofile, e.g. use this in your theme:
   <?php $children = nodefamily_relation_load($nid);
         print node_view($children[0]);
   ?>
   
   So you can easily change this later, if you decide to create another nodeprofile for
   your users.
   
   If there might be more than one nodeprofile per user you may use the usernode to provide
   links to your nodeprofiles as it is per default.

 * Use the pageroute module to provide an userfriendly way for filling out the nodeprofile.
   Note: Use the node management page type for adding/editing a nodeprofile content type.

 * For building user listings and user searches use the views module together with the
   usernode module. If the view should also contain profile information use the views
   fusion module.
   Create a view for each content type of your nodeprofile, which contains information you
   need. Fuse the parent nodeprofile content type with this views using the views fusion
   module and fuse the usernode content type with this type.
   (You have to fuse the content types the same way as there are nodefamily relations.)

