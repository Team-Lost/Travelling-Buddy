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
                Gender varchar(15),
                Rank varchar(20) DEFAULT 'PENDING',
                IDFile varchar(255),
                creationDate DATETIME DEFAULT NOW()               
            )";
            mysqli_query($this->connect(), $table);
            $table = "create table if not exists passwordReset
            (
                ResetID int AUTO_INCREMENT PRIMARY KEY,
                ResetMail varchar(255) NOT NULL,
                ResetSelector varchar(255),
                ResetToken varchar(255),
                ResetExpire varchar(255) 
            )";
            mysqli_query($this->connect(), $table);
            $table = "create table if not exists Contact
            (
                contactID int AUTO_INCREMENT PRIMARY KEY,
                contactName varchar(255) NOT NULL,
                contactMail varchar(255) NOT NULL,
                contactSubject varchar(255) NOT NULL,
                contactMessage varchar(255) NOT NULL 
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

