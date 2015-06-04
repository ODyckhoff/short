<style type="text/css">
iframe {
  -moz-transform: scale(0.4, 0.4); 
  -webkit-transform: scale(0.4,0.4); 
  -o-transform: scale(0.4, 0.4);
  -ms-transform: scale(0.4, 0.4);
  transform: scale(0.4, 0.4); 
  -moz-transform-origin: top left;
  -webkit-transform-origin: top left;
  -o-transform-origin: top left;
  -ms-transform-origin: top left;
  transform-origin: top left;
}
</style>
<h1><a href="/" style="text-decoration:none; color:#000" >URL Shortener</a></h1>
<?php

if(session_id() == '') { session_start(); }
echo '<p>';
if(! isset($_SESSION['login'])) {
    echo '<a href="/login">Register/Login</a>';
}
else {
    echo '<a href="/logout">Logout</a>, ' . $_SESSION['name'] . '?';
}
echo '</p>';
