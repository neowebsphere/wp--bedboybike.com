// Modal functionality
class BikeModal {
  constructor() {
    this.modal = document.getElementById('bikeModal');
    this.modalClose = document.getElementById('modalClose');
    this.modalMainImage = document.getElementById('modalMainImage');
    this.modalThumbnails = document.getElementById('modalThumbnails');
    this.modalTitle = document.getElementById('modalTitle');
    this.modalModel = document.getElementById('modalModel');
    this.modalDescription = document.getElementById('modalDescription');
    this.modalSpecs = document.getElementById('modalSpecs');
    this.modalModifications = document.getElementById('modalModifications');
    
    this.currentBike = null;
    this.currentImageIndex = 0;
    
    this.init();
  }
  
  init() {
    // Close button
    this.modalClose.addEventListener('click', () => this.close());
    
    // Close on background click
    this.modal.addEventListener('click', (e) => {
      if (e.target === this.modal) {
        this.close();
      }
    });
    
    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.modal.classList.contains('active')) {
        this.close();
      }
    });
    
    // Arrow keys for image navigation
    document.addEventListener('keydown', (e) => {
      if (!this.modal.classList.contains('active')) return;
      
      if (e.key === 'ArrowLeft') {
        this.previousImage();
      } else if (e.key === 'ArrowRight') {
        this.nextImage();
      }
    });
  }
  
  open(bike) {
    this.currentBike = bike;
    this.currentImageIndex = 0;
    
    this.renderModalContent();
    
    this.modal.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
  
  close() {
    this.modal.classList.remove('active');
    document.body.style.overflow = '';
  }
  
  renderModalContent() {
    if (!this.currentBike) return;
    
    const bike = this.currentBike;
    
    // Set title and model
    this.modalTitle.textContent = bike.name;
    this.modalModel.textContent = `${bike.model} • ${bike.year} • ${bike.category}`;
    
    // Set description
    this.modalDescription.textContent = bike.description;
    
    // Set main image
    const mainImageSrc = bike.images && bike.images.length > 0 
      ? bike.images[0] 
      : bike.thumbnail || 'images/placeholder-bike.svg';
    this.modalMainImage.src = mainImageSrc;
    this.modalMainImage.alt = bike.name;
    
    // Render thumbnails
    this.renderThumbnails();
    
    // Render specifications
    this.renderSpecs();
    
    // Render modifications
    this.renderModifications();
  }
  
  renderThumbnails() {
    if (!this.currentBike.images || this.currentBike.images.length === 0) {
      this.modalThumbnails.innerHTML = '';
      return;
    }
    
    this.modalThumbnails.innerHTML = '';
    
    this.currentBike.images.forEach((imageSrc, index) => {
      const thumbnail = document.createElement('div');
      thumbnail.className = 'modal__thumbnail';
      if (index === this.currentImageIndex) {
        thumbnail.classList.add('active');
      }
      
      thumbnail.innerHTML = `
        <img src="${imageSrc}" alt="${this.currentBike.name} - Image ${index + 1}" onerror="this.src='images/placeholder-bike.svg'">
      `;
      
      thumbnail.addEventListener('click', () => this.setImage(index));
      
      this.modalThumbnails.appendChild(thumbnail);
    });
  }
  
  renderSpecs() {
    this.modalSpecs.innerHTML = '';
    
    const specs = this.currentBike.specs;
    
    for (const [key, value] of Object.entries(specs)) {
      const specElement = document.createElement('div');
      specElement.className = 'modal__spec';
      
      const label = key.charAt(0).toUpperCase() + key.slice(1);
      
      specElement.innerHTML = `
        <span class="modal__spec-label">${label}</span>
        <span class="modal__spec-value">${value}</span>
      `;
      
      this.modalSpecs.appendChild(specElement);
    }
    
    // Add status
    const statusElement = document.createElement('div');
    statusElement.className = 'modal__spec';
    statusElement.innerHTML = `
      <span class="modal__spec-label">Status</span>
      <span class="modal__spec-value">${this.currentBike.status}</span>
    `;
    this.modalSpecs.appendChild(statusElement);
  }
  
  renderModifications() {
    this.modalModifications.innerHTML = '';
    
    if (!this.currentBike.modifications || this.currentBike.modifications.length === 0) {
      return;
    }
    
    this.currentBike.modifications.forEach(mod => {
      const modElement = document.createElement('div');
      modElement.className = 'modal__modification';
      modElement.textContent = mod;
      
      this.modalModifications.appendChild(modElement);
    });
  }
  
  setImage(index) {
    if (!this.currentBike.images || index < 0 || index >= this.currentBike.images.length) {
      return;
    }
    
    this.currentImageIndex = index;
    this.modalMainImage.src = this.currentBike.images[index];
    
    // Update active thumbnail
    const thumbnails = this.modalThumbnails.querySelectorAll('.modal__thumbnail');
    thumbnails.forEach((thumb, i) => {
      if (i === index) {
        thumb.classList.add('active');
      } else {
        thumb.classList.remove('active');
      }
    });
  }
  
  nextImage() {
    if (!this.currentBike.images) return;
    
    const nextIndex = (this.currentImageIndex + 1) % this.currentBike.images.length;
    this.setImage(nextIndex);
  }
  
  previousImage() {
    if (!this.currentBike.images) return;
    
    const prevIndex = (this.currentImageIndex - 1 + this.currentBike.images.length) % this.currentBike.images.length;
    this.setImage(prevIndex);
  }
}

// Initialize modal and make it globally accessible
document.addEventListener('DOMContentLoaded', () => {
  window.bikeModal = new BikeModal();
});
