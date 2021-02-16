<?php 

namespace App\Core;

abstract class AbstractModel {

    // Propriétés
    protected $database;

    // Constructeur
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}