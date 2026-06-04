// Add new product
function addProduct() {
    let name = document.getElementById("pname").value.trim();
    let price = document.getElementById("pprice").value.trim();
    let stock = document.getElementById("pstock").value.trim();
    let desc = document.getElementById("pdesc").value.trim();
    let fileInput = document.getElementById("pimage");

    if (!name || !price || !stock || !desc || !fileInput.files[0]) {
        alert("Please fill all fields and select an image");
        return;
    }

    // Create a FormData object to easily send files and text data
    let formData = new FormData();
    formData.append("pname", name);
    formData.append("pprice", price);
    formData.append("pstock", stock);
    formData.append("pdesc", desc);
    formData.append("pimage", fileInput.files[0]);

    // Send data to PHP backend
    fetch("addProduct.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert(data.message);

            // Clear form fields
            document.getElementById("pname").value = "";
            document.getElementById("pprice").value = "";
            document.getElementById("pstock").value = "";
            document.getElementById("pdesc").value = "";
            document.getElementById("pimage").value = "";
            
            // If you have a function to reload elements on the dashboard, call it here
            if (typeof loadProducts === "function") {
                loadProducts(); 
            }
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while adding the product.");
    });
}