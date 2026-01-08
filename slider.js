class TeamSlider {
    constructor() {
        this.track = document.getElementById('sliderTrack');
        this.prevBtn = document.querySelector('.slider-prev');
        this.nextBtn = document.querySelector('.slider-next');
        this.dotsContainer = document.getElementById('sliderDots');
        this.cards = document.querySelectorAll('.team .card');
        
        this.currentIndex = 0;
        this.cardWidth = 0;
        this.visibleCards = 3;
        this.maxIndex = 0;
        
        this.init();
    }
    
    init() {
        this.updateVisibleCards();
        this.maxIndex = this.cards.length - this.visibleCards;
        this.createDots();
        this.updateSlider();
        this.bindEvents();
    }
    
    updateVisibleCards() {
        const width = window.innerWidth;
        if (width < 480) this.visibleCards = 1;
        else if (width < 768) this.visibleCards = 2;
        else this.visibleCards = 3;
    }
    
    createDots() {
        this.dotsContainer.innerHTML = '';
        const totalDots = Math.ceil(this.cards.length / this.visibleCards);
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('span');
            dot.className = 'dot';
            dot.addEventListener('click', () => this.goToIndex(i));
            this.dotsContainer.appendChild(dot);
        }
    }
    
    bindEvents() {
        this.prevBtn.addEventListener('click', () => this.move(-1));
        this.nextBtn.addEventListener('click', () => this.move(1));
        window.addEventListener('resize', () => {
            this.updateVisibleCards();
            this.maxIndex = this.cards.length - this.visibleCards;
            this.updateSlider();
        });
    }
    
    move(direction) {
        this.currentIndex += direction;
        if (this.currentIndex < 0) this.currentIndex = 0;
        if (this.currentIndex > this.maxIndex) this.currentIndex = this.maxIndex;
        this.updateSlider();
    }
    
    goToIndex(index) {
        this.currentIndex = index * this.visibleCards;
        if (this.currentIndex > this.maxIndex) this.currentIndex = this.maxIndex;
        this.updateSlider();
    }
    
    updateSlider() {
        this.cardWidth = this.cards[0].offsetWidth + 24;
        const translateX = -this.currentIndex * this.cardWidth;
        this.track.style.transform = `translateX(${translateX}px)`;
        
        this.updateButtons();
        this.updateDots();
    }
    
    updateButtons() {
        this.prevBtn.disabled = this.currentIndex === 0;
        this.nextBtn.disabled = this.currentIndex >= this.maxIndex;
    }
    
    updateDots() {
        const dots = this.dotsContainer.querySelectorAll('.dot');
        const activeDot = Math.floor(this.currentIndex / this.visibleCards);
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === activeDot);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new TeamSlider();
});