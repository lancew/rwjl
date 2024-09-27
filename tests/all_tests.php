<?php

require_once('vendor/simpletest/simpletest//autorun.php');

class AllTests extends TestSuite
{
    public function AllTests()
    {
        $this->TestSuite('All tests');

        $this->addFile('tests/data_test.php');
        $this->addFile('tests/elo_test.php');
        $this->addFile('tests/rwjl_ctrl_test.php');

        //$this->addFile('tests/bugs.php');
    }
}
