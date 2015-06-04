<?php
    include('header.php');
    $db = new PDO('mysql:dbname=short;host=127.0.0.1', 'root', '2R41RviX');

    if(isset($_SESSION['login']) && $_GET['u'] == $_SESSION['name']) {
        echo '<h2>Welcome, ' . $_SESSION['name'] . '.</h2>';
        include('form.php');
    }
    else {
        echo '<h2>Profile for ' . $_GET['u'] .'</h2>';
        $query = $db->prepare('SELECT * FROM users WHERE name = ?;');
        $query->execute(array($_GET['u']));

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(!$result) {
            echo '<div class="error">User ID does not exist.</div>';
        }
    }

    echo '<h3>' . ( $_GET['u'] == $_SESSION['name'] ? 'Your' : $_GET['u'] . '\'s' ) . ' recent links.</h3>';
    $query = $db->prepare('SELECT * FROM userlink ul INNER JOIN links l ON l.link_id = ul.link_id INNER JOIN users u ON u.user_id = ul.user_id WHERE u.name = ? ORDER BY l.date_added DESC LIMIT 10;');
    $query->execute(array($_GET['u']));
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if($results) {
        echo '<table><thead><th></th><th align="left">Link</th><th align="center">Visit Count</th><th></th></thead><tbody>';
        $count = 1;
        foreach($results as $result) {
            echo '<tr>';
            echo '<td><strong>' . $count . ') </strong></td>';
            echo '<td><a href="http://s.scon.es/l/' . $result['small_url'] . '">http://s.scon.es/l/' . $result['small_url'] . '</a></td>';
            echo '<td align="center">' . $result['visit_count'] . '</td>';
      
            date_default_timezone_set('Europe/London');
            $date1 = new DateTime($result['date_added']);
            $date2 = new DateTime();
            $interval = $date1->diff($date2);
            $timestr = "";
            if ($interval->y) { $timestr .= $interval->format("%y years "); }
            if ($interval->m) { $timestr .= $interval->format("%m months "); }
            if ($interval->d) { $timestr .= $interval->format("%d days "); }
            if ($interval->h) { $timestr .= $interval->format("%h hours "); }
            if ($interval->i) { $timestr .= $interval->format("%i minutes "); }
            if ($interval->s) { $timestr .= $interval->format("%s seconds "); }

            echo '<td><em>(Added ' . $timestr . ' ago.)</em></td>';
            echo '</tr>';
            $count++;
        }
        echo '</tbody></table>';
    }
    else {
        echo '<em>No links posted yet.</em>';
    }

    echo '<h3>' . ( $_GET['u'] == $_SESSION['name'] ? 'Your' : $_GET['u'] . '\'s' ) . ' top links.</h3>';
    $query = $db->prepare('SELECT * FROM userlink ul INNER JOIN links l ON l.link_id = ul.link_id INNER JOIN users u ON u.user_id = ul.user_id WHERE u.name = ? ORDER BY l.visit_count DESC LIMIT 10;');
    $query->execute(array($_GET['u']));
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    if($results) {
        echo '<table><thead><th></th><th align="left">Link</th><th align="center">Visit Count</th></thead><tbody>';
        $count = 1;
        foreach($results as $result) {
            echo '<tr>';
            echo '<td><strong>' . $count . ') </strong></td>';
            echo '<td><a href="http://s.scon.es/l/' . $result['small_url'] . '">http://s.scon.es/l/' . $result['small_url'] . '</a></td>';
            echo '<td align="center">' . $result['visit_count'] . '</td>';
            echo '</tr>';
            $count++;
        }

        echo '</tbody></table>';
    }
    else {
        echo '<em>No links posted yet.</em>';
    }
