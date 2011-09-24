Imagecache is a dynamic image manipulation and cache tool.
It allows you to create a namespace that corresponds to a set
of image manipulation actions. It generates a derivative image the
first time it is requested from a namespace until the namespace or
the entire imagecache is flushed.

with drupal 4.7.1 and later drupal creates a .htaccess
in the files directory. It has two stanza's which disagree with imagecache
and file previews in general. They are.

1) Options None
2) RewriteEngine off.

Change Options None to Options FollowSymlinks
and comment out Rewrite Engine off with a # at the 
beginning of the line.


Usage:
goto  admin -> imagecache 
create a preeset,
add some actions to your preset,

add a 
print theme('imagecache', $preset_namespace, $image['filepath'])
to you themes and you should be set.


Theory of Operation...

Imagecache takes advantage of the following stanza in the apache 
rewrite directives for drupal.

 RewriteCond %{REQUEST_FILENAME} !-f

This directive tells apache not to rewrite the url to index.php?q=$url
if a file exists at the requested url.

givens:
  - imagecache preset named 'cacheThumb'.
  - image file located at 'files/myimage.png'.
  - site url of 'http://www.example.com/'

The constructed url to get a 'cacheThumb' version of 'files/myimage.png' would be:
  'http://www.example.com/files/imagecache/cacheThumb/files/myimage.png'

What imagecache does...
  -imagecache implements a menu callback at files/imagecache
  -drupal passes the remainder of the URL into the imagecache_cache function.
   (files/imagecache/cacheThumb/files/myimage.png - files/imagecache = cacheThumb/files/myimage.png)
  -imagecache_cache takes the first part of the remaining path as the name of the preset.
   ( [cacheThumb] files/myimage.png ) 
  -imagecache will create a version of files/myimage.png manipulated by the cacheThumb actions at
   'files/imagecache/cacheThumb/files/myimage.png'
  -imagecache then delivers the final image to the end user.
  
What apache does when it receives a request for
  'http://www.example.com/files/imagecache/cacheThumb/files/myimage.png'
  
   -the RewriteCond %{REQUEST_FILENAME} !-f tells apache to check if
              'files/imagecache/cacheThumb/files/myimage.png' exists.
      if the file exists apache delivers it to the end users.
      if the file does not exist it passes the request to drupal 
        which passes the request to imagecache
