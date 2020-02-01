// extend the Siema class to add dot based nav menu
class SiemaWithDots extends Siema {

    addDots() {
        // create a container for all dots
        this.dots = document.createElement('div');
        this.dots.classList.add('dots');

        // loop through slides to create a number of dots
        for(let i = 0; i < this.innerElements.length; i++) {
            // create a dot
            const dot = document.createElement('div');
            // add a class to dot
            dot.classList.add('dot');

            // add an event handler to each of them
            dot.addEventListener('click', () => {
                this.goTo(i);
            });
            // append dot to a container for all of them
            this.dots.appendChild(dot);
        }

        // add the container full of dots after selector
        this.selector.parentNode.insertBefore(this.dots, this.selector.nextSibling);
    }

    updateDots() {
        // loop through all dots
        for(let i = 0; i < this.dots.querySelectorAll('.dot').length; i++) {
            // if current dot matches currentSlide prop, add a class to it, remove otherwise
            const addOrRemove = this.currentSlide === i ? 'add' : 'remove';
            this.dots.querySelectorAll('.dot')[i].classList[addOrRemove]('active');
        }
    }
}
  
//Sets all slides in a set to the same height
function siemaEqualHeights(siemaSlider) {
    let maxHeight = 0;
    let slides = siemaSlider.querySelectorAll('.siema-slide-content');
    
    //Get tallest slide content element
    slides.forEach(function(slide) {
        if (slide.clientHeight > maxHeight) {
            maxHeight = slide.clientHeight;
        }
    });
    slides.forEach(function(slide) {
        slide.style.minHeight = maxHeight + 'px';
    });
}

//Initialize new siema sliders
function siemaInit(siemaSlider) {
    console.log('Siema Slider Initialized 🥑');
    siemaEqualHeights(siemaSlider);
}

//Supports multiple slider instances per page
const siemas = document.querySelectorAll('.wp-siema-slider');

siemas.forEach(function(siema) {
    let thisSiema = new SiemaWithDots({
        selector: siema,
        duration: 400,
        easing: 'ease-out',
        perPage: 1,
        startIndex: 0,
        draggable: true,
        multipleDrag: true,
        threshold: 20,
        loop: true,
        onInit: function(){
            this.addDots();
            this.updateDots();
            siemaInit(siema);
        },
        onChange: function(){
            this.updateDots()
        },
    });

    //Set timeout function for autoplay
    setInterval(() => thisSiema.next(), 7000);

    //Update content heights on window resize
    window.addEventListener('resize', function(event){
        siemaEqualHeights(siema);
    });

});