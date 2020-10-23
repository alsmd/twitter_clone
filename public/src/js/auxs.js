$(document).ready(()=>{
    $("#create_tweet").on("click",()=>{
        let $tweet = $("#tweet").val();
        $("#tweet").val('');
        $("#_tweet").val('');
        $.ajax({
            type:'POST',
            url:'/tweetsPags',
            data:`tweet=${$tweet}`,
            dataType:'JSON',
            success: (e)=>{
                let $totalPag = e.total_pag;
                delete e.total_pag;
                //Get the new tweet and add into the page
                addTweets(e)
               //
               setMenuPagination($totalPag);
            },
                
            error: (e)=>{console.log(e);}
        })
    })
    $("#create_tweet").trigger("click");
    //Creating paginatio's menu
    function setMenuPagination($totalPag){
        let x = 1;
        while(x < $totalPag){
            $(".last").before(`<li class="page-item"><a class="page-link" id="${x}">${x}</a></li>`);
            x++;
        }
        $(".last").attr("href",`?pag=+${$totalPag}`);

    }
    //
    function addTweets(e){
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
            $('.create-tweet-div').after(tweet_html);
        }
    }
    //Changing the current page
    $(".pagination").on("click",'a',(e)=>{
        let next_page = $(e.target).attr('id'); //get the next pag, that is the link's id that was clicked

        $.ajax({
            type: 'post',
            url: '/tweetsPags',
            data: `pag=${next_page}`,
            success: (e)=>{
                console.log(e);
            }
        })
    })
})