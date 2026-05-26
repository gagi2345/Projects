document.getElementById("loginForm").addEventListener("submit", function(event){

    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const correctUsername = "GabrijelM";
    const correctPassword = "12345678";

    if(username === correctUsername && password === correctPassword){

        localStorage.setItem("ulogiran", "true");

        window.location.href = "../PHP/managerPocetna.php";

    } else {

        document.getElementById("error").textContent =
            "Pogrešno korisničko ime ili lozinka.";
    }

});