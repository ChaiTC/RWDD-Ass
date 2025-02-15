document.addEventListener("DOMContentLoaded", function () {
    const sidebarItems = document.querySelectorAll(".sidebar ul li");

    
    sidebarItems.forEach((item) => {
        item.addEventListener("mouseover", function () {
            this.style.backgroundColor = "#555";
        });
        item.addEventListener("mouseout", function () {
            this.style.backgroundColor = "";
        });
    });

    
    const retryBtn = document.querySelector(".retry-btn");
    if (retryBtn) {
        retryBtn.addEventListener("click", function () {
            this.style.transform = "scale(0.95)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 150);
        });
    }

    
    const chartCanvas = document.getElementById('scoreChart');
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');

        // Set fixed size for the chart
        chartCanvas.width = 300;
        chartCanvas.height = 300;

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
                responsive: false, 
                maintainAspectRatio: false, 
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }
});

