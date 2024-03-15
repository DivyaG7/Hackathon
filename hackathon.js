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