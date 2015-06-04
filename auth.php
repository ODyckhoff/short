<?php
session_start();

require_once('dbauth.php');

if(isset($_POST['id'])) {
    // Registration or Login has been sumbitted.

    if(isset($_POST['checkbox'])) {
        // Register user.
        if(preg_match("/anon(ymous)?/i", $_POST['id'])) {
            echo '<div class="error">That nickname is not allowed, as it identifies non-registered users.</div>';
            return; // Not allowed that nickname for confusion reasons.
        }

        // There's no nice way to break out of nested if statements in PHP...
        switch(true) {
            case true:
                // so I cheat and break out of switch cases instead.
                if(!isset($_POST['confirm'])) {
                    echo '<div class="error">Password Confirmation field is empty.</div>';
                    break;
                }
                if($_POST['pass'] != $_POST['confirm']) {
                    echo '<div class="error">Passwords do not match.</div>';
                    break;
                }

                if( ! register_user( $_POST['id'], $_POST['pass'] ) ) {
                    echo '<div class="error">Registration failed.</div>';
                }
        }
    }
    else {
        // Login.

        if(!isset($_POST['pass'])) {
            echo '<div class="error">Empty Password field.</div>';
        }
        else {
            if( ! login_user( $_POST['id'], $_POST['pass'] ) ) {
                echo '<div class="error">Login failed.</div>';
            }
        }
    }
}

if(isset($_SESSION['userid'])) {
    header('Location:http://s.scon.es/u/' . $_SESSION['name']);
}

?>

<h2>Login/Register</h2>
<form method="POST" action="auth.php">
    Username: <input type="text" name="id" /><br />
    Password: <input type="password" name="pass" /><br />

    <br />
        Register? <input id="checkbox" type="checkbox" name="checkbox"
                    onClick="document.getElementById('confirm').disabled=!this.checked;"
        /><br />
        Confirm: <input id="confirm" type="password" name="confirm" disabled />
    <br />
    <p>
        <input type="submit" />
    </p>
</form>
<script type="text/javascript">
</script>

