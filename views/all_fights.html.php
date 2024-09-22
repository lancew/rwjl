<?php


//echo $html;
// create html variable with header
$html = '<h2>All fights</h2>';

// connect to the DB and run query
$db = 'data/rwjl.db';
$dbo = new SQLite3("$db");
$query = "SELECT * FROM fights
              ORDER BY id ASC;";
$result = $dbo->query($query) or die("A MySQL error has occurred.<br />Your Query: " . $query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());


//create the HTML table
$html .= '<table>';
$html .= '<tr><th>Fight ID</th><th>Event</th><th>Blue</th><th>Blue Score</th><th>Blue Rank Change</th><th>White Player</th><th>White Score</th><th>White Rank Change</th></tr>';


//loop through the query rows and add to the html table
while ($row = $result->fetchArray()) {
    // fetch current row
    //$row = $result->current();
    //print_r($row);
    $html .= '<tr>';
    // Fight ID
    $html .= '<td>';
    $html .= $row['id'];
    $html .= '</td>';
    // Event
    $html .= '<td>';
    $html .= $row['event'];
    $html .= '</td>';
    // Blue players name
    $html .= '<td>';
    $html .= '<a href="/player/'.$row['p1_name'].'">';
    $html .= $row['p1_name'];
    $html .= '</a>';
    $html .= '</td>';
    // Blue player score
    $html .= '<td>';
    $html .= $row['p1_score'];
    $html .= '</td>';

    // Blue Rank Change
    $html .= '<td>';
    $html .= $row['p1_rank_pre'].' -> '. $row['p1_rank_post'];
    $html .= '</td>';
    // WHite players name
    $html .= '<td>';
    $html .= '<a href="/player/'.$row['p2_name'].'">';
    $html .= $row['p2_name'];
    $html .= '</a>';
    $html .= '</td>';
    // White player score
    $html .= '<td>';
    $html .= $row['p2_score'];
    $html .= '</td>';
    // WHite player rank change
    $html .= '<td>';
    $html .= $row['p2_rank_pre'].' -> '. $row['p2_rank_post'];
    $html .= '</td>';


    // end of the row
    $html .= '</tr>';

    echo $html;
    $html = '';

    //$result->next();
}
$html .= '</table>';
echo $html;
