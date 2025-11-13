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
        // Ensure overlay is visible on load
        parallaxElements.forEach(element => {
            const overlay = element.querySelector('.parallax-overlay');
            if (overlay) {
                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';
            }
            
            // Set initial image position
            const image = element.querySelector('.parallax-bg__image');
            if (image) {
                image.style.transform = 'translate3d(0, 0, 0) scale(1.2)';
            }
        });
        
        // Set initial position after a small delay to ensure DOM is ready
        setTimeout(() => {
            updateParallax();
        }, 100);
        
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
            
            // Calculate the offset based on the element's position relative to viewport
            const elementTop = rect.top + lastScrollY;
            const elementHeight = rect.height;
            const windowHeight = window.innerHeight;
            
            // Calculate parallax offset
            const scrolled = lastScrollY - (elementTop - windowHeight);
            const yPos = -(scrolled * speed);
            
            // Only update if element is in viewport or near it
            if (rect.bottom >= -100 && rect.top <= windowHeight + 100) {
                const image = element.querySelector('.parallax-bg__image');
                if (image) {
                    // Use transform3d for better GPU acceleration
                    image.style.transform = `translate3d(0, ${yPos}px, 0) scale(1.2)`;
                }
                
                // Ensure overlay is visible
                const overlay = element.querySelector('.parallax-overlay');
                if (overlay && !overlay.style.opacity) {
                    overlay.style.opacity = '1';
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
        
        // Ensure overlay exists and is visible
        const overlay = parallaxBg.querySelector('.parallax-overlay');
        if (overlay) {
            overlay.style.opacity = '1';
            overlay.style.visibility = 'visible';
            // Add a smooth fade-in animation
            overlay.style.transition = 'opacity 0.5s ease-in-out';
        }
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add smooth transition when section comes into view
                    parallaxBg.style.transition = 'transform 0.1s ease-out';
                    
                    // Ensure overlay remains visible
                    if (overlay) {
                        overlay.style.opacity = '1';
                    }
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
