<?php

namespace src\test;

use src\adapter\PersonGroupAdapter;
use src\entity\Person;

/**
 * Class PersonGroupAdapterTest
 * @package src\test
 */
class PersonGroupAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * test groups persons
     */
    public function testGroupsPersons()
    {
        $personGroupAdapterMock = $this->getMockBuilder(PersonGroupAdapter::class)
            ->disableOriginalConstructor()
            ->setMethods(['select', 'executeFetch', 'getResult', 'setQuery', 'execute'])
            ->getMock();
        $groupId = 10;
        $params = array('id'=> $groupId);

        $personGroupAdapterMock->expects($this->once())->method('select')->with(
            $this->equalTo("Groups"),
            $this->equalTo($params)
        );

        $personGroupAdapterMock->expects($this->once())->method('executeFetch')->willReturnSelf();
        $result = [
            "id"    =>  5,
            "groupName" =>  "yusuf",
            "leftIndex" =>  5,
            "rightIndex"    =>  6,
            "groupRoot" =>  2,
            "groupLevel"    => 2

        ];

        $personGroupAdapterMock->expects($this->at(2))->method('getResult')->willReturn($result);

        $query = "SELECT * FROM Groups WHERE leftIndex>=5 AND rightIndex<=6";

        $personGroupAdapterMock->expects($this->at(3))->method('setQuery')->with($this->equalTo($query));
        $personGroupAdapterMock->expects($this->at(4))->method('execute');
        $result2 = [["id"   =>  5]];

        $personGroupAdapterMock->expects($this->at(5))->method('getResult')->willReturn($result2);

        $personQuery = "
            SELECT * FROM Person
            LEFT JOIN PersonGroup 
            ON Person.id = PersonGroup.personId 
            LEFT JOIN Groups ON Groups.id = PersonGroup.groupId 
            WHERE PersonGroup.groupId=5";

        $personGroupAdapterMock->expects($this->at(6))->method('setQuery')->with($this->equalTo($personQuery));
        $personGroupAdapterMock->expects($this->at(7))->method('execute');

        $result3 = [[
            "personId"  =>  6,
            "id"    =>  5,
            "userid"    =>  3,
            "name"  =>  "yusuf",
            "surname"   =>  "dogan",
            "adress"    =>  "kocaeli",
            "website"   =>  "website",
            "email"     =>  "email",
            "note"      =>  "note"
        ]];

        $personGroupAdapterMock->expects($this->at(8))->method('getResult')->willReturn($result3);

        $person = new Person();
        $person->setId(5);
        $person->setUserid(3);
        $person->setName("yusuf");
        $person->setSurname("dogan");
        $person->setAdress("kocaeli");
        $person->setWebsite("website");
        $person->setEmail("email");
        $person->setNote("note");
        $expectedResult[] = $person;
        $finalResult = $personGroupAdapterMock->groupsPersons(10);


        $this->assertEquals($expectedResult, $finalResult);
    }
}
