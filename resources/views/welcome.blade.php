<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookingApp - Gestion de rendez-vous simplifiée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold gradient-text">📅 BookingApp</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-purple-600 transition">Fonctionnalités</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-purple-600 transition">Comment ça marche</a>
                    <a href="#about" class="text-gray-600 hover:text-purple-600 transition">À propos</a>
                    <a href="#specializations" class="text-gray-600 hover:text-purple-600 transition">Spécialisations</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-600 transition">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                            Inscription gratuite
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-600 hover:text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition class="md:hidden bg-white border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="#features" class="block text-gray-600 hover:text-purple-600">Fonctionnalités</a>
                <a href="#how-it-works" class="block text-gray-600 hover:text-purple-600">Comment ça marche</a>
                <a href="#about" class="block text-gray-600 hover:text-purple-600">À propos</a>
                <a href="#specializations" class="block text-gray-600 hover:text-purple-600">Spécialisations</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block bg-purple-600 text-white px-6 py-2 rounded-lg text-center">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-600 hover:text-purple-600">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="block bg-purple-600 text-white px-6 py-2 rounded-lg text-center">
                        Inscription gratuite
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- SECTION 1: HERO -->
    <section class="pt-32 pb-20 px-4 gradient-bg">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Text -->
                <div class="text-white">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 animate-fade-in-up">
                        Gérez vos rendez-vous en toute simplicité
                    </h1>
                    <p class="text-xl mb-8 text-purple-100 animate-fade-in-up delay-100">
                        La solution idéale pour les coiffeurs, barbiers, coachs et tous les professionnels indépendants.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up delay-200">
                        <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition text-center">
                            🚀 Commencer gratuitement
                        </a>
                        <a href="#how-it-works" class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-purple-600 transition text-center">
                            📖 Comment ça marche
                        </a>
                    </div>
                    <p class="mt-6 text-purple-200 text-sm animate-fade-in-up delay-300">
                        ✨ Aucune carte bancaire requise • Installation en 5 minutes
                    </p>
                </div>

                <!-- Right: Illustration -->
                <div class="animate-fade-in-up delay-200 animate-float">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 bg-purple-50 p-4 rounded-lg">
                                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                    JD
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold">Jean Dupont</p>
                                    <p class="text-sm text-gray-500">Coupe + Barbe • 14:00</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Confirmé</span>
                            </div>
                            <div class="flex items-center gap-4 bg-yellow-50 p-4 rounded-lg">
                                <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center text-white font-bold">
                                    ML
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold">Marie Lopez</p>
                                    <p class="text-sm text-gray-500">Coloration • 16:30</p>
                                </div>
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">En attente</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: FONCTIONNALITÉS -->
    <section id="features" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Tout ce dont vous avez besoin
                </h2>
                <p class="text-xl text-gray-600">
                    Une solution complète pour gérer votre activité
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-8 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Réservation en ligne</h3>
                    <p class="text-gray-600">
                        Vos clients réservent 24h/24 sur votre page personnalisée. Fini les appels manqués !
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-8 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Gestion simplifiée</h3>
                    <p class="text-gray-600">
                        Tableau de bord intuitif pour voir et gérer tous vos rendez-vous en un coup d'œil.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-pink-50 to-purple-50 rounded-xl p-8 hover:shadow-xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-pink-600 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Services personnalisés</h3>
                    <p class="text-gray-600">
                        Créez vos services avec photos, prix, durées. Tout est personnalisable !
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: COMMENT ÇA MARCHE -->
    <section id="how-it-works" class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Comment ça marche ?
                </h2>
                <p class="text-xl text-gray-600">
                    3 étapes simples pour commencer
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="relative">
                    <div class="bg-white rounded-xl p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">
                            1
                        </div>
                        <h3 class="text-2xl font-bold mb-3">Inscrivez-vous</h3>
                        <p class="text-gray-600 mb-4">
                            Créez votre compte gratuitement en 2 minutes. Aucune carte bancaire requise.
                        </p>
                        <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">
                            S'inscrire maintenant →
                        </a>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative">
                    <div class="bg-white rounded-xl p-8 hover:shadow-xl transition">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">
                            2
                        </div>
                        <h3 class="text-2xl font-bold mb-3">Configurez</h3>
                        <p class="text-gray-600 mb-4">
                            Ajoutez vos services (coupe, barbe, coloration...) avec prix et durées.
                        </p>
                        <div class="text-gray-500">
                            Configuration rapide ⚡
                        </div>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-xl p-8 hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6">
                        3
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Partagez</h3>
                    <p class="text-gray-600 mb-4">
                        Obtenez votre lien unique et partagez-le à vos clients sur WhatsApp, Instagram, Facebook...
                    </p>
                    <div class="text-green-600 font-semibold">
                        🎉 C'est parti !
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: À PROPOS DE DHALY LAND -->
    <section id="about" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Image/Logo -->
                <div class="order-2 md:order-1">
                    <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl p-12 text-white text-center">
                        <div class="text-6xl mb-4">🏢</div>
                        <h3 class="text-4xl font-bold mb-4">DHALY LAND</h3>
                        <p class="text-xl text-purple-100">
                            Innovation • Excellence • Confiance
                        </p>
                    </div>
                </div>

                <!-- Right: Text -->
                <div class="order-1 md:order-2">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">
                        À propos de DHALY LAND
                    </h2>
                    <div class="space-y-4 text-gray-600 text-lg">
                        <p>
                            <strong class="text-purple-600">DHALY LAND</strong> est une entreprise innovante spécialisée dans le développement de solutions digitales pour les professionnels indépendants.
                        </p>
                        <p>
                            Notre mission : <strong>simplifier la gestion quotidienne des entrepreneurs</strong> en leur offrant des outils puissants mais accessibles.
                        </p>
                        <p>
                            Avec <strong>BookingApp</strong>, nous aidons des milliers de professionnels à se concentrer sur leur passion plutôt que sur l'administratif.
                        </p>
                        <div class="grid grid-cols-3 gap-4 mt-8">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-purple-600">1000+</div>
                                <div class="text-sm text-gray-500">Professionnels</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600">50K+</div>
                                <div class="text-sm text-gray-500">RDV gérés</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-green-600">99%</div>
                                <div class="text-sm text-gray-500">Satisfaction</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 5: SPÉCIALISATIONS & SERVICES SUR MESURE -->
    <section id="specializations" class="py-20 px-4 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-block bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    🎯 Services Premium
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                    Besoin d'une solution personnalisée ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    DHALY LAND développe des fonctionnalités sur mesure adaptées aux besoins spécifiques de votre entreprise
                </p>
            </div>

            <!-- Cards Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Card 1: Intégrations -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Intégrations API</h3>
                    <p class="text-gray-600 mb-4">
                        Connectez BookingApp à vos outils existants : CRM, facturation, paiement en ligne, SMS...
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            API REST complète
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Webhooks personnalisés
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Documentation technique
                        </li>
                    </ul>
                </div>

                <!-- Card 2: Fonctionnalités métier -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">Fonctionnalités Métier</h3>
                    <p class="text-gray-600 mb-4">
                        Nous développons des modules spécifiques à votre secteur d'activité et vos processus.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Gestion de stock
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Système de fidélité
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Rapports personnalisés
                        </li>
                    </ul>
                </div>

                <!-- Card 3: White Label -->
                <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-red-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-3 text-gray-800">White Label</h3>
                    <p class="text-gray-600 mb-4">
                        Déployez BookingApp avec votre propre identité visuelle et nom de domaine.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Branding personnalisé
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Nom de domaine custom
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Support dédié
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CTA Contact -->
            <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 rounded-3xl p-12 text-center text-white shadow-2xl">
                <div class="max-w-3xl mx-auto">
                    <h3 class="text-3xl md:text-4xl font-bold mb-4">
                        💼 Votre projet mérite une solution sur mesure
                    </h3>
                    <p class="text-xl text-purple-100 mb-8">
                        Notre équipe d'experts est à votre écoute pour étudier vos besoins et vous proposer une solution adaptée
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mb-8 max-w-2xl mx-auto">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-3xl font-bold mb-1">48h</div>
                            <div class="text-sm text-purple-100">Réponse garantie</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-3xl font-bold mb-1">50+</div>
                            <div class="text-sm text-purple-100">Projets réalisés</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="text-3xl font-bold mb-1">100%</div>
                            <div class="text-sm text-purple-100">Sur mesure</div>
                        </div>
                    </div>

                    <!-- Message de succès -->
                    @if(session('success'))
                        <div class="bg-green-50 border-2 border-green-500 rounded-xl p-4 mb-6 max-w-2xl mx-auto">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Contact Form -->
                    <div class="bg-white rounded-2xl p-8 text-left max-w-2xl mx-auto">
                        <form action="{{ route('contact.specialization') }}" method="POST" class="space-y-4">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Entreprise *</label>
                                    <input type="text" name="company" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition text-gray-800"
                                           placeholder="Votre entreprise">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Nom complet *</label>
                                    <input type="text" name="name" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition text-gray-800"
                                           placeholder="Jean Dupont">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Email *</label>
                                    <input type="email" name="email" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition text-gray-800"
                                           placeholder="contact@entreprise.com">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2 text-sm">Téléphone *</label>
                                    <input type="tel" name="phone" required
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition text-gray-800"
                                           placeholder="06 12 34 56 78">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm">Type de besoin</label>
                                <select name="need_type"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition text-gray-800">
                                    <option value="integration">Intégration API</option>
                                    <option value="custom_feature">Fonctionnalité sur mesure</option>
                                    <option value="white_label">White Label</option>
                                    <option value="consulting">Conseil & Audit</option>
                                    <option value="other">Autre</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-semibold mb-2 text-sm">Décrivez votre projet *</label>
                                <textarea name="message" rows="4" required
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition resize-none text-gray-800"
                                          placeholder="Décrivez-nous vos besoins, objectifs et contraintes..."></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-pink-700 transition transform hover:scale-[1.02] shadow-lg">
                                📩 Envoyer ma demande
                            </button>

                            <p class="text-xs text-gray-500 text-center">
                                En soumettant ce formulaire, vous acceptez d'être contacté par DHALY LAND concernant votre projet.
                            </p>
                        </form>
                    </div>

                    <!-- Alternative Contact -->
                    <div class="mt-8 flex flex-wrap justify-center gap-6 text-sm">
                        <a href="mailto:aridhaly@gmail.com" class="flex items-center gap-2 text-white hover:text-purple-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            aridhaly@gmail.com
                        </a>
                        <a href="tel:+22997140709" class="flex items-center gap-2 text-white hover:text-purple-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            +229 97 14 07 09
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA FINAL -->
    <section class="py-20 px-4 gradient-bg">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Prêt à simplifier votre gestion de rendez-vous ?
            </h2>
            <p class="text-xl mb-8 text-purple-100">
                Rejoignez des centaines de professionnels qui utilisent déjà BookingApp
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-purple-600 px-12 py-4 rounded-lg font-bold text-xl hover:bg-gray-100 transition">
                🚀 Commencer gratuitement
            </a>
            <p class="mt-6 text-purple-200">
                Aucune carte bancaire • Sans engagement
            </p>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h4 class="font-bold text-lg mb-4">BookingApp</h4>
                    <p class="text-gray-400 text-sm">
                        La solution de gestion de rendez-vous pour les professionnels indépendants.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Produit</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#features" class="hover:text-white">Fonctionnalités</a></li>
                        <li><a href="#how-it-works" class="hover:text-white">Comment ça marche</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">Inscription</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Entreprise</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#about" class="hover:text-white">À propos de DHALY LAND</a></li>
                        <li><a href="#specializations" class="hover:text-white">Spécialisations</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Suivez-nous</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-purple-600 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 DHALY LAND. Tous droits réservés. Propulsé par BookingApp.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll -->
    <script>
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
    </script>

</body>
</html>
