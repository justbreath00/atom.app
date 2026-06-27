<?php 

require_once '../config/connect';

class subjectModel 
{
    private $pdo;

    public function __construct($pdo){

        $this->pdo = $pdo;
    }

    public function getSubjectsById($id){
        $quiry = "SELECT *FROM subjects WHERE user";
    }


    
    

}


