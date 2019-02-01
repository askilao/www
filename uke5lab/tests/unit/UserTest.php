<?php 
require_once "../html/classes/User.php";
require_once "../html/classes/DB.php";
class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $email, $optional, $userdata;
    private $password = 'password';
    private $user;
    private $db;
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
        $this->assertEquals('OK', $data['status'], 'Failed to create user!');
        $contactID = $data['id'];
        $this->assertTrue($contactID>0, 'Error in userID, should be > 0');
        $deleteResult = $this->user->deleteUser($data['id']);
        $this->assertEquals('OK', $data['status'], 'Failed to delete!');
    }
    public function testCanLogIn(){
        $userdata = $this->user->addUser($this->userdata);
        $data = $this->user->login($this->userdata['username'], $this->userdata['password']);
        $this->assertEquals('OK', $data['status'], 'User cant login!');
        $deleteResult = $this->user->deleteUser($userdata['id']);
        $this->assertEquals('OK', $data['status'], 'Failed to delete!');
    }
}