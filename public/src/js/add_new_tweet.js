$(document).ready(()=>{
    $("#create_tweet").on("click",()=>{
        let $tweet = $("#tweet_content").val();
        $("#tweet_content").val('');
        $("#_tweet").val('');
        $.ajax({
            type:'POST',
            url:'/tweetsPags',
            data:`tweet=${$tweet}`,
            dataType:'JSON',
            success: (e)=>{
                //remove tha current page and render a new one with the new tweet
                renderPagTweets(e);
            },
                
            error: (e)=>{console.log(e);}
        })
    })
})