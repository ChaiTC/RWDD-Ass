document.addEventListener("DOMContentLoaded", function () {
    const retryBtn = document.querySelector(".retry-btn");
    const menuBtn = document.querySelector(".menu-btn"); 
    const sidebar = document.querySelector(".sidebar");


    if (retryBtn) {
        retryBtn.addEventListener("click", function () {
            this.style.transform = "scale(0.95)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 150);
        });
    }

 
    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
        });
    }


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
            sidebar.classList.remove("active"); 
            document.body.style.flexDirection = "column"; 

            if (retryBtn) {
                retryBtn.style.width = "100%"; 
            }
        } else {
            document.body.style.flexDirection = "row"; 
        }
    }


    adjustForMobile();


    window.addEventListener("resize", adjustForMobile);
});

