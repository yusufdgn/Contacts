<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 09.08.2017
 * Time: 13:01
 */
namespace src\controller;

use src\adapter\GroupsAdapter;
use src\entity\Groups;

class GroupsController
{
    public function select(){
        $GroupsAdapter = new GroupsAdapter();
        $GroupsAdapter->select("Groups", null);
        $GroupsAdapter->execute();
        $groups = $GroupsAdapter->getResult();
        $groupList =null;

        foreach($groups as $group){
            $groupList[] = $group;

        }
        return [
            "groups" => $groupList
        ];
    }

    public function deleteGroups(){
        $GroupsAdapter = new GroupsAdapter();
        $GroupsAdapter->select("Groups", null);
        $GroupsAdapter->execute();
        $groups = $GroupsAdapter->getResult();
        $groupList =null;

        foreach($groups as $group){
            $groupList[] = $group;

        }
        return [
            "groups" => $groupList
        ];
    }

    public function checkAddGroup(){
        try {

            $groupAdapter = new GroupsAdapter();

            $parentGroup = array("id" => $_POST["parentGroup"]);
            $groupAdapter->select("Groups", $parentGroup);
            $groupAdapter->executeFetch();
            $result = $groupAdapter->getResult();
            $groupLevel = $result["groupLevel"] + 1;

            $group = new Groups();
            $group->setGroupName($_POST["groupName"]);
            $group->setGroupRoot($_POST["parentGroup"]);
            $group->setLeftIndex(1);
            $group->setRightIndex(2);
            $group->setGroupLevel($groupLevel);

            $groupAdapter->insert($group);

            $groupAdapter->execute();
            $groupAdapter->updateIndex(1, 1);

            return ["status" => "ok"];
        }
        catch(\Exception $e){
            return ["status" => "error"];
        }
    }

    public function getGroups($leftIndex,$rightIndex){
        if ($leftIndex != null && $leftIndex != null) {

            $GroupsAdapter = new GroupsAdapter();

            $bol = explode("/", $rightIndex);
            $rightIndex = $bol[1];

            $groups = $GroupsAdapter->listGroupWithIndex($leftIndex, $rightIndex);

            $groupList = null;
            foreach ($groups as $group) {
                $groupList[] = $group;

            }
            return [
                "groups" => $groupList
            ];
        }
        {
            $params = array("groupLevel" => 2);
            $GroupsAdapter = new GroupsAdapter();
            $GroupsAdapter->select("Groups", $params);
            $GroupsAdapter->execute();
            $groups = $GroupsAdapter->getResult();
            $groupList = null;


            foreach ($groups as $group) {
                $groupList[] = $group;

            }
            return [
                "groups" => $groupList
            ];
        }
    }

    public function getGroupForEdit($id){
        $GroupsAdapter = new GroupsAdapter();
        $params = array("id"=>$id);
        $GroupsAdapter->select("Groups",$params);
        $GroupsAdapter->executeFetch();
        $group = $GroupsAdapter->getResult();

        $groups = $GroupsAdapter->getGroupsFilterParent($id);

        return ["group" => $group, "groups"=>$groups];
    }

    public function getGroupForDelete($id){
        $GroupsAdapter = new GroupsAdapter();
        $params = array("id"=>$id);
        $GroupsAdapter->select("Groups",$params);
        $GroupsAdapter->executeFetch();
        $group = $GroupsAdapter->getResult();


        return ["group" => $group];
    }

    public function checkEditGroup(){
        try {
            $group = new Groups();
        $groupAdapter = new GroupsAdapter();

        $group->setId($_POST["groupId"]);
        $group->setGroupName($_POST["groupName"]);
        $group->setGroupRoot($_POST["parentGroup"]);
        $group->setRightIndex(0);
        $group->setLeftIndex(0);

        $params = array("id"=>$_POST["parentGroup"]);
        $groupAdapter->select("Groups",$params);
        $groupAdapter->executeFetch();
        $parentGroup = $groupAdapter->getResult();
        $group->setGroupLevel($parentGroup["groupLevel"]+1);

        $groupAdapter->update($group);
        $groupAdapter->execute();
        $groupAdapter->updateIndex(1,1);
        return ["status"=>"ok"];
        }
        catch (\Exception $e){
            return ["status"=>"error"];
        }
    }

    public function checkDeleteGroup(){
        $params = array("id"=>$_POST["groupId"]);
        try {
            $groupAdapter = new GroupsAdapter();
            $groupAdapter->select("Groups", $params);
            $groupAdapter->executeFetch();
            $groupResult = $groupAdapter->getResult();

            $leftIndex = $groupResult["leftIndex"];
            $rightIndex = $groupResult["rightIndex"];

            $groupAdapter->deleteGroup($leftIndex, $rightIndex);
            return ["status"=>"ok"];
        }
        catch (\Exception $e){
            return ["status"=>"error"];
        }
    }

}