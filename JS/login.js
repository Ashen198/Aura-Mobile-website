function login() {
    var username = document.getElementById("username").value.trim();
    var password = document.getElementById("password").value.trim();

    if (username === "" || password === "") {
        alert("Please fill in all fields!");
        return;
    }

    // Admin back-door path
    if (username === "admin" && password === "1234") {
        window.location.href = "adminActive.php";
        return; 
    }

    // Database check path
    var formData = new FormData();
    formData.append("email", username); 
    formData.append("password", password);

    fetch("login.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Login successful! Welcome back.");
            
            // CHANGED THIS LINE: Redirects straight to your dynamic PHP profile page
            
            window.location.href = "homePage.html"; 
            
        } else {
            alert(data.message); // This will show your "No account found..." message cleanly in an alert box!
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Something went wrong connecting to the server.");
    });
}