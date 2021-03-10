// Globals

// Click listener for setting star ratings
document.querySelectorAll('.star-rating').forEach(starRating => {
    starRating.addEventListener('click', function (e) {
        let action = 'add';
        starRating.querySelectorAll('span').forEach(star => {
            star.classList[action]('active');
            if (star === e.target) {
                action = 'remove';
                starRating.dataset.rating = star.dataset.rating;
            }
        });
        // Check all contest ratings
        if (checkContestRatings(starRating.dataset.contestId)) {
            // Show form details
            document.querySelector('#wp-photo-contest-form-details-'+starRating.dataset.contestId).classList.add('active');
        }
    });
});

// Check each contest rating, return true if all have been finished
function checkContestRatings(contestId) {
    const form = document.querySelector('#wp-photo-contest-form-'+contestId);
    let allRated = true;
    form.querySelectorAll('.star-rating').forEach(starRating => {
        if (typeof(starRating.dataset.rating) === 'undefined' || starRating.dataset.rating < 1 ) {
            allRated = false;
        }
    });

    return allRated;
}

// Validate Form


// Submit Form Via Ajax
