
        function scrollToSection(id) {
            const section = document.getElementById(id);
            window.scrollTo({
                top: section.offsetTop - document.querySelector('.menu').offsetHeight,
                behavior: 'smooth'
            });
        }

        function onScroll() {
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= window.innerHeight && rect.bottom >= 0) {
                    section.classList.add('visible');
                } else {
                    section.classList.remove('visible');
                }
            });
        }

        window.addEventListener('scroll', onScroll);
        document.addEventListener('DOMContentLoaded', onScroll);
   