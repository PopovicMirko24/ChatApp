function posts(){
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
        document.getElementById("posts").innerHTML = this.responseText;
    }
    xhttp.open("GET", "scripts/php-scripts/profile-show-posts.php");
    xhttp.send();
}

document.addEventListener("DOMContentLoaded", function() {
    posts();    
});


$(document).ready(function(){
    $('#form').submit(function(e){
        e.preventDefault(); // sprečava podrazumevano ponašanje forme

        var formData = $('#form').serialize(); // prikuplja podatke iz forme

        $.ajax({
            type: 'POST',
            url: 'scripts/php-scripts/creat-post.php', // ispravljena putanja do skripte
            data: formData,
            success: function(response){
                $('#content').val("");
                posts();
            }
        });
    });
});

function deletePost(post_id) {
    event.preventDefault(); // Prevents the default action of the link
    const url = "delete-post.php?post_id="+post_id; // Retrieves the URL from the clicked link
    if (confirm('Are you sure you want to delete this post?')) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                posts();
            }
        });
    }
}
