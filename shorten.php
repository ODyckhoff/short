<?php
session_start();

$userid = 0;

if( isset( $_SESSION['login'] ) ) {
    $userid = $_SESSION['userid'];
}

if(!isset($_POST['url'])) {
    return null;
}

$dsn = 'mysql:dbname=short;host=127.0.0.1';
$db = new PDO($dsn, 'root', '2R41RviX');

$count = 0;
$result = array();

if($userid) {
    $query = $db->prepare('SELECT * FROM userlink ul INNER JOIN links l ON l.link_id = ul.link_id INNER JOIN users u ON u.user_id = ul.user_id WHERE l.big_url = ? AND u.user_id = ?;');
    $query->execute( array( $_POST['url'], $userid ) );

    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
}
else {
    $query = $db->prepare('SELECT * FROM links WHERE big_url = ?;');
    $query->execute(array($_POST['url']));

    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $count = count($result);
}

if( $count == 1 ) {
    // give back the one already in the DB.
    header("Location:http://s.scon.es/i/" . $result[0]['small_url']);
}
else {
    // shorten it.
    $query = $db->prepare('SELECT COUNT(*) AS count FROM links WHERE small_url = ?;');

    do {
        if(isset($_POST['custom']) && isset($_SESSION['login'])) {
            $query->execute(array($_POST['custom']));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if($result['count'] == 0) {
                $short = $_POST['custom'];
                break;
            }
        }
        $string = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for($i = 0; $i < 6; $i++)
            $string.=substr($chars,rand(0,strlen($chars)),1);
        $short = $string;

        $query->execute(array($short));

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
    } while( $count > 0 );

    $query = $db->prepare('INSERT INTO links VALUES( DEFAULT, ?, ?, 0, NOW());');
    $query->execute(array($short, $_POST['url']));
    $linkid = $db->lastInsertId();

    if($userid) {
        $query = $db->prepare('INSERT INTO userlink VALUES( DEFAULT, ?, ? );');
        $query->execute(array($userid, $linkid));
    }
    header('Location:http://s.scon.es/i/' . $short);
}


/* NO. STOP PROGRAMMING. YOU NEED TO PLAN THIS. */
