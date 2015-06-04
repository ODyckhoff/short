<?php
    session_start();

    if(! isset($_SESSION['login'])) {
        return;
    }

    unset($_SESSION['login']);
    unset($_SESSION['name']);
    unset($_SESSION['userid']);

    echo 'Logged out successfully!';
