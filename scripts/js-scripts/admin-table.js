function table(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        document.getElementById("table").innerHTML = this.responseText;
    }
    xhttp.open("GET", "scripts/php-scripts/show-users.php");
    xhttp.send();
}

document.addEventListener("DOMContentLoaded", function() {
    table();  
});

function deleteUser(user_id) {
    event.preventDefault(); // Prevents the default action of the link
    const url = "scripts/php-scripts/delete-user.php?user_id="+user_id; // Retrieves the URL from the clicked link
    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                table();
            }
        });
    }
}