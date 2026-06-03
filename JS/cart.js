// 1. Initial Cart Data (This would normally come from localStorage)
let cart = [
    { id: 1, name: 'iPhone 17 Pro', price: 395000, quantity: 1, img: 'rsc/17 pro silver.webp' },
    { id: 2, name: 'Samsung S24', price: 330000, quantity: 1, img: 'rsc/samsungS24.webp' }
];

// 2. Function to display the cart
function displayCart() {
    const cartContainer = document.getElementById("cart");
    const totalElement = document.getElementById("total");
    let total = 0;

    // Clear current display
    cartContainer.innerHTML = "";

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        // Create the HTML for each cart item
        const productDiv = document.createElement("div");
        productDiv.className = "product-item-row"; // We will style this in CSS
        productDiv.innerHTML = `
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 10px;">
                <img src="${item.img}" style="width: 50px; border-radius: 5px;">
                <div style="flex: 1; margin-left: 15px;">
                    <h4 style="margin: 0;">${item.name}</h4>
                    <p style="margin: 0;">Rs ${item.price.toLocaleString()}</p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <button onclick="changeQuantity(${index}, -1)" class="qty-btn">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="changeQuantity(${index}, 1)" class="qty-btn">+</button>
                </div>
                <div style="margin-left: 20px; font-weight: bold;">
                    Rs ${itemTotal.toLocaleString()}
                </div>
                <button onclick="removeItem(${index})" style="background:none; border:none; color:red; cursor:pointer; margin-left:10px;">🗑️</button>
            </div>
        `;
        cartContainer.appendChild(productDiv);
    });

    // Update the Total Price
    totalElement.innerText = `Total: Rs ${total.toLocaleString()}`;
}

// 3. Function to change quantity
function changeQuantity(index, delta) {
    cart[index].quantity += delta;

    // Remove item if quantity goes to 0
    if (cart[index].quantity <= 0) {
        removeItem(index);
    } else {
        displayCart();
    }
}

// 4. Function to remove item
function removeItem(index) {
    cart.splice(index, 1);
    displayCart();
}

// Initialize on page load
window.onload = displayCart;