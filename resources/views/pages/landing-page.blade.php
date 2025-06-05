<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="TOEIC Prep - Your ultimate platform for TOEIC test preparation with expert-led courses, practice tests, and resources to boost your English proficiency." />
    <meta name="keywords" content="TOEIC, English test preparation, TOEIC practice, English proficiency, TOEIC courses" />
    <title>TOEIC Prep - Master Your English Proficiency</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#1D4ED8",
              secondary: "#F59E0B",
              accent: "#EF4444",
            },
          },
        },
      };
    </script>
    <!-- GSAP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
  </head>
  <body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
      <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
<div class="flex items-center">
  <img src="{{ asset('img/simtoeic0.png') }}" alt="Sim TOEIC Logo" class="h-10">
</div>

          <!-- Navigation Menu -->
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-8">
              <a href="home" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Home</a>
              <a href="#About us" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">About Us</a>
        
                <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium flex items-center transition-colors">
                  Campus
                
        
              <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">FaQ</a>
            </div>
          </div>

          <!-- CTA Button -->
          <div class="flex items-center space-x-4">
            <a href="{{ route('auth.login') }}" class="bg-gray-800 text-white px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-700 transition-all duration-300 hover:scale-105">Log In</a>

            <!-- Mobile menu button -->
            <button class="md:hidden p-2" onclick="toggleMobileMenu()">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
          </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden pb-4">
          <div class="flex flex-col space-y-2">
            <a href="#" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium">Home</a>
            <a href="#courses" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium">Our Courses</a>
            <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium">Resources</a>
            <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium">Instructors</a>
            <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium">Blog</a>
          </div>
        </div>
      </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 to-yellow-50 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div class="space-y-8 animate-fade-in">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-medium animate-bounce gsap-bounce">
              TOEIC Preparation Platform
            </div>

         <!-- Main Heading -->
<div class="space-y-4">
  <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 leading-tight gsap-fade">
    Make your TOEIC<br />
    Management Better in<br />
    <span style="color: #8c7cd4;">SIMTOEIC</span>
  </h1>

              <p class="text-lg text-gray-600 max-w-lg gsap-fade">
                Join thousands of POLINEMA Civitas Academica at SIMTOEIC. Achieve your target score and advance your career with confidence.
            </p>
            </div>

          

          <!-- Right Content - Hero Image -->
          <div class="relative">
            <!-- Background Shapes -->
            <div class="absolute inset-0">
              <!-- Large Triangle -->
              <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-primary to-primary/70 transform rotate-12 rounded-3xl gsap-pulse"></div>
              <!-- Orange Shape -->
              <div class="absolute bottom-10 right-20 w-60 h-40 bg-gradient-to-r from-secondary to-red-400 transform -rotate-12 rounded-3xl gsap-pulse delay-300"></div>
              <!-- Yellow Circle -->
              <div class="absolute top-20 left-10 w-20 h-20 bg-yellow-400 rounded-full gsap-bounce delay-500"></div>
              <!-- Small Dots -->
              <div class="absolute top-10 right-40 w-4 h-4 bg-secondary rounded-full gsap-ping"></div>
              <div class="absolute bottom-40 left-20 w-4 h-4 bg-primary rounded-full gsap-ping delay-700"></div>
            </div>

            <!-- Main Image Placeholder -->
            <div class="relative z-10 flex justify-center">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="Student preparing for TOEIC" class="w-80 h-96 object-cover rounded-2xl shadow-2xl gsap-scale" />
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-16 right-8 bg-white p-3 rounded-xl shadow-lg z-20 gsap-float">
              <svg class="h-8 w-8 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
              </svg>
            </div>

            <div class="absolute bottom-32 left-8 bg-white p-3 rounded-xl shadow-lg z-20 gsap-float delay-1000">
              <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>


<!-- About Section -->
<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-12">
      <span class="inline-block px-4 py-2 text-white rounded-full text-sm font-medium mb-4 gsap-fade" style="background-color: #8c7cd4;">About Us</span>
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4 gsap-fade">
        Meet Our Passionate Team
      </h2>
      <p class="text-gray-600">Team Profile and Identity Number</p>
    </div>

    

<!-- Profiles Grid -->
<div class="flex flex-row gap-8 justify-center">
  <!-- Profile Card 1 -->
  <div class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
    <img src="{{ asset('img/yonanda.jpg') }}" alt="Yonanda" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Yonanda Mayla</h3>
    <p class="text-gray-600">NIM: 12345678</p>
  </div>

  <!-- Profile Card 2 -->
  <div class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
    <img src="{{ asset('img/ircham.jpeg') }}" alt="Ircham" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
    <h3 class="text-xl font-bold text-gray-900 mb-2">M.Ircham D</h3>
    <p class="text-gray-600">NIM: 2341760115</p>
  </div>

  <!-- Profile Card 3 -->
  <div class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
    <img src="{{ asset('img/athalah.jpeg') }}" alt="Athalah" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Athallah Ayudya P</h3>
    <p class="text-gray-600">NIM: 2341760061</p>
  </div>

  <!-- Profile Card 4 -->
  <div class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
    <img src="{{ asset('img/kanaya.jpeg') }}" alt="Kanaya" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Kanaya Abdiela R</h3>
    <p class="text-gray-600">NIM: 2341760</p>
  </div>

  <!-- Profile Card 5 -->
  <div class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
    <img src="{{ asset('img/audric.jpeg') }}" alt="Audric" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
    <h3 class="text-xl font-bold text-gray-900 mb-2">M. Audric Andhika H</h3>
    <p class="text-gray-600">NIM: 23417600094</p>
  </div>
</div>

<!-- Padding Between Sections -->
<div class="py-12"></div>


<!-- Campus Collaborations Section -->
<section id="campus" class="py-16 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-12">
      <div class="mb-6 lg:mb-0">
        <span class="inline-block px-4 py-2 bg-secondary/10 text-secondary rounded-full text-sm font-medium mb-4 gsap-fade">Our Collaborators</span>
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 gsap-fade">Campus That Collaborated With Us</h2>
      </div>
    </div>

    <!-- Campus Grid -->
    <div class="grid md:grid-cols-2 gap-8">
      <!-- Campus Card 1 -->
      <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('campus1')">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo-polinema.png') }}" alt="University A" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="text-xl font-bold text-gray-900">Polytechnic state of malang</h3>
              <p class="text-gray-600">Campus Profile</p>
            </div>
          </div>
          <svg id="icon-campus1" class="w-6 h-6 text-gray-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        <div id="dropdown-campus1" class="mt-4 hidden">
          <img src="{{ asset('img/kampus1.png') }}" alt="University A Campus" class="w-full h-60 object-cover rounded">
          <p class="mt-2 text-gray-600">Malang State Polytechnic, abbreviated as "Polinema", is a state coeducational vocational education institution located in Malang City, East Java, Indonesia. Vocational education is a higher education diploma program that prepares students for work with certain applied skills. Polinema provides vocational education for the Diploma III, Diploma IV and Applied Masters Programs.</p>
        </div>
      </div>

      <!-- Campus Card 2 -->
      <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('campus2')">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo-polinema.png') }}" alt="University B" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="text-xl font-bold text-gray-900">Polytechnic state of malang PSDKU kediri</h3>
              <p class="text-gray-600">Campus Profile</p>
            </div>
          </div>
          <svg id="icon-campus2" class="w-6 h-6 text-gray-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        <div id="dropdown-campus2" class="mt-4 hidden">
          <img src="{{ asset('img/kampus2.jpg') }}" alt="University B Campus" class="w-full h-60 object-cover rounded">
          <p class="mt-2 text-gray-600">Polinema PSDKU Kediri is one of the Off-Campus Study Programs (PSDKU) of the State Polytechnic of Malang, located in Kediri City, East Java. This campus was established to expand access to vocational education for communities in and around the Kediri region. PSDKU Kediri offers study programs that are aligned with local and national industry needs, supported by learning facilities that emphasize practical training and technical skills development.</p>
        </div>
      </div>

      <!-- Campus Card 3 -->
      <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('campus3')">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo-polinema.png') }}" alt="University C" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="text-xl font-bold text-gray-900">polythecnic state of malang PSDKU Pamekasan</h3>
              <p class="text-gray-600">Campus Profile</p>
            </div>
          </div>
          <svg id="icon-campus3" class="w-6 h-6 text-gray-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        <div id="dropdown-campus3" class="mt-4 hidden">
          <img src="{{ asset('img/kampus3.jpg') }}" alt="University C Campus" class="w-full h-60 object-cover rounded">
          <p class="mt-2 text-gray-600">Polinema PSDKU Pamekasan is situated on Madura Island, specifically in Pamekasan Regency, East Java. The presence of PSDKU Pamekasan aims to bring higher vocational education closer to the people of Madura and surrounding areas while empowering local potential in the fields of engineering and entrepreneurship. With a practice-oriented learning system and strong collaboration with industry, this campus serves as a center for developing skilled human resources who are ready to compete in the job market.</p>
        </div>
      </div>

      <!-- Campus Card 4 -->
      <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 group">
        <div class="flex items-center justify-between cursor-pointer" onclick="toggleDropdown('campus4')">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('img/logo-polinema.png') }}" alt="University D" class="w-16 h-16 object-cover rounded-full">
            <div>
              <h3 class="text-xl font-bold text-gray-900">polythecnic state of malang PSDKU Lumajang</h3>
              <p class="text-gray-600">Campus Profile</p>
            </div>
          </div>
          <svg id="icon-campus4" class="w-6 h-6 text-gray-600 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        <div id="dropdown-campus4" class="mt-4 hidden">
          <img src="{{ asset('img/Kampus5.jpg') }}" alt="University D Campus" class="w-full h-60 object-cover rounded">
          <p class="mt-2 text-gray-600">Polinema PSDKU Lumajang is part of Polinema's commitment to distributing quality vocational education throughout East Java's eastern region. Located in Lumajang Regency, this campus focuses on study programs that support the area's growing industrial and agricultural sectors. With competency-based teaching and hands-on learning approaches, PSDKU Lumajang helps enhance the competitiveness of its graduates both regionally and nationally.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function toggleDropdown(campusId) {
    const dropdown = document.getElementById('dropdown-' + campusId);
    const icon = document.getElementById('icon-' + campusId);
    if (dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      icon.classList.add('rotate-180');
    } else {
      dropdown.classList.add('hidden');
      icon.classList.remove('rotate-180');
    }
  }
</script>

<!-- Padding Between Sections -->
<div class="py-12"></div>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4 md:px-6">
        <div class="grid md:grid-cols-[1fr_2fr] gap-8">
          <!-- Left Column - Title and Description -->
          <div>
            <div class="flex flex-col items-left gap-2 mb-4">
              <h2 class="text-5xl font-bold mt-2">Frequently Asked Questions</h2>
            </div>
            <p class="text-gray-600 text-sm">Have questions about TOEIC preparation? Contact our support team via email, and we’ll assist you promptly.</p>
          </div>

          <!-- Right Column - Accordion -->
          <div>
            <div class="space-y-4">
              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-1" class="hidden" />
                  <label for="item-1" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">How do I join TOEIC Test?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">To register TOEIC test, please Log in to your account, then choose "registration" menu and follow the insctruction there. Make sure you already fulffiled profile requirements</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-2" class="hidden" />
                  <label for="item-2" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">How do i see my exam result?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">exam score can be seen on "registration" menu after you did the exam.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-3" class="hidden" />
                  <label for="item-3" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">can i redo my exam if i failed the first TOEIC exam?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">Yes, you could  redo the exam if you failed the first one by doing self-exam that already have been provided by the ITC.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-4" class="hidden" />
                  <label for="item-4" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">What is the minimum score to pass the test?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">the minimum score to pass the exam is above 500 points.</div>
                </div>
              </div>



              </div>
            </div>
          </div>
        </div>

<!-- Padding Between Sections -->
<div class="py-12"></div>


<!-- Footer -->
<footer class="bg-gray-100 text-gray-600 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
      <!-- Logo & Address -->
      <div class="mb-6 md:mb-0">
        <img src="{{ asset('img/simtoeic0.png') }}" alt="SIMTOEIC Logo" class="h-[90px] mb-2">
        <p class="text-sm">
          POLITEKNIK NEGERI MALANG<br>
          No. 9 Soekarno Hatta St., Jatimulyo, Lowokwaru District,<br>
          Malang City, East Java 65141<br>
          (0341) 404424
        </p>
      </div>
      <!-- Social Icons -->
      <div class="flex space-x-4">
        <a href="#" class="text-gray-600 text-xl"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-gray-600 text-xl"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/upabahasa" class="text-gray-600 text-xl"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
    <!-- Copyright -->
    <div class="text-center text-sm">
      Copyright &copy; 2025 &nbsp;•&nbsp; Design By
      <a href="https://github.com/yonandamayla/simtoeic-polinema" class="hover:underline">PBL Group 2</a>
    </div>
  </div>
</footer>

    <script>
      // Mobile menu toggle
      function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
      }

      // Accordion functionality
      document.querySelectorAll('.accordion-header input[type="checkbox"]').forEach((checkbox) => {
        checkbox.addEventListener("change", (e) => {
          const content = e.target.parentElement.querySelector(".accordion-content");
          const arrow = e.target.parentElement.querySelector("svg");
          
          if (e.target.checked) {
            content.classList.remove("hidden");
            arrow.style.transform = "rotate(180deg)";
          } else {
            content.classList.add("hidden");
            arrow.style.transform = "rotate(0deg)";
          }
        });
      });

      // Smooth scrolling for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });

      // Add scroll effect to header
      window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (window.scrollY > 100) {
          header.classList.add('backdrop-blur-md', 'bg-white/90');
        } else {
          header.classList.remove('backdrop-blur-md', 'bg-white/90');
        }
      });

      // GSAP Animations
      gsap.registerPlugin(ScrollTrigger);

      // Fade animation
      gsap.utils.toArray('.gsap-fade').forEach((element) => {
        gsap.from(element, {
          opacity: 0,
          y: 50,
          duration: 1,
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
          }
        });
      });

      // Scale animation
      gsap.utils.toArray('.gsap-scale').forEach((element) => {
        gsap.from(element, {
          scale: 0.9,
          opacity: 0,
          duration: 1.2,
          ease: "back.out(1.7)",
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            end: 'bottom 20%',
            toggleActions: 'play none none reverse'
          }
        });
      });

      // Bounce animation
      gsap.from('.gsap-bounce', {
        y: 0,
        repeat: -1,
        yoyo: true,
        duration: 1.5,
        ease: "power1.inOut"
      });

      // Pulse animation
      gsap.utils.toArray('.gsap-pulse').forEach((element) => {
        gsap.from(element, {
          scale: 0.8,
          opacity: 0.5,
          repeat: -1,
          yoyo: true,
          duration: 2,
          ease: "power1.inOut"
        });
      });

      // Ping animation
      gsap.utils.toArray('.gsap-ping').forEach((element) => {
        gsap.from(element, {
          scale: 0,
          opacity: 0,
          repeat: -1,
          yoyo: true,
          duration: 1.5,
          ease: "elastic.out(1, 0.3)"
        });
      });

      // Float animation
      gsap.utils.toArray('.gsap-float').forEach((element) => {
        gsap.from(element, {
          y: 0,
          repeat: -1,
          yoyo: true,
          duration: 2.5,
          ease: "sine.inOut"
        });
      });

      // Scale animation for hero image
      gsap.from('.gsap-scale', {
        scale: 0.95,
        duration: 1.5,
        ease: "power2.out",
        scrollTrigger: {
          trigger: '.gsap-scale',
          start: 'top 80%',
          end: 'bottom 20%',
          toggleActions: 'play none none reverse'
        }
      });
    </script>
  </body>
</html>
