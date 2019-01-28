<?php
require_once "classes/User.php";
require_once "classes/DB.php";
class dbconnectTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCanConnectToDatabase(){
        $this->assertInstanceOf(
            PDO::class, DB::getDBConnection()
        );

    }
}
