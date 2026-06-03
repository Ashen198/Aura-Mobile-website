function openProduct(page) {
    window.location.href = page;
}












function displayProducts() {
  // Get product list from localStorage (saved by admin panel)
  let products = JSON.parse(localStorage.getItem("products")) || [];
  let grid = document.getElementById("productGrid");

  // Clear any existing content
  grid.innerHTML = "";

  // Show message if no products
  if (products.length === 0) {
    let message = document.createElement("p");
    message.className = "no-products";
    message.textContent = "No products yet. Add some in the admin panel.";
    grid.appendChild(message);
    return;
  }

  // Loop through products and create cards
  products.forEach(p => {
    let card = document.createElement("div");
    card.className = "product-card";

    // Use placeholder if image is missing
    let imgSrc = p.image || "https://media.newyorker.com/photos/59095bb86552fa0be682d9d0/master/w_1920,c_limit/Monkey-Selfie.jpg";

    card.innerHTML = `
      <img src="${imgSrc}" alt="${p.name}">
      <h3>${escapeHTML(p.name)}</h3>
      <div class="price">Rs ${escapeHTML(p.price)}</div>
      <div class="description">${escapeHTML(p.description || '')}</div>
      <div class="stock">Stock: ${escapeHTML(p.stock)}</div>
    `;

    grid.appendChild(card);
  });
}

// Simple helper to prevent XSS (though data is from localStorage, it's good practice)
function escapeHTML(str) {
  return String(str).replace(/[&<>"]/g, function(match) {
    if (match === '&') return '&amp;';
    if (match === '<') return '&lt;';
    if (match === '>') return '&gt;';
    if (match === '"') return '&quot;';
    return match;
  });
}

// Run when page loads
window.addEventListener('DOMContentLoaded', displayProducts);



