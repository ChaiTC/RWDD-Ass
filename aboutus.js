function toggleDescription(index) {
    let descriptions = document.querySelectorAll('.description');
    descriptions.forEach((desc, i) => {
        if (i === index) {
            desc.style.display = desc.style.display === 'block' ? 'none' : 'block';
        } else {
            desc.style.display = 'none';
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.querySelector(".menu-btn"); 
    const sidebar = document.querySelector(".sidebar");

    menuBtn.addEventListener("click", function () {
        sidebar.classList.toggle("active");
    });
});