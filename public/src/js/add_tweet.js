$(document).ready(()=>{
    $("#create_tweet").on("click",()=>{
        let $tweet = $("#tweet").val();
        $("#_tweet").val('');
        $.ajax({
            type:'POST',
            url:'/tweet',
            data:`tweet=${$tweet}`,
            dataType:'JSON',
            success: (e)=>{
                //Get the new tweet and add into the page
                let tweet_html = $("#_tweet").html();
                let tweet_dom =  new DOMParser().parseFromString(tweet_html,'text/html');
                $(tweet_dom).find(".tweet_data").html(e.date);
                $(tweet_dom).find(".tweet_content").html(e.tweet);
                $(tweet_dom).find(".button-remove").attr('id',e.id);
                $(tweet_dom).find(".tweet_user_name").html(e._name);
                
                tweet_html = $(tweet_dom).find('body').html();
                $('.create-tweet-div').after(tweet_html);
            },
            error: (e)=>{}
        })
    })
})