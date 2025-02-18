document.addEventListener("DOMContentLoaded", function () {
    const retryBtn = document.querySelector(".retry-btn");
    const menuBtn = document.querySelector(".menu-btn"); 
    const sidebar = document.querySelector(".sidebar");

    // Retry button animation
    if (retryBtn) {
        retryBtn.addEventListener("click", function () {
            this.style.transform = "scale(0.95)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 150);
        });
    }

    // Toggle sidebar on menu button click
    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
        });
    }

    // Chart.js for displaying the result chart
    const ctx = document.getElementById('scoreChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Correct Answers', 'Incorrect Answers'],
            datasets: [{
                data: [score, totalQuestions - score],
                backgroundColor: ['#27ae60', '#e74c3c']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    
    function adjustForMobile() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove("active"); // Close sidebar on small screens
            document.body.style.flexDirection = "column"; // Stack elements vertically

            if (retryBtn) {
                retryBtn.style.width = "100%"; // Full-width button
            }
        } else {
            document.body.style.flexDirection = "row"; // Default layout for larger screens
        }
    }

    // Run on page load
    adjustForMobile();

    // Run on window resize
    window.addEventListener("resize", adjustForMobile);
});

