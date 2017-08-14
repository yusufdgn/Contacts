<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 14:35
 */

namespace src\adapter;


use src\entity\Groups;

class GroupsAdapter extends Adapter
{
    /**
     * Kendisine gelen parametreleri kullanarak Gruplar tablosundaki
     * left index ve rightindex sütunlarını tekrardan
     * düzenleme yapan metod.
     * @param $rootId
     * @param $counter
     * @return int
     */
    public function updateIndex($rootId,$counter){
        $params = ["groupRoot"=>$rootId];
        $this->select("Groups", $params);
        $this->execute();
        $results = $this->getResult();
        if(count($results)>0) {
            foreach ($results as $result){
                $counter += 1;
                $Groups = new Groups();
                $Groups->create($result);
                $Groups->setLeftIndex($counter);
                $counter = $this->updateIndex($Groups->getID(),$counter);
                $counter += 1;
                $Groups->setRightIndex($counter);
                $this->update($Groups);
                $this->execute();
            }
        }
        return $counter;
    }


    public function listGroupWithIndex($leftIndex,$rightIndex){
        $query = "SELECT * FROM Groups WHERE leftindex>$leftIndex AND rightindex<$rightIndex";

        $this->setQuery($query);
        $this->execute();
        return $this->getResult();
    }

    public function getGroupsFilterParent($parent){
        $query = "SELECT * FROM Groups WHERE groupRoot!='$parent' AND id!='$parent'";
        $this->setQuery($query);
        $this->execute();
        return $this->getResult();
    }

    public function deleteGroup($leftIndex,$rightIndex){
        $query = "DELETE FROM Groups WHERE leftindex>='$leftIndex' AND rightindex<='$rightIndex'";

        $this->setQuery($query);
        $this->execute();
        return true;
    }

    public function groupScore()
    {
        $this->setQuery("SELECT COUNT(*) as toplam FROM Groups");
        $this->executeFetch();
        $result = $this->getResult();

        return $result["toplam"];
    }

}