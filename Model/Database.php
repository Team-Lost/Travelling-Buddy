<?php
    class database
    {
        private $servername = "localhost";        
        private $username = "root";
        private $password = "";
        private $db = "TravellingBuddy";
        function __construct()
        {
            $conn = mysqli_connect($this->servername,$this->username,$this->password);
            $query = "create database if not exists TravellingBuddy";
            mysqli_query($conn, $query);    
            $table = "create table if not exists User
            (
                UserID int AUTO_INCREMENT PRIMARY KEY, 
                UserName varchar(100),
                Mail varchar(255) UNIQUE,
                Phone varchar(15) UNIQUE,
                UserPassword varchar(64),
                Status varchar(20) DEFAULT 'PENDING',
                creationDate DATE DEFAULT (CURRENT_DATE)               
            )";
            mysqli_query($this->connect(), $table);           
        }        
        function connect()
        {           
            $conn = mysqli_connect($this->servername,$this->username,$this->password, $this->db);
            return $conn;   
        }       
        function updateTable($query)
        {
            $conn = $this->connect();              
            mysqli_query($conn, $query);  
        }         
    }

?>

