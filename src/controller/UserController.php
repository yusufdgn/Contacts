<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 09.08.2017
 * Time: 13:02
 */
namespace src\controller;

use src\adapter\UserAdapter;
use src\entity\User;

class UserController
{
    public function login(){

        return array(1,1);

    }
    public function select(){

        return [];
    }

    public function checkSession(){
        if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"])){
            return true;
        }
        else {
            return false;
        }
    }

    public function getUserInfo(){
        $params = array("id" => $_SESSION["userid"]);
        $userAdapter = new UserAdapter();
        $userAdapter->select("User",$params);
        $userAdapter->executeFetch();
        $results = $userAdapter->getResult();

        return $results;

    }
    public function getSession(){
        $userid = $_SESSION["userid"];
        return $userid;
    }

    public function getServerAddress(){
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        return ["server"=>$actual_link];
    }

    public function loginCheck()
    {
        if(isset($_POST["username"]) && isset($_POST["password"])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $params = array("username"=>$username, "AND"=>array("password"=>$password));
            $userAdapter = new UserAdapter();
            $userAdapter->select("User",$params);
            $userAdapter->executeFetch();
            $results = $userAdapter->getResult();

            if(!empty($results)){
                $_SESSION["userid"] = $results["id"];
                return ["status"=>"ok"];
            }
            else {
                return ["status"=>"error"];
            }
        }
        else {
            return ["status"=>"fail"];
        }

    }

    public function logout(){
        session_destroy();

        return ["logout"=>"logout"];
    }

    public function checkRegister(){
        try{
            $user = new User();
            $user->setName($_POST["name"]);
            $user->setSurname($_POST["surname"]);
            $user->setEmail($_POST["email"]);
            $user->setUsername($_POST["username"]);
            $user->setPassword($_POST["password"]);

            $userAdapter = new UserAdapter();
            $userAdapter->insert($user);
            $userAdapter->execute();
            return ["status"=>"ok"];
        }catch (\Exception $e){
            return ["status"=>"error"];
        }
    }
}