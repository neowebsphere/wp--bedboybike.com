/**
 * Gallery Slider with Lightbox
 * Handles image slider and lightbox functionality
 */

class GallerySlider {
    constructor() {
        this.currentSlide = 0;
        this.slider = document.getElementById('gallerySlider');
        this.sliderTrack = document.getElementById('sliderTrack');
        this.slides = document.querySelectorAll('.gallery__slide');
        this.indicators = document.querySelectorAll('.gallery__indicator');
        this.thumbnails = document.querySelectorAll('.gallery__thumbnail');
        this.images = document.querySelectorAll('.gallery__image');
        
        // Controls
        this.prevBtn = document.getElementById('prevSlide');
        this.nextBtn = document.getElementById('nextSlide');
        
        // Lightbox elements
        this.lightbox = null;
        this.lightboxImage = null;
        this.currentLightboxIndex = 0;
        
        // Auto-play settings
        this.autoPlayInterval = null;
        this.autoPlayDelay = 4000; // 4 seconds for smoother experience
        
        // Performance optimization flags
        this.isTransitioning = false;
        this.preloadedImages = new Set();
        
        if (this.slides.length > 0) {
            this.init();
        }
    }
    
    init() {
        this.createLightbox();
        this.bindEvents();
        this.preloadNearbyImages();
        this.startAutoPlay();
        
        // Enable GPU acceleration for smoother animations
        if (this.slider) {
            this.slider.style.transform = 'translateZ(0)';
        }
    }
    
    preloadNearbyImages() {
        // Preload next 2 and previous 1 images for smoother transitions
        const preloadIndexes = [
            (this.currentSlide - 1 + this.images.length) % this.images.length,
            (this.currentSlide + 1) % this.images.length,
            (this.currentSlide + 2) % this.images.length
        ];
        
        preloadIndexes.forEach(index => {
            if (!this.preloadedImages.has(index) && this.images[index]) {
                const img = new Image();
                img.src = this.images[index].src;
                this.preloadedImages.add(index);
            }
        });
    }
    
    createLightbox() {
        // Create lightbox overlay
        this.lightbox = document.createElement('div');
        this.lightbox.className = 'gallery-lightbox';
        this.lightbox.innerHTML = `
            <div class="gallery-lightbox__content">
                <button class="gallery-lightbox__close" aria-label="Close">×</button>
                <button class="gallery-lightbox__nav gallery-lightbox__prev" aria-label="Previous">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="gallery-lightbox__nav gallery-lightbox__next" aria-label="Next">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <div class="gallery-lightbox__image-wrapper">
                    <img class="gallery-lightbox__image" src="" alt="">
                    <div class="gallery-lightbox__counter">
                        <span class="current">1</span> / <span class="total">${this.images.length}</span>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(this.lightbox);
        
        // Cache lightbox elements
        this.lightboxImage = this.lightbox.querySelector('.gallery-lightbox__image');
        this.lightboxClose = this.lightbox.querySelector('.gallery-lightbox__close');
        this.lightboxPrev = this.lightbox.querySelector('.gallery-lightbox__prev');
        this.lightboxNext = this.lightbox.querySelector('.gallery-lightbox__next');
        this.lightboxCounter = this.lightbox.querySelector('.gallery-lightbox__counter');
    }
    
    bindEvents() {
        // Slider controls
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => {
                this.stopAutoPlay();
                this.prevSlide();
                this.startAutoPlay();
            });
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => {
                this.stopAutoPlay();
                this.nextSlide();
                this.startAutoPlay();
            });
        }
        
        // Indicators
        this.indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                this.stopAutoPlay();
                this.goToSlide(index);
                this.startAutoPlay();
            });
        });
        
        // Thumbnails
        this.thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => {
                this.stopAutoPlay();
                this.goToSlide(index);
                this.startAutoPlay();
            });
        });
        
        // Images - open lightbox on click
        this.images.forEach((image, index) => {
            image.addEventListener('click', () => {
                this.openLightbox(index);
            });
            image.style.cursor = 'pointer';
        });
        
        // Lightbox controls
        this.lightboxClose.addEventListener('click', () => this.closeLightbox());
        this.lightboxPrev.addEventListener('click', () => this.lightboxPrevImage());
        this.lightboxNext.addEventListener('click', () => this.lightboxNextImage());
        
        // Close lightbox on overlay click
        this.lightbox.addEventListener('click', (e) => {
            if (e.target === this.lightbox || e.target.classList.contains('gallery-lightbox__content')) {
                this.closeLightbox();
            }
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (this.lightbox.classList.contains('active')) {
                if (e.key === 'Escape') this.closeLightbox();
                if (e.key === 'ArrowLeft') this.lightboxPrevImage();
                if (e.key === 'ArrowRight') this.lightboxNextImage();
            } else if (this.slider && this.slider.contains(document.activeElement)) {
                if (e.key === 'ArrowLeft') {
                    this.stopAutoPlay();
                    this.prevSlide();
                    this.startAutoPlay();
                }
                if (e.key === 'ArrowRight') {
                    this.stopAutoPlay();
                    this.nextSlide();
                    this.startAutoPlay();
                }
            }
        });
        
        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;
        
        if (this.slider) {
            this.slider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });
            
            this.slider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe(touchStartX, touchEndX);
            });
        }
    }
    
    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            this.stopAutoPlay();
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.prevSlide();
            }
            this.startAutoPlay();
        }
    }
    
    goToSlide(index) {
        // Prevent multiple transitions at once
        if (this.isTransitioning) return;
        this.isTransitioning = true;
        
        // Use requestAnimationFrame for smoother transitions
        requestAnimationFrame(() => {
            // Remove active class from current slide
            if (this.slides[this.currentSlide]) {
                this.slides[this.currentSlide].classList.remove('active');
            }
            if (this.indicators[this.currentSlide]) {
                this.indicators[this.currentSlide].classList.remove('active');
            }
            
            // Update current slide
            this.currentSlide = index;
            
            // Add active class to new slide with a small delay for smoother transition
            setTimeout(() => {
                if (this.slides[this.currentSlide]) {
                    this.slides[this.currentSlide].classList.add('active');
                }
                if (this.indicators[this.currentSlide]) {
                    this.indicators[this.currentSlide].classList.add('active');
                }
                
                // Preload nearby images
                this.preloadNearbyImages();
                
                // Reset transition flag
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 400);
            }, 10);
            
            // Update thumbnails active state
            this.thumbnails.forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });
        });
    }
    
    nextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.goToSlide(nextIndex);
    }
    
    prevSlide() {
        const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        this.goToSlide(prevIndex);
    }
    
    startAutoPlay() {
        if (this.slides.length <= 1) return;
        
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    // Lightbox methods
    openLightbox(index) {
        this.currentLightboxIndex = index;
        const image = this.images[index];
        
        // Pre-load image for smoother opening
        const tempImg = new Image();
        tempImg.onload = () => {
            this.lightboxImage.src = image.src;
            this.lightboxImage.alt = image.alt;
            
            this.updateLightboxCounter();
            
            // Use requestAnimationFrame for smooth opening
            requestAnimationFrame(() => {
                this.lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        };
        tempImg.src = image.src;
        
        // Stop slider auto-play when lightbox is open
        this.stopAutoPlay();
    }
    
    closeLightbox() {
        this.lightbox.classList.remove('active');
        
        // Delay overflow reset for smoother closing animation
        setTimeout(() => {
            document.body.style.overflow = '';
        }, 300);
        
        // Restart slider auto-play
        this.startAutoPlay();
    }
    
    lightboxNextImage() {
        this.currentLightboxIndex = (this.currentLightboxIndex + 1) % this.images.length;
        this.updateLightboxImage();
    }
    
    lightboxPrevImage() {
        this.currentLightboxIndex = (this.currentLightboxIndex - 1 + this.images.length) % this.images.length;
        this.updateLightboxImage();
    }
    
    updateLightboxImage() {
        const image = this.images[this.currentLightboxIndex];
        
        // Smooth fade transition
        this.lightboxImage.style.opacity = '0';
        this.lightboxImage.style.transform = 'scale(0.95)';
        
        // Use requestAnimationFrame for smoother animation
        requestAnimationFrame(() => {
            setTimeout(() => {
                this.lightboxImage.src = image.src;
                this.lightboxImage.alt = image.alt;
                
                // Fade in with scale animation
                this.lightboxImage.onload = () => {
                    requestAnimationFrame(() => {
                        this.lightboxImage.style.opacity = '1';
                        this.lightboxImage.style.transform = 'scale(1)';
                    });
                };
                
                this.updateLightboxCounter();
            }, 150);
        });
    }
    
    updateLightboxCounter() {
        const current = this.lightboxCounter.querySelector('.current');
        current.textContent = this.currentLightboxIndex + 1;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new GallerySlider();
});
