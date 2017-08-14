<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 09.08.2017
 * Time: 13:01
 */

namespace src\controller;

use src\adapter\PersonGroupAdapter;
use src\entity\User;

class PersonGroupController
{
    public function select($id){
        $personGroupAdapter = new PersonGroupAdapter();
        $userController = new UserController();
        $userid = $userController->getSession();

        $personList = $personGroupAdapter->groupsPersons($id, $userid);
        $uniquePerson = $this->unique_multidim_array($personList,"personId");

        return ["persons"=>$uniquePerson];
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }
}