<?php
class user{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $idUsers;
    public $uidUsers;
    public $emailUsers;
    public $pwdUsers;
    public $hashPwd;


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

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                uidUsers=:uidUsers, emailUsers=:emailUsers, pwdUsers=:pwdUsers";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->uidUsers=htmlspecialchars(strip_tags($this->uidUsers));
        $this->emailUsers=htmlspecialchars(strip_tags($this->emailUsers));
        $this->pwdUsers=htmlspecialchars(strip_tags($this->pwdUsers));

        $hashPwd = password_hash($pwdUsers, PASSWORD_DEFAULT);

        // bind values
        $stmt->bindParam(":uidUsers", $this->uidUsers);
        $stmt->bindParam(":emailUsers", $this->emailUsers);
        $stmt->bindParam(":pwdUsers", $this->$hashPwd);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
// used when filling up the update product form
/*    function readOne(){

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
*/
}
