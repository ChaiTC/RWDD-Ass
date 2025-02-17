// Function to toggle the sidebar visibility
function toggleSidebar() {
    const sidebar = document.querySelector(".sidebar");

    if (sidebar) {
        console.log("Toggling sidebar...");  // Debugging message

        // Toggle the 'active' class on the sidebar (this will show/hide it)
        sidebar.classList.toggle("active");

        console.log("Sidebar class after toggle:", sidebar.classList);  // Check the class

    } else {
        console.error("Sidebar not found.");
    }
}

// Wait for the DOM to load before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".menu-btn");

    // Ensure the menu button exists before attaching the event listener
    if (menuBtn) {
        console.log("Menu button found.");  // Debugging message
        menuBtn.addEventListener("click", function () {
            toggleSidebar();  // Call toggleSidebar when the button is clicked
        });
    } else {
        console.error("Menu button not found.");
    }
});
