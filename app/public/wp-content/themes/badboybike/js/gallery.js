// Gallery functionality
class Gallery {
  constructor() {
    this.galleryGrid = document.getElementById('galleryGrid');
    this.motorcycles = motorcyclesData; // From motorcycles-data.js
    
    this.init();
  }
  
  init() {
    this.renderGallery();
  }
  
  renderGallery() {
    if (!this.galleryGrid) return;
    
    this.galleryGrid.innerHTML = '';
    
    this.motorcycles.forEach(bike => {
      const bikeCard = this.createBikeCard(bike);
      this.galleryGrid.appendChild(bikeCard);
    });
  }
  
  createBikeCard(bike) {
    const card = document.createElement('article');
    card.className = 'bike-card';
    card.dataset.bikeId = bike.id;
    
    // Create placeholder image if thumbnail doesn't exist
    const imgSrc = bike.thumbnail || 'images/placeholder-bike.svg';
    
    card.innerHTML = `
      <div class="bike-card__image">
        <img src="${imgSrc}" alt="${bike.name}" onerror="this.src='images/placeholder-bike.svg'">
      </div>
      <div class="bike-card__content">
        <h3 class="bike-card__name">${bike.name}</h3>
        <p class="bike-card__model">${bike.model} • ${bike.year}</p>
        <div class="bike-card__specs">
          <span class="bike-card__spec">
            <span>${bike.specs.engine}</span>
          </span>
          <span class="bike-card__spec">
            <span>${bike.specs.power}</span>
          </span>
        </div>
        <button class="btn btn--primary bike-card__btn">VIEW DETAILS</button>
      </div>
    `;
    
    // Add click event to open modal
    card.addEventListener('click', () => this.openBikeModal(bike.id));
    
    return card;
  }
  
  openBikeModal(bikeId) {
    // Find the bike data
    const bike = this.motorcycles.find(b => b.id === bikeId);
    if (!bike) return;
    
    // Trigger modal open with bike data
    if (window.bikeModal) {
      window.bikeModal.open(bike);
    }
  }
}

// Initialize gallery when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new Gallery();
});
