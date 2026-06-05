function changeImage(element){
    document.getElementById("mainImage").src = element.src;
}
function addToCartDetails() {
    if (!selectedColor) {
        alert("Please select a color!");
        return;
    }
    if (!selectedCapacity) {
        alert("Please select a capacity!");
        return;
    }

    let form = document.createElement('form');
    form.method = 'POST';
    form.action = 'addToCartBackend.php';

    let data = {
        product_id: "<?php echo $product_id; ?>",
        product_name: "<?php echo addslashes($product_name); ?>",
        product_price: "<?php echo $product_price; ?>",
        product_desc: "<?php echo addslashes($product_desc); ?>",
        product_img: "<?php echo addslashes($product_img); ?>",
        color: selectedColor,
        capacity: selectedCapacity,
        qty: quantity
    };

    for (let key in data) {
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
}