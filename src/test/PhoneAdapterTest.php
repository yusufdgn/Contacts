<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 16:40
 */

namespace src\test;


use src\adapter\PhoneAdapter;

class PhoneAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testPhoneScoreForUser(){
        $phoneAdapter = new PhoneAdapter();
        $actualValue = $phoneAdapter->phoneScoreForUser(8);
        $expectedValue = "0";
        $this->assertEquals($actualValue,$expectedValue);
    }

    public function testPhoneSearch(){
        $phoneAdapter = new PhoneAdapter();
        $actualValue = $phoneAdapter->phoneSearch(444,1);
        $expectedValue = array(1);
        $this->assertEquals($actualValue,$expectedValue);
    }

}
