<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 08.08.2017
 * Time: 14:28
 */

namespace src\adapter;


use src\entity\PersonGroup;

class PhoneAdapter extends Adapter
{
    /**
     * Gelen kullanıcı id bilgisine göre
     * kullanıcıya ait kisilerin toplam numara sayısını
     * geri döndüren metod
     * @param $userId
     * @return int
     */
    public function phoneScoreForUser($userId)
    {
        $params = ["userid" => $userId];
        $this->select("Person", $params);
        $this->execute();
        $results = $this->getResult();
        $toplam = 0;
        if (count($results) > 0) {
            foreach ($results as $row) {
                $personId = $row["id"];
                $countQuery = "SELECT COUNT(*) as toplam FROM Phone WHERE personid='$personId'";
                $this->setQuery($countQuery);
                $this->executeFetch();
                $rowResult = $this->getResult();
                if ($rowResult != null) {
                    $toplam += $rowResult["toplam"];
                }
            }
        }
        return $toplam;
    }

    /**
     * Gelen arama texti ve kullanıcı id bilgisine göre
     * Phone tablosunda arama yapan ve bulduğu kayıtların id bilgisini
     * geri döndüren metod
     * @param $q
     * @param $userId
     * @return array|null
     */
    public function phoneSearch($q,$userId,$personResult){
        $this->select("Phone",null);
        $params = ["phoneNumber" => $q];
        $this->withLike($params);
        $this->execute();
        $persons = $personResult;
        if(!empty($this->getResult())){
            $results = $this->getResult();
            foreach($results as $fax){
                $personId = $fax["personid"];
                if(!in_array($personId, $persons)) {
                    $params = ["id" => $personId, "AND" => ["userid" => $userId]];
                    $this->select("Person", $params);
                    $this->executeFetch();
                    $result = $this->getResult();
                    $result = $result["id"];
                    $persons[] = $result;
                }
            }
        }
        return $persons;
    }


}