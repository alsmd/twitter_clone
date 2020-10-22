
$(document).ready(()=>{
    //When the page load render de users
    renderUsers('all');
    // When Filter render the users with filter
    $("#btn_search_user").on("click",()=>{
        renderUsers('only_searched');
    })
    function renderUsers(act){
        let $user = $("#search_user").val();
        let res = $.ajax({
            type:'POST',
            url: '/who_follow_search',

            data: `name=${$user}&action=${act}`,
            dataType: 'json',
            success: (e)=>{

            },
            error: (e) =>{
                console.log(e);
            }
        })

        res.then((users)=>{
            let aux = $("#user_searched_model").html(); //get the model to create a user's div
            $.each($("#results .user"), (i,v) =>{ //remove the users that are already render
                v.remove(); 
            })
            for(let i in users){
                //get the users that correspond to the search
                let user = users[i];
                let user_cont =  new DOMParser().parseFromString(aux,'text/html');// user's div in DOM to be easy edit

                $(user_cont).find("#name").html(user._name); //set  user's name
                //setting follow and unfollow button
                if(user.following_yn == 1){
                    $(user_cont).find(".follow").css('display','none'); //href=""
                    $(user_cont).find(".unfollow").css('display','inline-block');
                }else if(user.following_yn == 0){
                    $(user_cont).find(".unfollow").css('display','none');
                    $(user_cont).find(".follow").css('display','inline-block');
                }
                //storing user's id to consult the bd
                $(user_cont).find(".unfollow").attr("href",`/action?action=unfollow&&id=${user.id}`)
                $(user_cont).find(".follow").attr("href",`/action?action=follow&&id=${user.id}`)

                //getting the user's div formated
                $user =$(user_cont).find("body").html();
                $user = $user;
                
                //adding this div into the page
                $("#results").append($user);
            }
            
        })
    }
})