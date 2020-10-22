
(function(){
    let tweet_id;
    let tweet;
    //delete tweet
    $(document).ready(()=>{
        $("#tweets").on("click",".button-remove",(e)=>{
            $(".modal").slideToggle(100);
            //get the id of the tweet that was clicked
            tweet_id = $(e.target).closest('button').attr('id');
            tweet = $(e.target).closest('.tweet');
        })
        $("#del_yes").on("click",()=>{
            //and do a request to delete_tweet that will delete it from the db, just when the model "Yes" be clicked
            $.ajax({
                type:'POST',
                url:'php/delete_tweet.php',
                data: 'tweet_id='+tweet_id,
                success: (e)=>{
                    tweet.remove();
                }, //if the request is sucess i'll delete the tweet from the timeline with jquery
                error: ()=>{console.log('nao foi')},
            })
            $(".modal").slideToggle(100);
        })
        //Close the modal
        $("#del_no").on("click",()=>{
            $(".modal").slideToggle(100);
        })
        $(".close").on("click",()=>{
            $(".modal").slideToggle(100);
        })
        
    })
}) ();
