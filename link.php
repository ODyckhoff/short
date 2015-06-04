<?php

    $link = $_GET['l'];
    $dsn = 'mysql:dbname=short;host=127.0.0.1';
    $db = new PDO($dsn, 'root', '2R41RviX');

    $query = $db->prepare('SELECT link_id,big_url,visit_count FROM links WHERE small_url = ?;');
    $query->execute(array($link));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if($result) {
        $query = $db->prepare('UPDATE links SET visit_count = ? WHERE link_id = ?');
        $query->execute(array(++$result['visit_count'], $result['link_id']));
        $query = $db->prepare('INSERT INTO log VALUES( DEFAULT, ?, NOW() );');
        $query->execute(array($result['link_id']));

        header('Location:' . $result['big_url'] );
    }
    else {
        echo '<div class="error">No such link.</div>';
    }

?>
