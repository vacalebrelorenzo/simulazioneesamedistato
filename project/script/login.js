$(document).ready(function() {
    let txtUsername = "<input type='text' id='username' placeholder='inserisci username!'>";
    let txtPassword = "<input type='password' id='password' placeholder='inserisci password!'>";
    let btnLogin = "<button type='button' onclick='effettuaLogin()'>Login!!!</button>";
    let container = $("<div id='login-container'></div>");

    container.append(txtUsername);
    container.append(txtPassword);
    container.append(btnLogin);

    $("#container").append(container);

});