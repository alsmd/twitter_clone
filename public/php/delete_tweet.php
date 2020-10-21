<?php 
    //i had to put this function right here because my ajax's request cant go out the public's folder
    require '../../App/Controllers/Delete_tweet.php';

    $app = new Delete_tweet();
    $app->delete_tweet();

?>