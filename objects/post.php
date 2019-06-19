<?php
class post{

    // database connection and table name
    private $conn;
    private $table_name = "posts";

    // object properties
    public $id;
    public $title;
    public $content;
    public $selectedTopic;


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
        $stmt = $this->conn->prepare(  "INSERT INTO   " . $this->table_name . " (title, content, selectedTopic)
VALUES (:title, :content, :selectedTopic)");

        // sanitize
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->content=htmlspecialchars(strip_tags($this->content));
        $this->selectedTopic=htmlspecialchars(strip_tags($this->selectedTopic));


        // bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":selectedTopic", $this->selectedTopic);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    function readOne(){
        $query = "SELECT
                *
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->selectedTopic = $row['selectedTopic'];

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
