<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 13:56
 */

namespace src\adapter;


use src\entity\Groups;

class PersonAdapter extends Adapter
{
    /**
     * Kendisine gelen Person id dizisini kullanarak
     * person bilgilerini geri döndüren metod
     * @param $personIdList array
     * @return array|null
     *
     */
    public function getPersonsWithID($personIdList)
    {
        $personList = null;
        $personIdList = implode(",", $personIdList);

            $this->setQuery("SELECT * FROM Person WHERE id IN ($personIdList)");
            $this->execute();
            $results = $this->getResult();
            foreach($results as $result){
                $personList[] = $result;
            }
            return $personList;
    }

    /**
     * kendisine gelen kullanıcı id bilgisine göre
     * kullanıcının eklediği kisilerin toplamını veren fonksiyon.
     * @param $userId
     * @return mixed
     */
    public function personScoreForUser($userId)
    {
        $this->setQuery("SELECT COUNT(*) as toplam FROM Person WHERE userid='$userId'");
        $this->executeFetch();
        $result = $this->getResult();

        return $result["toplam"];
    }

    /**
     * Person tablosunda gelen arama textine göre
     * bulduğu kayıtların id bilgilerini geri döndüren fonksiyon.
     * @param $q
     * @param $uid
     * @return array
     */
    public function personSearch($q,$uid){
        $matchQuery = "name, surname";
        $this->select("Person", null);
        $this->withAgainst($matchQuery,$q);
        $this->execute();
        $searchResults = $this->getResult();

        $results = array();
        if(!empty($searchResults)) {
            foreach($searchResults as $result) {
                if($result['userid']==$uid) {
                    $id = $result["id"];
                    array_push($results, $id);
                }
            }
        }
        return $results;
    }


}