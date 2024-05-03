function table(){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        document.getElementById("table").innerHTML = this.responseText;
    }
    xhttp.open("GET", "scripts/php-scripts/show-users.php");
    xhttp.send();
}

setInterval(function(){
    table();
},1);