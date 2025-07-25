<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LineShop Africa - Inventory & POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        
        .gradient-text {
            background: linear-gradient(90deg, #4f46e5, #10b981);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-icon {
            transition: transform 0.3s ease;
        }
        
        .glow-on-hover {
            transition: box-shadow 0.3s ease;
        }
        
        .glow-on-hover:hover {
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.5);
        }
    </style>
</head>
<body class="font-nunito bg-gray-50">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex items-center">
                        <i class="fas fa-store text-indigo-600 text-2xl mr-2"></i>
                        <span class="text-xl font-bold text-gray-900">LineShop <span class="text-indigo-600">Africa</span></span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-indigo-600 transition">Features</a>
                    <a href="#pricing" class="text-gray-700 hover:text-indigo-600 transition">Pricing</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-indigo-600 transition">Testimonials</a>
                    <a href="#contact" class="text-gray-700 hover:text-indigo-600 transition">Contact</a>
                    
                    <div class="relative group">
                        <button class="flex items-center text-gray-700 hover:text-indigo-600 transition">
                            <i class="fas fa-globe mr-1"></i> English
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg py-1 hidden group-hover:block">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50" onclick="changeLanguage('en'); return false;">English</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50" onclick="changeLanguage('sw'); return false;">Swahili</a>
                        </div>
                    </div>
                    
                    <a href="login" class="px-4 py-2 border border-transparent rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">Login</a>
                    <a href="register" class="px-4 py-2 border border-transparent rounded-md text-white bg-green-600 hover:bg-green-700 transition">Register</a>
                </div>
                
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-toggle" class="text-gray-500 hover:text-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="fixed inset-0 z-50 bg-white bg-opacity-95 flex flex-col items-center justify-start pt-24 space-y-8 text-lg font-semibold text-gray-800 transition-transform duration-300 transform -translate-y-full md:hidden" style="display:none;">
        <a href="#features" class="hover:text-indigo-600" onclick="closeMobileMenu()">Features</a>
        <a href="#pricing" class="hover:text-indigo-600" onclick="closeMobileMenu()">Pricing</a>
        <a href="#testimonials" class="hover:text-indigo-600" onclick="closeMobileMenu()">Testimonials</a>
        <a href="#contact" class="hover:text-indigo-600" onclick="closeMobileMenu()">Contact</a>
        <div class="flex flex-col w-full items-center">
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 w-full text-center" onclick="changeLanguage('en'); closeMobileMenu(); return false;">English</a>
            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 w-full text-center" onclick="changeLanguage('sw'); closeMobileMenu(); return false;">Swahili</a>
        </div>
        <a href="login" class="w-3/4 py-2 rounded-md text-white bg-indigo-600 hover:bg-indigo-700 text-center">Login</a>
        <a href="register" class="w-3/4 py-2 rounded-md text-white bg-green-600 hover:bg-green-700 text-center">Register</a>
        <button onclick="closeMobileMenu()" class="absolute top-6 right-6 text-gray-500 hover:text-gray-900 text-3xl focus:outline-none">&times;</button>
    </div>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-blue-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Transform Your Business with <span class="gradient-text">LineShop Africa</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                    The most powerful yet simple Inventory & POS system designed specifically for East African businesses.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="register" class="px-8 py-4 bg-green-500 hover:bg-green-600 rounded-lg text-lg font-semibold text-white transition transform hover:scale-105 glow-on-hover delay-200">
                        <i class="fas fa-rocket mr-2"></i> Start Free Trial
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-indigo-600 hover:bg-gray-100 rounded-lg text-lg font-semibold transition transform hover:scale-105 delay-300">
                        <i class="fas fa-play-circle mr-2"></i> Watch Demo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="animate-fade-in delay-100">
                    <div class="text-4xl font-bold text-indigo-600">500+</div>
                    <div class="text-gray-600 mt-2">Happy Businesses</div>
                </div>
                <div class="animate-fade-in delay-200">
                    <div class="text-4xl font-bold text-indigo-600">24/7</div>
                    <div class="text-gray-600 mt-2">Customer Support</div>
                </div>
                <div class="animate-fade-in delay-300">
                    <div class="text-4xl font-bold text-indigo-600">99.9%</div>
                    <div class="text-gray-600 mt-2">Uptime</div>
                </div>
                <div class="animate-fade-in delay-400">
                    <div class="text-4xl font-bold text-indigo-600">5+</div>
                    <div class="text-gray-600 mt-2">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Powerful Features for Your Business</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Everything you need to manage your inventory, sales, and customers in one place
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-100">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Smart POS System</h3>
                        <p class="text-gray-600">
                            Lightning-fast checkout with barcode scanning, multiple payment options, and customer management.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-200">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Inventory Control</h3>
                        <p class="text-gray-600">
                            Real-time stock tracking across multiple locations with low stock alerts and expiry date management.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-300">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Advanced Analytics</h3>
                        <p class="text-gray-600">
                            Beautiful dashboards and reports to track sales, profits, and inventory performance.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-400">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile App</h3>
                        <p class="text-gray-600">
                            Manage your business on the go with our iOS and Android apps. Works offline too!
                        </p>
                    </div>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-500">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-User Access</h3>
                        <p class="text-gray-600">
                            Create staff accounts with different permission levels for better security and control.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:-translate-y-2 animate-fade-in delay-600">
                    <div class="p-6">
                        <div class="feature-icon text-4xl text-indigo-600 mb-4">
                            <i class="fas fa-language"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Bilingual Support</h3>
                        <p class="text-gray-600">
                            Switch between English and Swahili with one click. More languages coming soon!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Video Section -->
    <section class="py-20 bg-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">See LineShop in Action</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Watch our 2-minute demo to see how LineShop can transform your business
                </p>
            </div>
            
            <div class="relative aspect-w-16 aspect-h-9 rounded-xl shadow-2xl overflow-hidden bg-black animate-fade-in">
                <div class="absolute inset-0 flex items-center justify-center">
                    <button class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center text-white hover:bg-indigo-700 transition transform hover:scale-110">
                        <i class="fas fa-play text-2xl"></i>
                    </button>
                </div>
                <img src="https://images.unsplash.com/photo-1556740738-b6a63e27c4df?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Demo Video Thumbnail" class="w-full h-full object-cover opacity-70">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Trusted by Businesses Across East Africa</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it. Here's what our customers say:
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "LineShop has transformed our pharmacy business. Inventory management is now a breeze, and our sales have increased by 30% since we started using their POS system."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4">
                            <i class="fas fa-user-md text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Dr. Amina Hassan</h4>
                            <p class="text-gray-600">MediCare Pharmacy, Dar es Salaam</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "As a small retail shop owner, I needed something simple but powerful. LineShop was exactly that. The mobile app lets me check my business from anywhere."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4">
                            <i class="fas fa-store text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">John Mwangi</h4>
                            <p class="text-gray-600">Mwangi Supermarket, Nairobi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-xl shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-xl">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-6">
                        "The customer support is exceptional. They helped us customize the system for our wholesale business and trained our staff. Highly recommended!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4">
                            <i class="fas fa-warehouse text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Sarah Nalwoga</h4>
                            <p class="text-gray-600">Kampala Wholesalers, Uganda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Start with a 30-day free trial. No credit card required.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Basic Plan -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
                        <p class="text-gray-600 mb-6">Perfect for small businesses</p>
                        <div class="text-4xl font-bold text-indigo-600 mb-6">TZS 99,000<span class="text-lg text-gray-500">/mo</span></div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Up to 500 products</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>2 user accounts</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Basic reports</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Email support</span>
                            </li>
                        </ul>
                        <a href="register" class="block w-full py-3 px-6 border border-indigo-600 text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition">Start Free Trial</a>
                    </div>
                </div>
                
                <!-- Popular Plan -->
                <div class="bg-white rounded-xl shadow-xl overflow-hidden transform scale-105 relative">
                    <div class="absolute top-0 right-0 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                        MOST POPULAR
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Business</h3>
                        <p class="text-gray-600 mb-6">For growing businesses</p>
                        <div class="text-4xl font-bold text-indigo-600 mb-6">TZS 199,000<span class="text-lg text-gray-500">/mo</span></div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Unlimited products</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>5 user accounts</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Advanced reports</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Phone & email support</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Mobile app access</span>
                            </li>
                        </ul>
                        <a href="register" class="block w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">Start Free Trial</a>
                    </div>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                        <p class="text-gray-600 mb-6">For large businesses</p>
                        <div class="text-4xl font-bold text-indigo-600 mb-6">Custom</div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Unlimited everything</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Dedicated account manager</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Custom integrations</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>Priority 24/7 support</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                <span>On-site training</span>
                            </li>
                        </ul>
                        <a href="#contact" class="block w-full py-3 px-6 border border-indigo-600 text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-indigo-600 to-blue-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Transform Your Business?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto">
                Join over 500 businesses in East Africa who trust LineShop for their inventory and POS needs.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="register" class="px-8 py-4 bg-white text-indigo-600 hover:bg-gray-100 rounded-lg text-lg font-semibold transition transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i> Start Free Trial
                </a>
                <a href="#contact" class="px-8 py-4 border border-white text-white hover:bg-white hover:bg-opacity-10 rounded-lg text-lg font-semibold transition transform hover:scale-105">
                    <i class="fas fa-phone-alt mr-2"></i> Talk to Sales
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Get in Touch</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Have questions? Our team is here to help you grow your business.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="bg-gray-50 rounded-xl p-8 shadow-md">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                                <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Email</h4>
                                <p class="text-gray-600">info@lineshopafrica.com</p>
                                <p class="text-gray-600">support@lineshopafrica.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                                <i class="fas fa-phone-alt text-indigo-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Phone</h4>
                                <p class="text-gray-600">+255 787 123 456 (Tanzania)</p>
                                <p class="text-gray-600">+254 700 123 456 (Kenya)</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                                <i class="fas fa-map-marker-alt text-indigo-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Office</h4>
                                <p class="text-gray-600">Mikocheni Light Industrial Area</p>
                                <p class="text-gray-600">Dar es Salaam, Tanzania</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 shadow-md">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h3>
                    <form>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                                <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <input type="text" id="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                            
                            <div>
                                <button type="submit" class="w-full py-3 px-6 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                    Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">
                    Everything you need to know about LineShop Africa
                </p>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">Is there a free trial available?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform transform"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Yes! You can try LineShop Africa free for 30 days with no credit card required. After your trial, you can choose a plan that fits your business needs.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">Can I use LineShop offline?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform transform"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Absolutely! Our mobile apps work offline and will sync your data automatically when you're back online. Perfect for areas with unreliable internet.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">How is my data protected?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform transform"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            We take data security seriously. Your data is encrypted both in transit and at rest, with regular backups. We comply with all local data protection regulations.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">Do you offer training?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform transform"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Yes! We provide comprehensive online training materials and video tutorials. For enterprise customers, we also offer on-site training sessions.
                        </p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="w-full flex justify-between items-center p-6 text-left focus:outline-none">
                        <h3 class="text-lg font-medium text-gray-900">Can I switch plans later?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform transform"></i>
                    </button>
                    <div class="px-6 pb-6 hidden">
                        <p class="text-gray-600">
                            Of course! You can upgrade or downgrade your plan at any time with just a few clicks. Your data remains intact when changing plans.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-lg font-semibold mb-4">LineShop Africa</h3>
                    <p class="text-gray-400">
                        Empowering East African businesses with simple, effective inventory and POS solutions.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Product</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition">Features</a></li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Demo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Updates</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Security</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <i class="fas fa-store text-indigo-400 text-2xl mr-2"></i>
                    <span class="text-xl font-bold">LineShop <span class="text-indigo-400">Africa</span></span>
                </div>
                
                <div class="flex space-x-6 mb-4 md:mb-0">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                
                <div class="text-gray-400 text-sm">
                    &copy; 2023 LineShop Africa. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle FAQ items
        document.querySelectorAll('.bg-white.rounded-xl.shadow-md button').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');
                
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        // Mobile menu toggle
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
                    mobileMenu.style.display = 'flex';
                    setTimeout(() => mobileMenu.style.transform = 'translateY(0)', 10);
                } else {
                    closeMobileMenu();
                }
            });
        }
        function closeMobileMenu() {
            mobileMenu.style.transform = '-translate-y-full';
            setTimeout(() => mobileMenu.style.display = 'none', 300);
        }

        // Language switcher: reloads current page with new language
        function changeLanguage(lang) {
            const url = new URL(window.location.href);
            url.pathname = '/language/' + lang + url.pathname;
            window.location.href = url.toString();
        }
    </script>
</body>
</html>