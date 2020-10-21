<?php
    //Here i created a separete class for delete_tweet cause it'll be used in the public's folder
    //So my composer will not work
    session_start();
    require '../../App/Connection.php';
    use App\Connection;
class Delete_tweet{
    public function delete_tweet(){

        $query = "DELETE FROM tweets WHERE id = :id and id_user = :id_user ";
        $con = Connection::getDb();
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id',$_POST['tweet_id']);
        $stmt->bindValue(':id_user',$_SESSION['id']);
        $stmt->execute();
    }
}

?>