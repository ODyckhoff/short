<form action="/shorten.php" method="POST">
URL: <input name="url" type="text" /><br />

<?php
    if(isset($_SESSION['login'])) {
        echo 'Custom URL: http://s.scon.es/l/<input name="custom" type="text" /><br />';
    }
?>

<input type="submit" />
</form>

