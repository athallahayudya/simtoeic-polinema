<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIMTOEIC - Master Your TOEIC Journey</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Motion.dev -->
    <script src="https://cdn.jsdelivr.net/npm/motion@11.2.0/dist/motion.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Custom Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            overflow-x: hidden;
            background: #0a0a0a;
            color: #ffffff;
        }

        .hero-gradient {
            background: radial-gradient(ellipse at center, #1a1a2e 0%, #0a0a0a 70%);
        }

        .accent-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
        }

        .card-gradient {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .text-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glow-effect {
            box-shadow: 0 0 50px rgba(99, 102, 241, 0.3);
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(1px);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .mesh-gradient {
            background:
                radial-gradient(at 40% 20%, hsla(228, 100%, 74%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189, 100%, 56%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(355, 100%, 93%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 50%, hsla(340, 100%, 76%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(22, 100%, 77%, 1) 0px, transparent 50%),
                radial-gradient(at 80% 100%, hsla(242, 100%, 70%, 1) 0px, transparent 50%),
                radial-gradient(at 0% 0%, hsla(343, 100%, 76%, 1) 0px, transparent 50%);
            filter: blur(100px) saturate(150%);
            opacity: 0.15;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .floating-navbar {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-radius: 20px;
            margin: 20px;
            transition: all 0.3s ease;
        }

        .floating-navbar.scrolled {
            background: rgba(10, 10, 10, 0.95);
            border: 1px solid rgba(99, 102, 241, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(99, 102, 241, 0.2);
            transform: translateY(-5px);
        }

        .floating-navbar:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.5);
        }

        .nav-pill {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .nav-pill:hover {
            background: rgba(99, 102, 241, 0.2);
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        }

        .nav-pill.active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-color: rgba(99, 102, 241, 0.6);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }

        .login-button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .login-button:hover {
            background: rgba(99, 102, 241, 0.3);
            border-color: rgba(99, 102, 241, 0.5);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
        }

        .neon-glow {
            text-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#6366f1',
                        'secondary': '#8b5cf6',
                        'accent': '#06b6d4',
                        'dark': '#0a0a0a',
                        'dark-light': '#1a1a2e',
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
                }
            }
        }
    </script>
</head>

<body class="font-space bg-dark text-white">
    <!-- Floating Navigation -->
    <nav class="fixed w-full z-50 top-0" id="navbar-container">
        <div class="floating-navbar" id="navbar">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gradient neon-glow">SIMTOEIC</h1>
                        </div>
                    </div>

                    <!-- Navigation Pills -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="#hero" class="nav-pill active text-white text-sm font-medium">Home</a>
                        <a href="#about" class="nav-pill text-gray-300 hover:text-white text-sm font-medium">About</a>
                        <a href="{{ route('auth.login') }}"
                            class="login-button px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 transform hover:scale-105">
                            <i data-lucide="log-in" class="w-4 h-4 inline mr-2"></i>
                            Login
                        </a>
                    </div>

                    <!-- Dashboard Button for Authenticated Users -->
                    @auth
                        <div class="flex items-center">
                            <a href="{{ url('/home') }}"
                                class="accent-gradient text-white px-5 py-2.5 rounded-full font-medium text-sm transition-all duration-300 transform hover:scale-105 glow-effect">
                                Dashboard
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden">
                        <button id="mobile-menu-btn" class="nav-pill text-gray-300 hover:text-white p-2">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="floating-navbar mt-2">
                <div class="px-6 py-4 space-y-4">
                    <a href="#hero" class="block nav-pill text-white text-sm font-medium text-center">Home</a>
                    <a href="#about"
                        class="block nav-pill text-gray-300 hover:text-white text-sm font-medium text-center">About</a>
                    @guest
                        <a href="{{ route('auth.login') }}"
                            class="block login-button px-5 py-3 rounded-full text-sm font-semibold text-center transition-all duration-300 transform hover:scale-105">
                            <i data-lucide="log-in" class="w-4 h-4 inline mr-2"></i>
                            Login
                        </a>
                    @else
                        <a href="{{ url('/home') }}"
                            class="block accent-gradient text-white px-5 py-3 rounded-full font-medium text-sm text-center transition-all duration-300 transform hover:scale-105">
                            Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden" id="hero">
        <!-- Background -->
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="absolute inset-0 mesh-gradient"></div>

        <!-- Floating Orbs -->
        <div class="floating-orb w-32 h-32 accent-gradient top-20 left-10 opacity-20" style="animation-delay: 0s;">
        </div>
        <div class="floating-orb w-24 h-24 bg-purple-500 top-40 right-20 opacity-30" style="animation-delay: 2s;"></div>
        <div class="floating-orb w-16 h-16 bg-cyan-400 bottom-40 left-20 opacity-25" style="animation-delay: 4s;"></div>
        <div class="floating-orb w-20 h-20 bg-pink-500 top-1/3 right-1/4 opacity-20" style="animation-delay: 1s;"></div>
        <div class="floating-orb w-28 h-28 bg-indigo-500 bottom-1/3 left-1/3 opacity-15" style="animation-delay: 3s;">
        </div>

        <div class="relative z-10 text-center px-6 lg:px-8 max-w-6xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full glass-card mb-8" id="hero-badge">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                <span class="text-sm text-gray-300">Trusted by 10,000+ students</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-6xl md:text-8xl font-bold mb-6 leading-tight" id="hero-title">
                <span class="block text-white">Master Your</span>
                <span class="block text-gradient neon-glow">TOEIC Journey</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed" id="hero-subtitle">
                Transform your English proficiency with our AI-powered TOEIC simulation platform.
                Get personalized insights, realistic practice tests, and achieve your target score faster.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16" id="hero-buttons">
                @auth
                    <a href="{{ url('/home') }}"
                        class="accent-gradient text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 glow-effect">
                        Go to Dashboard
                        <i data-lucide="arrow-right" class="inline w-5 h-5 ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('auth.login') }}"
                        class="accent-gradient text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 glow-effect">
                        Start Free Trial
                        <i data-lucide="arrow-right" class="inline w-5 h-5 ml-2"></i>
                    </a>
                    <a href="#features"
                        class="glass-card text-white px-8 py-4 rounded-full font-semibold text-lg transition-all duration-300 transform hover:scale-105 border border-white/20">
                        Watch Demo
                        <i data-lucide="play" class="inline w-5 h-5 ml-2"></i>
                    </a>
                @endauth
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto" id="hero-stats">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gradient">10K+</div>
                    <div class="text-gray-400 text-sm">Students</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gradient">95%</div>
                    <div class="text-gray-400 text-sm">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gradient">850+</div>
                    <div class="text-gray-400 text-sm">Avg Score</div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-gray-400 animate-bounce">
            <i data-lucide="chevron-down" class="w-6 h-6"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-32 bg-dark relative" id="features">
        <div class="absolute inset-0 bg-gradient-to-b from-dark via-dark-light to-dark opacity-50"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <div class="inline-flex items-center px-4 py-2 rounded-full glass-card mb-6">
                    <i data-lucide="zap" class="w-4 h-4 text-yellow-400 mr-2"></i>
                    <span class="text-sm text-gray-300">Powered by AI</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-bold text-white mb-6" id="features-title">
                    Why Choose <span class="text-gradient">SIMTOEIC</span>?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed" id="features-subtitle">
                    Experience the future of TOEIC preparation with our cutting-edge platform designed for maximum
                    learning efficiency
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="features-grid">
                <!-- Feature 1 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="1">
                    <div
                        class="w-16 h-16 accent-gradient rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="target" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">AI-Powered Practice</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Experience adaptive learning with our AI that personalizes practice tests based on your
                        performance and learning patterns.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="2">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="zap" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Instant Analytics</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Get real-time insights into your performance with detailed analytics, score predictions, and
                        personalized improvement strategies.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="3">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="trending-up" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Progress Tracking</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Monitor your journey with comprehensive progress tracking, skill assessments, and milestone
                        achievements.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="4">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="book-open" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Smart Study Materials</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Access curated study resources, interactive lessons, and expert strategies tailored to your
                        learning style.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="5">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="clock" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Flexible Learning</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Study anytime, anywhere with our mobile-optimized platform and offline practice capabilities.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-500 hover:scale-105 group"
                    data-feature="6">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i data-lucide="users" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Expert Community</h3>
                    <p class="text-gray-300 leading-relaxed">
                        Connect with certified instructors and join a supportive community of learners achieving their
                        TOEIC goals.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-32 bg-dark-light relative" id="about">
        <div class="max-w-6xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 rounded-full glass-card mb-6">
                    <i data-lucide="info" class="w-4 h-4 text-blue-400 mr-2"></i>
                    <span class="text-sm text-gray-300">About SIMTOEIC</span>
                </div>
                <h2 class="text-5xl md:text-6xl font-bold text-white mb-8" id="about-title">
                    Empowering Your <span class="text-gradient">English Journey</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-4xl mx-auto leading-relaxed" id="about-subtitle">
                    SIMTOEIC is a comprehensive TOEIC preparation platform designed to help students, professionals, and
                    learners achieve their English proficiency goals through innovative technology and proven
                    methodologies.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-2xl font-bold text-white mb-4">Our Mission</h3>
                        <p class="text-gray-300 leading-relaxed">
                            To democratize access to high-quality TOEIC preparation through cutting-edge AI technology,
                            making English proficiency testing accessible to learners worldwide.
                        </p>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <h3 class="text-2xl font-bold text-white mb-4">Our Vision</h3>
                        <p class="text-gray-300 leading-relaxed">
                            To become the leading platform for English proficiency assessment, empowering millions of
                            learners to achieve their academic and professional goals.
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card rounded-2xl p-8 text-center">
                        <div
                            class="w-16 h-16 accent-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-8 h-8 text-white"></i>
                        </div>
                        <h4 class="text-xl font-bold text-white mb-2">10,000+</h4>
                        <p class="text-gray-300">Active Learners</p>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="glass-card rounded-2xl p-6 text-center">
                            <div class="text-2xl font-bold text-gradient mb-2">95%</div>
                            <p class="text-gray-300 text-sm">Success Rate</p>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center">
                            <div class="text-2xl font-bold text-gradient mb-2">850+</div>
                            <p class="text-gray-300 text-sm">Average Score</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 relative overflow-hidden" id="cta">
        <div class="absolute inset-0 accent-gradient opacity-90"></div>
        <div class="absolute inset-0 mesh-gradient"></div>

        <div class="relative z-10 max-w-5xl mx-auto text-center px-6 lg:px-8">
            <div class="inline-flex items-center px-4 py-2 rounded-full glass-card mb-8">
                <i data-lucide="rocket" class="w-4 h-4 text-yellow-400 mr-2"></i>
                <span class="text-sm text-white">Start Your Journey Today</span>
            </div>

            <h2 class="text-5xl md:text-7xl font-bold text-white mb-8 leading-tight" id="cta-title">
                Ready to <span class="text-yellow-300 neon-glow">Dominate</span> TOEIC?
            </h2>

            <p class="text-xl text-white/90 mb-12 max-w-3xl mx-auto leading-relaxed" id="cta-subtitle">
                Join over 10,000 successful learners who transformed their English proficiency and achieved their dream
                scores with our AI-powered platform.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16" id="cta-buttons">
                @auth
                    <a href="{{ url('/home') }}"
                        class="bg-white text-primary px-10 py-5 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 glow-effect">
                        Access Dashboard
                        <i data-lucide="arrow-right" class="inline w-5 h-5 ml-2"></i>
                    </a>
                @else
                    <a href="{{ route('auth.login') }}"
                        class="bg-white text-primary px-10 py-5 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 glow-effect">
                        Start Free Trial
                        <i data-lucide="arrow-right" class="inline w-5 h-5 ml-2"></i>
                    </a>
                    <a href="#features"
                        class="glass-card text-white px-10 py-5 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105 border border-white/30">
                        Learn More
                        <i data-lucide="info" class="inline w-5 h-5 ml-2"></i>
                    </a>
                @endauth
            </div>

            <!-- Trust Indicators -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">4.9/5</div>
                    <div class="text-white/70 text-sm">User Rating</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">10K+</div>
                    <div class="text-white/70 text-sm">Active Users</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">95%</div>
                    <div class="text-white/70 text-sm">Success Rate</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white">24/7</div>
                    <div class="text-white/70 text-sm">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-light border-t border-white/10 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-3xl font-bold text-gradient mb-6">
                        SIMTOEIC
                    </h3>
                    <p class="text-gray-300 mb-8 max-w-md leading-relaxed">
                        Transform your TOEIC journey with AI-powered learning. Join thousands of successful learners who
                        achieved their dream scores.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#"
                            class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110">
                            <i data-lucide="twitter" class="w-5 h-5"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110">
                            <i data-lucide="facebook" class="w-5 h-5"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110">
                            <i data-lucide="instagram" class="w-5 h-5"></i>
                        </a>
                        <a href="#"
                            class="w-12 h-12 glass-card rounded-full flex items-center justify-center text-gray-300 hover:text-white transition-all duration-300 hover:scale-110">
                            <i data-lucide="linkedin" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Quick Links</h4>
                    <ul class="space-y-4">
                        <li><a href="#features"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Features</a></li>
                        <li><a href="{{ route('auth.login') }}"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Login</a></li>
                        <li><a href="#" onclick="showRegisterModal()"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Register</a></li>
                        <li><a href="#about"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>About</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Help Center</a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Contact Us</a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Privacy Policy</a></li>
                        <li><a href="#"
                                class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center">
                                <i data-lucide="arrow-right" class="w-4 h-4 mr-2"></i>Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} SIMTOEIC. All rights reserved. | Powered by Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }}
                </p>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <span class="text-gray-400 text-sm">Made with</span>
                    <i data-lucide="heart" class="w-4 h-4 text-red-400"></i>
                    <span class="text-gray-400 text-sm">for learners worldwide</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Register Modal -->
    <div id="registerModal"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="glass-card rounded-3xl p-8 max-w-md w-full transform transition-all duration-300 scale-95"
            id="modalContent">
            <div class="text-center">
                <div class="w-16 h-16 accent-gradient rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="info" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Registration Information</h3>
                <p class="text-gray-300 mb-8 leading-relaxed">
                    Registration for SIMTOEIC must be done through the administrator. Please contact your institution's
                    admin to create an account.
                </p>
                <button onclick="hideRegisterModal()"
                    class="accent-gradient text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 transform hover:scale-105 w-full">
                    Got it, thanks!
                </button>
            </div>
        </div>
    </div>

    <!-- Motion.dev Animations -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Motion.dev animations
        document.addEventListener('DOMContentLoaded', function () {
            // Navbar entrance animation
            Motion.animate("#navbar",
                { opacity: [0, 1], y: [-50, 0] },
                { duration: 0.8, delay: 0.1 }
            );

            // Hero animations with Motion.dev
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

            // Scroll-triggered animations for features
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;

                        if (element.id === 'features-title') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [50, 0] },
                                { duration: 0.8 }
                            );
                        }

                        if (element.id === 'features-subtitle') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [30, 0] },
                                { duration: 0.6, delay: 0.2 }
                            );
                        }

                        if (element.hasAttribute('data-feature')) {
                            const delay = parseInt(element.getAttribute('data-feature')) * 0.1;
                            Motion.animate(element,
                                { opacity: [0, 1], y: [40, 0], scale: [0.9, 1] },
                                { duration: 0.6, delay }
                            );
                        }

                        if (element.id === 'cta-title') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [50, 0] },
                                { duration: 0.8 }
                            );
                        }

                        if (element.id === 'cta-subtitle') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [30, 0] },
                                { duration: 0.6, delay: 0.2 }
                            );
                        }

                        if (element.id === 'cta-buttons') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [20, 0] },
                                { duration: 0.6, delay: 0.4 }
                            );
                        }

                        if (element.id === 'about-title') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [50, 0] },
                                { duration: 0.8 }
                            );
                        }

                        if (element.id === 'about-subtitle') {
                            Motion.animate(element,
                                { opacity: [0, 1], y: [30, 0] },
                                { duration: 0.6, delay: 0.2 }
                            );
                        }
                    }
                });
            }, observerOptions);

            // Observe elements
            ['#features-title', '#features-subtitle', '#about-title', '#about-subtitle', '#cta-title', '#cta-subtitle', '#cta-buttons'].forEach(selector => {
                const element = document.querySelector(selector);
                if (element) observer.observe(element);
            });

            document.querySelectorAll('[data-feature]').forEach(element => {
                observer.observe(element);
            });

            // Floating navbar scroll effect
            window.addEventListener('scroll', () => {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');

                    // Animate mobile menu
                    if (!mobileMenu.classList.contains('hidden')) {
                        Motion.animate(mobileMenu,
                            { opacity: [0, 1], y: [-20, 0] },
                            { duration: 0.3 }
                        );
                    }
                });
            }

            // Active nav pill tracking (simplified for Home and About only)
            const navPills = document.querySelectorAll('.nav-pill[href^="#"]');
            const sections = document.querySelectorAll('section[id]');

            const observerNav = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const id = entry.target.getAttribute('id');

                        // Remove active class from all nav pills
                        navPills.forEach(pill => pill.classList.remove('active'));

                        // Add active class based on section
                        if (id === 'hero') {
                            const homeNavPill = document.querySelector('.nav-pill[href="#hero"]');
                            if (homeNavPill) homeNavPill.classList.add('active');
                        } else if (id === 'about' || id === 'features' || id === 'cta') {
                            const aboutNavPill = document.querySelector('.nav-pill[href="#about"]');
                            if (aboutNavPill) aboutNavPill.classList.add('active');
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

        // Modal functions
        function showRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            Motion.animate(modalContent,
                { scale: [0.8, 1], opacity: [0, 1] },
                { duration: 0.3, easing: "ease-out" }
            );
        }

        function hideRegisterModal() {
            const modal = document.getElementById('registerModal');
            const modalContent = document.getElementById('modalContent');

            Motion.animate(modalContent, {
                scale: [1, 0.8],
                opacity: [1, 0]
            }, {
                duration: 0.2,
                easing: "ease-in"
            }).then(() => {
                modal.classList.add('hidden');
            });
        }

        // Close modal when clicking outside
        document.getElementById('registerModal').addEventListener('click', function (e) {
            if (e.target === this) {
                hideRegisterModal();
            }
        });
    </script>
</body>

</html>