<?php
include('header.php');
$link = $_GET['l'];

echo "<h2>Info about $link</h2>";

echo'<strong>Short Link: </strong><a href="http://s.scon.es/l/' . $link . '">http://s.scon.es/l/' . $link . '</a><br />';

require('dbh.php');
$db = getDB();
$query = $db->prepare('SELECT * FROM links l LEFT JOIN userlink ul ON l.link_id = ul.link_id LEFT JOIN users u ON u.user_id = ul.user_id WHERE l.small_url = ? ORDER BY l.visit_count DESC LIMIT 10;');
$query->execute(array($link));
$result = $query->fetch(PDO::FETCH_ASSOC);

echo '<strong>Full Link: </strong><a href="http://s.scon.es/l/' . $link . '">' . $result['big_url'] . '</a><br />';

$headers = get_headers($result['big_url']);
$doc = new DOMDocument();
$str = file_get_contents($result['big_url']);
$status = $doc->loadHTML($str);

if($status /*&& strpos($headers[0], '200 OK') !== false*/) {
    $list = $doc->getElementsByTagName("title");
    if($list->length > 0) {
        $title = $list->item(0)->textContent;
        echo '<strong>Page Title: </strong>' . $title . '<br />';
    }
}
else {
    echo '<div class="error">Error getting page info. It may be down, or the HTML is broken.</div>';
}
echo '<strong>Headers: </strong>';

echo '<ul style="line-height:0.2em;"><li><pre>' . join('</pre></li><li><pre>', $headers) . '</pre></li></ul>';
