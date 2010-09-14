$Id: README.txt,v 1.3.2.1 2006/12/03 20:29:51 fago Exp $

Views Fusion Module
------------------------
by Wolfgang Ziegler, nuppla@zites.net


Description
-----------
Views Fusion allows one to fuse multiple views into one. So you can
build fusioned views that display information that is stored in multiple
nodes - useful for tabular views. It uses node relations for joining the
appropriate nodes together.

So currently the views_fusion module needs the nodefamily module 
(http://drupal.org/project/nodefamily) for obtaining the node relation 
information. However in future other node relation modules could also 
provide their data for views fusion as it is written generic.


Installation 
------------
 * Install the latest views module, you need at least version 1.2
 * Copy the module to your modules directory and activate it.

Note: You also need a node relation module, e.g. nodefamily.


How to use it
-------------
First you have to define multiple views, one for each type of nodes. Then
the views fusion module is used to fuse these views to a big one which 
contains all the information.
To do this go to 'admin/views/fusion' and define which views you want to 
fuse and which information you want to use for fusing the views, e.g. 
use a nodefamily relation.

Then the information of the fused view is displayed when the other view
is displayed.


Notes
-----
 * You have the fuse the views in the correct order.
   If you use it in conjunction with nodefamily, you have to fuse your views
   in the same order as there is a nodefamily relation.
 * Currently it's not possible to alter the order of single fields of a tabular 
   view over the whole view. The first field of a fused view will always be displayed
   behind the last field of the primary view.
   This also applies to any sort critera you might have set for the views. So the sort
   criteria of the primary view will have precedence over the sort criteria from the
   fused view.
   However the order of the fields can still be customized by theming the view.

