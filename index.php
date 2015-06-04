<?php
include('header.php');

include('form.php');

echo '<h3>Top links</h3>';

$db = new PDO('mysql:dbname=short;host=127.0.0.1', 'root', '2R41RviX');
$query = $db->prepare('SELECT * FROM links l LEFT JOIN userlink ul ON l.link_id = ul.link_id LEFT JOIN users u ON u.user_id = ul.user_id ORDER BY l.visit_count DESC LIMIT 10;');

$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

if(!$results) {
    echo '<em>No Top links to show.</em>';
}
else {
    echo '<table><thead><th></th><th align="left">Link</th><th>Visit Count</th><th>User</th></thead><tbody>';
    $count = 1;

    foreach($results as $result) {
        echo '<tr><td><strong>' . $count . ') </strong></td>';
        echo '<td><a href="http://s.scon.es/l/' . $result['small_url'] . '">http://s.scon.es/l/' . $result['small_url'] . '</td>';
        echo '<td align="center">' . $result['visit_count'] . '</td>';
        echo '<td>' . ( $result['name'] ? $result['name'] : '<em>Anonymous</em>' ) . '</td></tr>';

        $count++;
    }
    echo '</tbody></table>';
}
