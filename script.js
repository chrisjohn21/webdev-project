document.addEventListener("DOMContentLoaded", function () {
  const purchaseButton = document.getElementById("purchase-selected-button");
  const productCheckboxes = document.querySelectorAll(".product-checkbox");

  purchaseButton.addEventListener("click", function () {
      const selectedProducts = [];

      productCheckboxes.forEach((checkbox, index) => {
          if (checkbox.checked) {
              const row = checkbox.closest(".row");
              const productName = row.querySelector("h3").textContent;
              const productPrice = parseFloat(row.querySelector("p").textContent.replace('₱', ''));

              const quantity = parseInt(row.querySelector(".quantity-input").value);

              selectedProducts.push({ name: productName, price: productPrice, quantity: quantity });
          }
      });

      if (selectedProducts.length === 0) {
          Swal.fire("No items selected", "Please select at least one item to purchase.", "info");
      } else {
          Swal.fire({
              title: "Enter Your Information",
              html:
                  '<input id="swal-input1" class="swal2-input" placeholder="Name">' +
                  '<input id="swal-input2" class="swal2-input" placeholder="Address">' +
                  '<input id="swal-input3" class="swal2-input" placeholder="Phone Number">',
              showCancelButton: true,
              confirmButtonText: "Confirm Purchase",
              preConfirm: () => {
                  return {
                      name: document.getElementById("swal-input1").value,
                      address: document.getElementById("swal-input2").value,
                      phone: document.getElementById("swal-input3").value,
                  };
              },
          }).then((result) => {
              if (result.isConfirmed) {
                  const buyerName = result.value.name;
                  const buyerAddress = result.value.address;
                  const buyerPhone = result.value.phone;

                  const totalCost = selectedProducts.reduce((total, product) => {
                      return total + product.price * product.quantity;
                  }, 0);

                  const receiptText = `Buyer's Information:<br>Name: ${buyerName}<br>Address: ${buyerAddress}<br>Phone Number: ${buyerPhone}<br><br>Receipt:<br>${selectedProducts
                      .map((product) => `${product.name} (Quantity: ${product.quantity}): ₱ ${product.price.toFixed(2)}`)
                      .join("<br>")}<br><br>Total Cost: ₱ ${totalCost.toFixed(2)}`;

                  Swal.fire("Purchase Successful", receiptText, "success");
              }
          });
      }
  });
});