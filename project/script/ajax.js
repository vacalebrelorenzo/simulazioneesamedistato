function effettuaLogin()
{
    let username = $("#username").val;
    let password = $("#password").val;

    $.get("../ajax/login.php", { username: username, password: password }, function (data) {
            
    });
}