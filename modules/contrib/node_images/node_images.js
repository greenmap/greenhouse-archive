// $Id: node_images.js,v 1.1.2.2 2007/01/13 14:48:55 stefano73 Exp $

if(isJsEnabled() && typeof gallery != 'undefined') {
  addLoadEvent(galleryInit);
}

function galleryInit() {
  galleryPreload(0);
  var ps = document.getElementsByName('gallery-previous');
  for (i = 0; p = ps[i]; i++) {
    p.onclick = function() { galleryPrevious(i); return false; };
  }
  var ns = document.getElementsByName('gallery-next');
  for (i = 0; n = ns[i]; i++) {
    n.onclick = function() { galleryNext(i); return false; };
  }
  var thumbs = document.getElementsByName('gallery-thumb');
  for (i = 0; t = thumbs[i]; i++) {
	t.onclick = function() { galleryUpdate(null, this); return false; };
  }
}

function galleryPreload(i) {
  if (!gallery[++i]) return;
  var n = gallery[i];
  if (n) {
    n.image = new Image();
    n.image.src = n.src;
    n.image.onload = function() { galleryPreload(i); };
  }
}

function galleryPrevious(i) {
  if(!(gallery[--gallery[i].current])) gallery[i].current = gallery[i].total;
  galleryUpdate(i);
}

function galleryNext(i) {
  if(!(gallery[++gallery[i].current])) gallery[i].current = 1;
  galleryUpdate(i);
}

function galleryUpdate(i, thumb) {
  var o = gallery[i];
  
  if (thumb) {
	  var id = thumb.id.substr(6, thumb.id.length-6);
      var o = gallery[id];
	  o.current = id;
  }

  var img = gallery[o.current];
  var obj = document.getElementsByName('gallery-image')[0];
  if (obj && img.src) obj.src = img.src;
  var obj = document.getElementsByName('gallery-description')[0];
  if (obj && img.description) obj.innerHTML = img.description;
  var obj = $('gallery-caption');
  if (obj && img.caption) obj.innerHTML = img.caption;
}