<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description"
    content="SIMTOEIC - Transform your TOEIC journey with AI-powered learning platform. Join thousands of successful learners achieving their dream scores." />
  <meta name="keywords"
    content="TOEIC, English test preparation, TOEIC practice, English proficiency, AI learning, SIMTOEIC" />
  <title>SIMTOEIC - Master Your TOEIC Journey</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo-simtoeic.png') }}">
  <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo-simtoeic.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#6366f1",
            secondary: "#8b5cf6",
            accent: "#06b6d4",
            dark: "#0a0a0a",
            "dark-light": "#1a1a2e",
          },
          fontFamily: {
            'space': ['Space Grotesk', 'sans-serif'],
            'inter': ['Inter', 'sans-serif'],
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'glow': 'glow 2s ease-in-out infinite alternate',
            'slide-up': 'slideUp 0.8s ease-out',
            'fade-in': 'fadeIn 1s ease-out',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
              '50%': { transform: 'translateY(-20px) rotate(180deg)' },
            },
            glow: {
              '0%': { boxShadow: '0 0 20px rgba(99, 102, 241, 0.3)' },
              '100%': { boxShadow: '0 0 40px rgba(99, 102, 241, 0.6)' },
            },
            slideUp: {
              '0%': { transform: 'translateY(100px)', opacity: '0' },
              '100%': { transform: 'translateY(0)', opacity: '1' },
            },
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            }
          }
        },
      },
    };
  </script>

  <!-- Motion.dev -->
  <script src="https://cdn.jsdelivr.net/npm/motion@11.2.0/dist/motion.js"></script>

  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Custom Styles -->
  <style>
    body {
      font-family: 'Space Grotesk', 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .main-navbar {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(30px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }



    .hero-pattern {
      background-image:
        radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    }

    .floating-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(1px);
      animation: float 6s ease-in-out infinite;
    }

    .text-gradient {
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Campus Cards Animation */
    .campus-card {
      transition: all 0.3s ease;
    }

    .campus-card:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    /* Sticky Footer */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .page-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .content-wrapper {
      flex: 1 0 auto;
    }

    footer {
      flex-shrink: 0;
      position: relative;
      z-index: 10;
      width: 100%;
      display: block !important;
      visibility: visible !important;
    }
  </style>
</head>

<body class="font-space page-wrapper">
  <!-- Main Content Wrapper -->
  <div class="content-wrapper">
    <!-- Main Navigation -->
    <nav class="fixed w-full z-50 top-0 main-navbar" id="navbar">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <!-- Logo -->
          <div class="flex items-center">
            <img src="{{ asset('img/simtoeic0.png') }}" alt="SIMTOEIC Logo" class="h-10">
          </div>

          <!-- Navigation Links -->
          <div class="hidden md:flex items-center space-x-8">
            <a href="#home" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
            <a href="#about" class="text-gray-700 hover:text-primary font-medium transition-colors">About</a>
            <a href="#campus" class="text-gray-700 hover:text-primary font-medium transition-colors">Campus</a>
            <a href="#faq" class="text-gray-700 hover:text-primary font-medium transition-colors">FAQ</a>
          </div>

          <!-- Login Button -->
          <div class="flex items-center space-x-4">
            <a href="{{ route('auth.login') }}"
              class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-all duration-300 hover:shadow-lg">
              <i data-lucide="log-in" class="w-4 h-4 inline mr-2"></i>
              Login
            </a>

            <!-- Mobile menu button -->
            <button class="md:hidden p-2 text-gray-700 hover:text-primary" onclick="toggleMobileMenu()">
              <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200">
          <div class="px-6 py-4 space-y-3">
            <a href="#home" class="block text-gray-700 hover:text-primary font-medium py-2">Home</a>
            <a href="#about" class="block text-gray-700 hover:text-primary font-medium py-2">About</a>
            <a href="#campus" class="block text-gray-700 hover:text-primary font-medium py-2">Campus</a>
            <a href="#faq" class="block text-gray-700 hover:text-primary font-medium py-2">FAQ</a>
            <a href="{{ route('auth.login') }}"
              class="block bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-lg font-semibold text-sm text-center mt-4">
              <i data-lucide="log-in" class="w-4 h-4 inline mr-2"></i>
              Login
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section id="home"
      class="relative min-h-screen flex items-center justify-center overflow-hidden hero-pattern pt-20 pb-16">
      <!-- Background Gradient -->
      <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-purple-50"></div>

      <!-- Floating Orbs -->
      <div class="floating-orb w-32 h-32 bg-gradient-to-r from-primary to-secondary top-20 left-10 opacity-20"
        style="animation-delay: 0s;"></div>
      <div class="floating-orb w-24 h-24 bg-gradient-to-r from-purple-500 to-pink-500 top-40 right-20 opacity-30"
        style="animation-delay: 2s;"></div>
      <div class="floating-orb w-16 h-16 bg-gradient-to-r from-cyan-400 to-blue-500 bottom-40 left-20 opacity-25"
        style="animation-delay: 4s;"></div>

      <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
          <!-- Left Content -->
          <div class="space-y-8" id="hero-content">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 glass-card rounded-full text-sm font-medium text-primary"
              id="hero-badge">
              <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
              POLINEMA TOEIC Management System
            </div>

            <!-- Main Heading -->
            <div class="space-y-6">
              <h1 class="text-4xl md:text-6xl font-bold leading-tight" id="hero-title">
                <span class="block text-gray-900">SIMTOEIC</span>
                <span class="block text-gradient">POLINEMA</span>
              </h1>
              <p class="text-xl text-gray-600 max-w-2xl leading-relaxed" id="hero-subtitle">
                TOEIC Management Information System for the Academic Community of Malang State Polytechnic. 
                Manage TOEIC test results, schedules, and certificates easily and efficiently.
              </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4" id="hero-buttons">
              <a href="{{ route('auth.login') }}"
                class="bg-gradient-to-r from-primary to-secondary text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                <i data-lucide="log-in" class="inline w-5 h-5 mr-2"></i>
                Login to System
              </a>
              <a href="#about"
                class="bg-white text-gray-700 px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 border-2 border-gray-200 hover:border-primary">
                <i data-lucide="info" class="inline w-5 h-5 mr-2"></i>
                Learn More
              </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 pt-8" id="hero-stats">
              <div class="text-center">
                <div class="text-3xl font-bold text-gradient">5</div>
                <div class="text-gray-500 text-sm">User Roles</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-gradient">4</div>
                <div class="text-gray-500 text-sm">Campus</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-gradient">500+</div>
                <div class="text-gray-500 text-sm">Min Score</div>
              </div>
            </div>
          </div>
          <!-- Right Content - Animated Info Cards -->
          <div class="relative flex flex-col items-center space-y-6">
            <!-- Feature Card 1 -->
            <div
              class="relative bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-4 w-72 hover:scale-105 transition-transform duration-300">
              <div class="bg-blue-100 p-3 rounded-full">
                <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
              </div>
              <div>
                <div class="font-bold text-gray-900">Manage TOEIC Results</div>
                <div class="text-xs text-gray-500">Upload and manage TOEIC results</div>  
              </div>
            </div>
            <!-- Feature Card 2 -->
            <div
              class="relative bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-4 w-72 hover:scale-105 transition-transform duration-300">
              <div class="bg-green-100 p-3 rounded-full">
                <i data-lucide="calendar" class="w-6 h-6 text-green-600"></i>
              </div>
              <div>
                <div class="font-bold text-gray-900">Calendar</div>
                <div class="text-xs text-gray-500">Set and schedule TOEIC dates</div>
              </div>
            </div>
            <!-- Feature Card 3 -->
            <div
              class="relative bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center gap-4 w-72 hover:scale-105 transition-transform duration-300">
              <div class="bg-purple-100 p-3 rounded-full">
                <i data-lucide="users" class="w-6 h-6 text-purple-600"></i>
              </div>
              <div>
                <div class="font-bold text-gray-900">Multi-Role Access</div>
                <div class="text-xs text-gray-500">Access for all academic community members</div>
              </div>
            </div>

          </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-4">
          About SIMTOEIC
        </span>
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
          System Information Management
          <span class="text-gradient">TOEIC POLINEMA</span>
        </h2>
        <p class="text-gray-600 max-w-3xl mx-auto">
          SIMTOEIC is a digital platform specifically designed to manage all aspects of TOEIC tests in the academic
          community of Malang State Polytechnic, starting from registration to managing results.
        </p>
      </div>

      <!-- Features Grid -->
      <div class="max-w-6xl mx-auto px-6 lg:px-8 mb-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          <!-- Feature 1 -->
          <div class="text-center">
            <div
              class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <i data-lucide="users" class="w-8 h-8 text-white"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Multi-Role System</h3>
            <p class="text-gray-600 text-sm">Supports 5 roles: Admin, Student, Lecturer, Staff, and Alumni</p>
          </div>

          <!-- Feature 2 -->
          <div class="text-center">
            <div
              class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <i data-lucide="file-text" class="w-8 h-8 text-white"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Import Exam Results</h3>
            <p class="text-gray-600 text-sm">Upload exam results via PDF file with automatic parsing</p>
          </div>

          <!-- Feature 3 -->
          <div class="text-center">
            <div
              class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <i data-lucide="calendar-check" class="w-8 h-8 text-white"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Schedule Management</h3>
            <p class="text-gray-600 text-sm">Easily manage exam schedules and participant registrations</p>
          </div>

          <!-- Feature 4 -->
          <div class="text-center">
            <div
              class="w-16 h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
              <i data-lucide="send" class="w-8 h-8 text-white"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Telegram Notifications</h3>
            <p class="text-gray-600 text-sm">Send announcements and notifications via Telegram Bot</p>
          </div>
        </div>
      </div>

      <!-- Team Section -->
      <div class="text-center mb-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Development Team</h3>
        <p class="text-gray-600">Developed by students of Malang State Polytechnic</p>
      </div>
      <style>
        .shine-text {
          position: relative;
          overflow: hidden;
          display: inline-block;
          vertical-align: middle;
        }

        .shine-effect {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          pointer-events: none;
          background: linear-gradient(120deg, transparent 0%, transparent 40%, #fff 50%, transparent 60%, transparent 100%);
          opacity: 0.7;
          transform: translateX(-100%);
        }
      </style>
      <script>
        // Shine animation loop for "Team"
        function animateShine() {
          const shine = document.querySelector('.shine-effect');
          if (!shine) return;
          shine.style.transition = 'none';
          shine.style.transform = 'translateX(-100%)';
          setTimeout(() => {
            shine.style.transition = 'transform 1.2s cubic-bezier(.4,0,.2,1)';
            shine.style.transform = 'translateX(100%)';
          }, 50);
        }
        setInterval(animateShine, 1800);
        // Initial trigger
        setTimeout(animateShine, 400);
      </script>



      <!-- Profiles Grid -->
      <div class="flex flex-row gap-8 justify-center flex-wrap">
        <!-- Profile Card 1 -->
        <div
          class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
          <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden flex items-center justify-center bg-white">
            <img src="{{ asset('img/yonanda.jpeg') }}" alt="Yonanda" class="object-cover w-full h-full object-top" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Yonanda Mayla</h3>
          <p class="text-gray-600">NIM: 12345678</p>
        </div>

        <!-- Profile Card 2 -->
        <div
          class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
          <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden flex items-center justify-center bg-white">
            <img src="{{ asset('img/ircham.jpeg') }}" alt="Ircham" class="object-cover w-full h-full object-top" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">M.Ircham </h3>
          <p class="text-gray-600">NIM: 2341760115</p>
        </div>

        <!-- Profile Card 3 -->
        <div
          class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
          <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden flex items-center justify-center bg-white">
            <img src="{{ asset('img/athalah.jpeg') }}" alt="Athalah" class="object-cover w-full h-full object-top" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Athallah Ayudya </h3>
          <p class="text-gray-600">NIM: 2341760061</p>
        </div>

        <!-- Profile Card 4 -->
        <div
          class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
          <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden flex items-center justify-center bg-white">
            <img src="{{ asset('img/kanaya.jpeg') }}" alt="Kanaya" class="object-cover w-full h-full object-top" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Kanaya Abdiela </h3>
          <p class="text-gray-600">NIM: 2341760118</p>
        </div>

        <!-- Profile Card 5 -->
        <div
          class="bg-gray-50 rounded-2xl p-6 text-center shadow-sm hover:shadow-xl transition-all duration-300 hover:scale-105 group">
          <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden flex items-center justify-center bg-white">
            <img src="{{ asset('img/audric.jpeg') }}" alt="Audric" class="object-cover w-full h-full object-top" />
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">M. Audric Andhika </h3>
          <p class="text-gray-600">NIM: 23417600094</p>
        </div>
      </div>

      <!-- Padding Between Sections -->
      <div class="py-12"></div>

      <!-- Campus Collaboration Section -->
      <section id="campus" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
          <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.3) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.3) 0%, transparent 50%);">
          </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
          <!-- Section Header -->
          <div class="text-center mb-16" id="campus-header">
            <div
              class="inline-flex items-center px-4 py-2 bg-blue-100 rounded-full text-sm font-medium text-blue-700 mb-6">
              <i data-lucide="graduation-cap" class="w-4 h-4 mr-2"></i>
              Campus Collaboration
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
              Campus That <span class="text-gradient">Collaborated With Us</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
              SIMTOEIC collaborates with various campuses to provide a comprehensive TOEIC management system. Our
              platform supports multiple campuses, allowing students and staff to manage TOEIC tests efficiently.
            </p>
          </div>

          <!-- Campus Grid -->
          <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16" id="campus-grid">
          <!-- Campus 1 - POLINEMA -->
          <div
            class="campus-card bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group relative overflow-hidden"
            data-campus="1">
            <div class="text-center relative z-10">
              <div
                class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="building" class="w-12 h-12 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">POLINEMA</h3>
              <p class="text-gray-600 text-sm mb-4">Politeknik Negeri Malang</p>
              <div class="text-xs text-gray-500">
                <p></p>
                <p>📍 Malang, Jawa Timur</p>
                <p>🏆 Campus Utama</p>
              </div>
            </div>
            <div class="overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
              <h4 class="text-lg font-bold text-white mb-2">POLINEMA Malang</h4>
              <p class="text-sm font-light text-white text-left">Polinema is a state vocational polytechnic in Malang, Indonesia, offering applied diploma and master's programs to prepare students for skilled work.</p>
            </div>
          </div>

          <!-- Campus 2 -->
          <div
            class="campus-card bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group relative overflow-hidden"
            data-campus="2">
            <div class="text-center relative z-10">
              <div
                class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="building" class="w-12 h-12 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">POLINEMA <br> PSDKU Kediri</h3>
              <p class="text-gray-600 text-sm mb-4">Polteknik Negeri Malang <br> PSDKU Kediri</p>
              <div class="text-xs text-gray-500">
                <p></p>
                <p>📍 Kediri, Jawa Timur</p>
                <p>🤝 Campus Partner</p>
              </div>
            </div>
            <div class="overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
              <h4 class="text-lg font-bold text-white mb-2">POLINEMA <br> PSDKU Kediri</h4>
              <p class="text-sm font-light text-white text-left">Polinema's PSDKU in Kediri is an off-campus program of Malang State Polytechnic, providing practical vocational education to meet the needs of local industry in the Kediri region.</p>
            </div>
          </div>

          <!-- Campus 3  -->
          <div
            class="campus-card bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group relative overflow-hidden"
            data-campus="3">
            <div class="text-center relative z-10">
              <div
                class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="building" class="w-12 h-12 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">POLINEMA <br> PSDKU Lumajang</h3>
              <p class="text-gray-600 text-sm mb-4">Politeknik Negeri Malang <br> PSDKU Lumajang</p>
              <div class="text-xs text-gray-500">
                <p></p>
                <p>📍 Lumajang, Jawa Timur</p>
                <p>🎓 Campus Partner</p>
              </div>
            </div>
            <div class="overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
              <h4 class="text-lg font-bold text-white mb-2">POLINEMA <br> PSDKU Lumajang</h4>
              <p class="text-sm font-light text-white text-left">Polinema's PSDKU in Lumajang offers hands-on, competency-based education to support the local industrial and agricultural sectors, aiming to enhance its graduates' regional and national competitiveness.</p>
            </div>
          </div>

          <!-- Campus 4 -->
          <div
            class="campus-card bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group relative overflow-hidden"
            data-campus="4">
            <div class="text-center relative z-10">
              <div
                class="w-24 h-24 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <i data-lucide="building" class="w-12 h-12 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-2">POLINEMA <br> PSDKU Pamekasan</h3>
              <p class="text-gray-600 text-sm mb-4">Politeknik Negeri Malang <br> PSDKU Pamekasan</p>
              <div class="text-xs text-gray-500">
                <p></p>
                <p>📍 Pamekasan, Jawa Timur</p>
                <p>🌐 Campus Partner</p>
              </div>
            </div>
            <div class="overlay absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6">
              <h4 class="text-lg font-bold text-white mb-2">POLINEMA <br> PSDKU Pamekasan</h4>
              <p class="text-sm font-light text-white text-left">Polinema's PSDKU campus in Pamekasan, Madura Island, offers hands-on vocational education in engineering and entrepreneurship to develop a skilled local workforce ready for the job market.</p>
            </div>
          </div>
        </div>

        <style>
          .campus-card {
            position: relative;
            overflow: hidden;
          }

          .campus-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: 0;
          }

          .campus-card[data-campus="1"]::before {
            background-image: url('{{ asset('img/campus/UTAMA.png') }} ')
          }

          .campus-card[data-campus="2"]::before {
            background-image: url('{{ asset('img/campus/KEDIRI.png') }} ')
          }

          .campus-card[data-campus="3"]::before {
            background-image: url('{{ asset('img/campus/LUMAJANG.png') }} ')
          }

          .campus-card[data-campus="4"]::before {
            background-image: url('{{ asset('img/campus/PAMEKASAN.png') }} ')
          }

          .campus-card:hover::before {
            opacity: 1;
          }

          .campus-card .overlay {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
          }

          .campus-card:hover .text-center {
            opacity: 0;
            transition: opacity 0.5s ease;
          }
        </style>

          <!-- Statistics Section -->
          <div class="bg-white rounded-3xl p-8 shadow-xl" id="campus-stats">
            <div class="grid md:grid-cols-4 gap-8 text-center">
              <div class="stat-item" data-stat="1">
                <div class="text-4xl font-bold text-gradient mb-2">4+</div>
                <p class="text-gray-600">Campus Partners</p>
              </div>
              <div class="stat-item" data-stat="2">
                <div class="text-4xl font-bold text-gradient mb-2">25,000+</div>
                <p class="text-gray-600">Total Students</p>
              </div>
              <div class="stat-item" data-stat="3">
                <div class="text-4xl font-bold text-gradient mb-2">500+</div>
                <p class="text-gray-600">Total Exams</p>
              </div>
              <div class="stat-item" data-stat="4">
                <div class="text-4xl font-bold text-gradient mb-2">95%</div>
                <p class="text-gray-600">Pass Rate</p>
              </div>
            </div>
          </div>

          <!-- Partnership Benefits -->
          <div class="mt-16 grid md:grid-cols-3 gap-8" id="partnership-benefits">
            <div class="benefit-card text-center" data-benefit="1">
              <div
                class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-3">Integrated System</h3>
              <p class="text-gray-600">A comprehensive TOEIC management system that supports all aspects of the tests</p>
            </div>

            <div class="benefit-card text-center" data-benefit="2">
              <div
                class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="trending-up" class="w-8 h-8 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-3">Efficiency Improvement</h3>
              <p class="text-gray-600">Automation of administrative processes and reporting of TOEIC results</p>
            </div>

            <div class="benefit-card text-center" data-benefit="3">
              <div
                class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users" class="w-8 h-8 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-Role Support</h3>
              <p class="text-gray-600">Supports various user roles from students to administrators</p>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <!-- FAQ Section -->
      <section id="faq" class="py-16 bg-white">
        <div class="max-w-3xl mx-auto">
          <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-2">Frequently Asked Questions</h2>
            <p class="text-gray-600 text-sm">Have questions about TOEIC preparation? Contact our support team via email,
              and we'll assist you promptly.</p>
          </div>
          <div class="space-y-4">
            <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
              <div class="accordion-header">
                <input type="checkbox" id="item-1" class="hidden" />
                <label for="item-1" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                  <span class="text-left font-medium">How do I join TOEIC Test?</span>
                  <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </label>
                <div class="accordion-content hidden pb-4 text-gray-600">To register TOEIC test, please Log in to your
                  account, then choose "registration" menu and follow the insctruction there. Make sure you already
                  fulffiled profile requirements</div>
              </div>
            </div>
            <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
              <div class="accordion-header">
                <input type="checkbox" id="item-2" class="hidden" />
                <label for="item-2" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                  <span class="text-left font-medium">How do i see my exam result?</span>
                  <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </label>
                <div class="accordion-content hidden pb-4 text-gray-600">exam score can be seen on "registration" menu
                  after you did the exam.</div>
              </div>
            </div>
            <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
              <div class="accordion-header">
                <input type="checkbox" id="item-3" class="hidden" />
                <label for="item-3" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                  <span class="text-left font-medium">can i redo my exam if i failed the first TOEIC exam?</span>
                  <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </label>
                <div class="accordion-content hidden pb-4 text-gray-600">Yes, you could redo the exam if you failed the
                  first one by doing self-exam that already have been provided by the ITC.</div>
              </div>
            </div>
            <div class="border rounded-lg px-6 py-2 hover:border-primary/30 transition-colors">
              <div class="accordion-header">
                <input type="checkbox" id="item-4" class="hidden" />
                <label for="item-4" class="flex justify-between items-center cursor-pointer hover:no-underline py-4">
                  <span class="text-left font-medium">What is the minimum score to pass the test?</span>
                  <svg class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </label>
                <div class="accordion-content hidden pb-4 text-gray-600">the minimum score to pass the exam is above 500
                  points.</div>
              </div>
            </div>
          </div>
        </div>
        <script>
          // Accordion animation
          document.querySelectorAll('.accordion-header input[type="checkbox"]').forEach((checkbox) => {
            checkbox.addEventListener("change", (e) => {
              const content = e.target.parentElement.querySelector(".accordion-content");
              const arrow = e.target.parentElement.querySelector("svg");

              if (e.target.checked) {
                content.classList.remove("hidden");
                content.style.maxHeight = content.scrollHeight + "px";
                arrow.style.transform = "rotate(180deg)";
              } else {
                content.style.maxHeight = "0";
                arrow.style.transform = "rotate(0deg)";
                setTimeout(() => {
                  content.classList.add("hidden");
                }, 300);
              }
            });
          });
        </script>

        <!-- Padding Between Sections -->
        <div class="py-12"></div>
  </div>
  <!-- End Main Content Wrapper -->

  <!-- Modern Footer -->
  <footer class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden"
    style="display: block !important; visibility: visible !important; min-height: 400px;">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
      <div class="absolute inset-0"
        style="background-image: radial-gradient(circle at 25% 25%, rgba(99, 102, 241, 0.3) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.3) 0%, transparent 50%);">
      </div>
    </div>

    <!-- Floating Orbs -->
    <div class="floating-orb w-20 h-20 bg-gradient-to-r from-primary to-secondary top-10 left-10 opacity-10"
      style="animation-delay: 0s;"></div>
    <div class="floating-orb w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 bottom-20 right-20 opacity-10"
      style="animation-delay: 3s;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16">
      <!-- Main Footer Content -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">

        <!-- Company Info -->
        <div class="lg:col-span-2 space-y-6">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('img/simtoeic0.png') }}" alt="SIMTOEIC Logo" class="h-12">
            <div>
              <h3 class="text-2xl font-bold text-gradient">SIMTOEIC</h3>
              <p class="text-gray-400 text-sm">Sistem Manajemen TOEIC POLINEMA</p>
            </div>
          </div>

          <p class="text-gray-300 leading-relaxed max-w-md">
            System Information Management for the Academic Community of Malang State Polytechnic.
            Manage TOEIC test results, schedules, and certificates easily and efficiently.
          </p>

          <!-- Contact Info Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="glass-card rounded-2xl p-4">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                  <i data-lucide="map-pin" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-white text-sm">Address</h4>
                  <p class="text-gray-300 text-xs">Soekarno Hatta St. No.9, Malang</p>
                </div>
              </div>
            </div>

            <div class="glass-card rounded-2xl p-4">
              <div class="flex items-center space-x-3">
                <div
                  class="w-10 h-10 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                  <i data-lucide="phone" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-white text-sm">Phone</h4>
                  <p class="text-gray-300 text-xs">(0341) 404424</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Social Media -->
          <div class="space-y-4">
            <h4 class="text-lg font-semibold text-white">Follow Us</h4>
            <div class="flex space-x-4">
              <a href="#"
                class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 group">
                <i data-lucide="twitter" class="w-5 h-5 group-hover:text-blue-400"></i>
              </a>
              <a href="#"
                class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 group">
                <i data-lucide="facebook" class="w-5 h-5 group-hover:text-blue-600"></i>
              </a>
              <a href="https://www.instagram.com/upabahasa"
                class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 group">
                <i data-lucide="instagram" class="w-5 h-5 group-hover:text-pink-500"></i>
              </a>
              <a href="#"
                class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 group">
                <i data-lucide="linkedin" class="w-5 h-5 group-hover:text-blue-500"></i>
              </a>
              <a href="#"
                class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110 group">
                <i data-lucide="youtube" class="w-5 h-5 group-hover:text-red-500"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="space-y-6">
          <h4 class="text-xl font-bold text-white">Quick Links</h4>
          <ul class="space-y-3">
            <li>
              <a href="#home"
                class="flex items-center space-x-2 text-gray-300 hover:text-white transition-all duration-300 group">
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                <span>Home</span>
              </a>
            </li>
            <li>
              <a href="#about"
                class="flex items-center space-x-2 text-gray-300 hover:text-white transition-all duration-300 group">
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                <span>About Us</span>
              </a>
            </li>
            <li>
              <a href="#campus"
                class="flex items-center space-x-2 text-gray-300 hover:text-white transition-all duration-300 group">
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                <span>Campus</span>
              </a>
            </li>
            <li>
              <a href="#faq"
                class="flex items-center space-x-2 text-gray-300 hover:text-white transition-all duration-300 group">
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                <span>FAQ</span>
              </a>
            </li>
            <li>
              <a href="{{ route('auth.login') }}"
                class="flex items-center space-x-2 text-primary hover:text-secondary transition-all duration-300 group font-semibold">
                <i data-lucide="log-in" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                <span>Login</span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Resources & Support -->
        <div class="space-y-6">
          <h4 class="text-xl font-bold text-white">Resources</h4>

          <!-- Contact Cards -->
          <div class="space-y-3">
            <div class="glass-card rounded-xl p-4">
              <div class="flex items-center space-x-3">
                <div
                  class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                  <i data-lucide="mail" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                  <p class="text-xs text-gray-400">Email Support</p>
                  <a href="mailto:info@simtoeic.com"
                    class="text-sm text-white hover:text-primary transition-colors">info@simtoeic.com</a>
                </div>
              </div>
            </div>

            <div class="glass-card rounded-xl p-4">
              <div class="flex items-center space-x-3">
                <div
                  class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                  <i data-lucide="headphones" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                  <p class="text-xs text-gray-400">Help Center</p>
                  <a href="mailto:support@simtoeic.com"
                    class="text-sm text-white hover:text-primary transition-colors">support@simtoeic.com</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Legal Links -->
          <div class="space-y-2">
            <h5 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Legal</h5>
            <ul class="space-y-2">
              <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Privacy Policy</a>
              </li>
              <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Terms of
                  Service</a>
              </li>
              <li><a href="#" class="text-sm text-gray-300 hover:text-white transition-colors">Cookie Policy</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bottom Section -->
      <div class="border-t border-gray-700/50 pt-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          <!-- Copyright -->
          <div class="text-center md:text-left">
            <p class="text-gray-400 text-sm">
              © 2025 <span class="text-white font-semibold">SIMTOEIC</span>. All rights reserved.
            </p>
            <p class="text-gray-500 text-xs mt-1">
              Powered by <span class="text-primary">Laravel</span> • Design by
              <a href="https://github.com/yonandamayla/simtoeic-polinema"
                class="text-primary hover:text-secondary transition-colors">PBL Group 2</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <button id="back-to-top"
    class="fixed bottom-8 right-8 bg-gradient-to-r from-primary to-secondary text-white p-4 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 opacity-0 scale-0 z-50">
    <i data-lucide="arrow-up" class="w-5 h-5"></i>
  </button>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Mobile menu toggle
    function toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');

      // Animate mobile menu
      if (!mobileMenu.classList.contains('hidden')) {
        Motion.animate(mobileMenu,
          { opacity: [0, 1], y: [-20, 0] },
          { duration: 0.3 }
        );
      }
    }

    // Motion.dev animations
    document.addEventListener('DOMContentLoaded', function () {
      // Navbar entrance animation
      Motion.animate("#navbar",
        { opacity: [0, 1] },
        { duration: 0.5 }
      );

      // Hero animations
      Motion.animate("#hero-badge",
        { opacity: [0, 1], y: [30, 0] },
        { duration: 0.8, delay: 0.2 }
      );

      Motion.animate("#hero-title",
        { opacity: [0, 1], y: [50, 0] },
        { duration: 1, delay: 0.4 }
      );

      Motion.animate("#hero-subtitle",
        { opacity: [0, 1], y: [30, 0] },
        { duration: 0.8, delay: 0.6 }
      );

      Motion.animate("#hero-buttons",
        { opacity: [0, 1], y: [20, 0] },
        { duration: 0.6, delay: 0.8 }
      );

      Motion.animate("#hero-stats",
        { opacity: [0, 1], y: [20, 0] },
        { duration: 0.6, delay: 1 }
      );

      // Hero cards animation
      document.querySelectorAll('[data-card]').forEach((card, index) => {
        Motion.animate(card,
          { opacity: [0, 1], x: [50, 0], scale: [0.9, 1] },
          { duration: 0.6, delay: 1.2 + (index * 0.1) }
        );
      });

      // Floating orbs animation
      document.querySelectorAll('.floating-orb').forEach((orb, index) => {
        Motion.animate(orb,
          {
            y: [-20, 20, -20],
            rotate: [0, 180, 360]
          },
          {
            duration: 6 + index,
            repeat: Infinity,
            easing: "ease-in-out"
          }
        );
      });

      // Footer animations on scroll
      const footerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Animate footer content
            Motion.animate("footer .glass-card",
              { opacity: [0, 1], y: [30, 0] },
              { duration: 0.6, delay: Motion.stagger(0.1) }
            );

            // Animate social media icons
            Motion.animate("footer .w-12",
              { opacity: [0, 1], scale: [0.8, 1] },
              { duration: 0.5, delay: Motion.stagger(0.05) }
            );

            // Animate footer stats
            Motion.animate("footer .text-gradient",
              { opacity: [0, 1], scale: [0.9, 1] },
              { duration: 0.8, delay: 0.3 }
            );
          }
        });
      }, { threshold: 0.2 });

      const footer = document.querySelector('footer');
      if (footer) footerObserver.observe(footer);

      // Campus section animations
      const campusObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Animate campus header
            Motion.animate("#campus-header",
              { opacity: [0, 1], y: [50, 0] },
              { duration: 0.8 }
            );

            // Animate campus cards with stagger
            Motion.animate(".campus-card",
              { opacity: [0, 1], y: [30, 0], scale: [0.9, 1] },
              { duration: 0.6, delay: Motion.stagger(0.1) }
            );

            // Animate statistics
            Motion.animate(".stat-item",
              { opacity: [0, 1], scale: [0.8, 1] },
              { duration: 0.5, delay: Motion.stagger(0.1, { start: 0.8 }) }
            );

            // Animate benefits
            Motion.animate(".benefit-card",
              { opacity: [0, 1], y: [20, 0] },
              { duration: 0.6, delay: Motion.stagger(0.1, { start: 1.2 }) }
            );
          }
        });
      }, { threshold: 0.2 });

      const campusSection = document.querySelector('#campus');
      if (campusSection) campusObserver.observe(campusSection);

      // Active nav tracking
      const navLinks = document.querySelectorAll('nav a[href^="#"]');
      const sections = document.querySelectorAll('section[id]');

      const observerNav = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const id = entry.target.getAttribute('id');

            // Remove active class from all nav links
            navLinks.forEach(link => {
              link.classList.remove('text-primary');
              link.classList.add('text-gray-700');
            });

            // Add active class to current section's nav link
            const activeNavLink = document.querySelector(`nav a[href="#${id}"]`);
            if (activeNavLink) {
              activeNavLink.classList.remove('text-gray-700');
              activeNavLink.classList.add('text-primary');
            }
          }
        });
      }, {
        threshold: 0.3,
        rootMargin: '-20% 0px -20% 0px'
      });

      sections.forEach(section => {
        observerNav.observe(section);
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
    });

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

    // Navbar scroll effect
    window.addEventListener('scroll', function () {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
      } else {
        navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
      }
    });

    // Back to Top button functionality
    const backToTopButton = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTopButton.style.opacity = '1';
        backToTopButton.style.transform = 'scale(1)';
      } else {
        backToTopButton.style.opacity = '0';
        backToTopButton.style.transform = 'scale(0)';
      }
    });

    backToTopButton.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  </script>
</body>

</html>