<?php
// Data Model for RWJL
// Specifically, CRUD for SQLite via PHP5


function Create_database()
{
	echo "<html><body>";
	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	$dbo->query("
        CREATE TABLE players(id INTEGER PRIMARY KEY, name CHAR(255), rank INTEGER, category CHAR(4), country CHAR(255), wins INTEGER, losses INTEGER);
    ")  or die("Unable to create players table");
	
	$dbo->query("
        CREATE TABLE fights(id INTEGER PRIMARY KEY, p1_name CHAR(255), p2_name CHAR(255), p1_score INTEGER, p2_score INTEGER, p1_rank_pre INTEGER, p1_rank_post INTEGER, p2_rank_pre INTEGER, p2_rank_post INTEGER, fight_date DATE, event CHAR(255), round CHAR(255), category CHAR(4));
    ") or die("Unable to create fights table");
    
    $dbo->query("
        CREATE TABLE events(id INTEGER PRIMARY KEY, name CHAR(255), event_date DATE, shortcut CHAR(255));
    ")  or die("Unable to create events table");
    
    chmod($db, 0777);
	return 'DB created';

}



/**
 * Db_create function.
 *
 * @access public
 * @param mixed   $name.     (default: null)
 * @param mixed   $rank.     (default: null)
 * @param mixed   $category. (default: null)
 * @param mixed   $country.  (default: null)
 * @param int     $wins.     (default: 0)
 * @param int     $losses.   (default: 0)
 * @return void
 */
function Db_create($name=null, $rank = null, $category = null, $country = null, $wins = 0, $losses = 0)
{
	if (!$name) {
		$name = params('name');
	}
	if (!Find_name($name)) {

		//echo "<html><body>";
		//echo $name;
		$db = 'data/rwjl.db';
		$dbo = new SQLiteDatabase("$db");

		$dbo->query("
        INSERT INTO players (name, rank, category, country, wins, losses) VALUES ('$name', '1500','$category', '$country', '$wins', '$losses');
    ");
		return ' inserted';
	} else {

		return 'Player already exists';
	}

}

/**
 * Db_read function.
 *
 * @access public
 * @return void
 */
function Db_read()
{

}

function Db_update($name=null, $rank = null, $category = null, $country = null, $wins = null, $losses = null)
{
	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	//echo "rank='$rank', category='$category', country = '$country', wins = '$wins', losses = '$losses'";

	$dbo->query("
        UPDATE players
        SET rank='$rank', category='$category', country = '$country', wins = '$wins', losses = '$losses'
        WHERE name='$name';
    ");



}


/**
 * Db_delete function.
 *
 * @access public
 * @return void
 */
function Db_delete($name = null)
{
	if (!$name) {
		$name = params('name');
	}

	//echo "<html><body>";
	//echo $name;
	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	$dbo->query("
        DELETE FROM players WHERE name='$name';
    ");

	return ' deleted';

}


/**
 * Find_name function.
 *
 * @access public
 * @param mixed   $name. (default: null)
 * @return void
 */
function Find_name($name = null)
{
	// Function returns 1 if name found, "Not Found" if not

	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	$result = $dbo->query("
        SELECT * FROM players WHERE name='$name';
    ");

	if ($result->valid()) {
		return 1;
	} else {
		return 0;
	}


}

function Get_rank($name = null)
{
	// Function returns 1 if name found, "Not Found" if not

	/*
    $db = 'data/rwjl.db';
    $dbo = new SQLiteDatabase("$db");

    $result = $dbo->query("
        SELECT rank FROM players WHERE name='$name';
    ");

    $row = $result->current();
    return $row[0];
    */
	return Get_data($name);
}

function Get_data($name = null, $field = 'rank')
{
	// Function returns 1 if name found, "Not Found" if not

	$db = 'data/rwjl.db';
	$dbo = new SQLite3("$db");

	$result = $dbo->query("
        SELECT $field FROM players WHERE name='$name';
    ");

	$row = $result->fetchArray();
	return $row[0];
}



function test_insert()
{
	echo "<html><body>";
	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	$dbo->query("
        INSERT INTO players (name, rank, category) VALUES ('BLOGGS Test', '1500', '-90' );
    ");
	return 'Data inserted';
}








function test_update()
{
	Db_update('BLOGGS Test', 999, '-60');
	return 'Test update';

}


/**
 * Fix_playernames function.
 *  - This function cleans up known bad names, mis spellings etc.
 *
 * @access public
 * @param mixed   $name. (default: null)
 * @return mixed $name
 */
function Fix_playernames($name = null)
{



	$name =  iconv("UTF-8", "ISO-8859-1//TRANSLIT//IGNORE", $name);
	// Take any apostrophe's out
	$name = str_replace("'", "", $name);
	$name = str_replace(",", "", $name);
    
    // format is incorrect name then correct name
    // $name = str_replace("","", $name);
    $name = str_replace("ABDURAHMONOV Muhamad","ABDURAKHMONOV Mukhamadmurod", $name);
    $name = str_replace("ABDURAHMONOV Muhamadmurod","ABDURAKHMONOV Mukhamadmurod", $name);
    $name = str_replace("ABDURAHMONOV Mukhamadmurod","ABDURAKHMONOV Mukhamadmurod", $name);
    $name = str_replace("ABDURAKHMONOV Muhamadmurod","ABDURAKHMONOV Mukhamadmurod", $name);
    $name = str_replace("ABDURAKHMONOV Mukhamadmurodmurod","ABDURAKHMONOV Mukhamadmurod", $name);  
    $name = str_replace("ACHARRA LR BLANC Belen","ACHURRA Belen", $name);
    $name = str_replace("ACHURRA LE BLANC Belen","ACHURRA Belen", $name);                   
    $name = str_replace("AFENDIKOVA Lyudmyla", "AFENDIKOVA Liudmyla", $name);
    $name = str_replace("AIT ALI Fatima Zohra","AIT ALI Fatima Zahra", $name);
    $name = str_replace("ALI Mohamed","ALI Mohammed", $name);
    $name = str_replace("ANACHENKO Konstantin","ANANCHENKO Kostiantyn", $name);
    $name = str_replace("ANANCHENKO Konstantin","ANANCHENKO Kostiantyn", $name);
    $name = str_replace("AL QUBAISI Halifa", "ALQUBAISI Khalifa", $name);
	$name = str_replace("AL QUBAISI Khalifa", "ALQUBAISI Khalifa", $name);
	$name = str_replace("ALEXANIDIS Lavrentis","ALEXANIDIS Lavrentios", $name);
	$name = str_replace("ALI OUALLA Adia","ALI OUALLA Aida", $name);
	$name = str_replace("ALIEV Elnur","ALIJEV Elnur", $name);
	$name = str_replace("ALTHAMAM Maria Suelen","ALTHEMAN Maria Suelen", $name);
	$name = str_replace("ALTHAMAM Maria suelen","ALTHEMAN Maria Suelen", $name);
	$name = str_replace("ALTHEMAM Maria Suelen","ALTHEMAN Maria Suelen", $name);
	$name = str_replace("ALTHEMAN Maria Suelem","ALTHEMAN Maria Suelen", $name);
	$name = str_replace("ALVAREZ Luz Adiela","ALVAREZ Luz", $name);	
	$name = str_replace("ALVAREZ SALAZAR Luz Adiela","ALVAREZ Luz", $name);	
	$name = str_replace("AMARIS Yadinis","AMARIS Yadinys", $name);
	$name = str_replace("ANDREASSON Jennie","ANDREASON Jennie", $name);
	$name = str_replace("ARCA Ayse Saadet","ARCA Ayse", $name);
	$name = str_replace("ARTAVIA AGUILAR Laura","ARTAVIA Laura", $name);
	$name = str_replace("ARAUJO Fernandda","ARAUJO Fernanda", $name);
	$name = str_replace("ARUTIUNYAN Gayane", "ARUTIYUNYAN Gayane", $name);
	$name = str_replace("ARYECHA FERREIRA Juliene","ARYECHA Juliene", $name);
	$name = str_replace("BABAMURATOVA Gulbadau","BABAMURATOVA Gulbadam", $name);
	$name = str_replace("BACZKO Bernadette","BACZKO Bernadett", $name);
	$name = str_replace("BARRIOS Anrriquelis","BARRIOS Anriqueli", $name);
	$name = str_replace("BATA Philomene Jocelyne","BATA Philomene", $name);
	$name = str_replace("BATSUURI Bat-Orshikn", "BATSUURI Bat Orshikh", $name);
	$name = str_replace("BAYASGALAN Uyanga","BAYASGALAN Yanga", $name);
	$name = str_replace("BAYARSAIKHAN Tuuldur", "BAYARSAIKHAN Tuguldur", $name);
	$name = str_replace("BAYINDIR Yunus Emre","BAYINDIR Yunus", $name);
	$name = str_replace("BENAMADI Aberahmane", "BENAMADI Abderahmane", $name);
	$name = str_replace("BEN SALAH Mohamed","BENSALAH Mohamed", $name);
	$name = str_replace("BEN SALEH Mohammed Ali","BENSALAH Mohamed", $name);
	$name = str_replace("BEDZETI Vlora","BEDETI Vlora", $name);
	$name = str_replace("BERMOY Yanet","BERMOY ACOSTA Yanet", $name);
	$name = str_replace("BERNABEU AVOMO Maria","BERNABEU Maria", $name);
	$name = str_replace("BETANCOURT Antonio","BENTANCOURT Antonio", $name);
	$name = str_replace("BILGIC Ali Sahin","BILGIC Ali", $name);
    $name = str_replace("BIVIECA Fausto Cristian","BIVIECA Fausto", $name);
    $name = str_replace("BIVIECA MOREL Fausto Cristian","BIVIECA Fausto", $name);
    $name = str_replace("BLANCO Geovanna", "BLANCO Giovanna", $name);
    $name = str_replace("BLAS JR Ricardo","BLAS Ricardo", $name);
    $name = str_replace("BOISSARD Jose","BOISARD Jose", $name);
    $name = str_replace("BOLDBAATAR Gambat", "BOLDBAATAR Ganbat", $name);
    $name = str_replace("GAMBAT Boldbaatar", "BOLDBAATAR Ganbat", $name);
    $name = str_replace("GANBAT Boldbaatar", "BOLDBAATAR Ganbat", $name);
    $name = str_replace("BOLDPUNEV Sugurjagal", "BOLDPUREV Sugarjargal", $name);
    $name = str_replace("BORDIGNON Nathalia","BORDIGNON Natalia", $name);
    $name = str_replace("BOULEMIA Mustapha", "BOULEMYA Mustapha", $name);
    $name = str_replace("BRYASON Oscar","BRAYSON Oscar", $name);
    $name = str_replace("BUI THI Hoa","BUI Thi Hoa", $name);
    $name = str_replace("BURNS Nathan","BURNS Nathon", $name);
    $name = str_replace("CACHOLA Marta","CACHOLA Ana", $name);
    $name = str_replace("CADOUX-DUC Thomas","CADOUX-DUC Jeremy", $name);
    $name = str_replace("CAMPOS Hector Fernando","CAMPOS Hector", $name);
    $name = str_replace("CAMPOS DE MORAES Katherine","CAMPOS Katherine", $name);
	$name = str_replace("CAPRIORIU Corina Oana", "CAPRIORIU Corina", $name);
	$name = str_replace("CARILLO Edna","CARRILLO Edna", $name);
	$name = str_replace("CASTILLO Yelenis","CASTILLO Yalennis", $name);
	$name = str_replace("CASTRO Pedro Andrey", "CASTRO Pedro", $name);
	$name = str_replace("CATOTA Karla","CATOTA QUIJANO Karla", $name);
	$name = str_replace("CATUNA Andreea Florina", "CATUNA Andreea", $name);
	$name = str_replace("CHALA Vanessa Fernanda","CHALA Vanessa", $name);
	$name = str_replace("CHAUDHRY Garima","CHAUDHARY Garima", $name);
	$name = str_replace("CHOI Woo Su", "CHOI Sean", $name);
	$name = str_replace("CHOI Woosu", "CHOI Sean", $name);
	$name = str_replace("CHOI Min Ho","CHOI Min-Ho", $name);
	$name = str_replace("CHERNYAK Inna","CHERNIAK Inna", $name);
	$name = str_replace("CHERNYAK Maryna","CHERNIAK Maryna", $name);
	$name = str_replace("CHEPURINA Svitlana", "CHEPURINA Svetlana", $name);
	$name = str_replace("CHITU Andreea Stefania", "CHITU Andreea", $name);
	$name = str_replace("CHIMEB-YONBON Bolbbaatar", "CHIMED-YONDON Boldbaatar", $name);
	$name = str_replace("COLLINS Sarah", "COLLINS Sara", $name);
	$name = str_replace("CORFIOS Margi","CORFIOS Marguerita", $name);
	$name = str_replace("CRUZ QUINTANA Osmay","CRUZ Osmay", $name);
	$name = str_replace("CUTRO KELLY Nina","CUTRO-KELLY Nina", $name);
	$name = str_replace("DESPAIGNE TERRY Yosvane", "DESPAIGNE Terry", $name);
	$name = str_replace("KOBAYASHI Diasuke","KOBAYASHI Daisuke", $name);
	$name = str_replace("D AQUINO Matthew", "DAQUINO Matthew", $name);
	$name = str_replace("DAQUINO Matt","DAQUINO Matthew", $name);
	$name = str_replace("DAQUINO Matthewhew","DAQUINO Matthew", $name);
	$name = str_replace("DAHL Josh","DAHL Joshua", $name);
	$name = str_replace("DAHL Joshuaua","DAHL Joshua", $name);
	$name = str_replace("DELANNE Cedrrick","DELANNE Cedric", $name);
	$name = str_replace("DELPOPOLO Nick","DELPOPOLO Nicholas", $name);
	$name = str_replace("DE VILLERS MATTE Marie-Eve", "DE-VILLER-MATTE Marie-Eve", $name);
	$name = str_replace("DIDENKO Oksana", "DIDENKO Oskana", $name);
	$name = str_replace("DIEDHIOU Hortense","DIEDHIOU Hortance", $name);
	$name = str_replace("DONEGAN Ben","DONEGAN Benjamin", $name);
	$name = str_replace("DOS-SANTOS Ivo","DOS SANTOS Ivo", $name);
	$name = str_replace("DUARTE Alexis Uriel","DUARTE Alexis", $name);
	$name = str_replace("DUSTOV Sukhrob","DUSTOV Suhrob", $name);
	$name = str_replace("DUVERGER Richardson","DUVERGE Richardson", $name);
	$name = str_replace("DUDCHYK Vitaliy","DUDCHYK Vitalii", $name);
	$name = str_replace("DUMITRU Alina Alexandra", "DUMITRU Alina", $name);
	$name = str_replace("EDWARDS Kelly","EDWARDS Kelly Marie", $name);
	$name = str_replace("EDWARDS Kelly Marie Marie","EDWARDS Kelly Marie", $name);
	$name = str_replace("EL ASRI Mohamed","EL ASSRI Mohamed", $name);
	$name = str_replace("EL AZAAR El Assania","EL AZAAR El Hassania", $name);
	$name = str_replace("EL HADAD Islam","EL HADDAD Eslam", $name);
	$name = str_replace("EL HADY Amin", "EL HADY Amien", $name);
	$name = str_replace("ELKAWISAH Mohamed Elhadi", "ELKAWISAH Mohamed", $name);
	$name = str_replace("EL SHAHABY Islam","EL SHEHABY Islam", $name);
	$name = str_replace("ELIAS JR Nacif","ELIAS Nacif", $name);
	$name = str_replace("ENKHBAT Azzya","ENKHBAT Azzaya", $name);
	$name = str_replace("ERDENEBILEG Eknhbat", "ERDENEBILEG Enkhbat", $name);
	$name = str_replace("ESPINOSA Maricet","ESPINOSA Mariset", $name);
	$name = str_replace("EYFELLS Eyjofur","EYFELLS Eyjolfur", $name);
	$name = str_replace("FASIE Dan Gheorghe","FASIE Dan", $name);
	$name = str_replace("FERRERIA Marcelo", "FERREIRA Marcelo", $name);
	$name = str_replace("FONG Jacky","FONG Jacqueline", $name);
	$name = str_replace("FUJIMOTO Jeff","FUJIMOTO Jeffrey", $name);
	$name = str_replace("FUJIMOTO Jeffery", "FUJIMOTO Jeffrey", $name);
	$name = str_replace("FUJIMOTO Jeffreyery", "FUJIMOTO Jeffrey", $name);
	$name = str_replace("FUJIMOTO Jeffreyrey", "FUJIMOTO Jeffrey", $name);
	$name = str_replace("FUTTINICO Jhon Jairo","FUTTINICO John", $name);
	$name = str_replace("GADANOV Alimbek","GADANOV Alim", $name);
	$name = str_replace("GAMBOA Miniverth","GAMBOA Nynivher", $name);
	$name = str_replace("GARCIA Estefania Priscila","GARCIA Estefania", $name);
	$name = str_replace("GARCIA Estefania Priscila","GARCIA Estefania", $name);
	$name = str_replace("GARSIA MENDOSA Estefania","GARCIA Vanesa", $name);
	$name = str_replace("GEDUTYTE Renalda","GEDUTYTE Raimonda", $name);
	$name = str_replace("GERMAN TEJEDA Leidi","GERMAN Leidi", $name);
	$name = str_replace("GHASEMINEZHAD Amir","GHASEMI NEJAD Amir", $name);
	$name = str_replace("GOMEZ Angelo","GOMEZ Anyelo", $name);
	$name = str_replace("GOMEZ LOPEZ Maria","GOMEZ Maria", $name);
	$name = str_replace("GONTYUK Roman","GONTIUK Roman", $name);
	$name = str_replace("GRINI El Arbi","GRINI Elarbi", $name);
	$name = str_replace("GURTUEV Oulan","GURTUEV Ulan", $name);
	$name = str_replace("GUTSCHE Yannick","GUTSCHE Yannik", $name);
	$name = str_replace("HASAN Vanlioglu", "VANLIOGLU Hasan", $name);
	$name = str_replace("HASHIMOTO Kenny", "HASHIMOTO Kenneth", $name);
	$name = str_replace("HASHBAATAR Tsagaanbaatar", "KHASHBAATAR Tsagaanbaatar", $name);
	$name = str_replace("HAYYTBAYEVA Gulnar","HAYYTBAEVA Gulnar", $name);
	$name = str_replace("HEVONDIN S","HEVONDIAN Shushana", $name);
	$name = str_replace("HILL Debbie","HILL Deborah", $name);
	$name = str_replace("HONG Suk-Woong","HONG Suk Woong", $name);
	$name = str_replace("HUANG Shin-Han","HUANG Shih Han", $name);
	$name = str_replace("HWANG Dong-Kyu","HWANG Dong Kyu", $name);
	$name = str_replace("HWANG Bo-Bae","HWANG Bo Bae", $name);
	$name = str_replace("ILIADIS Ilias Of Nikos", "ILIADIS Ilias", $name);
	$name = str_replace("JABALLAH Faycal","JABALLAH Faical", $name);
	$name = str_replace("JEONG Gyeong-Mi","JEONG Gyeong Mi", $name);
	$name = str_replace("JO Songhui","JO Song Hui", $name);
	$name = str_replace("JONSSON Thormodur","JONSSON Tormodur", $name);
	$name = str_replace("JUNG Da-Woon","JUNG Da Woon", $name);
	$name = str_replace("JOUNG Dawoon","JOUNG Da-Woon", $name);
	$name = str_replace("KABA Ahmet Sahin","KABA Ahmet", $name);
	$name = str_replace("KABDELOV Yerzham","KABDELOV Yerzhan", $name);
	$name = str_replace("KABDELOV Yetzhan","KABDELOV Yerzhan", $name);
	$name = str_replace("KARBELASHVILI Davit","KARBELASHVILI David", $name);
	$name = str_replace("KARIMOV Tarian", "KARIMOV Tarlan", $name);
	$name = str_replace("KASSACMEV Alemnar","KASSACHEV Alexandr", $name);
	$name = str_replace("KATAIEV Ievgen","KATAIEV Evgen", $name);
	$name = str_replace("KHALAF Ibraheem","KHALAF Ibrahim", $name);
	$name = str_replace("KHANJALIASHVILI Zviadi","KHANJALIASHVILI Zviad", $name);
	$name = str_replace("KKHASHBAATAR Tsagaanbaatar", "KHASHBAATAR Tsagaanbaatar", $name);
	$name = str_replace("KIM Min-Gyu","KIM Min Gyu", $name);
	$name = str_replace("KIM Na Young","KIM Na-Young", $name);
	$name = str_replace("KIM Won-Jin","KIM Won Jin", $name);
	$name = str_replace("KIM Eun-Kyung","KIM Eun Kyung", $name);
	$name = str_replace("KIM Ji Youn","KIM Ji-Youn", $name);
	$name = str_replace("KIM Mi Ri","KIM Mi-Ri", $name);
	$name = str_replace("KIM Won Jung","KIM Won-Jung", $name);
	$name = str_replace("KITADI Felipe","KITADAI Felipe", $name);
	$name = str_replace("KONE KONAPEYA Romeo","KONE Kinapeya Romeo", $name);
	$name = str_replace("KONG Ja Young","KONG Ja-Young", $name);
	$name = str_replace("KONDRATEVA Nataliya", "KONDRATYEVA Nataliya", $name);
	$name = str_replace("KOUMBA Audrey","KOUMBA IMANDA ADJANI Audrey Nancy", $name);
	$name = str_replace("KURBANOV Otkir", "KURBANOV Utkur", $name);
	$name = str_replace("KURBANOV Otkirr", "KURBANOV Utkur", $name);
	$name = str_replace("KURBANOV Utkir", "KURBANOV Utkur", $name);
	$name = str_replace("KURBANOV Utkurr", "KURBANOV Utkur", $name);
	$name = str_replace("KURBONMAMADOV Khushvakht","KURBONMAMADOV Khushbakht", $name);
	$name = str_replace("LAMBERT Christoph","LAMBERT Christophe", $name);
	$name = str_replace("LAMBERT Christophee","LAMBERT Christophe", $name);
	$name = str_replace("LAMOUR Abdias","LAMOUR Abdias Philippe", $name);
	$name = str_replace("LAMOUR Abidas Phillipe","LAMOUR Abdias Philippe", $name);
	$name = str_replace("LAMOUR Abdias Philippe Philippe","LAMOUR Abdias Philippe", $name);
	$name = str_replace("LARSEN Jake", "LARSEN Jacob", $name);
	$name = str_replace("LAVRENTIEV Denis","LAVRENTYEV Denis", $name);
	$name = str_replace("LASKUTA Anatoliy","LASKUTA Anatolii", $name);
	$name = str_replace("LAZAROU Alecos","LAZAROU Alekos", $name);
	$name = str_replace("LEE Jung-Eun","LEE Jung Eun", $name);
	$name = str_replace("LEE Hye-Sun","LEE Hye Sun", $name);
	$name = str_replace("LEE Sun-A","LEE Sun Ah", $name);
	$name = str_replace("LEE Sun-Ah","LEE Sun Ah", $name);
	$name = str_replace("LEVYTSKA Tetiana","LEVYTSKA Tetyana", $name);
	$name = str_replace("LEON Lizbeth","LEON Lisbeth", $name);
	$name = str_replace("LIEN Chen Ling","LIEN Chen-Ling", $name);
	$name = str_replace("LISEWSKI Anne-Kathrin","LISEWSKI Anne-Katrin", $name);
	$name = str_replace("LOABILE Thabe","LOABILE Thebe", $name);
	$name = str_replace("LOPEZ Freddy","LOPEZ Fredy", $name);
	$name = str_replace("LOSHCHININ Yaroslav","LOSHCHININ Iaroslav", $name);
	$name = str_replace("LUCENTI Enmanuel", "LUCENTI Emmanuel", $name);
	$name = str_replace("LUPETEY Yurileidys","LUPETEY COBAS Yurileidys", $name);
	$name = str_replace("LUPETEY Yurisleidis","LUPETEY COBAS Yurileidys", $name);
	$name = str_replace("LUPETEY Yurisleydis","LUPETEY COBAS Yurileidys", $name);
    $name = str_replace("MACHADO Wisneiby","MACHADO Wisneibi", $name);
    $name = str_replace("MACHADO Wisneybi", "MACHADO Wisneibi", $name);
	$name = str_replace("MAKUKHA Ivanna","MAKUHA Ivanna", $name);
	$name = str_replace("MARET Cyrille", "MARET Cyril", $name);
	$name = str_replace("MARMELJUK Aleksandr", "MARMELJUK Aleksander", $name);
	$name = str_replace("MATEO Wander","MATEO RAMIREZ Wander", $name);
	$name = str_replace("MATROSOVA Anastasiya", "MATROSOVA Anastasiia", $name);
	$name = str_replace("MAZIBAYEV Maksat","MAZIBAYEV Maxat", $name);
	$name = str_replace("MBALLA ATANGANA Vanessa","MBALLA ATANGANA Hortence Vanessa", $name);
	$name = str_replace("MBARGA NDI Armelle","MBARGA NDI ARMELLE Cathia", $name);
	$name = str_replace("MEJIA DE LA ROCA Pedro Juan","MEJIA DE LA ROCA Juan", $name);
	$name = str_replace("MEJIA Juan Pedro","MEJIA DE LA ROCA Juan", $name);
	$name = str_replace("MEJIA Pedro","MEJIA DE LA ROCA Juan", $name);
	$name = str_replace("MENEZES Sara","MENEZES Sarah", $name);
	$name = str_replace("MENEZES Sarahh","MENEZES Sarah", $name);
	$name = str_replace("MERGHANI Hana","MERGHENI Hana", $name);
	$name = str_replace("MERHEB George","MERHEB George", $name);
	$name = str_replace("MERHEB Georges","MERHEB George", $name);
	$name = str_replace("MIRESMAEILI Arash","MIRESMAEILI Arash", $name);
	$name = str_replace("MOKTAR Houmed Kamil","MOKTAR Houmed", $name);
	$name = str_replace("MONDIERE Anne Sophie","MONDIERE Anne-Sophie", $name);
	$name = str_replace("MONNE Herman","MONNE Hermann", $name);
	$name = str_replace("MONNE Hermannn","MONNE Hermann", $name);
	$name = str_replace("MORISHITA Jumpei","MORISHITA Junpei", $name);
	$name = str_replace("MOUSSIMA EWANE Franck","MOUSSIMA EWANE Franck Martial", $name);
	$name = str_replace("MOUSSIMA EWANE Franck Martial Martial","MOUSSIMA EWANE Franck Martial", $name);
	$name = str_replace("MUKHBAATAR Bundmaa", "MUNKHBAATAR Bundmaa", $name);
	$name = str_replace("MURILLO SEGURA Osman", "MURILLO Osman", $name);
	$name = str_replace("MVONDO ETOGA Bernard","MVONDO Bernard", $name);
	$name = str_replace("MVONDO ETOGA Bernard Sylvain","MVONDO Bernard", $name);
	$name = str_replace("NABIEV Munin","NABIEV Mumin", $name);
	$name = str_replace("NACU Artiom","NACU Octavian", $name);
	$name = str_replace("NAGYSOLYMOSI JR. Sandor", "NAGYSOLYMOSI JR Sandor", $name);
	$name = str_replace("NAGYSOLYMOSI Sandor","NAGYSOLYMOSI JR Sandor", $name);
	$name = str_replace("NAGIYEV Kenan","NAGIYEV Kanan", $name);
	$name = str_replace("NIANG Asmaa", "NIANG Asma", $name);
	$name = str_replace("NIEMELÌã Niko-tapio", "NIEMELA Niko-Tapio", $name);
	$name = str_replace("NIEMEL� Niko-tapio","NIEMELA Niko-Tapio", $name);
	$name = str_replace("NIEMELA Niko Tapio", "NIEMELA Niko-Tapio", $name);
	$name = str_replace("NIZHENKO Oleksiy", "NIZHENKO Oleksii", $name);
	$name = str_replace("OKRUASHVILI Adam", "OKROASHVILI Adam", $name);
	$name = str_replace("OMURZAKOV Abazbek","OMURZAKOV Avazbek", $name);
	$name = str_replace("ORTIZ Dianna", "ORTIZ Diana", $name);
	$name = str_replace("ORTIZ Idalis","ORTIZ Idalys", $name);
	$name = str_replace("OSNACS Vladimirs", "OSNACHS Vladimirs", $name);
	$name = str_replace("OUALLAL Kaouther", "OUALAL Kaouthar", $name);
	$name = str_replace("OUALAL Kawthar","OUALAL Kaouthar", $name);
	$name = str_replace("OVCHINNIKOVS Konstantins", "OVCINNIKOVS Konstantins", $name);
	$name = str_replace("OZERLER Halil Ibrahim","OZERLER Halil", $name);
	$name = str_replace("PALELASHVILI Ioseb", "PALELASHVILI Iosef", $name);
	$name = str_replace("PAPOSHVILI Tengiz","PAPOSHVILI Tengizi", $name);
	$name = str_replace("PAPOSHVILI Tengizii","PAPOSHVILI Tengizi", $name);
	$name = str_replace("PARK Hyo-Ju","PARK Hyo Ju", $name);
	$name = str_replace("PERROT Lucie","PERROTTE Lucile", $name);
	$name = str_replace("PESSOA JR. Sergio", "PESSOA Sergio", $name);
	$name = str_replace("PINTO Kelvi","PINTO Keivi", $name);
	$name = str_replace("POLI Anne Laure", "POLI Anne-Laure", $name);
	$name = str_replace("POMBO SILVA Alex", "POMBO DA SILVA Alex William", $name);
	$name = str_replace("POMBO DA SILVA Alex","POMBO DA SILVA Alex William", $name);
	$name = str_replace("POPIEL Michal", "POPIEL Michael", $name);
	$name = str_replace("PRIETO MADRIGAL Raquel", "PRIETO Raquel", $name);
	$name = str_replace("PRIEDITIS Mike","PRIEDITIS Michael", $name);
	$name = str_replace("PROKOFYEVA Maryna","PROKOFIEVA Maryna", $name);
	$name = str_replace("REGDEL Anhbaator", "REGDEL Ankhbaatar", $name);
	$name = str_replace("REITER George","REITER Georg", $name);
	$name = str_replace("RESKO Viktor","RESHKO Viktors", $name);
	$name = str_replace("RIM Yunhui","RIM Yun Hui", $name);
	$name = str_replace("RIVAL Cyndi","RIVAL Cindy", $name);
    $name = str_replace("RIZEK Suzanne Catherine","RIZEK Suzanne", $name);
	$name = str_replace("ROBIN Pierre Alexandre", "ROBIN Pierre", $name);
	$name = str_replace("RODAKI Mohammad Reza","RODAKI Mohammad", $name);
	$name = str_replace("RODRIGUEZ Merwin","RODRIGUEZ Mervin", $name);
	$name = str_replace("ROMERO Jose Ernesto","ROMERO Jose", $name);
	$name = str_replace("ROSALES Albenys","ROSALES Albenis", $name);
	$name = str_replace("ROSSENUE Amelie", "ROSSENEU Amelie", $name);
	$name = str_replace("SADKOWSKA Ursula", "SADKOWSKA Urszula", $name);
	$name = str_replace("SAIDOV Saidzhalol","SAIDOV Saidjalol", $name);
	$name = str_replace("SALAZAR Luis Ignacio","SALAZAR Luis", $name);
	$name = str_replace("SALLES Laura","SALLES LOPEZ Laura", $name);
	$name = str_replace("LAURA Salles", "SALLES Laura", $name);
	$name = str_replace("SANJAASUREN Miyaraghaa", "SANJAASUREN Miyaragchaa", $name);
	$name = str_replace("SANCHO Ian", "SANCHO Ignacio", $name);
	$name = str_replace("SELL Katie", "SELL Kathleen", $name);
	$name = str_replace("SAMOYLOVICH Sergey","SAMOILOVICH Sergei", $name);
	$name = str_replace("SANTANA Lwilly","SANTANA Lwilli", $name);
	$name = str_replace("SANTO Amado Armando","SANTOS Amado Armando", $name);
	$name = str_replace("SAPARNIYAZOV Gadam","SAPARNYYAZOV Gadam", $name);
	$name = str_replace("SARAFOV Vanco","SARAFOV Vancho", $name);
	$name = str_replace("SAYDOV Ramziddin","SAYIDOV Ramziddin", $name);
	$name = str_replace("SCHMIDT Christian","SCHMIDT Cristian", $name);
	$name = str_replace("SCHOEMAN Henry","SCHOEMAN Henri", $name);
	$name = str_replace("SCHOENEBURG Karl","SCHONEBURG Karl", $name);
	$name = str_replace("SCHOENEBERG Karl","SCHONEBURG Karl", $name);
	$name = str_replace("SCHWARCZ Roni","SCHWARTZ Roni", $name);
	$name = str_replace("SCVOROV Victor","SCVORTOV Victor", $name);
	$name = str_replace("SEMENOV Viktor","SEMENOV Victor", $name);
	$name = str_replace("SEO Ha-Na","SEO Ha Na", $name);
	$name = str_replace("SERZMANOV Darkhan","SERZHANOV Darkhan", $name);
	$name = str_replace("SEYDI Mame Cira","SEYDI Mame", $name);
	$name = str_replace("SEYIDI Turane","SEYIDI Turana", $name);
	$name = str_replace("SHEPARD Janelle","SHEPHERD Janelle", $name);
	$name = str_replace("SHERRINGTON Christopher", "SHERRINGTON Chris", $name);
	$name = str_replace("SHERSHAN Dmitry","SHERSHAN Dzmitry", $name);
	$name = str_replace("SHIM Ji-Ho","SHIM Ji Ho", $name);
	$name = str_replace("SHIRAISHI Annie","SHIRAISHI Ann", $name);
	$name = str_replace("SHUKVANI Betkili", "SHUKVANI Betkil", $name);
	$name = str_replace("SINITSYNA Natalia", "SINITCYNA Natalia", $name);
	$name = str_replace("SIMIONESCU Vladut George","SIMIONESCU Vladut", $name);
	$name = str_replace("SIMMONDS PENA Omar","SIMMONDS PEA Omar", $name);
	$name = str_replace("SONG Chang-Hun","SONG Chang Hun", $name);
	$name = str_replace("STAUSHIY Aliaksei","STAUSHY Aliaksei", $name);
	$name = str_replace("STSEPHANKOU Aliaksei","STSEPANKOU Aliaksei", $name);
	$name = str_replace("SUNDSTROEM Olle","SUNDSTROM Olle", $name);
	$name = str_replace("SUNG Ji-Eun","SUNG Ji Eun", $name);
	$name = str_replace("TAPIA NAVAS Karina","TAPIA Karina", $name);
	$name = str_replace("TASSKIN Alexey","TASKIN Aleksei", $name);
	$name = str_replace("TATALASHVILI Nugzari", "TATALASHVILI Nugzar", $name);
	$name = str_replace("TAYLOR Andrew","TAYLOR Andre", $name);
	$name = str_replace("TONOVAN Hambardzum","TONOYAN Hambardzum", $name);
	$name = str_replace("TRITTON Nick", "TRITTON Nicholas", $name);
	$name = str_replace("TSEDEVSUREN Munkhuzaya", "TSEDEVSUREN Munkhzaya", $name);
	$name = str_replace("TSEND AYUSH Naranjargal", "TSEND-AYUSH Naranjargal", $name);
	$name = str_replace("TSIRKINA Katerina", "TSIRKINA Katarina", $name);
	$name = str_replace("TULENDIBAEV Adiljan","TULENDIBAEV Adiljon", $name);
	$name = str_replace("TUMEN OD Battugs", "TUMEN-OD Battugs", $name);
	$name = str_replace("UEMATSU Kioshi", "UEMATSU Kiyoshi", $name);
	$name = str_replace("ULMENTAYEVA Galiyna", "ULMENTAYEVA Galiya", $name);
	$name = str_replace("UNGUREANU Elena Monica", "UNGUREANU Monica", $name);
	$name = str_replace("UZUN Halil Ibrahim","UZUN Halil", $name);
	$name = str_replace("VALENTIM Eleudis","VALEMTIM Eleudis", $name);
	$name = str_replace("EMDEN Anicka", "VAN EMDEN Anicka", $name);
	$name = str_replace("VAN VAN EMDEN Anicka", "VAN EMDEN Anicka", $name);
	$name = str_replace("VANYAN Vitaliy", "VANYAN Vitaly", $name);
	$name = str_replace("VARGAS-KOCH Laura","VARGAS KOCH Laura", $name);
	$name = str_replace("VELASCO Diana Marcela","VELASCO Diana", $name);
	$name = str_replace("VELASCO German", "VELAZCO German", $name);
	$name = str_replace("VELENSEK Ana","VELENSEK Anamari", $name);
	$name = str_replace("VERDUGO Flavio Israel","VERDUGO Israel", $name);
	$name = str_replace("WANG Ki Chun", "WANG Ki-Chun", $name);
	$name = str_replace("WEZEU Helene","WEZEU DOMBEU Helene", $name);
	$name = str_replace("WILKOMIRSKI Krzystof","WILKOMIRSKI Krzysztof", $name);
	$name = str_replace("WOLFMAN Archil","WOLFMAN Archy", $name);
	$name = str_replace("YAMAN OEmer","YAMAN Omer", $name);
	$name = str_replace("YARTSEV Dmitriy","YARTSEV Denis", $name);
	$name = str_replace("YOO Kwang-Sun","YOO Kwang Sun", $name);
	$name = str_replace("YOON Ji-Seob","YOON Ji Seob", $name);
	$name = str_replace("YURI BARBOSA Daniell","YURI BARBOSA Danielli", $name);
	$name = str_replace("YUSUBOVA Naila","YUSUBOVA Ramila", $name);
	$name = str_replace("ZEGARRA Carlos","ZEGARRA PRESSER Carlos", $name);
	$name = str_replace("ZEGARRA PRESSER Carlos Erick","ZEGARRA PRESSER Carlos", $name);
	$name = str_replace("ZELLNER Ben","ZELLNER Benjamin", $name);
	$name = str_replace("ZOUAK Rizlein","ZOUAK Rizlen", $name);
    

	// clean out badly parsed names with a digit at the start
	$digits = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	$name = str_replace($digits, "", $name);
	
	//clean any double spaced names
	$name = str_replace("  ", " ", $name);


	return $name;
}



function Add_fight($player1, $player2, $p1_score, $p2_score, $p1_rank_pre, $p1_rank_post, $p2_rank_pre, $p2_rank_post, $fight_date=null, $event=null, $round=null, $category=null)
{
	echo "$player1, $player2, $p1_score, $p2_score, $p1_rank_pre, $p1_rank_post, $p2_rank_pre, $p2_rank_post $fight_date $event $round $category";
	flush();
	ob_flush();
	$db = 'data/rwjl.db';
	$dbo = new SQLiteDatabase("$db");

	
	$dbo->query("
        INSERT INTO fights (p1_name, p2_name, p1_score, p2_score, p1_rank_pre, p1_rank_post, p2_rank_pre, p2_rank_post, fight_date, event, round, category) 
        VALUES ('$player1', '$player2', '$p1_score', '$p2_score', '$p1_rank_pre', '$p1_rank_post',' $p2_rank_pre', '$p2_rank_post', '$fight_date', '$event', '$round', '$category');
    ") or die("<h1>A MySQL error has occurred during insert in ADD_fight.</h1>");
   
	
		
	return 'Data inserted';
}


function Get_category_strength($category = null)
{
	// Set category strength to null to start
	$strength = null;
	$aRanks = array();
	$sCount = null;
	$sTotal = null;

	// Create a doc object which we load with the DOM from the temp file
	$doc = new DOMDocument();
	@$doc->loadHTMLFile('data/temp.txt');

	// create an array of all the tables in the document
	$tables = $doc->getElementsByTagName('table');

	// create a array of rows in all the tables
	$rows = $tables->item(2)->getElementsByTagName('tr');
	$rows = $rows->item(0)->getElementsByTagName('tr');

	foreach ($rows as $row) {
		$cols = $row->getElementsByTagName('td');

		//Strip all the HTML tags out of the data
		$raw_data = strip_tags($cols->item(0)->nodeValue);


		if (strpos($raw_data, 'kg]:')) {
			// start averaging the the ranks

			$data1 = explode("[", $raw_data);

			$data2 = explode("kg]: ", $data1[1]);
			$data3 = explode("IWYKPIWYKP", $data2[1]);

			$category = $data2[0];
			//$category = str_replace("-", "U", $category);
			//$category = str_replace("p", "P", $category);
			$category = str_replace(" ", "", $category);

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

			$p1_rank = Get_rank($player1);
			$p2_rank = Get_rank($player2);


			$aRanks[$player1] = $p1_rank;
			$aRanks[$player2] = $p2_rank;


		}
	}

	//print_r($aRanks);

	foreach ($aRanks as $name => $rank) {
		//echo $name;
		$sTotal += $rank;
		$sCount++;
	}
	// echo '<p>'.$sCount.":".$sTotal;
	$sAverage = $sTotal / $sCount;
	//echo '<br />'.$sAverage. '</p>';
	$strength = $sAverage / 1500;
	return $strength;
}


function Load_Judoinside_data()
{
    $row = 0;
    $data_array = array();
    $handle = fopen("lib/IDs.csv", "r");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        
        for ($c=0; $c < $num; $c++) {
            $data_array[$row][$c] = $data[$c];
        }
        $row++;
    }
    
    fclose($handle);
    
    
     
    return $data_array;
}



function Add_event($name=null, $event_date=null, $shortcut=null)
{

        $name = params('name');
        $event_date = params('event_date');
        $shortcut = params('0');		
		echo "Data:'$name', '$event_date', '$shortcut' ";
		
		
		$db = 'data/rwjl.db';
		$dbo = new SQLiteDatabase("$db");

		$dbo->query("
        INSERT INTO events (name, event_date, shortcut) VALUES ('$name', '$event_date', '$shortcut');
    ") or die("Unable to insert this event");
		return ' inserted';
	

}



// http://code.google.com/p/php-name-parser/
// split full names into the following parts:
// - prefix / salutation  (Mr., Mrs., etc)
// - given name / first name
// - middle initials
// - surname / last name
// - suffix (II, Phd, Jr, etc)
function split_full_name($full_name) {
    $fname = '';
    $lname = '';
    $initials = '';
    
    
    $full_name = trim($full_name);
    // split into words
    $unfiltered_name_parts = explode(" ",$full_name);
    // completely ignore any words in parentheses
    foreach ($unfiltered_name_parts as $word) {
        if ($word{0} != "(")
            $name_parts[] = $word;
    }
    $num_words = sizeof($name_parts);

    // is the first word a title? (Mr. Mrs, etc)
    $salutation = is_salutation($name_parts[0]);
    $suffix = is_suffix($name_parts[sizeof($name_parts)-1]);

    // set the range for the middle part of the name (trim prefixes & suffixes)
    $start = ($salutation) ? 1 : 0;
    $end = ($suffix) ? $num_words-1 : $num_words;

    // concat the first name
    for ($i=$start; $i < $end-1; $i++) {
        $word = $name_parts[$i];
        // move on to parsing the last name if we find an indicator of a compound last name (Von, Van, etc)
        // we use $i != $start to allow for rare cases where an indicator is actually the first name (like "Von Fabella")
        if (is_compound_lname($word) && $i != $start)
            break;
        // is it a middle initial or part of their first name?
        // if we start off with an initial, we'll call it the first name
        if (is_initial($word)) {
            // is the initial the first word?  
            if ($i == $start) {
                // if so, do a look-ahead to see if they go by their middle name
                // for ex: "R. Jason Smith" => "Jason Smith" & "R." is stored as an initial
                // but "R. J. Smith" => "R. Smith" and "J." is stored as an initial
                if (is_initial($name_parts[$i+1]))
                    $fname .= " ".strtoupper($word);
                else
                    $initials .= " ".strtoupper($word);
            // otherwise, just go ahead and save the initial
            } else {
                $initials .= " ".strtoupper($word);
            }
        } else {
            $fname .= " ".fix_case($word);
        }  
    }

    // check that we have more than 1 word in our string
    if ($end-$start > 1) {
        // concat the last name
        for ($i; $i < $end; $i++) {
            $lname .= " ".fix_case($name_parts[$i]);
        }
    } else {
        // otherwise, single word strings are assumed to be first names
        $fname = fix_case($name_parts[$i]);
    }

    // return the various parts in an array
    $name['salutation'] = $salutation;
    $name['fname'] = trim($fname);
    $name['initials'] = trim($initials);
    $name['lname'] = trim($lname);
    $name['suffix'] = $suffix;
    return $name;
}

// detect and format standard salutations
// I'm only considering english honorifics for now & not words like
function is_salutation($word) {
    // ignore periods
    $word = str_replace('.','',strtolower($word));
    // returns normalized values
    if ($word == "mr" || $word == "master" || $word == "mister")
        return "Mr.";
    else if ($word == "mrs")
        return "Mrs.";
    else if ($word == "miss" || $word == "ms")
        return "Ms.";
    else if ($word == "dr")
        return "Dr.";
    else if ($word == "rev")
        return "Rev.";
    else if ($word == "fr")
        return "Fr.";
    else
        return false;
}

//  detect and format common suffixes
function is_suffix($word) {
    // ignore periods
    $word = str_replace('.','',$word);
    // these are some common suffixes - what am I missing?
    $suffix_array = array('I','II','III','IV','V','Senior','Junior','Jr','Sr','PhD','APR','RPh','PE','MD','MA','DMD','CME');
    foreach ($suffix_array as $suffix) {
        if (strtolower($suffix) == strtolower($word))
            return $suffix;
    }
    return false;
}

// detect compound last names like "Von Fange"
function is_compound_lname($word) {
    $word = strtolower($word);
    // these are some common prefixes that identify a compound last names - what am I missing?
    $words = array('vere','von','van','de','del','della','di','da','pietro','vanden','du','st.','st','la','ter');
    return array_search($word,$words);
}

// single letter, possibly followed by a period
function is_initial($word) {
    return ((strlen($word) == 1) || (strlen($word) == 2 && $word{1} == "."));
}

// detect mixed case words like "McDonald"
// returns false if the string is all one case
function is_camel_case($word) {
    if (preg_match("|[A-Z]+|s", $word) && preg_match("|[a-z]+|s", $word))
        return true;
    return false;
}

// ucfirst words split by dashes or periods
// ucfirst all upper/lower strings, but leave camelcase words alone
function fix_case($word) {
    // uppercase words split by dashes, like "Kimura-Fay"
    $word = safe_ucfirst("-",$word);
    // uppercase words split by periods, like "J.P."
    $word = safe_ucfirst(".",$word);
    return $word;
}

// helper function for fix_case
function safe_ucfirst($seperator, $word) {
    // uppercase words split by the seperator (ex. dashes or periods)
    $parts = explode($seperator,$word);
    foreach ($parts as $word) {
        $words[] = (is_camel_case($word)) ? $word : ucfirst(strtolower($word));
    }
    return implode($seperator,$words);
}

?>