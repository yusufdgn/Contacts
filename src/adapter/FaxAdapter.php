<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 16:15
 */

namespace src\adapter;

class FaxAdapter extends Adapter
{
    /**
     * Gelen kullanıcı id bilgisine göre
     * kullanıcıya ait kisilerin toplam numara sayısını
     * geri döndüren metod
     * @param $userId
     * @return int
     */
    public function faxScoreForUser($userId)
    {
        $params = ["userid" => $userId];
        $this->select("Person",$params);
        $this->execute();
        $results = $this->getResult();
        $toplam = 0;
        if(count($results)>0){
            foreach($results as $row){
                $personId = $row["id"];
                $countQuery = "SELECT COUNT(*) as toplam FROM Fax WHERE personid='$personId'";
                $this->setQuery($countQuery);
                $this->executeFetch();
                $rowResult = $this->getResult();
                if($rowResult != null){
                    $toplam += $rowResult["toplam"];
                }
            }
        }
        return $toplam;
    }

    /**
     * Gelen arama texti ve kullanıcı id bilgisine göre
     * Fax tablosunda arama yapan ve bulduğu kayıtların id bilgisini
     * geri döndüren metod.
     * @param $q
     * @param $userId
     * @return array|null
     */
    public function faxSearch($q,$userId,$phoneResult){
        $this->select("Fax",null);
        $params = ["faxNumber" => $q];
        $this->withLike($params);
        $this->execute();
        $persons = $phoneResult;
        if(!empty($this->getResult())){
            $results = $this->getResult();
            foreach($results as $fax){
                $personId = $fax["personid"];
                if(!in_array($personId,$persons)) {
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