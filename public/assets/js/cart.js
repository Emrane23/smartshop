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
                let li = document.createElement("li");
                li.classList.add("cart-item", "animate__animated", "animate__fadeIn");

                li.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-item-details">
                        <strong>${item.name}</strong>
                        <br> <span>${parseFloat(item.price).toFixed(2)} TND</span>
                    </div>
                    <button class="remove-btn-product" data-index="${index}">&times;</button>
                `;
                cartItemsContainer.appendChild(li);
                total += parseFloat(item.price);
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
            cartItemsContainer.innerHTML = `<tr><td colspan="4" class="text-center">Your Cart is empty.</td></tr>`;
        } else {
            cart.forEach((item, index) => {
                let tr = document.createElement("tr");
                tr.innerHTML = `
                    <td><img src="${item.image}" alt="${item.name}" style="width: 50px;"></td>
                    <td>${item.name}</td>
                    <td>${parseFloat(item.price).toFixed(2)} TND</td>
                    <td><button class="remove-btn-product" data-index="${index}">&times;</button></td>
                `;
                cartItemsContainer.appendChild(tr);
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
            toastr.info("Product removed from cart.");
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
            toastr.error("Your cart is empty.");
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
                    toastr.success("Order placed successfully!");
                    clearCart();
                } else if (status === 422) {
                    Object.values(body.errors).forEach(messages => {
                        messages.forEach(message => toastr.error(message));
                    });
                } else {
                    toastr.error(body.message || "An error occurred.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                toastr.error("Something went wrong.");
            });
    });

    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                image: this.dataset.image
            };

            cart.push(product);
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCart();
            let cartIcon = document.getElementById("cart-icon");
            cartIcon.classList.add("cart-bounce");
            setTimeout(() => cartIcon.classList.remove("cart-bounce"), 300);
            toastr.success(`${product.name} added to cart!`);
        });
    });

    updateCart();
});
