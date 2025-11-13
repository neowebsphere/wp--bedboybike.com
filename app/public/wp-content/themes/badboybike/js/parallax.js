/**
 * Parallax Effect for Bad Boy Bike Theme
 */

(function() {
    'use strict';

    // Cache DOM elements
    const parallaxElements = document.querySelectorAll('.parallax-bg');
    
    if (parallaxElements.length === 0) return;

    // Performance optimization variables
    let ticking = false;
    let lastScrollY = 0;

    // Initialize parallax on page load
    function initParallax() {
        // Set initial position
        updateParallax();
        
        // Listen to scroll events
        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleResize, { passive: true });
    }

    // Handle scroll event with requestAnimationFrame for smooth performance
    function handleScroll() {
        lastScrollY = window.scrollY;
        
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }

    // Update parallax position
    function updateParallax() {
        parallaxElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const speed = parseFloat(element.dataset.speed) || 0.5;
            const yPos = -(lastScrollY * speed);
            
            // Only update if element is in viewport
            if (rect.bottom >= 0 && rect.top <= window.innerHeight) {
                const image = element.querySelector('.parallax-bg__image');
                if (image) {
                    image.style.transform = `translateY(${yPos}px) scale(1.2)`;
                }
            }
        });
        
        ticking = false;
    }

    // Handle window resize
    function handleResize() {
        updateParallax();
    }

    // Smooth parallax effect for About section specifically
    function initAboutParallax() {
        const aboutSection = document.querySelector('#about');
        if (!aboutSection) return;
        
        const parallaxBg = aboutSection.querySelector('.parallax-bg');
        if (!parallaxBg) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add smooth transition when section comes into view
                    parallaxBg.style.transition = 'transform 0.1s ease-out';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '100px'
        });
        
        observer.observe(aboutSection);
    }

    // Mobile optimization - disable parallax on small screens for performance
    function checkMobile() {
        const isMobile = window.innerWidth <= 768;
        
        parallaxElements.forEach(element => {
            const image = element.querySelector('.parallax-bg__image');
            if (image) {
                if (isMobile) {
                    // Fixed position on mobile for better performance
                    image.style.transform = 'scale(1.1)';
                    element.style.position = 'relative';
                } else {
                    // Re-enable parallax on desktop
                    element.style.position = 'absolute';
                    updateParallax();
                }
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initParallax();
            initAboutParallax();
            checkMobile();
        });
    } else {
        initParallax();
        initAboutParallax();
        checkMobile();
    }

    // Re-check mobile on resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(checkMobile, 250);
    });

})();
