<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 16:36
 */

namespace src\test;


use src\adapter\GroupsAdapter;
use src\entity\Groups;

class GroupsAdapterTest extends \PHPUnit_Framework_TestCase
{

    public function testInsert()
    {
        $groupsAdapter = new GroupsAdapter();
        $groups = new Groups();
        $groups->setGroupName("AA");
        $groups->setRightIndex(4);
        $groups->setLeftIndex(5);
        $groups->setGroupRoot(1);
        $groups->setGroupLevel(2);

        $groupsAdapter->insert($groups);
        $actualSql = $groupsAdapter->getQuery();
        $expectedSql = "INSERT INTO Groups(groupName,leftIndex,rightIndex,groupRoot,groupLevel) VALUES('AA','5','4','1','2')";
        $this->assertEquals($expectedSql, $actualSql);

    }

    public function testUpdate(){
        $groupsAdapter = new GroupsAdapter();
        $groups = new Groups();
        $groups->setId(3);
        $groups->setGroupName("AA");
        $groups->setRightIndex(4);
        $groups->setLeftIndex(5);
        $groups->setGroupRoot(1);
        $groups->setGroupLevel(2);

        $groupsAdapter->update($groups);
        $actualSql = $groupsAdapter->getQuery();
        $expectedSql = "UPDATE Groups SET groupName='AA',leftIndex='5',rightIndex='4',groupRoot='1',groupLevel='2' WHERE id='3'";
        $this->assertEquals($expectedSql, $actualSql);
    }

    public function testUpdateIndex(){
        $groupAdapter = new GroupsAdapter();
        $actualValue = $groupAdapter->updateIndex(0,0);
        $expectedValue = "4";
        $this->assertEquals($actualValue,$expectedValue);
    }

}
