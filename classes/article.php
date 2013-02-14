<?php

/**
 * Description of article
 *
 * @author LP
 */
class Article {
    
    public $id = null;
    public $publication_date = null;
    public $title = null;
    public $summary = null;
    public $content = null;
    
    public function __construct( $data = array() ) {
        $pattern = "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/";
        if(isset($data["id"])){                 $this->id = (int) $data["id"];}
        if(isset($data["publication_date"])){   $this->publication_date = (int) $data["publication_date"];}
        if(isset($data["title"])){              $this->title = preg_replace($pattern, "", $data["title"]);}
        //if(isset($data["title"])){              $this->title = $data["title"];}
        if(isset($data["summary"])){            $this->summary = preg_replace($pattern, "", $data["summary"]);}
        if(isset($data["content"])){            $this->content = $data["content"];}
    }
    
    public static function getById( $id ) {
        $cnx = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT *, UNIX_TIMESTAMP(publication_date) AS publication_date FROM articles WHERE id = :id";
        $stm = $cnx->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        $cnx = null;
        if($row){
            return new Article($row);
        }else{
            return false;
        }
    }
    
    public static function getList( $numRows=100, $order="publication_date DESC") {
        $cnx = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publication_date) AS publication_date FROM articles ORDER BY ". mysql_escape_string($order) ." LIMIT :numRows";
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        $stmt->execute();
        $list = array();
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $article = new Article($row);
            $list[] = $article;
            //print_r($article);
        }
        
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $cnx->query($sql)->fetch(PDO::FETCH_ASSOC);
        $cnx = null;
        return array("articles"=>$list, "totalRows"=>$totalRows["totalRows"]);
    }
    
    public function storeFormValues( $params) {
        $this->__construct($params);
        if(isset($params["publication_date"])){
            $publication_date = explode("-", $params["publication_date"]);
            if(count($publication_date) == 3){
                list($y, $m, $d) = $publication_date;
                $this->publication_date = mktime(0, 0, 0, $m, $d, $y);
            }
        }
    }
    
    public function insert() {
        if(!is_null($this->id)){
            trigger_error("Article::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR );
        }
        
        $cnx = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO articles(publication_date, title, summary, content) VALUES(FROM_UNIXTIME(:publication_date), :title, :summary, :content)";
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(":publication_date", $this->publication_date, PDO::PARAM_INT);
        $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
        $stmt->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);
        $stmt->execute();
        
        $this->id = $cnx->lastInsertId();
        $cnx = null;        
    }
    
    public function update() {
        if(is_null($this->id)){
            trigger_error("Article::insert(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
        }
        
        $cnx = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE articles set publication_date=FROM_UNIXTIME(:publication_date), title=:title, summary=:summary, content=:content WHERE id=:id";
        $stmt = $cnx->prepare($sql);
        $stmt->bindValue(":publication_date", $this->publication_date, PDO::PARAM_INT);
        $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
        $stmt->bindValue(":summary", $this->summary, PDO::PARAM_STR);
        $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $cnx = null;        
    }
    
    public function delete() {
        if(is_null($this->id)){
            trigger_error("Article::insert(): Attempt to update an Article object that does not have its ID property set.", E_USER_ERROR );
        }
        
        $cnx = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "DELETE from articles WHERE id=:id LIMIT 1";
        $stmt = $cnx->prepare($sql);        
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $cnx = null;        
    }
}

?>
