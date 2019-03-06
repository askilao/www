<?php 

class fullIntegrationCest
{
	private $username, $optional;
    private $password = 'password';

    public function _before(AcceptanceTester $I) {
    	$this->username = md5(date('l jS h:i:s A \of F Y '));
    	$this->optional = md5(date('l jS \of F Y h:i:s A'));
    }

    // tests
    public function tryRegister(AcceptanceTester $I) {
    	$I->amOnPage('/');
        $I->click('Register user');
        $I->fillField('username', $this->username);
        $I->fillField('password', $this->password);
        $I->fillField('optional', $this->optional);
       	$I->click('Register');
       
    }
        public function tryLoginAndThenLogOut(AcceptanceTester $I) {
    	$I->amOnPage('/');
        $I->fillField('username', 'tester2');
        $I->fillField('password', 'test2');
       	$I->click('logg inn');
       	$I->see('User page');
       	$I->click('logg ut');
       	$I->see('Ikke logget inn');
    }
}
