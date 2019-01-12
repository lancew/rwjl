<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/data.php');

class TestOfDataModel extends UnitTestCase {

    
    function testDB_create() {
        $result = Db_create('test1', 1, '-81', 'NZL', 1, 0);
		$this->assertEqual($result,' inserted', 'Insert new user');
		Db_delete('test1');

        $result = Db_create('test1', 1, '-81', 'NZL', 1, 0);
		$result = Db_create('test1', 1, '-81', 'NZL', 1, 0);
		$this->assertEqual($result,'Player already exists', 'Insert same user a second time');
		Db_delete('test1');
	}
	
	
	function testFind_name() {
	 Db_create('test1', 1, '-81', 'NZL', 1, 0);
	 $result = Find_name('test1');
	 $this->assertEqual($result,1, 'Find_name found user succeeded');
	 $result = Find_name('test2');
	 $this->assertEqual($result,0, 'Find_name reported name not found succeeded');
	 Db_delete('test1');
	}

    function testGet_rank() {
        Db_create('test1', 1, '-81', 'NZL', 1, 0);
        $result = Get_rank('test1');
        $this->assertEqual($result,1500, 'Get_rank');
        Db_delete('test1');
    }
    
    function testGet_data() {
        Db_create('test1', 1, '-81', 'NZL', 1, 0);
        $result = Get_data('test1');
        $this->assertEqual($result,1500, 'Get_data (default category)');
        Db_delete('test1');
        
    }
    
    
    function testFix_playernames() {
        
        $result = Fix_playernames("a'a");
        $this->assertEqual($result,'aa', 'Fix_playername apostrophe');
        
        $result = Fix_playernames("a1a234567890");
        $this->assertEqual($result,'aa', 'Fix_playername digits');
        
        $result = Fix_playernames('a€a');
        $this->assertEqual($result,'aa', 'Fix_playername accents');
        
        $result = Fix_playernames('a,a');
        $this->assertEqual($result,'aa', 'Fix_playername commas');
        
        $result = Fix_playernames('AL QUBAISI Khalifa');
        $this->assertEqual($result,'ALQUBAISI Khalifa', 'Fix_playername AL QUBAISI Khalifa');
        
        $result = Fix_playernames('CHOI Woosu');
        $this->assertEqual($result,'CHOI Sean', 'Fix_playername CHOI Sean');
        
        $result = Fix_playernames('ASKEL…F Sanna');
        $this->assertEqual($result,'ASKELF Sanna', 'Fix_playername ASKEL…F Sanna');
        

    }
    
    
    function testLoad_Judoinside_data()
    {
        $result = Load_Judoinside_data();
        $this->assertEqual($result[1][1],'Abdelakher');
    
    }
    
    
   
    
   /* 
    function testGet_category_strength_1() {
        $data = file_get_contents('http://dev.rwjl/get_file/ijf/world/wc2010/-78');
        $result = Get_category_strength();
        echo $result;
		$this->assertEqual($result,(float)0.25191666666667, 'Get_Category_Strength');
	}
	*/
		
    
}

$test = &new TestOfDataModel();
$test->run(new HtmlReporter());
?>