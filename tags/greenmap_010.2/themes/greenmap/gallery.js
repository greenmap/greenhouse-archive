// JavaScript Document - functions for gallery
// Coded by Thomas Turnbull for Green Map System www.greenmap.org
// April 2007

function LoadGallery(imageFile,captionText)
{
  document.getElementById('imageHolder').src = imageFile;
  document.getElementById('imageHolder').alt = captionText;
  document.getElementById('captionHolder').innerHTML=captionText;
}

function EditPhoto(imagePath)
{
  window.location = imagePath;
}