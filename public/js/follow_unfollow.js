$(document).ready(()=>{

    $("body").on("click",".unfollow",(e)=>{
        e.preventDefault();
        let href = $(e.target).attr('href');
        ///action that will be executed(follow or unfollow)
        let action = href.split("?")[1];
        //path
        let path = href.split("?")[0];
        //execute ajax to change the bd's information
        unfollowAndFollow(path,action);
        //changing button
        $(e.target).css('display','none');
        $(e.target).closest('div').find(".follow").css('display','inline-block');
    })

    $("body").on("click",".follow",(e)=>{
        e.preventDefault();
        let href = $(e.target).attr('href');
        ///action that will be executed(follow or unfollow)
        let action = href.split("?")[1];
        //path
        let path = href.split("?")[0];

        //execute ajax 
        unfollowAndFollow(path,action);
        //changing button
        $(e.target).css('display','none');
        $(e.target).closest('div').find(".unfollow").css('display','inline-block');
    })

    function unfollowAndFollow(path,action){
        $.ajax({
            type: "POST",
            url: path,
            data: action,
            success: e => {},
            error: e => {console.log("ERROR IN FOLLOW_UNFOLLOW AJAX ",e);}
        })
    }

})