
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

    let file = fileInput.files[0];
    let reader = new FileReader();

    reader.onload = function(e) {
        let products = JSON.parse(localStorage.getItem("products")) || [];
        products.push({
            name: name,
            price: price,
            stock: stock,
            description: desc,
            image: e.target.result // base64 data URL
        });
        localStorage.setItem("products", JSON.stringify(products));

        alert("Product Added");

        // Clear form
        document.getElementById("pname").value = "";
        document.getElementById("pprice").value = "";
        document.getElementById("pstock").value = "";
        document.getElementById("pdesc").value = "";
        document.getElementById("pimage").value = "";

        loadProducts(); // update table
        document.getElementById("totalProducts").innerText = products.length;
    };

    reader.readAsDataURL(file);
}
