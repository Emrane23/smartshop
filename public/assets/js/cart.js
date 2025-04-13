function closeCarte() {
    document.getElementById("cartSidebar").classList.remove("active");
}

document.addEventListener("DOMContentLoaded", function () {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    window.updateCart = function () {
        updateNavbarCart();
        updateCartPage();
        toggleOrderButton();
    };

    function clearCart() {
        cart = [];
        localStorage.removeItem("cart");

        let cartItemsContainer = document.getElementById("cart-items");
        let cartListContainer = document.getElementById("cart-list");
        let cartCount = document.getElementById("cart-count");

        if (cartItemsContainer) {
            cartItemsContainer.innerHTML = `<p class="text-center">Your cart is empty.</p>`;
        }

        if (cartListContainer) {
            cartListContainer.innerHTML = `<tr><td colspan="4" class="text-center">Your Cart is empty.</td></tr>`;
        }

        if (cartCount) {
            cartCount.textContent = "";
            cartCount.style.display = "none";
        }

        updateCart();
    }

    document.getElementById("cart-icon").addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById("cartSidebar").classList.add("active");
        updateCart();
    });

    function updateNavbarCart() {
        let cartItemsContainer = document.getElementById("cart-items");
        let cartTotalContainer = document.querySelectorAll(".cart-total");
        let cartCount = document.getElementById("cart-count");

        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = "";
        let total = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `<p class="text-center">Your cart is empty.</p>`;
            cartCount.textContent = "";
            cartCount.style.display = "none";
        } else {
            cart.forEach((item, index) => {
                let price = parseFloat(item.price);
                let discountedPrice = item.discount ? price - (price * item.discount / 100) : price;

                let li = document.createElement("li");
                li.classList.add("cart-item", "d-flex", "align-items-center", "p-2", "border-bottom");

                li.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="me-3" style="width: 50px; height: 50px;">
                    <div class="flex-grow-1">
                        <strong>${item.name}</strong><br>
                        ${item.discount
                        ? `<span class="text-decoration-line-through text-danger">${price.toFixed(2)} TND</span>
                                   <span class="fw-bold text-warning">${discountedPrice.toFixed(2)} TND</span>`
                        : `<span class="fw-bold text-danger">${price.toFixed(2)} TND</span>`
                    }
                    </div>
                    <button class="remove-btn-product" data-index="${index}">&times;</button>
                `;
                cartItemsContainer.appendChild(li);
                total += discountedPrice;
            });

            cartCount.textContent = cart.length;
            cartCount.style.display = "inline-block";
        }

        cartTotalContainer.forEach(element => {
            element.textContent = (isNaN(total) ? 0 : total).toFixed(2) + " TND";
        });

        localStorage.setItem("cart", JSON.stringify(cart));
    }

    function updateCartPage() {
        let cartItemsContainer = document.getElementById("cart-list");
        if (!cartItemsContainer) return;

        cartItemsContainer.innerHTML = "";

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="col-12 text-center">
                    <p class="text-muted">🛒 Your cart is empty.</p>
                </div>
            `;
        } else {
            cart.forEach((item, index) => {
                let price = parseFloat(item.price);
                let discountedPrice = item.discount ? price - (price * item.discount / 100) : price;

                let card = document.createElement("div");
                card.classList.add("col-md-6", "col-lg-4");
                card.setAttribute("id", `cart-item-${index}`);

                card.innerHTML = `
                    <div class="card border-0 shadow-sm h-100">
                        <img src="${item.image}" alt="${item.name}" class="card-img-top object-fit-cover" style="height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">${item.name}</h5>
                            <p class="text-muted">Price:
                                ${item.discount
                        ? `<span class="text-decoration-line-through text-danger">${price.toFixed(2)} TND</span>
                                           <span class="fw-bold text-warning ms-2">${discountedPrice.toFixed(2)} TND</span>`
                        : `<span class="fw-bold text-danger">${price.toFixed(2)} TND</span>`
                    }
                            </p>
                            <button class="btn btn-outline-danger btn-sm remove-btn-product" data-index="${index}">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                `;

                cartItemsContainer.appendChild(card);
            });
        }
    }

    function toggleOrderButton() {
        const orderButton = document.getElementById("place-order");
        if (orderButton) {
            if (cart.length === 0) {
                orderButton.style.display = "none";
            } else {
                orderButton.style.display = "block";
            }
        }
    }


    function removeFromCart(index) {
        setTimeout(() => {
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCart();
            alertToastr(`Product removed from cart.`, 'info');

            toggleOrderButton();
        }, 500);

        let cartIcon = document.getElementById("cart-icon");
        cartIcon.classList.add("cart-bounce");
        setTimeout(() => cartIcon.classList.remove("cart-bounce"), 300);
    }


    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-btn-product")) {
            const index = parseInt(e.target.dataset.index);
            removeFromCart(index);
        }
    });

    document.getElementById("place-order")?.addEventListener("click", function () {
        if (!confirm("Are you sure you want to place this order?")) {
            return;
        }
        if (cart.length === 0) {
            alertToastr(`Your cart is empty.`, 'danger');
            return;
        }

        let url = this.dataset.url;
        let productIds = cart.map(item => item.id);

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ products: productIds })
        })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 && body.success) {
                    alertToastr("Order placed successfully!", 'success');
                    clearCart();
                } else if (status === 422) {
                    Object.values(body.errors).forEach(messages => {
                        messages.forEach(message => alertToastr(message, 'danger'));
                    });
                } else {
                    alertToastr(body.message || "An error occurred.", 'danger');
                }
            })
            .catch(error => {
                alertToastr("Something went wrong.", 'danger');
            });
    });

    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                discount: this.dataset.discount ? parseFloat(this.dataset.discount) : 0, // Ajout du discount
                image: this.dataset.image
            };

            cart.push(product);
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCart();
            let cartIcon = document.getElementById("cart-icon");
            cartIcon.classList.add("cart-bounce");
            setTimeout(() => cartIcon.classList.remove("cart-bounce"), 300);
            alertToastr(`${product.name} added to cart!`, 'success');
        });
    });

    updateCart();
});
