<?php 
    class Database {
        private string $host = "127.0.0.1";

        private string $name = "atom_db";

        private string $user = "root";

        private string $password = "";

        public function getConnection() : PDO {
            $dsn  = "mysql:host={$this->host}; dbname={$this->name}";

            return new PDO($dsn, $this->user, $this->password);
        }

    }