$(document).ready(()=>{

//Changing the current page
$(".pagination").on("click",'a',(e)=>{
    let next_page = $(e.target).attr('id'); //get the next pag, that is the link's id that was clicked
    $.ajax({
        type: 'post',
        url: '/tweetsPags',
        data: `pag=${next_page}`,
        dataType: 'json',
        success: (e)=>{
            //remove tha current page and render the pag selected
            renderPagTweets(e);
        },
        error: (e)=>{
            console.log(e);
        }
    })
})


})