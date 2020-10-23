//Remove all the tweets and render e new tweet's colection based on the past parameter

function renderPagTweets(e){
    $.each($(".tweet-us"),(i,v)=>{
        v.remove();
    })
    let $totalPag = e.total_pag;
    delete e.total_pag;

    for(let i in e){
        let $user = e[i];

        let tweet_html = $("#_tweet").html();
        let tweet_dom =  new DOMParser().parseFromString(tweet_html,'text/html');
        $(tweet_dom).find(".tweet_data").html($user.date);
        $(tweet_dom).find(".tweet_content").html($user.tweet);
        $(tweet_dom).find(".button-remove").attr('id',$user.id);
        $(tweet_dom).find(".tweet").addClass('tweet-us');
        $(tweet_dom).find(".tweet_user_name").html($user._name);
        
        tweet_html = $(tweet_dom).find('body').html();
        $('#_tweet').before(tweet_html);
    }
    return $totalPag;
}

$(document).ready(()=>{
    $.ajax({
        type:'POST',
        url:'/tweetsPags',
        data:``,
        dataType:'JSON',
        success: (e)=>{
            //show the tweets's first page
            $totalPag = renderPagTweets(e) //after render the tweets it returns me the totalPag
            setMenuPagination($totalPag);
        },
            
        error: (e)=>{console.log(e);}
    })
    //Creating pagination's menu

    function setMenuPagination($totalPag){
/*        $(".pagination-item",(i,v)=>{
           v.remove();
       }) */
        let x = 1;
        while(x < $totalPag){
            $(".last").before(`<li class="page-item pagination-item"><a class="page-link" id="${x}">${x}</a></li>`);
            x++;
        }
        $(".last").attr("href",`?pag=+${$totalPag}`);

    }

})