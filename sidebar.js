document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".menu-btn"); 
    const sidebar = document.querySelector(".sidebar");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            console.log("Menu button clicked!"); // Debug log
            sidebar.classList.toggle("active");
            console.log("Sidebar classes:", sidebar.classList);
        });
    } else {
        console.error("Sidebar or Menu button not found!");
    }
});
