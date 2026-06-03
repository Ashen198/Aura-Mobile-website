// Load products into table
function loadProducts() {
    let products = JSON.parse(localStorage.getItem("products")) || [];
    let table = document.getElementById("productTable");
    if (!table) return;

    table.innerHTML = "";
    products.forEach((p, index) => {
        let imgTag = p.image
            ? `<img src="${p.image}" width="50" height="50" style="object-fit:cover;">`
            : `<img src="https://media.istockphoto.com/id/629628952/photo/bonnet-monkey.jpg?s=612x612&w=0&k=20&c=UlCED-gnWw3fgiYQxIGEf-Fqbn-H0nJ0aH9rfj-12ac=" width="50">`;
        let desc = p.description || '';

        table.innerHTML += `
            <tr>
                <td>${imgTag}</td>
                <td>${p.name}</td>
                <td>$${p.price}</td>
                <td>${p.stock}</td>
                <td>${desc}</td>
                <td>
                    <button onclick="deleteProduct(${index})" style="background:#dc3545; padding:5px 10px;">Delete</button>
                </td>
            </tr>
        `;
    });

    document.getElementById("totalProducts").innerText = products.length;
}

// Delete product by index
function deleteProduct(index) {
    if (!confirm("Are you sure you want to delete this product?")) return;

    let products = JSON.parse(localStorage.getItem("products")) || [];
    products.splice(index, 1);
    localStorage.setItem("products", JSON.stringify(products));

    loadProducts(); // refresh table
    document.getElementById("totalProducts").innerText = products.length;
}



// Initial load of products for summary count
loadProducts();