<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="flex justify-center items-center gap-1 sm:gap-2 mb-12 overflow-x-auto pb-2">
            <a href="{{ route('create-custom.type') }}" class="flex items-center gap-1 sm:gap-2 group flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">1</button>
            </a>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.finish', ['type' => $type]) }}" class="flex items-center gap-1 sm:gap-2 group flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">2</button>
            </a>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" class="flex items-center gap-1 sm:gap-2 group flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft group-hover:shadow-lg transition-shadow">3</button>
            </a>
            <div class="w-6 sm:w-8 h-1 bg-blush-500 flex-shrink-0"></div>
            <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-500 text-white font-semibold text-xs sm:text-sm flex items-center justify-center shadow-soft">4</button>
            </div>
            <div class="w-6 sm:w-8 h-1 bg-blush-200 flex-shrink-0"></div>
            <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                <button class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-blush-100 text-charcoal font-semibold text-xs sm:text-sm flex items-center justify-center border-2 border-blush-200">5</button>
            </div>
        </div>

        <div class="text-center mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-serif font-bold text-charcoal mb-3">Pilih Ukuran Chain</h1>
            <p class="text-sm sm:text-base text-gray-600">Pilih ukuran chain untuk style <span class="font-semibold">{{ $chainStyleObj->name }}</span> sebelum melanjutkan ke pilihan charm.</p>
            <p class="text-sm text-gray-500 mt-2">
                @if($jewelry->type === 'necklace')
                    Ukuran umum: 40 cm (pendek), 45 cm (standar), dan 50 cm (panjang).
                @elseif($jewelry->type === 'bracelet')
                    Ukuran umum: 16 cm, 17 cm, 18 cm.
                @elseif($jewelry->type === 'hand_chain')
                    Ukuran umum: 16 cm, 17 cm, 18 cm.
                @elseif($jewelry->type === 'earrings')
                    Gunakan ukuran atau model yang disarankan untuk tampilan terbaik.
                @else
                    Pilih ukuran yang nyaman dan sesuai gaya Anda.
                @endif
            </p>
        </div>

        <div class="bg-white rounded-2xl border-2 border-blush-100 p-8 mb-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($chainStyleObj->sizes as $size)
                    <a href="{{ route('create-custom.charm', ['type' => $type, 'finish' => $finish, 'chain_style' => $chain_style, 'chain_size' => $size['label']]) }}" class="group block rounded-3xl border border-blush-200 bg-blush-50 hover:bg-white transition-all duration-300 shadow-sm hover:shadow-lg p-6 h-full">
                        <div class="flex items-start justify-between mb-4 gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.2em] text-gray-400">Ukuran</p>
                                <h3 class="text-xl font-semibold text-charcoal mt-2">{{ $size['label'] }}</h3>
                            </div>
                            @if(!empty($size['recommended']) && $size['recommended'])
                                <span class="rounded-full bg-emerald-500 text-white text-xs font-semibold px-3 py-1">Recommended</span>
                            @endif
                        </div>

                        <div class="text-gray-600 text-sm space-y-2">
                            @if(!empty($size['length']))
                                <p>Pan panjang: {{ $size['length'] }} cm</p>
                            @endif
                            <p>{{ $size['price_add'] > 0 ? 'Harga tambahan: Rp ' . number_format($size['price_add'], 0, ',', '.') : 'Harga standar' }}</p>
                            @if(!empty($size['recommended']) && $size['recommended'])
                                <p class="text-emerald-600 text-xs uppercase tracking-[0.2em] font-semibold">Direkomendasikan untuk kebanyakan pembeli</p>
                            @endif
                        </div>

                        <div class="mt-6 inline-flex items-center gap-2 text-blush-600 font-semibold">
                            <span>Pilih ukuran</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex justify-center">
            <a href="{{ route('create-custom.chain-style', ['type' => $type, 'finish' => $finish]) }}" class="inline-flex items-center gap-2 text-blush-600 hover:text-blush-700 font-semibold transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke pilihan chain style
            </a>
        </div>
    </div>
</div>
</x-app-layout>
