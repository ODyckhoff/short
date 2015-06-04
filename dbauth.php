<?php
require('dbh.php');
$db = getDB();

function register_user( $username, $password ) {
    global $db;

    $query = $db->prepare('SELECT COUNT(*) AS count FROM users WHERE name = ?;');
    $query->execute(array($username));

    $result = $query->fetch(PDO::FETCH_ASSOC);
    if($result['count'] == 0) {
        // Proceed with registration.
        $query = $db->prepare('INSERT INTO users VALUES( DEFAULT, ?, SHA1(?), NOW() );');
        $query->execute(array($username, $password));

        $_SESSION['login'] = true;
        $_SESSION['userid'] = $db->lastInsertId();
        $_SESSION['name'] = $username;

        return 1;
    }
    return 0;
}

function login_user( $username, $password ) {
    global $db;

    $query = $db->prepare('SELECT * FROM users WHERE name = ? AND password = SHA1(?)');
    $query->execute(array($username, $password));

    $results = $query->fetch(PDO::FETCH_ASSOC);
    if(count($results) == 0) {
        return 0;
    }
    else {

        $_SESSION['login'] = true;
        $_SESSION['userid'] = $results['user_id'];
        $_SESSION['name'] = $results['name'];
        
        return 1;
    }
}
