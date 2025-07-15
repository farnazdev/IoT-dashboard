<?php
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
  </head>
  <body>
    <input type="file" accept=".jpg, .png, .webp">
    <script>
      // from an input element
var filesToUpload = input.files;
var file = filesToUpload[0];

var img = document.createElement("img");
var reader = new FileReader();  
reader.onload = function(e) {img.src = e.target.result}
reader.readAsDataURL(file);

var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0);

var MAX_WIDTH = 800;
var MAX_HEIGHT = 600;
var width = img.width;
var height = img.height;

if (width > height) {
  if (width > MAX_WIDTH) {
    height *= MAX_WIDTH / width;
    width = MAX_WIDTH;
  }
} else {
  if (height > MAX_HEIGHT) {
    width *= MAX_HEIGHT / height;
    height = MAX_HEIGHT;
  }
}
canvas.width = width;
canvas.height = height;
var ctx = canvas.getContext("2d");
ctx.drawImage(img, 0, 0, width, height);

var dataurl = canvas.toDataURL("image/png");
  </script>
  </body>
</html>