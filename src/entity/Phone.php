<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:25
 */
namespace src\entity;

class Phone
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $personid;

    /**
     * @var string
     */
    protected $phoneNumber;

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
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * @param int $personid
     */
    public function setPersonid($personid)
    {
        $this->personid = $personid;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }



}