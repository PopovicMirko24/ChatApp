function comments(post_id){
    const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
        document.getElementById("comm").innerHTML = this.responseText;
    }
    xhttp.open("GET", "scripts/php-scripts/show-comments.php?post_id=" + post_id);
    xhttp.send();
}

$(document).ready(function() {
    $('#form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        var post_id = $('#post_id_hidden').val();
        createComment(post_id); // Call the createComment function
    });
});

function createComment(post_id) {
    var formData = $('#form').serialize(); // Serialize form data
    $.ajax({
        type: 'POST',
        url: 'scripts/php-scripts/create-comment.php',
        data: formData,
        success: function(response) {
            $('#content').val(""); 
            comments(post_id);// Clear the textarea after successful submission // Update comments after successful submission
        }
    });
}


function deleteComment(comment_id, post_id) {
    event.preventDefault(); // Prevents the default action of the link
    const url = "delete-comment.php?comment_id="+comment_id; // Retrieves the URL from the clicked link
    if (confirm('Are you sure you want to delete this comment?')) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                comments(post_id);
            }
        });
    }
}
