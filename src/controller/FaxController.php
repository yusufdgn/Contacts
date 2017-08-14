<?php
/**
 * Created by PhpStorm.
 * User: yusuf
 * Date: 09.08.2017
 * Time: 13:00
 */
namespace src\controller;
use src\adapter\FaxAdapter;

class FaxController
{
    public function __construct()
    {
        $faxAdapter = new FaxAdapter();
    }
}