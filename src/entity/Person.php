<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:15
 */

namespace src\entity;

class Person
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var integer
     */
    protected $userid;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $surname;
    /**
     * @var string
     */
    protected $adress;
    /**
     * @var string
     */
    protected $note;
    /**
     * @var string
     */
    protected $website;
    /**
     * @var string
     */
    protected $email;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param string $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function create($groupdata){
        $this->id = $groupdata["id"];
        $this->groupName = $groupdata["userid"];
        $this->leftIndex = $groupdata["name"];
        $this->rightIndex = $groupdata["surname"];
        $this->groupRoot = $groupdata["adress"];
        $this->groupLevel = $groupdata["note"];
        $this->groupLevel = $groupdata["website"];
        $this->groupLevel = $groupdata["email"];

    }

}