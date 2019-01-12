<?php
/**
 * Main controller for RWJL
 *
 * By Lance Wicks, 2010,2011
 *
 * PHP version 5.3.1
 *
 * @category RWJL
 * @package  RWJL
 * @author   Lance Wicks <lw@judocoach.com>
 * @license  All rights reserved.
 * @link     http://www.rwjl.net
 */

/**
 * Home_page function.
 *
 * This function simply returns the home page template.
 *
 * @access public
 * @return void
 */
function Home_page()
{
    return html('home_page.html.php');
}

/**
 * Get_file function.
 *
 * This function gets a file for processing.
 *
 * @access public
 * @return void
 */
function Get_file($event_region = null,
    $event_type = null,
    $event_name = null,
    $event_category = null 
) {

    // Get the parameters from the URL
    $event_region = params('event_region');
    $event_type = params('event_type');
    $event_name = params('event_name');
    $event_category = params('event_category');

    // These are the components of the URL of the page we
    // are going to download.
    $prefix = 'http://217.79.182.227/www.judo-world.net/'; 
    $suffix1 = '/tta.php?tta_mode=&aktion=fights&klasse=';
    $suffix2 = '&sprache=english';

    // If the event is the 2010 isla margarita the
    // base URL is different so change it.
    
    if ($event_name == '2010_isla_margarita') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_sofia') {
        $prefix = 'http://www.judo-world.net/';
    }    
    if ($event_name == '2011_duesseldorf') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_prague') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_istanbul') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_moscow') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == 'ec_u17_2011_malta') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_miami') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_ulaanbaatar') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_tashkent') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_almaty') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_rome') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_liverpool') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_minsk') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_baku') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2011_qingdao') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_almaty') {
        $prefix = 'http://www.judo-world.net/';
    }    
    if ($event_name == '2012_almaty') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_sofia') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_tblisi') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_paris') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_oberwart') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_duesseldorf') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_warsaw') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_agadir') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_montreal') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_chelyabinsk') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_tashkent') {
        $prefix = 'http://www.judo-world.net/';
    }
    if ($event_name == '2012_cairns') {
        $prefix = 'http://www.judo-world.net/';
    }
    



    // Contruct the URL from the params given and the components we know already.
    $url = $prefix.$event_region.'/'.$event_type.'/'.$event_name.$suffix1.$event_category.$suffix2;
    
    // Get the page from the internet
    $page = file_get_contents($url);


    //this section pulls the overview page where the date of the event is shown.
    $overview_suffix = '/tta.php?tta_mode=&aktion=live_overview&sprache=english';
    $overview_url = $prefix.$event_region.'/'.$event_type.'/'.$event_name.$overview_suffix;
    $page2 = file_get_contents($overview_url);


    if ($page === false) {
        // If the download fails report it as such
        set('result', "$url FAILED");
        return html('get_file.html.php');
    } else {
        // If the download succeeds save the page to temp.txt and then report success
        $fh = fopen('data/temp.txt', 'w') or die("Can't open file data/temp.txt");
        fwrite($fh, $page);
        fclose($fh);
        
        $fh = fopen('data/temp2.txt', 'w') or die("Can't open file data/temp2.txt");
        fwrite($fh, $page2);
        fclose($fh);
        
        set('result', "$url SUCCESS.");
        return html('get_file.html.php');
    }
}




/**
 * Import_html function.
 *
 * This function imports the results from the temp.txt file
 *
 * @access public
 * @return void
 */
function Import_html()
{
    // Create a doc object which we load with the DOM from the temp file
    $doc = new DOMDocument();
    $doc->loadHTMLFile("data/temp.txt");

    // create an array of all the tables in the document
    
    
    
    $tables = $doc->getElementsByTagName('table');
    

    // create a array of rows in all the tables
    $header = $tables->item(0)->nodeValue;
    
    $header = split(']', $header);
    //$date = explode(' ', $header[0]);
    //$date = $date[0];
    
    $date = Get_event_date();
    
    $event = str_ireplace(' Feedback', '', $header[1]);
    
    $event_data = array($date,$event);
    //print_r($event_data);
    
    //echo '<br />';
    
    $rows = $tables->item(2)->getElementsByTagName('tr');
    $rows = $rows->item(0)->getElementsByTagName('tr');
    

    foreach ($rows as $row) {
        
        $cols = $row->getElementsByTagName('td');

        //Strip all the HTML tags out of the data
        $raw_data = strip_tags($cols->item(0)->nodeValue);

        //print_r($raw_data);

        if (strpos($raw_data, 'kg]:')) {
            Process_row($raw_data, $event_data);
        }
    }


    unlink('data/temp.txt');
    

}






/**
 * Process_row function.
 *
 * This function processes each row of raw data fed to it by import_html and updates the database with results of each fight.
 *
 * @param mixed $raw_data
 * @param mixed $event_data
 * 
 * @access public
 * @return void
 */
function Process_row($raw_data, $event_data)
{

    
    /***
 * Get each column by tag name 
***/

    //$cols = $row->getElementsByTagName('td');
    //$raw_data = $cols->item(0)->nodeValue;
    $event_date = $event_data[0];
    $event_name = $event_data[1];
    
    
    $data1 = explode("[", $raw_data);

    $data2 = explode("kg]: ", $data1[1]);
    $data3 = explode("IWYKPIWYKP", $data2[1]);

    $category = $data2[0];
    //$category = str_replace("-", "U", $category);
    //$category = str_replace("p", "P", $category);
    $category = str_replace(" ", "", $category);

    //determine what round we are in for the Add_fight function later
    $round='';

    if (strpos($raw_data, "Preliminary round")) {
        $round = "Preliminary round";
    }
    if (strpos($raw_data, "Semifinal")) {
        $round = "Semifinal";
    }
    if (strpos($raw_data, "Final")) { 
        $round = "Final";
    }
    if (strpos($raw_data, "Fight for 3rd place")) { 
        $round = "Fight for 3rd place";
    }
    if (strpos($raw_data, "Repechage")) { 
        $round = "Repechage";
    }

    // Now determine the name from the row received
    $player1 = str_replace("Preliminary round", "", $data3[0]);
    $player1 = str_replace("Semifinal", "", $player1);
    $player1 = str_replace("Final", "", $player1);
    $player1 = str_replace("Fight for 3rd place", "", $player1);
    $player1 = str_replace("Repechage", "", $player1);



    $data_temp = explode(")", $player1);

    $score = $data_temp[1];
    $player1 = $data_temp[0];

    $data_temp = explode("(", $player1);

    $p1_country = $data_temp[1];
    $p1_country = str_replace("'", "", $p1_country);
    $p1_country = str_replace(",", "", $p1_country);
    $p1_country = str_replace("Korea South", "South Korea", $p1_country);
    $p1_country = str_replace("Democratic Peoples Republic of Korea", "North Korea", $p1_country);
    $player1 = $data_temp[0];


    $data_temp = explode("(", $data3[1]);



    $p2_country = $data_temp[1];
    $data_temp2 = explode(")", $p2_country);



    $p2_country = $data_temp2['0'];
    $p2_country = str_replace("'", "", $p2_country);
    $p2_country = str_replace(",", "", $p2_country);
    $p2_country = str_replace("Korea South", "South Korea", $p2_country);
    $p2_country = str_replace("Democratic Peoples Republic of Korea", "North Korea", $p2_country);



    $player2 = substr($data_temp[0], 4);

    $player1 = Fix_playernames($player1);
    $player2 = Fix_playernames($player2);


    $p1_score = substr($score, 0, 5);
    $p1_score = substr($p1_score, 0, 4);
    $p2_score = substr($score, -5);
    $p2_score = substr($p2_score, 0, 4);

    echo $event_date.' ';
    echo $event_name.' ';
    echo $category;
    echo "<br />";
    echo $player1;

    if (!Find_name($player1)) {
        echo ' *';
        Db_create($player1);
        Db_update($player1, 1500, $category, $p1_country, 0, 0);
    }
    echo "<br />";
    echo $p1_country;
    echo "<br />";

    echo $player2;
    if (!Find_name($player2)) {
        echo ' *';
        Db_create($player2);
        Db_update($player2, 1500, $category, $p2_country, 0, 0);
    }
    echo "<br />";
    echo $p2_country;
    echo "<br />";



    echo "<br />";

    echo $p1_score." - ".$p2_score;

    echo "<br />";

    $p1_wins = Get_data($player1, 'wins');
    $p2_wins = Get_data($player2, 'wins');

    $p1_losses = Get_data($player1, 'losses');
    $p2_losses = Get_data($player2, 'losses');




    if ($p1_score === $p2_score) {
        //echo '<h1>';
        echo '<h2>DRAWN SCORE</h2>';

        //echo $raw_data;
        //echo '</h1>';
        $answer = Process_draw($player1, $player2);
        //echo "<h1>$answer</h1>";
        if ($answer === 1) {
            $p1_score = 2;
            $p2_score = 1;
            //echo ' 1 ';
        } else {
            $p1_score = 1;
            $p2_score = 2;
            //echo ' 2 ';
        }
    }



    if ($p1_score > $p2_score) {
        $p1_wins++;
        $p2_losses++;
        echo "$player1 wins ($p1_wins/$p1_losses)";
    }
    if ($p1_score < $p2_score) {
        $p2_wins++;
        $p1_losses++;
        echo "$player2 wins ($p2_wins/$p2_losses)";
    }


    echo "<br />";

    if ($player1 != '-' && $player2 != '-') {
        $elo_calculator = elo_calculator;
        $p1_rank = Get_rank($player1);
        $p2_rank = Get_rank($player2);




        $results=$elo_calculator->rating($p1_score, $p2_score, $p1_rank, $p2_rank, 40);


        Db_update($player1, $results['R3'], $category, $p1_country, $p1_wins, $p1_losses);
        Db_update($player2, $results['R4'], $category, $p2_country, $p2_wins, $p2_losses);

        //echo "$player1, $player2, $p1_score, $p2_score, $p1_rank, ".$results['R3'].", $p2_rank, ".$results['R4'];
        // (p1_name, p2_name, p1_score, p2_score, p1_rank_pre, p1_rank_post, p2_rank_pre, p2_rank_post, date, event, category, round)
        
        
        Add_fight($player1, $player2, $p1_score, $p2_score, $p1_rank, $results['R3'], $p2_rank, $results['R4'], $event_date, $event_name, $round, $category);
        
        //print_r($results);
        echo '<p>'.$player1.' '.$p1_rank.' - '.$results['R3'].'</p>';
        echo '<p>'.$player2.' '.$p2_rank.' - '.$results['R4'].'</p>';

        /*
        S1 = 1st player's score
        S2 = 2nd player's score
        R1 = 1st player's current rank
        R2 = 2nd player's current rank

        The following are from $results
        [R3] => player1 ranking after ELO
        [R4] => player2 ranking after ELO
        [P1] => player1 points awarded
        [P2] => player2 points awarded

        */
    }

    echo '<hr />';
    flush();
    ob_flush();

}





/**
 * Get_all function.
 *
 * This function pulls all the event data into the database using get_file() and import_html() and process_row()
 *
 * @access public
 * @return void
 */
function Get_all()
{
    // Turn on Maintenance message
    echo Maintenance_mode('enable');

    // The base url used. dev.rwjl on my local machine. Include http:// and trailing slash
    $base_url = 'http://dev.rwjl/';
    $count = 1;
    // This is the array of events passed one at a time to get_file()
    $events = array(
    'ijf/grand_prix/2010_tunis/',
    'aju/world_cup/2010_cairo/',
    'ijf/grand_slam/2010_rio/',
    'pjc/world_cup/2010_sao_paulo/',
    'eju/world_cup/2010_bucharest/',
    'eju/world_cup/2010_madrid/',
    'eju/world_cup/2010_tallinn/',
    'eju/world_cup/2010_lisbon/',
    'pjc/world_cup/2010_isla_margarita/',
    'pjc/world_cup/2010_san_salvador/',
    'ijf/grand_slam/2010_moscow/',
    'jua/world_cup/2010_ulaanbaatar/',
    'oju/continental/2010_sen_canberra/',
    'pjc/world_cup/2010_miami/',
    'ijf/world/wc2010/',
    'jua/world_cup/2010_almaty/',
    'jua/world_cup/2010_tashkent/',
    'eju/world_cup/2010_birmingham/',
    'eju/world_cup/2010_rome/',
    'eju/world_cup/2010_baku/',
    'eju/world_cup/2010_minsk/',
    'ijf/grand_prix/2010_rotterdam/',
    'oju/world_cup/wcup_samoa2010/',
    'ijf/grand_prix/2010_abu_dhabi/',
    'jua/world_cup/2010_suwon/',
    'ijf/grand_slam/2010_tokyo/',
    'ijf/grand_prix/2010_qingdao/',
    'ijf/masters/2011_baku/',
    'eju/world_cup/2011_sofia/',
    'eju/world_cup/2011_tblisi/',
    'ijf/grand_slam/2011_paris/',
    'eju/world_cup/2011_budapest/',
    'eju/world_cup/2011_oberwart/',
    'ijf/grand_prix/2011_duesseldorf/',
    'eju/world_cup/2011_prague/',
    'eju/world_cup/2011_warsaw/',
    'pjc/continental/2011_guadalajara/',
    'jua/continental/2011_abu_dhabi/',
    'aju/continental/2011_dakar/',
    'oju/continental/2011_papeete',
    'eju/european/2011_istanbul/',
    'ijf/grand_prix/2011_baku/',
    'ijf/grand_slam/2011_moscow/',
    'eju/world_cup/2011_bucharest/',
    'eju/world_cup/2011_madrid/',
    'eju/world_cup/2011_lisbon/',
    'eju/world_cup/2011_tallinn/',
    'ijf/grand_slam/2011_rio/',
    'pjc/world_cup/2011_sao_paulo/',
    'pjc/world_cup/2011_miami/',
    'pjc/world_cup/2011_puerto_la_cruz/',
    'pjc/world_cup/2011_san_salvador/',
    'ijf/world/wc2011/',
    'jua/world_cup/2011_ulaanbaatar/',
    'jua/world_cup/2011_tashkent/',
    'jua/world_cup/2011_almaty/',
    'eju/world_cup/2011_rome/',
    'eju/world_cup/2011_liverpool/',
    'eju/world_cup/2011_minsk/',
    'eju/world_cup/2011_baku/',
    'ijf/grand_prix/2011_abu_dhabi/',
    'oju/world_cup/wcup_samoa2011/',
    'ijf/grand_prix/2011_amsterdam/',
    'jua/world_cup/2011_jeju/',
    'ijf/grand_slam/2011_tokyo/',
    'ijf/grand_prix/2011_qingdao/',
    'ijf/masters/2012_almaty/',
    'eju/world_cup/2012_sofia/',
    'eju/world_cup/2012_tblisi/',
    'ijf/grand_slam/2012_paris/',
    'eju/world_cup/2012_oberwart/',
    'eju/world_cup/2012_budapest/',
    'ijf/grand_prix/2012_duesseldorf/',
    'eju/world_cup/2012_prague/',
    'eju/world_cup/2012_warsaw/',
    'aju/continental/2012_agadir/',
    'jua/continental/2012_tashkent/',
    'pjc/continental/2012_montreal/',
    'eju/european/2012_chelyabinsk/',
    'oju/continental/2012_cairns/'
        
        

                

    );
    // array of categories for each event
    $categories = array(
    '-60',
    '-66',
    '-73',
    '-81',
    '-90',
    '-100',
    'p100',
    '-48',
    '-52',
    '-57',
    '-63',
    '-70',
    '-78',
    'p78'

    );
    // Loop through all the events
    foreach ($events as $event) {
        
        //check for the OJU 2011 champs, if so process differently, else standard.
        if ($event =='oju/continental/2011_papeete') {
            Import_Oju_2011();
        } else {
        
        
        
            // Loop through each category within each event
            foreach ($categories as $cat) {

                  // call the URL for the event and category
                  echo '<br />'.$base_url.'get_file/'.$event.$cat;
                  file_get_contents($base_url.'get_file/'.$event.$cat);
                  // call the URL to import the data downloaded
            
            
                  $text = file_get_contents($base_url.'import');
                  echo '<br>'.$text;
                  // Flush simply allows results to be pushed out to the web page
                  flush();
            }
        }
        if ($count > 9) {
            $filename = $count .'_'. str_replace('/', '', $event);
        } else {
            $filename = '0'.$count .'_'. str_replace('/', '', $event);
        }
        //echo $filename;
        if (!copy('data/rwjl.db', 'data/'.$filename.'.db')) {
            echo "failed to copy $filename...n";
        }
        $count++;
    }
    echo '<br />-end-';
    file_get_contents($base_url.'delete/');
    file_get_contents($base_url.'delete/-');
    file_get_contents($base_url.'delete/_');

    // Turn off maintenance mode
    echo Maintenance_mode('disable');
    
}


/**
 * Show_categories function.
 *
 * This function returns a list of categories web page
 *
 * @access public
 * @return void
 */
function Show_categories()
{
    return html('categories.html.php');
}


/**
 * Show_category function.
 *
 * This function displays the category given to it via URL parameter.
 *
 * @param mixed $category (default: null)
 * 
 * @access public
 * @return void
 */
function Show_category($category = null)
{

    if (!$category) {
        $category = params('category');
    }

    // Start by adding heading to the HTML we are going to return.
    $html = '<h2>'.$category.' (Athletes: '.Athletes_In_category($category).')</h2>';
    

    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // Select all the players from the category
    $query = "SELECT * FROM players
              WHERE category='".$category."'
              ORDER BY rank DESC;";
    $result = $dbo->query($query) or die("Error in query");

    // Set the counter to 1 (the first player)
    $count = 1;

    // Create the HTML table
    $html .= '<table id="t1" class="table-autosort">';
    $html .= '<thead><tr><th class="table-sortable:numeric">Position</th><th class="table-sortable:alphanumeric">Name</th><th class="table-sortable:numeric">Rank</th><th class="table-sortable:alphanumeric">Country</th><th style="padding-left:10px;" class="table-sortable:numeric">Wins</th><th class="table-sortable:numeric">Losses</th><th class="table-sortable:numeric">Total Fights</th><th class="table-sortable:numeric">Win rate</th></tr></thead>';

    // We need some arrays of categories for when we decide where to put the qualification line.
    $womens_categories = array('-48', '-52', '-57', '-63', '-70', '-78', '+78');
    $mens_categories = array('-60', '-66', '-73', '-81', '-90', '-100', '+100');

    // loop through the players and create a row for each
    while ($row = $result->fetchArray()) {
        // fetch current row
        //$row = $result->current();

        $html .= '<tr>';
        $html .= '<td>';
        $html .= $count;
        $html .= '</td><td>';
        $html .= '<a href="/player/'.$row['name'].'">';
        $html .= $row['name'];
        $html .= '</a>';
        $html .=  '</td><td>';
        $html .=  $row['rank'];
        $html .=  '</td><td>';
        $html .= '<a href="/country/'.$row['country'].'">';
        $html .=  $row['country'];
        $html .= '</a>';
        $html .=  '</td><td>';
        $html .=  $row['wins'];
        $html .=  '</td><td>';
        $html .=  $row['losses'];
        $html .=  '</td>';
        $html .= '<td>';
        $html .= $row['losses'] + $row['wins'];
        $html .= '</td>';
        $html .= '<td>';
        $win_rate = $row['wins'] / ($row['wins'] + $row['losses']);
        $html .= number_format($win_rate, 3);
        $html .= '</td>';

        $html .=  '</tr>';

        // increment the counter by one
        $count++;

        if ($count == 15 && in_array($category, $womens_categories)) {
            $html .= '<tr style="background:pink;"><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        if ($count == 23 && in_array($category, $mens_categories)) {
            $html .= '<tr style="background:blue;"><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        }
        // call the next row
        //$result->next();
    }
    $html .= '</table>';
    set('html', $html);
    return html('category.html.php');
}


/**
 * Show_country function.
 *
 * This function displays a country's players
 *
 * @param mixed $country (default: null)
 *
 * @access public
 * @return void
 */
function Show_country($country = null)
{

    if (!$country) {
        $country = params('country');
    }

    // start the HTML to be displayed.
    $html = '<h2>'.$country.'</h2>';


    // CHart of country over time
    $chart_url = Get_Country_Participation_chart($country);
    $html .= "<img src='$chart_url'>";
    
    // Add total number of athletes
    $html .= '<p>Total Athletes: ';
    $html .= Country_Total_players($country);
    $html .= '<br />';
    
    // Add total points for country
    $html .= '<p>Total Ranking points: ';
    $html .= Country_Total_rank($country);
    $html .= '<br />';
    
    // Add average points for country
    $html .= '<p>Average Ranking points: ';
    $html .= (int)Country_Average_rank($country);
    $html .= '</p>'; 
    
    // Add average win rate for country
    $html .= '<p>Average win rate: ';
    $html .= Country_Win_rate($country);
    $html .= '</p>';
      
    
    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // run the query
    $query = "SELECT * FROM players
              WHERE country='".$country."'
              ORDER BY rank DESC;";
    $result = $dbo->query($query) or die("Error in query");

    // set counter to 1
    $count = 1;
    $html .= '<table id="t1" class="table-autosort">';
    $html .= '<thead><tr><th class="table-sortable:numeric">Position</th><th class="table-sortable:alphanumeric">Name</th><th class="table-sortable:numeric">Rank</th><th class="table-sortable:alphanumeric">Category</th><th class="table-sortable:alphanumeric">Country</th><th style="padding-left:10px;" class="table-sortable:numeric" align="center">Wins</th><th class="table-sortable:numeric">Losses</th><th class="table-sortable:numeric">Total Fights</th><th class="table-sortable:numeric">Win rate</th></tr></thead>';

    // Loop through the results of the query and process each row
    while ($row = $result->fetchArray()) {
        // fetch current row
        //$row = $result->current();
        $html .= '<tr>';
        $html .= '<td>';
        $html .= $count;
        $html .= '</td><td>';
        $html .= '<a href="/player/'.$row['name'].'">';
        $html .= $row['name'];
        $html .= '</a>';
        $html .= '</td><td>';
        $html .= $row['rank'];
        $html .= '</td><td>';
        $html .= '<a href="/cat/'.$row['category'].'">';
        $html .= $row['category'];
        $html .= '</a>';
        $html .= '</td><td>';
        $html .= $row['country'];
        $html .= '</td><td align="center">';
        $html .= $row['wins'];
        $html .= '</td><td align="center">';
        $html .= $row['losses'];
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= $row['losses'] + $row['wins'];
        $html .= '</td>';
        $html .= '<td align="center">';
        $win_rate = $row['wins'] / ($row['wins'] + $row['losses']);
        $html .= number_format($win_rate, 3);
        $html .= '</td>';

        $html .= '</tr>';

        //incement theplayer counter
        $count++;
        // get the next result
        //$result->next();
    }
    $html .= '</table>';
    
    // Chart of participation changes over time
    $chart_url2 = Get_Country_Participation_Per_Event_chart($country);
    $html .= "<img src='$chart_url2'>";
    
    set('html', $html);
    return html('country.html.php');
}


/**
 * Full_list function.
 *
 * This function creates a html list of all athletes
 *
 * @access public
 * @return void
 */
function Full_list()
{
    // create html variable with header
    $html = '';

    // connect to the DB and run query
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");
    $query = "SELECT * FROM players
              ORDER BY rank DESC;";
    $result = $dbo->query($query) or die("Error in query");

    // Set player counter to 1
    $count = 1;

    //create the HTML table
    $html .= '<table id="t1" class="table-autosort">';
    $html .= '<thead><tr><th class="table-sortable:numeric">Position</th><th class="table-sortable:alphanumeric">Name</th><th class="table-sortable:numeric">Rank</th><th class="table-sortable:alphanumeric">Category</th><th class="table-sortable:alphanumeric">Country</th><th style="padding-left:10px;" class="table-sortable:numeric">Wins</th><th class="table-sortable:numeric">Losses</th><th class="table-sortable:numeric">Total Fights</th><th class="table-sortable:numeric">Win rate</th></tr></thead>';

    //loop through the query rows and add to the html table
    while ( $row = $result->fetchArray() ) {
        // fetch current row
        //$row = $result->current();
        $html .= '<tr>';
        $html .= '<td>';
        $html .= $count;
        $html .= '</td><td>';
        $html .= '<a href="/player/'.$row['name'].'">';
        $html .= $row['name'];
        $html .= '</a>';
        $html .= '</td><td>';
        $html .= $row['rank'];
        $html .= '</td><td>';
        $html .= '<a href="/cat/'.$row['category'].'">';
        $html .= $row['category'];
        $html .= '</a>';
        $html .= '</td><td>';
        $html .= '<a href="/country/'.$row['country'].'">';
        $html .= $row['country'];
        $html .= '</a>';
        $html .= '</td><td style="padding-left:10px;">';
        $html .= $row['wins'];
        $html .= '</td><td>';
        $html .= $row['losses'];
        $html .= '</td>';
        $html .= '<td>';
        $html .= $row['losses'] + $row['wins'];
        $html .= '</td>';
        $html .= '<td>';
        $win_rate = $row['wins'] / ($row['wins'] + $row['losses']);
        $html .= number_format($win_rate, 3);
        $html .= '</td>';

        $html .= '</tr>';

        // Increment to player count by 1 and get next result
        $count++;
        //$result->next();
    }
    $html .= '</table>';
    set('html', $html);
    return html('full_list.html.php');
}

/**
 * Show_all_countries function.
 *
 * This function displays a list of all the countries
 *
 * @access public
 * @return void
 */
function Show_all_countries()
{

    // create $HTML and start the html with header
    $html = '<h1>Countries</h1>';

    //Make database connection and run query
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");
    $query = "SELECT DISTINCT country FROM players
              ORDER BY country ASC;";
    $result = $dbo->query($query) or die("Error in query");

    $html .= '<table id="t1" class="table-autosort">';
    $html .= '<thead><tr>
	   <th class="table-sortable:numeric"></th>
	   <th class="table-sortable:alphanumeric" align="center">Country</th>
	   <th class="table-sortable:numeric" align="center">Average Rank</th>
	   <th class="table-sortable:numeric" align="center">Total Ranking Points</th>
	   <th class="table-sortable:numeric" align="center">Total Athletes</th>
	   <th class="table-sortable:numeric" align="center">Avg Win Rate</th>
	   </tr></thead>';
    
    
    $total_avg_ranking = 0;
    $total_total_points = 0;
    $total_athletes = 0;
    $total_avg_winrate = 0;
    
    $counter = 1;
    //loop through the results and add them to the html
    while ($row = $result->fetchArray()) {
        // fetch current row
        //$row = $result->current();
        
        $html .= '<tr>';
        $html .= '<td align="center">';
        $country =  $row['country'];
        $html .= $counter.') ';
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= '<a href="country/'.$country.'">'.$country.'</a>';
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= (int)Country_Average_rank($country);
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= (int)Country_Total_rank($country);
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= (int)Country_Total_players($country);
        $html .= '</td>';        
        $html .= '</td>';
        $html .= '<td align="center">';
        $html .= Country_Win_rate($country);
        $html .= '</td>';

        // Add this country data to the totals
        $total_avg_ranking += (int)Country_Average_rank($country);
        $total_total_points += (int)Country_Total_rank($country);
        $total_athletes += (int)Country_Total_players($country);
        $total_avg_winrate += Country_Win_rate($country);        

        // Increment counter and call the next result
        $counter++;
        //$result->next();
        
        $html .= '</tr>';
    }
    $html .= '<tr>';

    
    $html .= '<td align="center">';
    $html .= '</td>';
    $html .= '<td align="center">';
    $html .= '</td>';
    $html .= '<td align="center">AVG: ';
    $html .= (int)($total_avg_ranking / $counter);
    $html .= '</td>';
    $html .= '<td align="center">AVG: ';
    $html .= (int)($total_total_points / $counter);
    $html .= '</td>';
    $html .= '<td align="center">AVG: ';
    $html .= (int)($total_athletes / $counter);
    $html .= '</td>';
    $html .= '<td align="center">AVG: ';
    $html .= number_format($total_avg_winrate / $counter, 3);
    $html .= '</td>';
    
    $html .= '</table>';
    set('html', $html);
    return html('all_countries.html.php');
}


function All_fights()
{
    return html('all_fights.html.php');
}






function Fights_for_player($player = null)
{


    // create html variable with header
    $html = '<h2>Fights for $name</h2>';

    // connect to the DB and run query
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");
    $query = "SELECT * FROM fights
              WHERE p1_name ='$player' or
              p2_name ='$player';";
    //echo $query;
    $result = $dbo->query($query) or die("Error in query");
    
    $scores = array();
    
    $html = '<table>';
    $html .= '<tr><th>Fight ID</th><th>Blue</th><th>Blue Score</th><th>White Score</th><th>White</th><th>Ranking points for <br />'.$player.'</th><th>Event</th</tr>';
    //loop through the query rows and add to the html table
    while ($row = $result->fetchArray()) {
        // fetch current row
        //$row = $result->current();
        //echo '<pre>';
        //print_r($row);
        //echo '</pre>';

        $html .= '<tr>';

        $html .= '<td>';
        $html .= $row['id'];
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<a href="/player/'.$row['p1_name'].'">';
        $html .= $row['p1_name'];
        $html .= '</a></td>';

        $html .= '<td>';
        $html .= $row['p1_score'];
        $html .= '</td>';

        $html .= '<td>';
        $html .= $row['p2_score'];
        $html .= '</td>';

        $html .= '<td>';
        $html .= '<a href="/player/'.$row['p2_name'].'">';
        $html .= $row['p2_name'];
        $html .= '</a></td>';

        $html .= '<td>';

        if ($row['p1_name'] === $player) {
            $change = $row['p1_rank_post'] - $row['p1_rank_pre'];
            $html .= $row['p1_rank_post'].sprintf(" (%+d)", $change);
            //$scores[] = $row['p1_rank_post'];
            
            $scores[] = $change;
        } else {
            $change = $row['p2_rank_post'] - $row['p2_rank_pre'];
            $html .= $row['p2_rank_post'].sprintf(" (%+d)", $change);
            //$scores[] = $row['p2_rank_post'];
            $scores[] = $change;
        }
        $html .= '</td>';

        $html .= '<td>';
        $html .= $row['event'];
        $html .= '</td>';
        $html .= '</tr>';




        //$result->next();
    }
    $html .= '</table>';
    
    
    $data_elements = implode(",", $scores);
    

    //print_r($aPosition);
    $chart_url = 'http://chart.apis.google.com/chart?';     // base url for google charts
    $chart_url .= 'cht=lc';                                 // ls - sparkline chart
    $chart_url .= '&chs=400x125';                           // dimensions for the chart
    $chart_url .= '&chds=30,-30';                        // max and min data limits for display
    $chart_url .= '&chtt='.'Points: rwjl.net/player/'.$player;        // Adds athletes name to the chart.
    $chart_url .= '&chd=t:';                                // data header for the chart
    $chart_url .= $data_elements;                           // data, which is the players rank in each event on chart.

    $html .= "<img src='$chart_url'>";
    
    
    return $html;
    //set('html', $html);
    //return html('full_list.html.php');
}






/**
 * JI_get_profile function.
 *
 * This function scrapes the JudoInside.com profile page for a player and returns their results.
 *
 * @access public
 * @param mixed $name.   (default: null)
 * @return void
 */
function Player_profile($name = null)
{
    if (!$name) {
        $name = params('name');
    }

    $rank = Get_rank($name);
    
    $category = Get_data($name, 'Category');
    $country = Get_data($name, 'Country');
    $wins = Get_data($name, 'Wins');
    $losses = Get_data($name, 'Losses');
    //$total_fights = $wins + $losses;


    $html_text = '<h2>Player Profile: '.$name.'</h2>';
    

    $html_text .= '<h3>Category: <a href="/cat/'.$category.'">'.$category.'</a></h3>';
    $html_text .= '<h4>Country: <a href="/country/'.$country.'">'.$country.'</a></h4>';
    $html_text .= '<h3>Ranking Points: '.$rank.'</h3>';
    $html_text .= '<h4>Fights (Won/Lost): ';
    $html_text .= $wins.'/'.$losses;
    $win_rate = $wins / ($wins + $losses);
    $html_text .= ' ('. number_format($win_rate, 3) . ')';
    $html_text .= '</h4>';
    //$html_text .= '<h3>Total Fights: '.$total_fights;
    //$html_text .= ' Wins: '.$wins.' Losses: '.$losses;
    //$html_text = '</h3>';

    $html_text .= '<p><a href="'.Judoinside_profile($name).'">JudoInside.com profile</a></p>';

    $chart_url = Get_Player_Rank_chart($name);
    $html_text .= "<img src='$chart_url'>";


    $fights = Fights_for_player($name);

    $name = strtolower($name);
    $name = explode(' ', $name);
    $user_id = $name[1]."_".$name[0];
    $html_text = $html_text. $fights;
    set('html', $html_text);
    return html('player_profile.html.php');
}


function Judoinside_profile($name = null)
{
    if (!$name) {
        $name = params('name');
    }
    
    
    $name = explode(' ', $name);
    //print_r($name);
    $ids = Load_Judoinside_data(); 
   
    //echo $name[0];
    foreach($ids as $key => $value)
    {
    
    
        if(strtolower($name[0]) == strtolower($value[1]) && strtolower($name[1]) == strtolower($value[2])) {
            return $value[3];
        }
    }           

}





/**
 *
 *
 * @param  unknown $content
 * @param  unknown $start
 * @param  unknown $end
 * @return unknown
 */
function GetBetween($content, $start, $end)
{
    $r = explode($start, $content);
    if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}


/**
 * Get_Player_Rank_chart function.
 *
 * This function returns a URL to include in a IMG tag. The url is a Google chart of the players ranking history.
 *
 * @access public
 * @param  string $name. (default: 'SOBIROV Rishod')
 * @return void
 */
function Get_Player_Rank_chart($name = 'SOBIROV Rishod')
{
    $aPosition = array();
    $dir = new DirectoryIterator(dirname(__FILE__).'/../data');
    $dirnames = array();
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $dirnames[] = $fileinfo->getFilename();
        }
    }

    asort($dirnames);
    array_pop($dirnames);
    //print_r($dirnames);

    foreach ($dirnames as $db_name) {
        $db = 'data/'.$db_name;
        $dbo = new SQLite3("$db");

        $result = $dbo->query("SELECT rank FROM players WHERE name='$name';");

        while ($row = $result->fetchArray()) {
            // echo $db_name.': ';
            // echo $row[0].'<br>';
            if ($row[0]) {
                $aPosition[] = $row[0];
            } else {
                $aPosition[] = 0;
            }
        }


    }

    $data_elements = implode(",", $aPosition);

    //print_r($aPosition);
    $chart_url = 'http://chart.apis.google.com/chart?';     // base url for google charts
    $chart_url .= 'cht=lc';                                 // ls - sparkline chart
    $chart_url .= '&chs=400x125';                           // dimensions for the chart
    $chart_url .= '&chds=1200,1900';                        // max and min data limits for display
    $chart_url .= '&chtt='.'Rank: rwjl.net/player/'.$name;        // Adds athletes name to the chart.
    $chart_url .= '&chd=t:';                                // data header for the chart
    $chart_url .= $data_elements;                           // data, which is the players rank in each event on chart.

    return $chart_url;

}





function Get_Country_Participation_chart($country = 'Brazil')
{
    $aPosition = array();
    $dir = new DirectoryIterator(dirname(__FILE__).'/../data');
    $dirnames = array();
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $dirnames[] = $fileinfo->getFilename();
        }
    }

    asort($dirnames);
    array_pop($dirnames);
    //print_r($dirnames);

    foreach ($dirnames as $db_name) {
        $db = 'data/'.$db_name;
        $dbo = new SQLite3("$db");

        $result = $dbo->query(
            "
        SELECT count(*) AS 'people' FROM players WHERE country='$country';
        "
        );

        $row = $result->fetchArray();
        //echo $db_name.': ';
        //echo $row[0].'<br>';
        if ($row[0]) {
            $aPosition[] = $row[0];
        } else {
            $aPosition[] = 0;
        }



    }

    $data_elements = implode(",", $aPosition);

    //print_r($aPosition);
    $chart_url = 'http://chart.apis.google.com/chart?';     // base url for google charts
    $chart_url .= 'cht=lc';                                 // ls - sparkline chart
    $chart_url .= '&chs=400x120';                           // dimensions for the chart
    $chart_url .= '&chds=0,200';                        // max and min data limits for display
    $chart_url .= '&chtt='.'Athletes competing in events.('.$country.')';    // Adds athletes name to the chart.
    $chart_url .= '&chd=t:';                                // data header for the chart
    $chart_url .= $data_elements;                           // data, which is the players rank in each event on chart.

    return $chart_url;

}


function Get_Country_Participation_Per_Event_chart($country = 'Brazil')
{
    $aPosition = array();
    $dir = new DirectoryIterator(dirname(__FILE__).'/../data');
    $dirnames = array();
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $dirnames[] = $fileinfo->getFilename();
        }
    }

    asort($dirnames);
    array_pop($dirnames);
    //print_r($dirnames);
    $prior = 0;
    foreach ($dirnames as $db_name) {
        $db = 'data/'.$db_name;
        $dbo = new SQLite3("$db");

        $result = $dbo->query(
            "
        SELECT count(*) AS 'people' FROM players WHERE country='$country';
        "
        );

        $row = $result->fetchArray();
        //echo $db_name.': ';
        //echo $row[0].'<br>';
        if ($row[0]) {
            $aPosition[] = $row[0] - $prior;
            $prior = $row[0];
        } else {
            $aPosition[] = 0;
        }



    }

    $data_elements = implode(",", $aPosition);

    //print_r($aPosition);
    $chart_url = 'http://chart.apis.google.com/chart?';     // base url for google charts
    $chart_url .= 'chxr=0,0,60';                           // Labels
    $chart_url .= '&cht=bvg';                                 // ls - sparkline chart
    $chart_url .= '&chbh=a';                               // chbh - bar width, a = auto 
    $chart_url .= '&chs=600x120';                           // dimensions for the chart
    $chart_url .= '&chds=0,60';                        // max and min data limits for display
    $chart_url .= '&chxt=y';                           // CHart axis
    $chart_url .= '&chtt='.'Athletes competing in events.('.$country.')';    // Adds athletes name to the chart.
    $chart_url .= '&chd=t:';                                // data header for the chart
    $chart_url .= $data_elements;                           // data, which is the players rank in each event on chart.

    return $chart_url;

}


function Country_Average_rank($country = null)
{
    
    if (!$country) {
        $country = params('country');
    }


    $aRanks = array();

    //echo $country;
    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // run the query
    $query = "SELECT rank FROM players
              WHERE country='".$country."'
              ORDER BY rank DESC;";
    
    //echo $query;
    
    $result = $dbo->query($query) or die("Error in query");
    
    while ($row = $result->fetchArray()) {
        //$row = $result->current();
        
        //echo $row['rank'];
        //echo '<br>';
        $aRanks[] = $row['rank'];
    
        //$result->next();
    
    }

        return array_sum($aRanks)/count($aRanks);
}

function Country_Win_rate($country = null)
{
    
    if (!$country) {
        $country = params('country');
    }


    $aRanks = array();

    //echo $country;
    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // run the query
    $query = "SELECT * FROM players
              WHERE country='".$country."';";
    
    //echo $query;
    
    $result = $dbo->query($query) or die("Error in query");
    
    while ($row = $result->fetchArray()) {
        //$row = $result->current();
        
        //echo $row['rank'];
        //echo '<br>';
        $aRates[] = $row['wins'] / ($row['wins'] + $row['losses']);
    
        //$result->next();
    
    }

        $winrate = number_format(array_sum($aRates)/count($aRates), 3);
        return $winrate;
}

function Country_Total_rank($country = null)
{
    
    if (!$country) {
        $country = params('country');
    }


    $aRates = array();

    //echo $country;
    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // run the query
    $query = "SELECT rank FROM players
              WHERE country='".$country."'
              ORDER BY rank DESC;";
    
    //echo $query;
    
    $result = $dbo->query($query) or die("Error in query");
    
    while ($row = $result->fetchArray()) {
        //$row = $result->current();
        
        //echo $row['rank'];
        //echo '<br>';
        $aRanks[] = $row['rank'];
    
        //$result->next();
    
    }

        return array_sum($aRanks);
}

function Country_Total_players($country = null)
{
    
    if (!$country) {
        $country = params('country');
    }


    $aRanks = array();

    //echo $country;
    // connect to the DB
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");

    // run the query
    $query = "SELECT * FROM players
              WHERE country='".$country."'
              ORDER BY rank DESC;";
    
    //echo $query;
    
    $result = $dbo->query($query) or die("Error in query");
    
    while ($row = $result->fetchArray()) {
        //$row = $result->current();
        
        //echo $row['rank'];
        //echo '<br>';
        $aRanks[] = $row['rank'];
    
        //$result->next();
    
    }

        return count($aRanks);
        
}


function Process_draw($player1, $player2)
{

    $sWinner = null;
    //echo $player1,$player2;
    // This routine is called from process_row if scores are tied.
    $aResults = parse_by_images_in_html();
    //print_r($aResults);

    foreach ($aResults as $key => $value) {


        //echo $value.'<br />';
        $players = explode(',', $value);
        $p1 = trim($players[0]);
        $p2 = trim($players[1]);
        //echo $p1.' - '.$p2.'<br>';

        //echo $player1;
        //echo $p1;

        if ($p1 == $player1 && $p2 == $player2) {
            //echo '<h1>ping</h1>';
            $sWinner = 1;
        }

        if ($p1 == $player2 && $p2 == $player1) {
            //echo '<h1>pong</h1>';
            $sWinner = 2;
        }
    }
    return $sWinner;
}



function Parse_by_images_in_html()
{

    $aResults = null;
    $dirty_html = file_get_contents('data/temp.txt');
    //$purifier = new HTMLPurifier();
    //$clean_html = $purifier->purify($dirty_html);

    $clean_html = $dirty_html;

    //explode the text at the center tag, then grab the tables.
    $text = explode('<center>', $clean_html);
    //$centered_portion = $text[1];
    //print_r($centered_portion);

    $aFights = explode('kg]:', $clean_html);

    $total_fights = count($aFights)-1;
    $sWinner = null;
    //echo "number of fights: $total_fights<br>";
    for ($i=1; $i <= $total_fights; $i++) {


        $data3 = explode("IWYKPIWYKP", $aFights[$i]);


        $player1 = str_replace("Preliminary round", "", $data3[0]);
        $player1 = str_replace("Semifinal", "", $player1);
        $player1 = str_replace("Final", "", $player1);
        $player1 = str_replace("Fight for 3rd place", "", $player1);
        $player1 = str_replace("Repechage", "", $player1);
        $temp = explode("(", $player1);
        $player1 = $temp[0];
        $player1 = strip_tags($player1);

        //echo $player1;

        //echo(strip_tags($data3[0]));



        $data3 = explode("IWYKPIWYKP", strip_tags($aFights[$i]));
        $tmp = explode('(', $data3[1]);
        $player2 = substr($tmp[0], 4);

        //echo $player2;


        if (strpos($aFights[$i], 'daumen-hoch.gif')) {

            $result = $player1.','.$player2;
            $aResults[$i] = $result;

            //echo "$i: $player1 wins<br>";
            //$sWinner = $player1;
        } else {

            $result = $player2.','.$player1;
            $aResults[$i] = $result;

            //echo "$i: $player2 wins<br>";
            //$sWinner = $player2;

        }

    }
    return $aResults;
}


function Maintenance_mode($mode = null)
{
    if (!$mode) {
        $mode = params('mode');
    }

    if ($mode === 'enable') {
        rename("not_index.html", "index.html");
        //echo 'Maintenance Mode enabled';
        return 'Maintenance Mode enabled';

    }
    if ($mode === 'disable') {
        rename("index.html", "not_index.html");        
        //echo 'Maintenance Mode disabled';
        return 'Maintenance Mode disabled';
    }

}

function Import_Oju_2011()
{
    // As OJU 2011 did not use Ippon.org the results have been manually entered into a CSV file for import.
    // This needs parsing seperately, via this function.
    //CSV format is cat,surname blue, first name blue, country, surname white, firstname white, country,2/1,2/1
    // 2,1 at the end means blue won. 1,2 means white won.
    
    $row = 1;
    if (($handle = fopen("oju_2011.csv", "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            // Parse the CSV array and prepare to add to the database.
            $player1 = Fix_playernames($data[1].' '.$data[2]);
            $p1_country = $data[3];
            $p1_score = $data[7];
            echo $player1.' ('.$p1_country.') ';
            
            $category = $data[0];
            
            //check if the player is in the DB, if not add them.
            if (!Find_name($player1)) {
                echo ' *';
                Db_create($player1);
                Db_update($player1, 1500, $category, $p1_country, 0, 0);
            }
            
            //check if the player is in the DB, if not add them.
            $player2 = Fix_playernames($data[4].' '.$data[5]);
            $p2_country = $data[6];
            $p2_score = $data[8];
            echo $player2.' ('.$p2_country.') ';
            if (!Find_name($player2)) {
                echo ' *';
                Db_create($player2);
                Db_update($player2, 1500, $category, $p2_country, 0, 0);
            }

            // Get existing win/loss data
            $p1_wins = Get_data($player1, 'wins');
            $p2_wins = Get_data($player2, 'wins');

            $p1_losses = Get_data($player1, 'losses');
            $p2_losses = Get_data($player2, 'losses');
            
            if ($p1_score > $p2_score) {
                $p1_wins++;
                $p2_losses++;
                echo "$player1 wins ($p1_wins/$p1_losses)";
            }
            if ($p1_score < $p2_score) {
                $p2_wins++;
                $p1_losses++;
                echo "$player2 wins ($p2_wins/$p2_losses)";
            }
            
            
            
            echo '<br />';
           
            // Process results and add to DB
           
            $elo_calculator=elo_calculator;
            $p1_rank = Get_rank($player1);
            $p2_rank = Get_rank($player2);
            $results=$elo_calculator->rating($p1_score, $p2_score, $p1_rank, $p2_rank, 40);


            Db_update($player1, $results['R3'], $category, $p1_country, $p1_wins, $p1_losses);
            Db_update($player2, $results['R4'], $category, $p2_country, $p2_wins, $p2_losses);

            //echo "$player1, $player2, $p1_score, $p2_score, $p1_rank, ".$results['R3'].", $p2_rank, ".$results['R4'];
            Add_fight($player1, $player2, $p1_score, $p2_score, $p1_rank, $results['R3'], $p2_rank, $results['R4']);

            //print_r($results);
            echo '<p>'.$player1.' '.$p1_rank.' - '.$results['R3'].'</p>';
            echo '<p>'.$player2.' '.$p2_rank.' - '.$results['R4'].'</p>';
           
            
            

                        
        }
        fclose($handle);    
    }
}

function Last_fight_number($event = null)
{
    // This function is fed a event .DB file and returns the highest contest number
    // Used to identify where events start and finish.

    if (!$event) {
        $db = dirname(__FILE__).'/../data/rwjl.db';    
    } else {
        $db = $event;

    }

    $dbo = new SQLite3("$db");

    $result = $dbo->query(
        '
        SELECT MAX(id) as "Highest ID" FROM fights;
        '
    );

    $row = $result->fetchArray();
        return $row['Highest ID'];

}

function Last_fight_number_all()
{

    $aPosition = array();
    $dir = new DirectoryIterator(dirname(__FILE__).'/../data');
    $dirnames = array();
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $dirnames[] = $fileinfo->getFilename();
        }
    }

    asort($dirnames);
    array_pop($dirnames);
    //print_r($dirnames);

    foreach ($dirnames as $db_name) {
        $event = 'data/'.$db_name;
        $temp_number = Last_fight_number($event);
        echo $db_name.': '.$temp_number.'<br />';
        


    }
}

function Export_fights($start='12488',$finish='12806')
{
    // This function exports the fight results in the format Hans Van Hessen wanted.
    // Feed it the start fight number and the end fight number and get all the matches
    // Hans then asked for more customisations so I decided to leave this format alone
    // and create another for Hans.

    if (params('start')) {
        $start = params('start');
    
    }

    if (params('finish')) {
        $finish = params('finish');
    
    }


    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");
    $query = "SELECT * FROM fights
              WHERE id BETWEEN $start and $finish;";
    $result = $dbo->query($query) or die("Error in query");

    /*   1. Last Name
    2. first name
    3. Nation (or abbrevation)
    4. Last name
    5. First name
    6. Nation (or abbrevation)
    7. winner (1 or 2)
    8. not played (in case of an injury) 
    */

    echo '"Date","Event","Round","category","Surname1","FirstName1","Nation1","Surname2","Firstname2","Nation2","P1Score","P2Score","Winner"';
    echo '<br />';

    while ($row = $result->fetchArray()) {
        //$row = $result->current();
        
        // Event Date
        echo '"';
        echo ltrim($row['fight_date']);
        echo '",';
        
        // Event name
        echo '"';
        echo $row['event'];
        echo '",';
        
        // Round in competition
        echo '"';
        echo $row['round'];
        echo '",';
        
        // Event category
        echo '"';
        echo $row['category'];
        echo '",';
        
        // Player 1 name
        $name1 = explode(' ', $row['p1_name']);
        echo '"';
        echo $name1[0];
        echo '","';
        echo $name1[1];
        echo '","';
        
        // Player 1 nation.
        // currently we do not have
        $p1_nation = Get_data($row['p1_name'], 'country');
        
        echo $p1_nation.'",';
        
        // Player 2 name
        $name2 = explode(' ', $row['p2_name']);
        echo '"';
        echo $name2[0];
        echo '","';
        echo $name2[1];
        echo '","';
        
        // Player 2 nation.
        // currently we do not have
        $p2_nation = Get_data($row['p2_name'], 'country');
        
        echo $p2_nation.'","';        
        
        echo $row['p1_score'];
        echo '","';
        echo $row['p2_score'];
        echo '","';
        
        // Winner.
        if ($row['p1_score'] > $row['p2_score']) {
            echo '"1"';
        } else {
            echo '"2"';
        
        }
        
        
        echo '<br />';
        
        
        
        flush();
        ob_flush();
        
        
        //$result->next();
    }


}


function Export_Fights_ji($start='12488',$finish='12806')
{
    // This function exports the fight results in the format Hans Van Hessen wants.
    // Feed it the start fight number and the end fight number and get all the matches
    // This is the new version based on discussion with Hans at EJU Junior Champs 2011.

    if (params('start')) {
        $start = params('start');
    
    }

    if (params('finish')) {
        $finish = params('finish');
    
    }


    $db = 'data/rwjl.db';
    $dbo = new SQLiteDatabase("$db");
    $query = "SELECT * FROM fights
              WHERE id BETWEEN $start and $finish;";
    $result = $dbo->query($query) or die("Error in query");

    /*   1. Last Name
    2. first name
    3. Nation (or abbrevation)
    4. Last name
    5. First name
    6. Nation (or abbrevation)
    7. winner (1 or 2)
    8. not played (in case of an injury) 
    */

    echo "\tDate,\tEvent,\tRound,\tcategory,\tSurname1,\tFirstName1,\tNation1,\tSurname2,\tFirstname2,\tNation2,\tWinner";
    echo '<br />';

    while ($result->valid()) {
        $row = $result->current();
        
        // Event Dat
        echo ltrim($row['fight_date']);
        echo ",\t";
        
        // Event name
        echo $row['event'];
        echo ",\t";
        
        // Round in competition
        $round = $row['round'];
        
        switch ($round)
        {
        case 'Final':
            $round = '14';
            break;  
                
        case 'Semifinal':
            $round = '13';
            break;    
                             
        case 'Semifinal':
            $round = '13';
            break;    
                                             
        case 'Repechage':
            $round = '19';
            break;   
                                                             
        case 'Fight for 3rd place':
            $round = '21';
            break;    
        
        }
        
        
        echo $round;
        echo ",\t";
        
        // Event category
        $cat = $row['category'];
        $cat = ltrim($cat, '-');
        if ($cat == '+100') {
            $cat = '101';
        }
        if ($cat == '+78') {
            $cat = '79';
        }        
        echo $cat;
        echo ",\t";
        
        // Player 1 name
        //$name1 = explode(' ', $row['p1_name']);
        $name1 = split_full_name($row['p1_name']);
        //print_r($name1);
        echo $name1['fname'];
        echo ",\t";
        echo $name1['lname'];
        echo ",\t";
        
        // Player 1 nation.
        // currently we do not have
        $p1_nation = Get_data($row['p1_name'], 'country');
        
        echo $p1_nation;
        echo ",\t";
        
        // Player 2 name
        $name2 = split_full_name($row['p2_name']);
        //print_r($name1);
        echo $name2['fname'];
        echo ",\t";
        echo $name2['lname'];
        echo ",\t";
        
        // Player 2 nation.
        // currently we do not have
        $p2_nation = Get_data($row['p2_name'], 'country');
        
        echo $p2_nation;
        echo ",\t";        
        
        
        // Winner.
        if ($row['p1_score'] > $row['p2_score']) {
            echo '1';
        } else {
            echo '2';
        
        }
        
        
        echo '<br />';
        
        
        
        flush();
        ob_flush();
        
        
        $result->next();
    }


}



function List_all_events() 
{
    // create html variable with header
    

    // connect to the DB and run query
    $db = 'data/rwjl.db';
    $dbo = new SQLite3("$db");
    $query = "SELECT * FROM events;";
    $result = $dbo->query($query) or die("Error in query");

    
    //loop through the query rows and add to the html table
    while ($row->fetchArray()) {
        // fetch current row
        //        $row = $result->current();
       
           print_r($row);
           echo Get_event_date($row['shortcut']);
           echo '<br />';
           
       
        //        $result->next();
    }
}

function Get_event_date()
{
    //Take the shortcut and determine the url, then pull the 
    //right page and grab the date.
    // shortcut comes from GET_ALL

    
    
    $doc = file_get_contents("data/temp2.txt");

    $date = GetBetween($doc, '<b>Overview', '</b>');
    
    //echo "...$date...";
        
    return($date);


}

function Athletes_In_category($category = null)
{
    $dbo = new SQLite3("data/rwjl.db");
    $query = "SELECT Count(*) FROM players
              WHERE category='".$category."'
              ORDER BY rank DESC;";
    $results = $dbo->query($query) or die("Error in query");
    $athletes = $results->fetchArray();
    return $athletes[0];

}

/**
 * API_page function.
 *
 * This function simply returns the home page template.
 *
 * @access public
 * @return void
 */
function API_page()
{
    return html('api_page.html.php');
}

?>
