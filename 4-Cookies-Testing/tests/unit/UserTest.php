<?php 
require_once "./classes/User.php";
require_once "./classes/DB.php";
class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $email, $optional, $userdata;
    private $password = 'password';
    private $user;

    protected function _before(){
        $db = DB::getDBConnection();
        $this->email = md5(date('l jS \of F Y h:i:s A'));
        $this->optional = md5(date('l jS h:i:s A \of F Y '));
        $this->userdata['username'] = $this->email;
        $this->userdata['optional'] = $this->optional;
        $this->userdata['password'] = $this->password;
        $this->user = new User($db);
    }

    protected function _after(){
    }

    // tests
    public function testCreateUser(){
        $data = $this->user->addUser($this->userdata);
        $this->assertEquals('OK', $result['status'], 'Failed to create user');
        $contactID = $data['id'];
        $this->assertTrue($contactID>0, 'Error in userID, should be > 0');


    }
}
