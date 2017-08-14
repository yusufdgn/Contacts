<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 11:23
 /*
 *
$Adapter = new \src\adapter\FaxAdapter();

$data = array(
    "tableName" => "Person",
    "data" => array(
        "Key1" => "KeyData1",
        "Key2" => "KeyData2"
    )
);
$Fax = new \src\entity\Fax();


$Groups = new \src\entity\Groups();

$className = explode("entity\\", get_class($Groups));
echo $className[1];

$Fax->setId(1);
$Fax->setFaxNumber(11121512);
$Fax->setPersonid(1);
$Groups->setId(1);
$Groups->setRightIndex(1);
$Groups->setLeftIndex(1);
$Groups->setGroupLevel(3);
$Groups->setGroupRoot(4);

$entityMethods = get_class_methods($Groups);
$keyList = null;
$valueList = null;
foreach($entityMethods as $field) {
    if (substr($field, 0, 3) == "get") {
        $value = $Groups->{$field}();
        if ($value != null) {
            $key = lcfirst(str_replace("get", "", $field));
            $valueList[] = $value;
            $keyList[] = $key;
        }
    }
}


$keyQuery = implode(",", $keyList);
$valueQuery = implode(",", $valueList);
echo "<pre>";
print_r($valueQuery);
echo "<pre>";
print_r($keyQuery);
$query = "<br>INSERT INTO " . $className[1] . "(" . $keyQuery . ") VALUES(" . $valueQuery . ")";
echo $query."<br>";

$className = explode("entity\\", get_class($Groups));
$className = $className[1];

$entityMethods = get_class_methods($Groups);
$setUpdateQuery = null;
if (in_array("getId", $entityMethods)) {
    $entityId = $Groups->getId();
    $updateFieldList = null;
    foreach ($entityMethods as $field) {
        if (substr($field, 0, 3) == "get") {
            $value = $Groups->{$field}();
            if ($value != null) {
                $key = lcfirst(str_replace("get", "", $field));
                $updateFieldList[] = $key . "='" . $value . "'";
            }
        }
    }
    $keyQuery = implode(",", $updateFieldList);

    $query = "UPDATE " . $className . " SET " . $keyQuery . " WHERE id='" . $entityId . "'";
    echo $query;


    $params = array(
        "id" => '5',
        "AND" => array(
            "root" => 5,
        ),
        "OR" => array(
            "asd" => 7
        )
    );

    $whereQuery = null;
    if (isset($params)) {
        foreach ($params as $key => $value) {
            $valueType = gettype($value);
            if ($valueType == "array") {
                $whereQuery .= " " . $key . " ";
                $whereList = null;
                foreach ($value as $k => $v) {
                    $whereList[] = $k . "=" . $v;
                }
                $whereQuery .= implode(",", $whereList);
            } else {
                $whereQuery .= $key . "='" . $value . "'";
            }
        }
    }
    echo $whereQuery;
    echo "<br>";

}
 * TEST İçin Kullanılacak Komut
 * phpunit --bootstrap vendor/autoload.php src/test/
 *
 * */



/**
 *
$Fax = new \src\entity\Fax();

$Fax->setFaxNumber(11121512);
$Fax->setPersonid(1);
$Groups = new \src\entity\Groups();


$Groups->setGroupName("GrupAdi");
$Groups->setRightIndex(1);
$Groups->setLeftIndex(1);
$Groups->setGroupLevel(3);
$Groups->setGroupRoot(4);

$faxAdapter = new \src\adapter\FaxAdapter();
$phoneAdapter = new \src\adapter\PhoneAdapter();

$Person = new \src\entity\Person();
$personAdapter = new \src\adapter\PersonAdapter();

$Person->setAdress(2);
$Person->setEmail(3);
$Person->setName(4);
$Person->setWebsite(5);
$Person->setSurname(6);
$Person->setNote(7);
$Person->setUserid(8);

$groupsAdapter = new \src\adapter\GroupsAdapter();
$personGroupAdapter = new \src\adapter\PersonGroupAdapter();
//$personAdapter->insert($Person);
//$personAdapter->execute();

$results = $personAdapter->getPersonsWithID(array(1));
echo "<pre>";
var_dump($results);

$result = $personAdapter->personScoreForUser(8);
echo $result."<br>";

$result = $faxAdapter->faxScoreForUser(8);
var_dump($result);
echo "<br>";

$result = $phoneAdapter->phoneScoreForUser(8);
var_dump($result);
echo "<br>";

$result = $groupsAdapter->updateIndex(0,0);
var_dump($result);
echo "<br>";


$result = $personGroupAdapter->groupsPersons(2);
if($result!=null){
var_dump($result);
}
echo "<br>";

echo "<br> INSERT  ****************** <br>";
$faxAdapter->insert($Groups);
$faxAdapter->execute();

$Groups->setId("2");
$Groups->setGroupName("TESTASD");
$Groups->setRightIndex(2);
$Groups->setLeftIndex(1);
$Groups->setGroupLevel(1);
$Groups->setGroupRoot(0);



echo "<br> Update  ****************** <br>";
$faxAdapter->update($Groups);
$faxAdapter->execute();

echo "<br> SELECT  ****************** <br>";
$faxAdapter->select("Groups",null);
$faxAdapter->execute();

echo "<br> DELETE  ****************** <br>";
$faxAdapter->delete($Groups);
$faxAdapter->execute();
$faxAdapter->getResult();
 *
 **/


