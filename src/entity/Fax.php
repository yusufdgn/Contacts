<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:21
 */

namespace src\entity;

class Fax
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
    protected $faxNumber;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * @param integer $personid
     */
    public function setPersonid($personid)
    {
        $this->personid = $personid;
    }

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * @param string $faxNumber
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;
    }

}