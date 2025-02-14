document.addEventListener("DOMContentLoaded", function () {
    const questions = document.querySelectorAll(".question");
    const prevBtn = document.getElementById("prev-btn");
    const nextBtn = document.getElementById("next-btn");
    const submitBtn = document.getElementById("submit-btn");

    let currentIndex = 0;

    function updateButtons() {
        prevBtn.disabled = currentIndex === 0;
        nextBtn.style.display = currentIndex === questions.length - 1 ? "none" : "inline-block";
        submitBtn.style.display = currentIndex === questions.length - 1 ? "inline-block" : "none";
    }

    function showQuestion(index) {
        questions.forEach((q, i) => {
            q.style.display = i === index ? "block" : "none";
        });
        updateButtons();
    }

    prevBtn.addEventListener("click", function () {
        if (currentIndex > 0) {
            currentIndex--;
            showQuestion(currentIndex);
        }
    });

    nextBtn.addEventListener("click", function () {
        if (currentIndex < questions.length - 1) {
            currentIndex++;
            showQuestion(currentIndex);
        }
    });

    showQuestion(currentIndex);

    // Change color when option is selected
    document.querySelectorAll(".option-input").forEach((input) => {
        input.addEventListener("change", function () {
            document.querySelectorAll(`input[name="${this.name}"] + .option-text`).forEach((label) => {
                label.style.background = "#f1f1f1";
                label.style.color = "black";
            });
            this.nextElementSibling.style.background = "#3498db";
            this.nextElementSibling.style.color = "white";
        });
    });
});


