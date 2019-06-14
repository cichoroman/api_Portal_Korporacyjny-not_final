<?php
class Meating{

    // database connection and table name
    private $conn;
    private $table_name = "meatings";

    // object properties
    public $id;
    public $title;
    public $description;
    public $selectedTopic;
    public $date;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
//
    // read products
    function read(){

        // select all query
        $query = "SELECT
                *
            FROM
                " . $this->table_name . " p
               ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
// create product
    function create(){




        // prepare query
        $stmt = $this->conn->prepare(  "INSERT INTO   " . $this->table_name . " (title, description, selectedTopic, date)
VALUES (:title, :description, :selectedTopic, :date)");

        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->selectedTopic=htmlspecialchars(strip_tags($this->selectedTopic));
        $this->date=htmlspecialchars(strip_tags($this->date));



        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":selectedTopic", $this->selectedTopic);
        $stmt->bindParam(":date", $this->date);
        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
// used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT
                *
            FROM
                " . $this->table_name . " p

            WHERE
                p.id = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->selectedTopic = $row['selectedTopic'];
        $this->date = $row['date'];
    }
// update the product


// delete the product
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
// search products

}
