<?php

class DataSource {

    private function connect() {

        $servername = $_ENV['MySQL_DB_HOST'];
        $username = $_ENV['MySQL_DB_USER_NAME'];
        $password = $_ENV['MySQL_DB_PASSWORD'];
        $database = $_ENV['MySQL_DB_NAME'];

        try {
            $dsn = "mysql:host=" . $servername . ";dbname=" . $database . ";";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function retrieveAllCustomerNames(){

        $dbh = $this->connect();

        $allCustomerNames = [];

        $sql = "SELECT * FROM Customer";
        $query = $dbh->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row, []);
            array_push($allCustomerNames, $user);
        }

        return $allCustomerNames;

    }

    public function retrieveAllProducts(){

        $dbh = $this->connect();

        $allProducts = [];

        $sql = "SELECT id, name, price FROM Product";
        $query = $dbh->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product($row);
            array_push($allProducts, $product);
        }

        return $allProducts;

    }

    public function retrieveGroup($group_id){

        $dbh = $this->connect();

        $sql = "SELECT * FROM Customer_group WHERE id=" . $group_id . " LIMIT 1";
        $query = $dbh->query($sql);

        return $query->fetch(PDO::FETCH_ASSOC);

    }

    public function retrieveAllRelatedGroups($group_id){

        $allRelatedGroups = [];

        $newId = $group_id;

        do{
            $group = $this->retrieveGroup($newId);
            array_push($allRelatedGroups, $group);
            $newId = $group['parent_id'];
        }
        while($newId);

        return $allRelatedGroups;
    }


    public function retrieveCustomer($id){

        $dbh = $this->connect();

        $sql = "SELECT * FROM Customer WHERE id=" . $id . " LIMIT 1";
        $query = $dbh->query($sql);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function retrieveProduct($id){

        $dbh = $this->connect();

        $sql = "SELECT * FROM Product WHERE id=" . $id . " LIMIT 1";
        $query = $dbh->query($sql);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}