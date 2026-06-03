function changeImage(element){
    document.getElementById("mainImage").src = element.src;
}
function addToCartDetails() {

    let name = "iPhone 17 Pro";
    let price = 292000;
    

    let qty = parseInt(document.getElementById("qty").innerText);

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let existing = cart.find(item => item.name === name);

    if (existing) {
        existing.quantity += qty;
    } else {
        cart.push({
            name: name,
            price: price,
            quantity: qty
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    alert("Added to cart!");
}