// loader js start
$(document).ready(function () {
  $('.preloader').delay(500).fadeOut(500);
});

// loader js end


// main counter js start'

let count = document.querySelectorAll(".count")
let arr = Array.from(count)



arr.map(function (item) {
  let startnumber = 0

  function counterup() {
    startnumber++
    item.innerHTML = startnumber

    if (startnumber == item.dataset.number) {
      clearInterval(stop)
    }
  }

  let stop = setInterval(function () {
    counterup()
  }, 0)

})
// main counter js end



// happy customer js start
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 30,
  autoplay: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
      spaceBetween: 20
    },
    // when window width is >= 480px
    480: {
      slidesPerView: 2,
      spaceBetween: 20
    },
    // when window width is >= 640px
    540: {
      slidesPerView: 2,
      spaceBetween: 20
    },
    767: {
      slidesPerView: 3,
      spaceBetween: 20
    },
    1200: {
      slidesPerView: 4,
      spaceBetween: 20
    }
  }
});
// happy customer js end



// blog js start
var swiper = new Swiper(".blog-slider", {
  slidesPerView: 1,
  spaceBetween: 30,
  autoplay: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }

});
// blog customer js end


const $button = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');

$button.addEventListener('click', (e) => {
  e.preventDefault();
  $wrapper.classList.toggle('toggled');
});

document.getElementById('contact-form').addEventListener('submit', function (event) {
  event.preventDefault();
  Swal.fire({
    title: 'Success!',
    text: 'Your message has been sent successfully.',
    icon: 'success',
    confirmButtonText: 'OK'
  });
});
