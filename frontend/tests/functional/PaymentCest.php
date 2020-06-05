<?php namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class PaymentCest
{
    public function _before(FunctionalTester $I)
    {
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
    // tests
    public function tryToOrder(FunctionalTester $I)
    {

        $I->amOnPage('site/login');
        $I->submitForm('#login-form', $this->formParams('VascoxD', '1231234'));

        $I->amOnPage('index');
        $I->click('.experience_test');

        $I->submitForm('#order-form', [
            'Order[guest_number]' => 1,
            'Order[experience_time]' => "2019-02-20",
            'Order[id_user]' => 53,
            'Order[id_experiences_type]' => 3,
            'Order[data_order]' => date("Y-m-d H:i:s")

        ]);

        $I->see('CHECKOUT');
        $I->click('#button-to-payment');

        $I->see('Payment Details');

    }

}
