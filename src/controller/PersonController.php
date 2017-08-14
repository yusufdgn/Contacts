<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 09.08.2017
 * Time: 13:01
 */

namespace src\controller;
use src\adapter\FaxAdapter;
use src\adapter\PersonAdapter;
use src\adapter\PersonGroupAdapter;
use src\adapter\PhoneAdapter;
use src\adapter\GroupsAdapter;
use src\adapter\UserAdapter;
use src\entity\Person;
use src\entity\PersonGroup;
use src\entity\Phone;
use src\entity\Fax;
use src\entity\User;

class PersonController
{
    public function score(){
        /**
         * Person Score
         */
        $userController = new UserController();
        $params = $userController->getSession();

        $personAdapter = new PersonAdapter();
        $personTest = $personAdapter->personScoreForUser($params);

        /**
         * Fax Score
         */
        $faxAdapter = new FaxAdapter();
        $faxScore = $faxAdapter->faxScoreForUser($params);

        /**
         * Phone Score
         */
        $phoneAdapter = new PhoneAdapter();
        $phoneScore = $phoneAdapter->phoneScoreForUser($params);


        $groupAdapter = new GroupsAdapter();
        $groupScore = $groupAdapter->groupScore();

        $score = array("personScore"=>$personTest, "faxScore"=>$faxScore, "phoneScore"=>$phoneScore, "groupScore"=>$groupScore);


        return $score;
    }

    public function select(){
        $personAdapter = new PersonAdapter();
        $personAdapter->select("Person", null);
        $personAdapter->execute();
        $personResults = $personAdapter->getResult();
        $personList = null;
        foreach($personResults as $person){
            $personList[] = $person;
        }

        return ["persons"=>$personList];
    }

    public function selectPerson(){
        $personAdapter = new PersonAdapter();
        $userController = new UserController();
        $params = ["userid"=>$userController->getSession()];
        $personAdapter->select("Person", $params);
        $personAdapter->execute();
        $personResults = $personAdapter->getResult();
        $personList = null;
        foreach($personResults as $person){
            $id = $person["id"];
            $params = ["personid"=>$id];

            $personAdapter->select("Phone",$params);
            $personAdapter->executeFetch();
            $phoneResult = $personAdapter->getResult();

            $personAdapter->select("Fax",$params);
            $personAdapter->executeFetch();
            $faxResult = $personAdapter->getResult();

            $person["fax"] = $faxResult["faxNumber"];
            $person["phone"] = $phoneResult["phoneNumber"];

            $personList[] = $person;
        }

        return ["persons"=>$personList];
    }

    public function searchView($id){
        $params = ["id"=>$id];
        $personAdapter = new PersonAdapter();
        $personAdapter->select("Person", $params);
        $personAdapter->executeFetch();
        $person = $personAdapter->getResult();

            $params = ["personid"=>$id];

            $personAdapter->select("Phone",$params);
            $personAdapter->executeFetch();
            $phoneResult = $personAdapter->getResult();

            $personAdapter->select("Fax",$params);
            $personAdapter->executeFetch();
            $faxResult = $personAdapter->getResult();

            $person["fax"] = $faxResult["faxNumber"];
            $person["phone"] = $phoneResult["phoneNumber"];


        return $person;
    }


    public function viewPerson($id){
        $params = ["id"=>$id];
        $personAdapter = new PersonAdapter();
        $personAdapter->select("Person",$params);
        $personAdapter->executeFetch();
        $personResult = $personAdapter->getResult();

        $params = ["personid"=>$personResult["id"]];

        $phoneAdapter = new PhoneAdapter();
        $phoneAdapter->select("Phone",$params);
        $phoneAdapter->execute();
        $phoneResult = $phoneAdapter->getResult();

        $faxAdapter = new FaxAdapter();
        $faxAdapter->select("Fax", $params);
        $faxAdapter->execute();
        $faxResult = $faxAdapter->getResult();

        return ["person"=>$personResult,"phones"=>$phoneResult,"fax"=>$faxResult];
    }

    public function newPerson(){
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

    public function addPerson(){
        $name = $_POST["name"];

        $userAdapter = new UserController();
        $userid = $userAdapter->getSession();

        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $website = $_POST["website"];
        $note = $_POST["note"];
        $tel = $_POST["phones"];
        $fax = $_POST["fax"];

        $Person = new Person();
        $Person->setName($name);
        $Person->setUserid($userid);
        $Person->setSurname($surname);
        $Person->setEmail($email);
        $Person->setNote($address);
        $Person->setWebsite($website);
        $Person->setAdress($note);
        $warningData = array();
        $hatavarMi = false;

        if(!is_string($name) || empty($name) || strlen($name)>40){
            $warningData[] = ["message"=>"İsminizi hatalı girdiniz.."];
            $hatavarMi = true;
        }

        if(!is_string($surname) || empty($surname) || strlen($surname)>40){
            $warningData[] = ["message"=>"Soyadınızı hatalı girdiniz.."];
            $hatavarMi = true;
        }

        if(!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $warningData[] = ["message"=>"Email hatalı girildi."];
                $hatavarMi = true;
            }
        }

        if(!empty($website)){
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                $warningData[] = ["message"=>"Web sitesi hatalı girildi"];
                $hatavarMi = true;
            }
        }

        $kacinci = 1;
        foreach ($tel as $no){
            if(!is_numeric($no) || empty($no) || strlen($no)>12 || strlen($no)<10){
                $warningData[] = ["message"=>$kacinci.". Telefon numarası hatalı girildi.."];
                $hatavarMi = true;
            }
            $kacinci++;
        }

        $kacinci = 1;
        foreach ($fax as $no){
            if(!is_numeric($no) || empty($no) || strlen($no)>12 || strlen($no)<10){
                $warningData[] = ["message"=>$kacinci.". Fax numarası hatalı girildi.."];
                $hatavarMi = true;
            }
            $kacinci++;
        }
        if($hatavarMi){
            return ["status"=>"warning", "data"=>$warningData];
        }
        try {
            $personAdapter = new PersonAdapter();
            $personAdapter->insert($Person);
            $personAdapter->execute();

            $lastId = $personAdapter->lastId();
            $personGroupAdapter = new PersonGroupAdapter();
            foreach ($_POST["groups"] as $group) {
                $PersonGroup = new PersonGroup();
                $PersonGroup->setPersonId($lastId);
                $PersonGroup->setGroupId($group);

                $personGroupAdapter->insert($PersonGroup);
                $personGroupAdapter->execute();
            }

            $phoneAdapter = new PhoneAdapter();
            foreach ($_POST["phones"] as $phn) {
                $Phone = new Phone();
                $Phone->setPersonid($lastId);
                $Phone->setPhoneNumber($phn);

                $phoneAdapter->insert($Phone);
                $phoneAdapter->execute();
            }

            $faxAdapter = new FaxAdapter();
            foreach ($_POST["fax"] as $fx) {
                $fax = new Fax();
                $fax->setPersonid($lastId);
                $fax->setFaxNumber($fx);

                $faxAdapter->insert($fax);
                $faxAdapter->execute();
            }
            return ["status"=>"ok"];
        }
        catch (\Exception $e){
            return ["status"=>"error"];

        }
    }


    public function editPerson($id){

        $params = ["id"=>$id];
        $personAdapter = new PersonAdapter();
        $personAdapter->select("Person",$params);
        $personAdapter->executeFetch();
        $personResult = $personAdapter->getResult();

        $params = ["personid"=>$personResult["id"]];

        $phoneAdapter = new PhoneAdapter();
        $phoneAdapter->select("Phone",$params);
        $phoneAdapter->execute();
        $phoneResult = $phoneAdapter->getResult();

        $faxAdapter = new FaxAdapter();
        $faxAdapter->select("Fax", $params);
        $faxAdapter->execute();
        $faxResult = $faxAdapter->getResult();

        $groupAdapter = new GroupsAdapter();
        $groupAdapter->select("Groups",null);
        $groupAdapter->execute();
        $allGroups = $groupAdapter->getResult();

        $personGroupAdapter = new PersonGroupAdapter();
        $personGroupAdapter->select("PersonGroup",$params);
        $personGroupAdapter->execute();
        $selectedGroups = $personGroupAdapter->getResult();

        $sgArray = null;
        foreach ($selectedGroups as $sg){
            $sgArray[] = $sg["groupId"];
        }

        return [
            "person"=>$personResult,
            "phones"=>$phoneResult,
            "fax"=>$faxResult,
            "allGroups"=>$allGroups,
            "selGroups"=>$sgArray
               ];
    }

    public function checkEditPerson(){
        $id = $_POST["id"];
        $name = $_POST["name"];
        $userid = $_POST["userid"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $website = $_POST["website"];
        $note = $_POST["note"];
        $tel = $_POST["phones"];
        $fax = $_POST["fax"];

        $warningData = array();
        $hatavarMi = false;

        if(!is_string($name) || empty($name) || strlen($name)>40){
            $warningData[] = ["message"=>"İsminizi hatalı girdiniz.."];
            $hatavarMi = true;
        }

        if(!is_string($surname) || empty($surname) || strlen($surname)>40){
            $warningData[] = ["message"=>"Soyadınızı hatalı girdiniz.."];
            $hatavarMi = true;
        }

        if(!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $warningData[] = ["message"=>"Email hatalı girildi."];
                $hatavarMi = true;
            }
        }
        if(!empty($website)){
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                $warningData[] = ["message"=>"Web sitesi hatalı girildi"];
                $hatavarMi = true;
            }
        }

        $kacinci = 1;
        foreach ($tel as $no){
            if(!is_numeric($no) || empty($no) || strlen($no)>12 || strlen($no)<10){
                $warningData[] = ["message"=>$kacinci.". Telefon numarası hatalı girildi.."];
                $hatavarMi = true;
            }
            $kacinci++;
        }

        $kacinci = 1;
        foreach ($fax as $no){
            if(!is_numeric($no) || empty($no) || strlen($no)>12 || strlen($no)<10){
                $warningData[] = ["message"=>$kacinci.". Fax numarası hatalı girildi.."];
                $hatavarMi = true;
            }
            $kacinci++;
        }
        if($hatavarMi){
            return ["status"=>"warning", "data"=>$warningData];
        }


        $person = new Person();
        $person->setId($id);
        $person->setUserid($userid);
        $person->setName($name);
        $person->setSurname($surname);
        $person->setWebsite($website);
        $person->setEmail($email);
        $person->setNote($note);
        $person->setAdress($address);

        $personAdapter = new PersonAdapter();
        $personAdapter->update($person);
        $personAdapter->execute();

        $delete = ["personid" => $person->getId()];
        $personAdapter->deleteWhereId("Phone",$delete);
        $personAdapter->execute();

        $personAdapter->deleteWhereId("Fax",$delete);
        $personAdapter->execute();

        $personAdapter->deleteWhereId("PersonGroup",$delete);
        $personAdapter->execute();

        foreach ($_POST["phones"] as $phn){
            $phone = new Phone();
            $phone->setPhoneNumber($phn);
            $phone->setPersonid($person->getId());

            $phoneAdapter = new PhoneAdapter();
            $phoneAdapter->insert($phone);
            $phoneAdapter->execute();
        }

        foreach ($_POST["fax"] as $fx){
            $fax = new Fax();
            $fax->setFaxNumber($fx);
            $fax->setPersonid($person->getId());

            $faxAdapter = new FaxAdapter();
            $faxAdapter->insert($fax);
            $faxAdapter->execute();
        }

        foreach ($_POST["groups"] as $gp){
            $personGroup = new PersonGroup();
            $personGroup->setGroupId($gp);
            $personGroup->setPersonId($person->getId());

            $personGroupAdapter = new PersonGroupAdapter();
            $personGroupAdapter->insert($personGroup);
            $personGroupAdapter->execute();
        }

        return["status"=>"ok"];
    }

    public function checkDeletePerson(){
        $id = $_POST["id"];

        $delete = ["id" => $id];
        $personAdapter = new PersonAdapter();
        $personAdapter->deleteWhereId("Person", $delete);
        $personAdapter->execute();

        $delete = ["personid" => $id];
        $personAdapter->deleteWhereId("Phone",$delete);
        $personAdapter->execute();

        $personAdapter->deleteWhereId("Fax",$delete);
        $personAdapter->execute();

        $personAdapter->deleteWhereId("PersonGroup",$delete);
        $personAdapter->execute();
        return ["status"=>"ok"];
    }

    public function searchResult(){
        $q = $_POST["q"];
        $userAdapter = new UserAdapter();
        $userController = new UserController();

        $personAdapter = new PersonAdapter();
        $personResult = $personAdapter->personSearch($q,$userController->getSession());

        $phoneAdapter = new PhoneAdapter();
        $phoneResult = $phoneAdapter->phoneSearch($q, $userController->getSession(),$personResult);

        $faxAdapter = new FaxAdapter();
        $faxResult = $faxAdapter->faxSearch($q, $userController->getSession(),$phoneResult);

        $allResults = $faxResult;

        $person = null;

        foreach ($allResults as $id){
            $person[] = $this->searchView($id);
        }

        return ["search"=>$person];
    }

}