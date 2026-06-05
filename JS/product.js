function openProduct(page) {
    window.location.href = page;
}

function displayProducts() {
  let grid = document.getElementById("productGrid");

  // Clear any existing content
  grid.innerHTML = "";

  // Fetch product list from MySQL database via PHP backend API
  fetch("getProducts.php")
    .then(response => {
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then(products => {
        // Show message if no products exist in the database table
        if (!products || products.length === 0) {
          let message = document.createElement("p");
          message.className = "no-products";
          message.textContent = "No products yet. Add some in the admin panel.";
          grid.appendChild(message);
          return;
        }

        // Loop through database items and create cards
        products.forEach(p => {
          let card = document.createElement("div");
          card.className = "product-card";

          // Use fallback placeholder if image path string is missing
          let imgSrc = p.image || "https://media.newyorker.com/photos/59095bb86552fa0be682d9d0/master/w_1920,c_limit/Monkey-Selfie.jpg";

          card.innerHTML = `
            <img src="${imgSrc}" alt="${p.pimage}">
            <h3>${escapeHTML(p.name)}</h3>
            <div class="price">Rs ${escapeHTML(p.pprice)}</div>
            <div class="description">${escapeHTML(p.pdesc || '')}</div>
            <div class="stock">Stock: ${escapeHTML(p.pstock)}</div>
            <a href="productDetails.php?id=${p.pid}" class="glass-btn">View Details</a>
          `;

          grid.appendChild(card);
        });
    })
    .catch(error => {
        console.error("Error loading products from database:", error);
        let errorMessage = document.createElement("p");
        errorMessage.className = "no-products";
        errorMessage.textContent = "Failed to load products from database.";
        grid.appendChild(errorMessage);
    });
}

// Simple helper to prevent XSS
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