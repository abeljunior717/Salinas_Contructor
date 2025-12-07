@extends('layouts.app')

@section('title', 'Contacto - Salinas Constructor')

@section('content')
<div class="min-h-screen bg-blue-50">
    <x-hero title="Envíanos un Mensaje" subtitle="Completa el formulario y nuestro equipo de expertos se pondrá en contacto contigo a la brevedad." />

    <!-- Contact Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulario -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg p-8 shadow-md">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nombre Completo -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Nombre Completo</label>
                            <input type="text" name="name" placeholder="Ej. Juan Pérez" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('name') }}" required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Correo Electrónico</label>
                            <input type="email" name="email" placeholder="Ej. juan.perez@example.com" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('email') }}" required>
                        </div>

                        <!-- Mensaje -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-gray-700">Mensaje</label>
                            <textarea name="message" rows="6" placeholder="Escribe aquí tu consulta o solicitud de cotización." 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg 
                                      focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      required>{{ old('message') }}</textarea>
                            <small class="text-gray-500">Mínimo 10 caracteres</small>
                        </div>

                        <!-- Botón de envío -->
                        <button type="submit" class="btn-yellow w-full py-3 font-bold text-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div>
                <div class="bg-white rounded-lg p-8 shadow-md sticky top-24">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Detalles de Contacto</h3>

                    <!-- Ubicación -->
                    <div class="flex gap-4 mb-6">
                        <div class="text-blue-700 text-2xl flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Nuestra Ubicación</p>
                            <p class="text-gray-600 text-sm">Col. Fco. García Salinas Calle principal, calle Benito Juárez #23</p>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="flex gap-4 mb-6">
                        <div class="text-blue-700 text-2xl flex-shrink-0">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Teléfono</p>
                            <a href="tel:+524981225733" class="text-blue-600 hover:underline">(+52) 498 122 5733</a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex gap-4 mb-8">
                        <div class="text-blue-700 text-2xl flex-shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Correo Electrónico</p>
                            <a href="mailto:vfjunior117@gmail.com" class="text-blue-600 hover:underline">vfjunior117@gmail.com</a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="font-bold text-gray-900 mb-2">¿Preguntas urgentes?</p>
                        <p class="text-gray-600 text-sm mb-4">Chatea con nosotros en WhatsApp.</p>
                        <a href="https://wa.me/524981225733" target="_blank" class="inline-block bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-bold transition">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mapa (Opcional) -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-8">Ubicación</h2>
            <div class="bg-gray-300 rounded-lg overflow-hidden" style="height: 400px;">
                <iframe width="100%" height="100%" frameborder="0" style="border:0" 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3756.7436427894!2d-102.43!3d23.19!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x86af4d8c1c1c1c1d%3A0x1c1c1c1c1c1c1c1c!2sSalinas%20Constructor!5e0!3m2!1ses!2smx!4v1234567890" 
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <!-- Horario de Atención -->
        <div class="mt-16 bg-white rounded-lg p-8 shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Horario de Atención</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <p class="font-bold text-lg mb-2">🕒 Lunes a Viernes</p>
                    <p class="text-gray-600">8:00 AM - 6:00 PM</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-lg mb-2">📅 Sábados</p>
                    <p class="text-gray-600">9:00 AM - 2:00 PM</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-lg mb-2">🏖️ Domingos</p>
                    <p class="text-gray-600">Cerrado</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
