 // Function to handle animation when element comes into view
 function handleAnimation(entries, observer) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate'); // Add animate class when element is in view
        } else {
            entry.target.classList.remove('animate'); // Remove animate class when element is out of view
        }
    });
}

// Intersection Observer to observe when element comes into view
const observer = new IntersectionObserver(handleAnimation, { threshold: 0.5 });
document.querySelectorAll('.animated-section').forEach(section => {
    observer.observe(section);
});


// Show the button when user scrolls down 20px from the top of the document
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollToTopBtn").style.display = "block";
    } else {
        document.getElementById("scrollToTopBtn").style.display = "none";
    }
}

// Scroll to the top when the button is clicked
function scrollToTop() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}
