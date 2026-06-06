// Load products from the live PHP backend
function loadProducts() {
    let table = document.getElementById("productTable");
    if (!table) return;

    fetch('getProducts.php')
        .then(response => response.json())
        .then(products => {
            table.innerHTML = "";
            
            // Check if backend returned an error structure
            if (products.status === "error") {
                console.error(products.message);
                return;
            }

            products.forEach((p) => {
                // Check if image path exists; use placeholder fallback if empty
                let imgTag = p.image
                    ? `<img src="${p.image}" width="50" height="50" style="object-fit:cover; border-radius:8px;">`
                    : `<img src="https://media.istockphoto.com/id/629628952/photo/bonnet-monkey.jpg?s=612x612&w=0&k=20&c=UlCED-gnWw3fgiYQxIGEf-Fqbn-H0nJ0aH9rfj-12ac=" width="50" height="50">`;
                
                let desc = p.description || '';

                table.innerHTML += `
                    <tr>
                        <td>${imgTag}</td>
                        <td>${p.name}</td>
                        <td>$${parseFloat(p.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                        <td>${p.stock}</td>
                        <td>${desc}</td>
                        <td>
                            <button onclick="editProduct(${p.pid})" style="background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer; margin-right:5px;">Update</button>
                            <button onclick="deleteProduct(${p.pid})" style="background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error("Network Error fetching products:", error));
}

// Delete product execution using database Primary Key (pid)
function deleteProduct(pid) {
    if (!confirm("Are you sure you want to delete this product?")) return;

    let formData = new FormData();
    formData.append('pid', pid);

    fetch('deleteProduct.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadProducts(); // Instantly refresh the UI table
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error executing delete operations:", error));
}

// Handle Update button routing 
function editProduct(pid) {
    // Redirection passing the product ID as a query parameter string
    window.location.href = `adminItem.html?edit_pid=${pid}`;
}

// Fire up table parsing immediately upon page ready status
document.addEventListener("DOMContentLoaded", loadProducts);