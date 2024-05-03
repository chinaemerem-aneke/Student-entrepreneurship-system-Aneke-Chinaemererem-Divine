const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const mainContent = document.querySelector('.main-content');

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
    mainContent.classList.toggle("blur-effect"); // Toggle blur effect on main content
});

document.querySelectorAll(".nav-item").forEach(n => n.addEventListener("click", () => {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
    mainContent.classList.remove("blur-effect"); // Remove blur effect when a nav item is clicked
}));

document.addEventListener("click", (e) => {
    if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
        mainContent.classList.remove("blur-effect"); // Remove blur effect when clicking outside
    }
});
