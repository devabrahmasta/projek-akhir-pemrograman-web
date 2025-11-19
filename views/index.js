// document.addEventListener('DOMContentLoaded', () => {
//   const testimonials = document.querySelectorAll('.testimonial');
//   const container = document.getElementById('testimonialContainer');
//   const nextBtn = document.getElementById('nextBtn');
//   const prevBtn = document.getElementById('prevBtn');

//   console.log("aefeswebw")

//   const visiblePerRow = 2; // dua kolom (col-sm-5)
//   const totalSlides = Math.ceil(testimonials.length / visiblePerRow);
//   let currentSlide = 0;

//   function showSlide(index) {
//     testimonials.forEach((t, i) => {
//       const start = index * visiblePerRow;
//       const end = start + visiblePerRow;
//       t.style.display = i >= start && i < end ? 'block' : 'none';
//     });

//     // kalau jumlah item di batch terakhir cuma 1 → ubah justify-content
//     const remaining = testimonials.length - index * visiblePerRow;
//     if (remaining === 1) {
//       container.classList.remove('justify-content-evenly');
//       container.classList.add('justify-content-start');
//     } else {
//       container.classList.remove('justify-content-start');
//       container.classList.add('justify-content-evenly');
//     }
//   }

//   showSlide(currentSlide);

//   nextBtn.addEventListener('click', () => {
//     currentSlide = (currentSlide + 1) % totalSlides;
//     showSlide(currentSlide);
//   });

//   prevBtn.addEventListener('click', () => {
//     currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
//     showSlide(currentSlide);
//   });
// });

// scroll infinite
const container = document.querySelector('.testimonial');

let scrollSpeed = 1; // bisa kamu atur

function autoScroll() {
  container.scrollLeft += scrollSpeed;

  if (container.scrollLeft >= container.scrollWidth - container.clientWidth) {
    container.scrollLeft = 0; // balik ke awal
  }

  requestAnimationFrame(autoScroll);
}

autoScroll();