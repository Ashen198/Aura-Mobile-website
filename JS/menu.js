
function toggleMenu() {
    const menu = document.getElementById("profileMenu");
    menu.style.display = 
        menu.style.display === "block" ? "none" : "block";
}

// Close when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-btn')) {
        const menu = document.getElementById("profileMenu");
        if (menu.style.display === "block") {
            menu.style.display = "none";
        }
    }
}



// function filterProducts() {
//     let input = document.getElementById("searchInput").value.toLowerCase();
//     let products = document.querySelectorAll(".product1");

//     products.forEach(product => {
//         let name = product.querySelector("h3").innerText.toLowerCase();

//         if (name.includes(input)) {
//             product.style.display = "flex"; // show
//         } else {
//             product.style.display = "none"; // hide
//         }
//     });
// }


function filterProducts() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    // Ensure this matches the class name in your PHP file
    let products = document.querySelectorAll(".product-card");

    products.forEach(product => {
        let name = product.querySelector("h3").innerText.toLowerCase();

        // If it matches, show it; if not, hide it
        if (name.includes(input)) {
            product.style.display = "flex"; 
        } else {
            product.style.display = "none"; 
        }
    });
}