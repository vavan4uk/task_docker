<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Login');
        $I->see('Register');
        
        
        #tets login page
        $I->amOnPage('/login');
        $I->see('Sign In');
        
        
        #tets login page
        $I->amOnPage('/tasks');
        $I->see('Login');
        $I->see('Register');
        
        
        
        #tets login page
        $I->amOnPage('/register');
        $I->see('Sign Up');
        
        
        
        
        
        $emails = array(
            'asd',
            'as@ddd',
            'as @ddd',
            'as@ ddd',
            'as @ ddd.com',
            'as @ddd.com',
            'as @ddd. com',
            'test@gmail.com'
        );
        $testpassword = 'aaaaaa';
        
        
        foreach( $emails as $k=>$v ){
                $email = $v;
                if( $v=='test@gmail.com' ){
                    $email = time().$k.$v;
                }
                $I->fillField(['name' => 'user[email]'], $email);
                $I->fillField(['name' => 'user[password][first]'], $testpassword);
                $I->fillField(['name' => 'user[password][second]'], $testpassword);
                $I->click("Sign Up");         
                
                
                if( $v=='test@gmail.com' ){
                    $I->see("Logout");
                    
                }
                else{
                    $I->see("This value is not a valid email address");
                }
                    
                
                //$I->seeElement(".form-error-icon");
        }
        
        
        $I->click("Logout");
        $I->amOnPage('/register');
        $testpassword1 = 'aaa';
        $testpassword2 = '';
        $I->fillField(['name' => 'user[email]'], 'regtest'.time().'@gmail.com');
        $I->fillField(['name' => 'user[password][first]'], $testpassword1);
        $I->fillField(['name' => 'user[password][second]'], $testpassword2);
        $I->click("Sign Up");
        $I->see("value is not valid");
        
        
        
        
        $testpassword1 = 'aaa';
        $testpassword2 = 'aaa';
        $I->fillField(['name' => 'user[email]'], 'regtest'.time().'@gmail.com');
        $I->fillField(['name' => 'user[password][first]'], $testpassword1);
        $I->fillField(['name' => 'user[password][second]'], $testpassword2);
        $I->click("Sign Up");
        $I->see("This value is too short");
        
        
        
        
        $testpassword1 = '';
        $testpassword2 = 'aaa';
        $I->fillField(['name' => 'user[email]'], 'regtest'.time().'@gmail.com');
        $I->fillField(['name' => 'user[password][first]'], $testpassword1);
        $I->fillField(['name' => 'user[password][second]'], $testpassword2);
        $I->click("Sign Up");
        $I->see("value is not valid");
        
        
        
        
        
        $testpassword1 = 'aaaaaa';
        $testpassword2 = 'bbbbbb';
        $I->fillField(['name' => 'user[email]'], 'regtest'.time().'@gmail.com');
        $I->fillField(['name' => 'user[password][first]'], $testpassword1);
        $I->fillField(['name' => 'user[password][second]'], $testpassword2);
        $I->click("Sign Up");
        $I->see("value is not valid");
        
        
        
        
        $testpassword1 = 'aaaaaa';
        $testpassword2 = 'aaaaaa';
        $I->fillField(['name' => 'user[email]'], 'regtest'.time().'@gmail.com');
        $I->fillField(['name' => 'user[password][first]'], $testpassword1);
        $I->fillField(['name' => 'user[password][second]'], $testpassword2);
        $I->click("Sign Up");
        $I->see("Logout");
        
        
        
        
        
            
    }
}
