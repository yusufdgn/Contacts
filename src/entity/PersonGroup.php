<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:32
 */
namespace src\entity;

class PersonGroup
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $personId;
    /**
     * @var integer
     */
    protected $groupId;

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
    public function getPersonId()
    {
        return $this->personId;
    }

    /**
     * @param int $personId
     */
    public function setPersonId($personId)
    {
        $this->personId = $personId;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    public function create($data){
        $this->id = $data["id"];
        $this->personId = $data["personId"];
        $this->groupId = $data["groupId"];
    }

}