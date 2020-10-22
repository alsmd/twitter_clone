
$(document).ready(()=>{
    //When the page load
    
    //Filter
    $("#btn_search_user").on("click",()=>{
        let $user = $("#search_user").val();
        let name = $("#search_user").attr('name');
        let $users_result;

        let res = $.ajax({
            type:'POST',
            url: '/who_follow_search',

            data: `name=${$user}`,
            dataType: 'json',
            success: (e)=>{

            },
            error: (e) =>{
                console.log(e);
            }
        })

        res.then((users)=>{
            let aux = $("#user_searched").html();
            $.each($(".user"), (i,v) =>{ //remove the users that are already render
                v.remove(); 
            })
            for(let i in users){
                //get the users that correspond to the search
                let user = users[i];
                let user_cont =  new DOMParser().parseFromString(aux,'text/html');

                $(user_cont).find("#name").html(user._name); //set  user's name
                //setting follow and unfollow button
                if(user.following_yn == 1){
                    $(user_cont).find("#follow").css('display','none'); //href=""
                    $(user_cont).find("#unfollow").css('display','inline-block');
                    $(user_cont).find("#unfollow").attr("href",`/action?action=unfollow&&id=${user.id}`)
                }else if(user.following_yn == 0){
                    $(user_cont).find("#unfollow").css('display','none');
                    $(user_cont).find("#follow").css('display','inline-block');

                }
                //getting the user's div formated
                $user =$(user_cont).find(".row").html();
                $user = `<div class= "row mb-2 user"> ${$user} </div>`;
                //adding this div into the page
                $("#user_searched").append($user);
            }
            
        })
    })
})