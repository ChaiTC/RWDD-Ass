function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");

    if (sidebar) {
        sidebar.classList.toggle("active");
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".menu-btn");

    if (menuBtn) {
        menuBtn.addEventListener("click", toggleSidebar);
    } else {
        console.error("Menu button not found!");
    }
});
