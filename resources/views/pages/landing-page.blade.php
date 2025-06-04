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
            <span class="text-2xl font-bold"> 
              <span class="text-secondary">TOEIC</span><span class="text-gray-800">PREP</span> 
            </span>
          </div>

          <!-- Navigation Menu -->
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-8">
              <a href="#" class="text-gray-900 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Home</a>
              <a href="#courses" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Our Courses</a>
              <div class="relative group">
                <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium flex items-center transition-colors">
                  Resources
                  <svg class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </a>
              </div>
              <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Instructors</a>
              <a href="#" class="text-gray-600 hover:text-primary px-3 py-2 text-sm font-medium transition-colors">Blog</a>
            </div>
          </div>

          <!-- CTA Button -->
          <div class="flex items-center space-x-4">
            <a href="{{ route('auth.login') }}" class="bg-gray-800 text-white px-6 py-2 rounded-full text-sm font-medium hover:bg-gray-700 transition-all duration-300 hover:scale-105">Masuk</a>

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
                Master TOEIC<br />
                Excel in<br />
                <span class="text-secondary">English</span>
              </h1>

              <p class="text-lg text-gray-600 max-w-lg gsap-fade">
                Boost your English proficiency with expertly designed TOEIC preparation courses. Practice real test scenarios and achieve your target score.
              </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
              <button class="bg-primary text-white px-8 py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 hover:scale-105 flex items-center justify-center group gsap-fade">
                Start Free Trial
                <svg class="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </button>

              <button class="bg-secondary text-white px-8 py-4 rounded-full font-semibold hover:bg-secondary/90 transition-all duration-300 hover:scale-105 flex items-center justify-center group gsap-fade">
                <svg class="mr-2 h-5 w-5 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 5v14l11-7z" />
                </svg>
                How it Works
              </button>
            </div>
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
          <span class="inline-block px-4 py-2 bg-primary text-white rounded-full text-sm font-medium mb-4 gsap-fade">About Us</span>
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4 gsap-fade">
            Empowering learners to excel in <span class="text-primary">TOEIC</span> with<br />
            expert-led courses and practice resources.
          </h2>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-3 gap-8 mt-16">
          <!-- Stat 1 -->
          <div class="text-center p-8 bg-gray-50 rounded-2xl hover:bg-primary/5 transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors">10+</div>
            <div class="text-gray-600 font-medium">
              Years of TOEIC<br />
              Preparation Experience
            </div>
          </div>

          <!-- Stat 2 -->
          <div class="text-center p-8 bg-gray-50 rounded-2xl hover:bg-secondary/5 transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2 group-hover:text-secondary transition-colors">50k</div>
            <div class="text-gray-600 font-medium">
              Students Prepared for<br />
              TOEIC Tests
            </div>
          </div>

          <!-- Stat 3 -->
          <div class="text-center p-8 bg-gray-50 rounded-2xl hover:bg-accent/5 transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="text-4xl lg:text-5xl font-bold text-gray-900 mb-2 group-hover:text-accent transition-colors">150+</div>
            <div class="text-gray-600 font-medium">
              Expert TOEIC<br />
              Instructors
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Courses Section -->
    <section id="courses" class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-12">
          <div class="mb-6 lg:mb-0">
            <span class="inline-block px-4 py-2 bg-secondary/10 text-secondary rounded-full text-sm font-medium mb-4 gsap-fade">Our Courses</span>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 gsap-fade">Explore TOEIC Preparation Courses</h2>
          </div>
        </div>

        <!-- Course Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
          <!-- Course Card 1 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Listening Course" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.8 (200)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">TOEIC Listening Mastery</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$39.99</span>
              </div>
            </div>
          </div>

          <!-- Course Card 2 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Reading Course" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.7 (180)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">TOEIC Reading Comprehension</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$39.99</span>
              </div>
            </div>
          </div>

          <!-- Course Card 3 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Speaking Course" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.6 (150)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">TOEIC Speaking Confidence</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$44.99</span>
              </div>
            </div>
          </div>

          <!-- Course Card 4 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Writing Course" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.7 (170)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">TOEIC Writing Excellence</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$44.99</span>
              </div>
            </div>
          </div>

          <!-- Course Card 5 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Full Prep Course" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.9 (250)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">Complete TOEIC Preparation</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$59.99</span>
              </div>
            </div>
          </div>

          <!-- Course Card 6 -->
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group gsap-scale">
            <div class="relative overflow-hidden">
              <img src="https://cdn.elearningindustry.com/wp-content/uploads/2020/07/4f8fb44fd2ac51cd2650b95c48be2b18.gif" alt="TOEIC Practice Tests" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300" />
              <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-sm font-medium flex items-center">
                <svg class="h-4 w-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
                4.8 (190)
              </div>
            </div>
            <div class="p-6">
              <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary transition-colors">TOEIC Practice Tests & Strategies</h3>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <img src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?semt=ais_hybrid&w=740" alt="Instructor" class="w-8 h-8 rounded-full mr-2 object-cover" />
                  <span class="text-sm text-gray-600">Dr. Emily Carter</span>
                </div>
                <span class="text-lg font-bold text-secondary">$49.99</span>
              </div>
            </div>
          </div>
        </div>

        <!-- See All Courses Button -->
        <div class="text-center">
          <button class="bg-primary text-white px-8 py-4 rounded-full font-semibold hover:bg-primary/90 transition-all duration-300 hover:scale-105 gsap-fade">See All Courses</button>
        </div>
      </div>
    </section>

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
                    <span class="text-left font-medium">How do I start preparing for TOEIC?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">Sign up, explore our TOEIC courses, take a diagnostic test, and follow our structured learning path to boost your score.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-2" class="hidden" />
                  <label for="item-2" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">What payment methods do you accept?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">We accept all major credit cards, PayPal, and bank transfers. All transactions are secure and encrypted.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-3" class="hidden" />
                  <label for="item-3" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">Is there a free trial for TOEIC courses?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">Yes, we offer a 14-day free trial with access to sample TOEIC practice tests and course materials.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-4" class="hidden" />
                  <label for="item-4" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">Is technical support available?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">Yes, our technical support team is available 24/7 to help with any issues or questions.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-5" class="hidden" />
                  <label for="item-5" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">Can I cancel my subscription?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">You can cancel your subscription at any time from your account settings. No long-term commitments required.</div>
                </div>
              </div>

              <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
                <div class="accordion-header">
                  <input type="checkbox" id="item-6" class="hidden" />
                  <label for="item-6" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                    <span class="text-left font-medium">Is my data secure with your platform?</span>
                    <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                  </label>
                  <div class="accordion-content hidden pb-4 text-gray-600">We use industry-standard encryption and security practices to ensure your data is always protected.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- What You Looking for Section -->
        <div class="mt-24">
          <h2 class="text-3xl font-bold text-center mb-2 gsap-fade">Ready for TOEIC Success?</h2>
          <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto gsap-fade">Our platform provides tailored TOEIC preparation to help you achieve your target score and advance your career.</p>

          <div class="grid md:grid-cols-2 gap-8">
            <!-- Teach Card -->
            <div class="bg-white rounded-lg p-8 border shadow-sm hover:shadow-lg transition-all duration-300 hover:scale-105 group gsap-scale">
              <div class="flex justify-center mb-6">
                <div class="bg-orange-100 p-4 rounded-full group-hover:bg-orange-200 transition-colors">
                  <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#F59E0B" strokeWidth="2" />
                    <path
                      d="M17 14H17.3517C18.8646 14 20.1408 15.1266 20.3285 16.6279L20.719 19.752C20.8682 20.9457 19.9374 22 18.7344 22H5.26556C4.06257 22 3.1318 20.9457 3.28101 19.752L3.67151 16.6279C3.85917 15.1266 5.13538 14 6.64835 14H7"
                      stroke="#F59E0B"
                      strokeWidth="2"
                      strokeLinecap="round"
                      strokeLinejoin="round"
                    />
                  </svg>
                </div>
              </div>
              <h3 class="text-xl font-bold text-center mb-2">Teach TOEIC with Us</h3>
              <p class="text-center text-gray-600 mb-6">Join our platform as an instructor and help students excel in TOEIC.</p>
              <div class="flex justify-center">
                <button class="bg-gray-900 text-white px-6 py-2 rounded-md hover:bg-gray-800 transition-all duration-300 hover:scale-105">Get Started</button>
              </div>
            </div>

            <!-- Learn Card -->
            <div class="bg-teal-500 rounded-lg p-8 text-white shadow-sm hover:shadow-lg transition-all duration-300 hover:scale-105 group gsap-scale">
              <div class="flex justify-center mb-6">
                <div class="bg-teal-400 p-4 rounded-full group-hover:bg-teal-300 transition-colors">
                  <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 16L19 12L12 8L5 12L12 16Z" stroke="white" strokeWidth="2" strokeLinejoin="round" />
                    <path d="M19 12V18L12 22L5 18V12" stroke="white" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                    <path d="M12 16V22" stroke="white" strokeWidth="2" />
                  </svg>
                </div>
              </div>
              <h3 class="text-xl font-bold text-center mb-2">Start Your TOEIC Journey</h3>
              <p class="text-center mb-6">Enroll in our TOEIC courses and achieve your target score.</p>
              <div class="flex justify-center">
                <button class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 transition-all duration-300 hover:scale-105">Enroll Now</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-600 py-12">
      <div class="container mx-auto px-4 md:px-6">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
          <!-- Company Info -->
          <div class="md:col-span-1">
            <h3 class="text-lg font-semibold text-orange-500 mb-4 gsap-fade">TOEIC PREP</h3>
            <p class="text-sm mb-4 gsap-fade">Join our mission to help learners worldwide excel in TOEIC. Subscribe to our newsletter for tips and updates.</p>
            <div class="flex space-x-3">
              <a href="#" class="text-gray-400 hover:text-primary transition-colors gsap-fade">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-primary transition-colors gsap-fade">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-primary transition-colors gsap-fade">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z."/>
                </svg>
              </a>
              <a href="#" class="text-gray-400 hover:text-primary transition-colors gsap-fade">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
            </div>
          </div>

          <!-- Company Links -->
          <div>
            <h4 class="font-semibold mb-4 gsap-fade">Company Info</h4>
            <ul class="text-sm space-y-2">
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Home</a></li>
              <li><a href="#courses" class="hover:text-primary transition-colors gsap-fade">Courses</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Practice Tests</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">About TOEIC Prep</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Become an Instructor</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Contact Us</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">FAQ</a></li>
            </ul>
          </div>

          <!-- Categories -->
          <div>
            <h4 class="font-semibold mb-4 gsap-fade">TOEIC Categories</h4>
            <ul class="text-sm space-y-2">
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Listening</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Reading</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Speaking</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Writing</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Full Practice Tests</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Vocabulary</a></li>
              <li><a href="#" class="hover:text-primary transition-colors gsap-fade">Grammar</a></li>
            </ul>
          </div>

          <!-- Download App -->
          <div>
            <h4 class="font-semibold mb-4 gsap-fade">Download the TOEIC Prep App</h4>
            <p class="text-sm mb-4 gsap-fade">Access TOEIC practice tests and resources on the go.</p>
            <p class="text-sm mb-2 gsap-fade">254 Lillian Blvd, Holbrook</p>
            <p class="text-sm mb-4 gsap-fade">+880 1175 425 512</p>
            <div class="space-y-2">
              <a href="#" class="block hover:opacity-80 transition-opacity gsap-fade">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="h-10" />
              </a>
              <a href="#" class="block hover:opacity-80 transition-opacity gsap-fade">
                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" class="h-10" />
              </a>
            </div>
          </div>
        </div>

        <!-- Payment Methods -->
        <div class="border-t pt-8">
          <div class="text-center">
            <p class="text-sm mb-4 gsap-fade">We Accept Payment Gateway</p>
            <div class="flex justify-center items-center space-x-4 mb-6 flex-wrap">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/PayPal.svg/1200px-PayPal.svg.png" alt="PayPal" class="h-6 hover:opacity-80 transition-opacity gsap-fade" />
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/1200px-Visa_Inc._logo.svg.png" alt="Visa" class="h-6 hover:opacity-80 transition-opacity gsap-fade" />
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/MasterCard_2019_logo.svg/1200px-MasterCard_2019_logo.svg.png" alt="MasterCard" class="h-6 hover:opacity-80 transition-opacity gsap-fade" />
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Google_Pay_Logo.svg/1200px-Google_Pay_Logo.svg.png" alt="Google Pay" class="h-6 hover:opacity-80 transition-opacity gsap-fade" />
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Stripe_2018_logo.svg/1200px-Stripe_2018_logo.svg.png" alt="Stripe" class="h-6 hover:opacity-80 transition-opacity gsap-fade" />
            </div>
            <p class="text-xs text-gray-500 gsap-fade">© 2025 TOEIC Prep. All rights reserved.</p>
          </div>
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
