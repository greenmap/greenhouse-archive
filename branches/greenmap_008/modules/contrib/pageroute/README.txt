$Id: README.txt,v 1.11 2006/10/29 18:32:03 fago Exp $

Pageroute Module
------------------------
by Wolfgang Ziegler, nuppla@zites.net


Short module overview:
---------------------
pageroute.module - Allows the creation of pageroutes.
pageroute_ui.module - Adminstration pages for pageroute
pageroute_workflow.module - Creates a workflow for each pageroute and tracks users

Description
-----------
The module can be used to provide an userfriendly wizard for creating and
editing several nodes.

It allows you define a route through various pages. Currently a page can be a 
normal node display, a node adding form, a node editing form or a node management
 page.
The node management page allows one to add/edit/delete nodes from a configurable
content type. It shows a themeable list of already created nodes and allows
editing and deleting if the user has access.

Further this module will provide new URLs for all pages and 
optionally create customizeable back/forward buttons at the bottom of a page, 
so that users are lead through the route.

So you can use the module to create a route which leads users through multiple
node creation forms. 

For example this allows you to build a user profile which consists of multiple
content types. Then users can easily create and edit their nodes through the 
same pageroute. (Have a look at the nodeprofile project if you are interested
in building user profiles with nodes).


Installation 
------------
 * Copy the whole pageroute directory to your modules directory and 
   activate at least the modules pageroute and pageroute_ui.


How to use it
-------------
To build a pageroute go to 'admin/pageroute'.
First add your new route and then define pages for this route. A new menu item
will be provided for the new route.

Once you have finished defining your route you may deactivate pageroute_ui.module
again, as it provides only the adminstration pages.

Hints
-----
The node management page of a content type obeys the maximum nodefamily population,
if the nodefamily module is installed and activated.
So you may use the nodefamily module to restrict the number of addable nodes for a
content type.

You can go through the pageroute as another user by appending the users id to each
URL of the route. E.g. if your pageroute has the path 'example' use 'example/1' to
go through the route as user with the uid 1. Of course you need appropriate 
permissions, if you want to be able to add/edit/delete nodes for other users.

You can build a pageroute to add/edit nodes, where another page is used as a kind 
of preview. For this you need the "node edit form" and "node display" page types:
The node edit form pageroute page type uses the second argument as node id. The 
configured node id of the node display page type has to be 0, then it will also use 
the second argument. So this page will display the node, which the edit form has 
edited.
If the second argument is missing, the node edit form page type will present a node
add form and append the new node id to the next generated path - so the preview will
still work.

The nodefamily module provides two further page types. Read the nodefamily README
for more information.



pageroute_workflow.module
-------------------------
Dependencies: Workflow, Usernode (from the nodeprofile project), Pageroute Module

Note: This is an experimental module, don't use it in production environments

How to use:
Edit a route and activate the creation of a workflow for it. The module will create
a new workflow and a state for each page.
Don't manually edit this workflow! The module will automatically track how far a user
has gone through a pageroute using this workflow by setting the appropriate state to 
the usernode.

You can set the pageroute workflow to be used for the usernode content type to get the
workflow history. However the workflow module is currently only capable of one workflow
per content type.

So for now: DO NOT ACTIVATE THIS MODULE FOR MORE THAN ONE PAGEROUTE.



Developer Information
---------------------
Your module can offer new page types like you can do it with node types.  Implement 
hook_pageroute_info() to define your types. It works like hook_node_info().

Then implement the function PAGETYPEBASE_load_page($route, $page), like it's done
with pageroute_load_page() to show your page. Here an example for outputing something:

  //add tabs and buttons
  pageroute_get_tabs($page, $form);
  pageroute_get_buttons($page, $form);
  $form['buttons']['#weight'] = 10;
  $form['output'] = array('#value' => "your output");
  $form['op'] = array('#type' => 'value');
  return drupal_get_form('pageroute_'. $page->name, $form, 'pageroute_page_form');
    
If you make your own form be sure to include these:
    $form['op'] = array('#type' => 'value');
    $form['#validate']['pageroute_page_form_validate'] = array();
    $form['#submit']['pageroute_page_form_submit'] = array();
and also the tabs und buttons, if desired.

To display your own forms in the pageroute_ui use hook_form_alter.