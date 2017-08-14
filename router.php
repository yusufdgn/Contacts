<?php
$routers = [
    "homepage" => [
        "url" => "^/$",
        "class" => "Person",
        "action" => "score",
        "type"=>"normal",
        "template" => "index.twig"
    ],
    "index" => [
        "url" => "/index",
        "class" => "Person",
        "action" => "score",
        "type"=>"normal",
        "template" => "index.twig"
    ],
    "search" => [
        "url" => "/search",
        "class" => "Person",
        "action" => "searchResult",
        "type"=>"normal",
        "template" => "search.twig"
    ],
    "addPerson" => [
        "url" => "/person/new",
        "class" => "Person",
        "action" => "newPerson",
        "type"=>"normal",
        "template" => "addPerson.twig"
    ],
    "addPerson_check" => [
        "url" => "/check/addperson",
        "class" => "Person",
        "action" => "addPerson",
        "type" => "check",
        "template" => "checkNewPerson.twig"
    ],
    "viewPerson" => [
        "url" => "/viewperson/(\d+)",
        "class" => "Person",
        "action" => "viewPerson",
        "type"=>"normal",
        "template" => "viewPerson.twig"
    ],
    "editPerson" => [
        "url" => "/editperson/(\d+)",
        "class" => "Person",
        "action" => "editPerson",
        "type"=>"normal",
        "template" => "editPerson.twig"
    ],
    "checkEditPerson" => [
        "url" => "/check/editperson/",
        "class" => "Person",
        "action" => "checkEditPerson",
        "type"=>"check",
        "template" => "checkEditPerson.twig"
    ],
    "deletePerson" => [
        "url" => "/deleteperson/(\d+)",
        "class" => "Person",
        "action" => "viewPerson",
        "type"=>"normal",
        "template" => "deletePerson.twig"
    ],
    "checkDeletePerson" => [
        "url" => "/check/deleteperson",
        "class" => "Person",
        "action" => "checkDeletePerson",
        "type"=>"check",
        "template" => "checkDeletePerson.twig"
    ],
    "addGroupCheck" => [
        "url" => "/check/addgroup",
        "class" => "Groups",
        "action" => "checkAddGroup",
        "type" => "check",
        "template" => "checkAddGroup.twig"
    ],
    "login" => [
        "url" => "/login",
        "class" => "User",
        "action" => "getServerAddress",
        "type"=>"normal",
        "template" => "login.twig"
    ],
    "loginCheck" => [
        "url" => "/check/logon",
        "class" => "User",
        "action" => "loginCheck",
        "type"=>"check",
        "template" => "login_check.twig"
    ],
    "logout" => [
        "url" => "/logout",
        "class" => "User",
        "action" => "logout",
        "type"=>"check",
        "template" => "logout.twig"
    ],
    "register" => [
        "url" => "/check/register",
        "class" => "User",
        "action" => "checkRegister",
        "type"=>"check",
        "template" => "checkRegister.twig"
    ],
    "404" => [
        "url" => "/404",
        "class" => "User",
        "action" => "login",
        "type"=>"normal",
        "template" => "404.twig"
    ],
    "addGroup" => [
        "url" => "/group/new",
        "class" => "Groups",
        "action" => "select",
        "type"=>"normal",
        "template" => "addGroup.twig"
    ],
    "deleteGroup" => [
        "url" => "/group/delete/(\d+)",
        "class" => "Groups",
        "action" => "getGroupForDelete",
        "type"=>"normal",
        "template" => "deleteGroup.twig"
    ],
    "editGroup" => [
        "url" => "/group/edit/(\d+)",
        "class" => "Groups",
        "action" => "getGroupForEdit",
        "type"=>"normal",
        "template" => "editGroup.twig"
    ],
    "GroupPerson" => [
        "url" => "/group-person/(\d+)",
        "class" => "PersonGroup",
        "action" => "select",
        "type"=>"normal",
        "template" => "groupPerson.twig"
    ],
    "groups" => [
        "url" => "/group/((\d+)/(\d+))?",
        "class" => "Groups",
        "action" => "getGroups",
        "type"=>"normal",
        "template" => "groups.twig"
    ],
    "persons" => [
        "url" => "/person",
        "class" => "Person",
        "action" => "selectPerson",
        "type"=>"normal",
        "template" => "persons.twig"
    ],
    "Checkeditgroup" => [
        "url" => "/check/editgroup",
        "class" => "Groups",
        "action" => "checkEditGroup",
        "type"=>"check",
        "template" => "checkEditGroup.twig"
    ],
    "CheckDeleteGroup" => [
        "url" => "/check/deletegroup",
        "class" => "Groups",
        "action" => "checkDeleteGroup",
        "type"=>"check",
        "template" => "checkDeleteGroup.twig"
    ],

];