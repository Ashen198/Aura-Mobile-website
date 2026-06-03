function login(){
    /*let user = document.getElementById("username").value;
    let pass = document.getElementById("password").value;

    if(user ==="" || pass === ""){
        alert("please fill all fields")
    }else{
        alert("Login Successfull !")
    }*/

    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    if (username === "" || password === "") {
        alert("Please fill in all fields!");
        return;
    }

    if (username === "asharaashen" && password === "2004") {
        window.location.href = "homePage.html";
    } else if ((username === "admin" && password === "1234")){
        window.location.href = "adminActive.html";
    } else{
        alert("Invalid Username or Password!");
    }

}