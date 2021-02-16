<?php 

namespace App\Core;


abstract class AbstractController {

    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}