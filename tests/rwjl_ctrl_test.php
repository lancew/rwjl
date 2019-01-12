<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');


require_once('controllers/rwjl.php');
require_once('lib/data.php');


class TestOfRWJL_Controller extends UnitTestCase {



    function testGetBetween() {
        $result = GetBetween('start_the text_end', 'start_', '_end');
        $this->assertEqual($result,'the text', 'GetBetween');
  
    
    
    
    }

    function testJudoinside_profile() {
        $result = Judoinside_profile('SOBIROV Rishod');
        
        
        
        $this->assertEqual($result,'http://www.judoinside.com/judoka/view/2891/toshihiko_koga/');
  
    
    
    
    }



     function testMaintenance_mode() {
        $result = Maintenance_mode('enable');
        $this->assertEqual($result,'Maintenance Mode enabled', 'Maintenance mode enable function called');
        
        $this->assertTrue(file_exists('index.html'), 'index.html creation');
        
        $result = Maintenance_mode('disable');
        $this->assertEqual($result,'Maintenance Mode disabled','Maintenance mode enable function called');
        
        $this->assertFalse(file_exists('index.html'), 'index.html deletion');

        
    }
    
     

    
}

$test = &new TestOfRWJL_Controller();
$test->run(new HtmlReporter());
?>