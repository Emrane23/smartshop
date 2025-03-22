document.addEventListener('DOMContentLoaded', function () {
    const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'));

    document.querySelectorAll('.btn-rate-product').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const orderId = this.dataset.orderId;
            const productName = this.dataset.productName;

            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalOrderId').value = orderId;
            document.getElementById('ratingModalTitle').textContent = `Rate: ${productName}`;

            ratingModal.show();
        });
    });

    document.getElementById('ratingModal').addEventListener('hidden.bs.modal', function () {
        ratingInput.value = 0;
        ratingValue.innerText = "0";
        resetStars();
    });

    const stars = document.querySelectorAll("#starRating .stars i");
    const ratingInput = document.getElementById("ratingInput");
    const ratingValue = document.getElementById("ratingValue");
    const form = document.getElementById("ratingForm");

    stars.forEach(star => {
        star.addEventListener("mouseover", function () {
            updateStars(parseInt(star.dataset.value));
        });

        star.addEventListener("mouseleave", function () {
            updateStars(parseInt(ratingInput.value) || 0);
        });

        star.addEventListener("click", function () {
            const starValue = parseInt(star.dataset.value);
            ratingInput.value = starValue;
            ratingValue.innerText = starValue;
            updateStars(starValue);
        });
    });

    function updateStars(rating) {
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            star.classList.toggle("full", starValue <= rating);
        });

        ratingValue.innerText = rating;
    }

    function resetStars() {
        stars.forEach(star => star.classList.remove("full"));
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(form);
        const productId = document.getElementById('modalProductId').value;

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertToastr(data.message, 'success');
                    document.activeElement.blur();

                    ratingModal.hide();
                    console.log(data.newRating);

                    updateProductStars(productId, data.newRating, data.totalReviews);
                } else {
                    alertToastr(data.message, 'error');
                }
            })
            .catch(() => {
                alertToastr("An error occurred. Please try again.", 'error');
            });
    });

    function updateProductStars(productId, newRating, totalReviews) {
        const productStarsContainer = document.querySelector(`.rating-trigger[data-product-id="${productId}"]`);
        if (!productStarsContainer) return;

        const fullStars = Math.floor(parseFloat(newRating.toString().replace(",", "."))); 
        const halfStar = parseFloat(newRating.replace(",", ".")) % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
        

        // Supprime les étoiles existantes avec animation
        const stars = productStarsContainer.querySelectorAll("i");
        for (let i = 0; i < stars.length; i++) {
            stars[i].style.transition = "opacity 0.3s";
            stars[i].style.opacity = "0";
        }

        console.log(newRating);


        const rateButton = document.querySelector(`.btn-rate-product[data-product-id="${productId}"]`);
        if (rateButton) {
            rateButton.style.transition = "opacity 0.3s, transform 0.3s";
            rateButton.style.opacity = "0";
            rateButton.style.transform = "scale(0.8)";

            setTimeout(() => {
                rateButton.remove();
            }, 300);
        }


        setTimeout(() => {
            productStarsContainer.innerHTML = "";
            

            // Ajout de la note
            const ratingSpan = document.createElement("span");
            ratingSpan.classList.add("me-1");
            ratingSpan.textContent = newRating;
            productStarsContainer.appendChild(ratingSpan);

            // Génération des étoiles
            const starContainer = document.createElement("div");
            starContainer.style.display = "inline-flex";
            starContainer.style.opacity = "0";

            for (let i = 0; i < fullStars; i++) {
                starContainer.appendChild(createStar("fa-star", "text-info"));
            }
            if (halfStar) {
                starContainer.appendChild(createStar("fa-star-half-o", "text-info"));
            }
            for (let i = 0; i < emptyStars; i++) {
                starContainer.appendChild(createStar("fa-star", "", "color: lightgray;"));
            }

            productStarsContainer.appendChild(starContainer);

            // Ajout du nombre de reviews
            if (totalReviews !== null) {
                const popupIcon = document.createElement("i");
                popupIcon.classList.add("fa", "fa-chevron-down", "text-primary", "ms-2");
                popupIcon.setAttribute("title", "Cliquez pour voir plus de détails");
                productStarsContainer.appendChild(popupIcon);
                const reviewCount = document.createElement("span");
                reviewCount.classList.add("ms-3");
                reviewCount.textContent = `${totalReviews} - Reviews`;
                productStarsContainer.appendChild(reviewCount);
            }

            // Création dynamique du popup
            let popup = document.querySelector(`.rating-popup[data-product-id="${productId}"]`);
            if (!popup) {
                popup = document.createElement("div");
                popup.classList.add("card", "p-3", "shadow-sm", "rating-popup");
                popup.setAttribute("data-product-id", productId);
                popup.style.cssText = "width: 350px; top: 120%; left: 0; display: none; z-index: 10; background: white; position: absolute;";

                popup.innerHTML = `
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 close-popup"></button>
                    <div id="spinner" class="d-flex justify-content-center align-items-center" style="height: 100px; display: none;">
                        <div class="spinner-border text-info" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="rating-details"></div>
                `;

                productStarsContainer.parentNode.appendChild(popup);

                // Événement pour fermer le popup
                popup.querySelector(".close-popup").addEventListener("click", function () {
                    popup.style.display = "none";
                });
            }

            // Animation d'affichage
            setTimeout(() => {
                starContainer.style.transition = "opacity 0.5s";
                starContainer.style.opacity = "1";
            }, 50);
        }, 300);

        // Charger le script si nécessaire
        loadRatingScript();
    }


    function loadRatingScript() {
        setTimeout(() => {
            const script = document.createElement("script");
            // script.src = "/assets/js/rating-stat.js"; // Assure-toi que le chemin est correct
            script.async = true;
            document.body.appendChild(script);
        }, 500); // Attente pour s'assurer que tout est chargé
    }



    // Fonction utilitaire pour créer une étoile avec classes et styles
    function createStar(iconClass, additionalClass = "", style = "") {
        const star = document.createElement("i");
        star.classList.add("fa", iconClass);
        if (additionalClass) star.classList.add(additionalClass);
        if (style) star.style = style;
        return star;
    }

});
