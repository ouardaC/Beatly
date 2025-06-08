document.addEventListener("DOMContentLoaded", function () {
  let starsContainer = document.querySelector(".rating-stars");
  let ratingInput = document.getElementById("rating-input");

  if (starsContainer && ratingInput) {
    let stars = starsContainer.querySelectorAll(".star");

    function highlightStars(value) {
      for (let i = 0; i < stars.length; i++) {
        let starValue = parseInt(stars[i].getAttribute("data-value"));

        if (starValue <= value) {
          stars[i].classList.add("text-warning");
          stars[i].classList.remove("text-muted");
        } else {
          stars[i].classList.remove("text-warning");
          stars[i].classList.add("text-muted");
        }
      }
    }

    for (let i = 0; i < stars.length; i++) {
      stars[i].addEventListener("mouseover", function () {
        let val = parseInt(this.getAttribute("data-value"));
        highlightStars(val);
      });

      stars[i].addEventListener("click", function () {
        let val = parseInt(this.getAttribute("data-value"));
        ratingInput.value = val;
        highlightStars(val);
      });
    }

    starsContainer.addEventListener("mouseout", function () {
      let currentValue = parseInt(ratingInput.value) || 0;
      highlightStars(currentValue);
    });

    // Initialisation à la valeur sélectionnée
    highlightStars(parseInt(ratingInput.value) || 0);
  }
});
document.addEventListener("DOMContentLoaded", function () {
  window.editReview = function (userId) {
    document
      .getElementById("comment-display-" + userId)
      .classList.add("d-none");
    document.getElementById("edit-form-" + userId).classList.remove("d-none");
  };

  window.cancelEdit = function (userId) {
    document.getElementById("edit-form-" + userId).classList.add("d-none");
    document
      .getElementById("comment-display-" + userId)
      .classList.remove("d-none");
  };
});
