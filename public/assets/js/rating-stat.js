

    const triggers = document.querySelectorAll('.rating-trigger');
    let currentInterval = null;
    let isClicked = false;

    triggers.forEach(trigger => {
        const popup = trigger.nextElementSibling;
        const spinner = popup?.querySelector('#spinner');
        const ratingDetails = popup.querySelector('#rating-details');
        const productId = trigger.dataset.productId; // Récupérer l'ID du produit

        trigger.addEventListener('click', () => {
            isClicked = !isClicked;
            popup.style.display = isClicked ? 'block' : 'none';
            if (isClicked) fetchRatingDetails(productId, popup, spinner, ratingDetails);
        });

        trigger.addEventListener('mouseenter', () => {
            if (!isClicked) {
                clearTimeout(currentInterval);
                popup.style.display = 'block';
                fetchRatingDetails(productId, popup, spinner, ratingDetails);
            }
        });

        trigger.addEventListener('mouseleave', () => {
            if (!isClicked) hidePopupWithDelay(popup);
        });

        popup.addEventListener('mouseenter', () => clearTimeout(currentInterval));

        popup.addEventListener('mouseleave', () => {
            if (!isClicked) hidePopupWithDelay(popup);
        });

        popup.querySelector('.close-popup').addEventListener('click', () => {
            popup.style.display = 'none';
            isClicked = false;
            clearInterval(currentInterval);
        });
    });

    function hidePopupWithDelay(popup) {
        currentInterval = setTimeout(() => {
            popup.style.display = 'none';
            clearInterval(currentInterval);
        }, 300);
    }

    function fetchRatingDetails(productId, popup, spinner, ratingDetails) {
        spinner.style.display = 'flex';
        ratingDetails.style.display = 'none';

        fetch(`/ratings/${productId}`)
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch rating data');
                return response.json();
            })
            .then(data => {
                generateRatingDetails(ratingDetails, data);
                spinner.style.display = 'none';
                spinner.classList.remove('d-flex');
                ratingDetails.style.display = 'block';
                animateProgressBars(popup);
            })
            .catch(error => {
                console.error('Error fetching rating data:', error);
                spinner.style.display = 'none';
                spinner.classList.remove('d-flex');
                ratingDetails.innerHTML =
                    '<p class="text-danger text-bold">Unable to load reviews!</p>';
                ratingDetails.style.display = 'block';
            });
    }

    function generateRatingDetails(container, data) {
        container.innerHTML = '';

        // Génération des étoiles
        const starContainer = document.createElement('div');
        starContainer.className = 'd-flex align-items-center';
        
        const fullStars = Math.floor(parseFloat(data.rating.toString().replace(",", ".")));
        
        const halfStar = parseFloat(data.rating.replace(",", ".")) % 1 >= 0.5;
        const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);

        for (let i = 0; i < fullStars; i++) {
            starContainer.innerHTML += `<i class="fa fa-star text-info"></i>`;
        }
        if (halfStar) {
            starContainer.innerHTML += `<i class="fa fa-star-half-o text-info"></i>`;
        }
        for (let i = 0; i < emptyStars; i++) {
            starContainer.innerHTML += `<i class="fa fa-star" style="color: lightgray"></i>`;
        }
        

        const ratingText = document.createElement('span');
        ratingText.className = 'ms-2 fw-bold';
        ratingText.textContent = `${data.rating} out of 5`;

        starContainer.appendChild(ratingText);
        container.appendChild(starContainer);

        // Nombre total d'évaluations
        const totalReviewsText = document.createElement('p');
        totalReviewsText.className = 'text-muted small mb-2';
        totalReviewsText.textContent = `${data.totalReviews} evaluations`;
        container.appendChild(totalReviewsText);

        // Génération de l'histogramme
        [5, 4, 3, 2, 1].forEach(star => {
            const row = document.createElement('div');
            row.className = 'd-flex align-items-center w-100';

            const starLabel = document.createElement('span');
            starLabel.className = 'me-2';
            starLabel.style.whiteSpace = 'nowrap';
            starLabel.textContent = `${star} stars`;

            const progressBarContainer = document.createElement('div');
            progressBarContainer.className = 'progress flex-grow-1 mx-2';
            progressBarContainer.style.height = '10px';

            const progressBar = document.createElement('div');
            progressBar.className = 'progress-bar bg-info';
            progressBar.role = 'progressbar';
            progressBar.style.width = '0%';
            progressBar.style.transition = 'width 1.5s ease';
            progressBar.dataset.width = `${data.ratingDistribution[star] || 0}%`;

            progressBarContainer.appendChild(progressBar);

            const percentageText = document.createElement('span');
            percentageText.className = 'text-muted small text-end';
            percentageText.style.width = '35px';
            const totalVotes = Object.values(data.ratingDistribution).reduce((sum, count) => sum +
                count, 0);
            const percentage = totalVotes > 0 ? Math.round((data.ratingDistribution[star] || 0) /
                totalVotes * 100) : 0;

            percentageText.textContent =
                `${percentage}%`; // Affichage du pourcentage en nombre entier
            progressBar.style.width = `${percentage}%`; // Appliquer le pourcentage à la barre
            progressBar.dataset.width = `${percentage}%`; // Corriger l'animation


            row.appendChild(starLabel);
            row.appendChild(progressBarContainer);
            row.appendChild(percentageText);
            container.appendChild(row);
        });

        // Lien vers les commentaires
        const commentsLink = document.createElement('a');
        commentsLink.href = '#';
        commentsLink.className = 'd-block mt-2 text-primary small';
        commentsLink.textContent = 'See customer reviews ›';

        container.appendChild(commentsLink);
    }

    function animateProgressBars(popup) {
        const progressBars = popup.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            bar.style.width = '0%';
            const width = bar.dataset.width;
            setTimeout(() => {
                bar.style.width = width;
            }, 20);
        });
    }
