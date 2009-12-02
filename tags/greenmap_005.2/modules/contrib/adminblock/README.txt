Drupal adminblock module:
------------------------
Author - Fredrik Jonsson fredrik at combonet dot se
Requires - Drupal 4.7
License - GPL (see LICENSE)


Overview:
--------
The adminblock module enables admins to display a block with 
the comments approval queue, the node moderation queue and 
the trackback queue. Each item get there own edit link and delete link 
for quick administration.

The block will only show for users with administer 
comments/nodes/trackback" privilages.

If there are no comments to approve, no nodes to moderate 
and no trackbacks to approve the block will not show.

The module only show unpublished nodes in node moderation queue.


Installation:
------------
Installation is as simple as copying the module into your 'modules'
directory, then enabling the module at 'administer >> modules'. When
that is done the admin block can be activated in 'administer >> blocks'
like any other block.


Configuration:
-------------
There are no settings for this module, normally none is neaded.

Power users can edit the module directly. Here are some things that
may be of intrest.

To change the number of items that show up in the block go to line 42
and set

  $nlimit = 10;

to a lower or higher value.

To show both published and unpublished nodes in the moderation queue go to
line 62 and change

  WHERE n.status = 0 AND n.moderate = 1

to

  WHERE n.moderate = 1


Last updated:
------------
$Id: README.txt,v 1.5.2.2 2006/08/24 07:33:24 frjo Exp $