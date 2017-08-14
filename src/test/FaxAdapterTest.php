<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 12:03
 */

namespace src\test;

use src\adapter\FaxAdapter;
use src\entity\Fax;

class FaxAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testInsert()
    {
        $faxAdapter = new FaxAdapter();
        $fax = new Fax();
        $fax->setFaxNumber(1234);
        $faxAdapter->insert($fax);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "INSERT INTO Fax(faxNumber) VALUES('1234')";
        $this->assertEquals($expectedSql, $actualSql);

        $fax->setFaxNumber(1234);
        $fax->setPersonid(1);
        $faxAdapter->insert($fax);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "INSERT INTO Fax(personid,faxNumber) VALUES('1','1234')";
        $this->assertEquals($expectedSql, $actualSql);
    }

    public function testUpdate(){
        $fax = new Fax();
        $fax->setId(1);
        $fax->setFaxNumber(12345);
        $fax->setPersonid(2);

        $faxAdapter = new FaxAdapter();
        $faxAdapter->update($fax);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "UPDATE Fax SET personid='2',faxNumber='12345' WHERE id='1'";
        $this->assertEquals($expectedSql, $actualSql);
    }

    public function testSelect(){
        $faxAdapter = new FaxAdapter();
        $faxAdapter->select("Fax",null);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "SELECT * FROM Fax";
        $this->assertEquals($expectedSql, $actualSql);

        $params = array(
            "id" => '5',
            "AND" => array(
                "root" => 5,
            ),
            "OR" => array(
                "asd" => 7
            )
        );

        $faxAdapter = new FaxAdapter();
        $faxAdapter->select("Fax",$params);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "SELECT * FROM Fax WHERE id='5' AND root='5' OR asd='7'";
        $this->assertEquals($expectedSql, $actualSql);
    }

    public function testDelete(){
        $fax = new Fax();
        $fax->setId(1);
        $fax->setFaxNumber(12345);
        $fax->setPersonid(2);

        $faxAdapter = new FaxAdapter();
        $faxAdapter->delete($fax);
        $actualSql = $faxAdapter->getQuery();
        $expectedSql = "DELETE FROM Fax WHERE id='1'";
        $this->assertEquals($expectedSql, $actualSql);

    }

    public function testFaxScoreForUser(){
        $faxAdapter = new FaxAdapter();
        $actualValue = $faxAdapter->faxScoreForUser(8);
        $expectedValue = "0";
        $this->assertEquals($actualValue,$expectedValue);
    }

    public function testFaxSearch(){
        $faxAdapter = new FaxAdapter();
        $actualValue = $faxAdapter->faxSearch(444,1);
        $expectedValue = array(1);
        $this->assertEquals($actualValue,$expectedValue);
    }


}
