// Function to toggle the sidebar visibility
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");

    if (sidebar) {
        console.log("Toggling sidebar...");  // Debugging message

        sidebar.classList.toggle("active");  // Toggle the 'active' class on the sidebar
        console.log("Sidebar class after toggle:", sidebar.classList);  // Check the class

    } else {
        console.error("Sidebar not found.");
    }
}

// Wait for the DOM to load before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".sidebar").classList.add("active");

    const menuBtn = document.querySelector(".menu-btn");

    if (menuBtn) {
        console.log("Menu button clicked.");  // Debugging message
        menuBtn.addEventListener("click", function () {
            toggleSidebar();  // Call toggleSidebar when the button is clicked
        });
    } else {
        console.error("Menu button not found.");
    }
});
