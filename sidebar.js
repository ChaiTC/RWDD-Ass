// Toggling the sidebar visibility by adding/removing the 'active' class
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");
    if (sidebar) {
        sidebar.classList.toggle("active");  // Toggle the 'active' class
    } else {
        console.error("Sidebar not found.");
    }
}

// Wait for the DOM to load before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".menu-btn");

    // Attach the click event listener to the menu button
    menuBtn.addEventListener("click", function () {
        toggleSidebar();  // Call the toggleSidebar function to show/hide the sidebar
    });
});
