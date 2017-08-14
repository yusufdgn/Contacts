<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 07.08.2017
 * Time: 15:27
 */

namespace src\entity;


class Groups
{
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $groupName;

    /**
     * @var integer
     */
    protected $leftIndex;
    /**
     * @var integer
     */
    protected $rightIndex;
    /**
     * @var integer
     */
    protected $groupRoot;

    /**
     * @var integer
     */
    protected $groupLevel;

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
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @return int
     */
    public function getLeftIndex()
    {
        return $this->leftIndex;
    }

    /**
     * @param int $leftIndex
     */
    public function setLeftIndex($leftIndex)
    {
        $this->leftIndex = $leftIndex;
    }

    /**
     * @return int
     */
    public function getRightIndex()
    {
        return $this->rightIndex;
    }

    /**
     * @param int $rightIndex
     */
    public function setRightIndex($rightIndex)
    {
        $this->rightIndex = $rightIndex;
    }

    /**
     * @return int
     */
    public function getGroupRoot()
    {
        return $this->groupRoot;
    }

    /**
     * @param int $groupRoot
     */
    public function setGroupRoot($groupRoot)
    {
        $this->groupRoot = $groupRoot;
    }

    /**
     * @return int
     */
    public function getGroupLevel()
    {
        return $this->groupLevel;
    }

    /**
     * @param int $groupLevel
     */
    public function setGroupLevel($groupLevel)
    {
        $this->groupLevel = $groupLevel;
    }

    public function create($groupdata){
        $this->id = $groupdata["id"];
        $this->groupName = $groupdata["groupName"];
        $this->leftIndex = $groupdata["leftIndex"];
        $this->rightIndex = $groupdata["rightIndex"];
        $this->groupRoot = $groupdata["groupRoot"];
        $this->groupLevel = $groupdata["groupLevel"];
    }

}