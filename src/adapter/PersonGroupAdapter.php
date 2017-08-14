<?php

namespace src\adapter;

use src\entity\Groups;
use src\entity\Person;

class PersonGroupAdapter extends Adapter
{
    /**
     * Group id bilgisine göre kendisine alt gruplarına
     * kayıtlı kişileri geri döndüren metod.
     * @param $groupID
     * @return array
     */
    public function groupsPersons($groupID, $userId)
    {
        $params = array('id' => $groupID);
        $personGroups = array();
        $allData[] = null;


        $this->select("Groups", $params);

        $this->executeFetch();
        $result = $this->getResult();
        $Groups = new Groups();
        $Groups->create($result);

        $leftIndex = $Groups->getLeftIndex();
        $rightIndex = $Groups->getRightIndex();


        $query = "SELECT * FROM Groups WHERE leftIndex>=$leftIndex AND rightIndex<=$rightIndex";

        $this->setQuery($query);
        $this->execute();
        $results = $this->getResult();
        foreach ($results as $result) {
            $groupID = $result["id"];
            $personQuery = "
            SELECT * FROM Person
            LEFT JOIN PersonGroup 
            ON Person.id = PersonGroup.personId 
            LEFT JOIN Groups ON Groups.id = PersonGroup.groupId 
            WHERE PersonGroup.groupId=$groupID";
            $this->setQuery($personQuery);
            $this->execute();

            $personResults = $this->getResult();

            foreach ($personResults as $personResult) {
                if($userId == $personResult["userid"]) {
                    $personID = $personResult["personId"];
                    if (!in_array($personID, $allData)) {
                        $personGroupAdapter = new GroupsAdapter();
                        $params = ["personid" => $personID];
                        $personGroupAdapter->select("Phone", $params);
                        $personGroupAdapter->executeFetch();
                        $phoneResult = $personGroupAdapter->getResult();

                        $personGroupAdapter->select("Fax", $params);
                        $personGroupAdapter->executeFetch();
                        $faxResult = $personGroupAdapter->getResult();

                        $personResult["fax"] = $faxResult["faxNumber"];
                        $personResult["phone"] = $phoneResult["phoneNumber"];

                        $personGroups[] = $personResult;

                    }
                }
            }
        }

        return $personGroups;
    }
}