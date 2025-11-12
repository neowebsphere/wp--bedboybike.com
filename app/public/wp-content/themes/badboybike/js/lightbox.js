// Simple Lightbox for WP Gallery images on the Gallery page
(function() {
  class SimpleLightbox {
    constructor(containerSelector) {
      this.container = document.querySelector(containerSelector);
      if (!this.container) return;
      this.items = [];
      this.currentIndex = -1;
      this.buildItemsList();
      if (this.items.length === 0) return;
      this.createOverlay();
      this.bindEvents();
    }
    
    buildItemsList() {
      const imgNodes = this.container.querySelectorAll(
        '.wp-block-gallery img, .blocks-gallery-grid img'
      );
      this.items = Array.from(imgNodes).map((img) => {
        const parentLink = img.closest('a');
        const source = parentLink ? parentLink.getAttribute('href') : img.getAttribute('src');
        const alt = img.getAttribute('alt') || '';
        return { source, alt, node: img };
      }).filter(item => !!item.source);
    }
    
    createOverlay() {
      this.overlay = document.createElement('div');
      this.overlay.className = 'lightbox';
      this.overlay.setAttribute('aria-hidden', 'true');
      this.overlay.innerHTML = `
        <button class="lightbox__close" aria-label="Close">&times;</button>
        <button class="lightbox__nav lightbox__prev" aria-label="Previous">&#8249;</button>
        <div class="lightbox__content">
          <img class="lightbox__image" alt="">
        </div>
        <button class="lightbox__nav lightbox__next" aria-label="Next">&#8250;</button>
      `;
      document.body.appendChild(this.overlay);
      this.imgEl = this.overlay.querySelector('.lightbox__image');
      this.closeBtn = this.overlay.querySelector('.lightbox__close');
      this.prevBtn = this.overlay.querySelector('.lightbox__prev');
      this.nextBtn = this.overlay.querySelector('.lightbox__next');
    }
    
    bindEvents() {
      this.items.forEach((item, index) => {
        item.node.addEventListener('click', (e) => {
          // Prevent following the link (if present)
          if (item.node.closest('a')) e.preventDefault();
          this.open(index);
        });
      });
      
      this.closeBtn.addEventListener('click', () => this.close());
      this.prevBtn.addEventListener('click', () => this.showPrev());
      this.nextBtn.addEventListener('click', () => this.showNext());
      
      this.overlay.addEventListener('click', (e) => {
        if (e.target === this.overlay) this.close();
      });
      
      document.addEventListener('keydown', (e) => {
        if (!this.isOpen()) return;
        if (e.key === 'Escape') this.close();
        if (e.key === 'ArrowLeft') this.showPrev();
        if (e.key === 'ArrowRight') this.showNext();
      });
    }
    
    isOpen() {
      return this.overlay.classList.contains('lightbox--open');
    }
    
    open(index) {
      this.currentIndex = index;
      this.updateImage();
      this.overlay.classList.add('lightbox--open');
      this.overlay.setAttribute('aria-hidden', 'false');
      document.body.classList.add('no-scroll');
    }
    
    close() {
      this.overlay.classList.remove('lightbox--open');
      this.overlay.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('no-scroll');
    }
    
    showPrev() {
      this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
      this.updateImage();
    }
    
    showNext() {
      this.currentIndex = (this.currentIndex + 1) % this.items.length;
      this.updateImage();
    }
    
    updateImage() {
      const item = this.items[this.currentIndex];
      if (!item) return;
      this.imgEl.style.opacity = '0';
      const nextSrc = item.source;
      const nextAlt = item.alt || '';
      // Fade swap
      setTimeout(() => {
        this.imgEl.src = nextSrc;
        this.imgEl.alt = nextAlt;
        this.imgEl.onload = () => {
          this.imgEl.style.opacity = '1';
        };
      }, 100);
    }
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    // Only initialize on pages containing our gallery section
    const gallerySection = document.querySelector('section.gallery');
    if (gallerySection) {
      new SimpleLightbox('section.gallery .gallery__content');
      // Back-compat: if content wrapper not present, try whole section
      if (!document.querySelector('section.gallery .gallery__content')) {
        new SimpleLightbox('section.gallery');
      }
    }
  });
})();


