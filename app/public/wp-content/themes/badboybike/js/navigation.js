// Navigation functionality
class Navigation {
  constructor() {
    this.nav = document.getElementById('nav');
    this.navToggle = document.getElementById('navToggle');
    this.navLinks = document.querySelectorAll('.nav__link');
    this.header = document.querySelector('.header');
    
    this.init();
  }
  
  init() {
    // Mobile menu toggle
    this.navToggle.addEventListener('click', () => this.toggleMenu());
    
    // Close menu when clicking on links
    this.navLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        this.handleLinkClick(e);
        this.closeMenu();
      });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!this.nav.contains(e.target) && !this.navToggle.contains(e.target)) {
        this.closeMenu();
      }
    });
    
    // Highlight active section on scroll
    window.addEventListener('scroll', () => this.highlightActiveSection());
    
    // Header background on scroll
    window.addEventListener('scroll', () => this.handleHeaderScroll());
  }
  
  toggleMenu() {
    this.nav.classList.toggle('active');
    this.navToggle.classList.toggle('active');
  }
  
  closeMenu() {
    this.nav.classList.remove('active');
    this.navToggle.classList.remove('active');
  }
  
  handleLinkClick(e) {
    const href = e.target.getAttribute('href');
    
    // If it's an anchor link, handle smooth scroll
    if (href.startsWith('#')) {
      e.preventDefault();
      const targetId = href.substring(1);
      const targetSection = document.getElementById(targetId);
      
      if (targetSection) {
        const headerHeight = this.header.offsetHeight;
        const targetPosition = targetSection.offsetTop - headerHeight;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    }
  }
  
  highlightActiveSection() {
    const scrollPosition = window.scrollY + this.header.offsetHeight + 100;
    
    // Get all sections
    const sections = document.querySelectorAll('section[id]');
    
    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionBottom = sectionTop + section.offsetHeight;
      const sectionId = section.getAttribute('id');
      
      if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
        // Remove active class from all links
        this.navLinks.forEach(link => link.classList.remove('active'));
        
        // Add active class to current section link
        const activeLink = document.querySelector(`.nav__link[href="#${sectionId}"]`);
        if (activeLink) {
          activeLink.classList.add('active');
        }
      }
    });
  }
  
  handleHeaderScroll() {
    if (window.scrollY > 100) {
      this.header.style.backgroundColor = 'rgba(13, 13, 13, 0.98)';
    } else {
      this.header.style.backgroundColor = 'rgba(13, 13, 13, 0.95)';
    }
  }
}

// Initialize navigation when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  new Navigation();
});
