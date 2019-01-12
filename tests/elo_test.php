<?php
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('lib/mc-elo-calculator.php');



class TestOfELO extends UnitTestCase {

     function testELO() {
        $elo_calculator=&new elo_calculator;
        $results=$elo_calculator->rating(100, 90, 1500, 1500, 40);
        $this->assertEqual($results['R3'],1510, 'equal win at 1500');
        
        $elo_calculator=&new elo_calculator;
        $results=$elo_calculator->rating(1, 0, 1500, 1500, 40);
        $this->assertEqual($results['R3'],1510);
        
    }

    
}

$test = &new TestOfELO();
$test->run(new HtmlReporter());
?>