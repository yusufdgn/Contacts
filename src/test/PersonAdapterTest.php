<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 15:55
 */

namespace src\test;


use src\adapter\PersonAdapter;
use src\entity\Person;

class PersonAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPersonsWithID(){
        $personAdapter = new PersonAdapter();
        $actualValue = $personAdapter->getPersonsWithID(array(1));
        $expectedValue = array(array("id"=>1,
            "userid"=>1,
            "name"=>"4",
            "surname"=>"6",
            "adress"=>"2",
            "note"=>"7",
            "website"=>"5",
            "email"=>"3"
        ));
        $this->assertEquals($actualValue,$expectedValue);
    }

    public function testPersonScoreForUser(){
        $personAdapter = new PersonAdapter();
        $actualValue = $personAdapter->personScoreForUser(1);
        $expectedValue = "2";
        $this->assertEquals($actualValue,$expectedValue);
    }

    public function testPersonSearch(){
        $personAdapter = new PersonAdapter();
        $actualValue = $personAdapter->personSearch("TEST",1);
        $expectedValue = array(10);
        $this->assertEquals($actualValue,$expectedValue);
    }

}
