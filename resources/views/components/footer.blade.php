<footer class="bg-charcoal text-white mt-20 py-12">
    <div class="container-centered">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Brand -->
            <div>
                <h4 class="font-serif font-bold text-xl mb-4">1989 Studio</h4>
                <p class="text-blush-100 text-sm leading-relaxed">{{ __('site.footer_slogan') }}</p>
            </div>

            <!-- Links -->
            <div>
                <h5 class="font-bold text-sm mb-4 uppercase tracking-widest">{{ __('site.footer_shop') }}</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('products.index') }}" class="text-blush-100 hover:text-white transition">{{ __('navigation.products') }}</a></li>
                    <li><a href="{{ route('collections.index') }}" class="text-blush-100 hover:text-white transition">{{ __('navigation.collections') }}</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h5 class="font-bold text-sm mb-4 uppercase tracking-widest">{{ __('site.footer_legal') }}</h5>
                <ul class="space-y-2 text-sm">
                    @php
                        $legalPages = \App\Models\LegalPage::where('is_active', true)->get();
                    @endphp
                    @forelse($legalPages as $page)
                        <li><a href="{{ route('pages.legal', $page) }}" class="text-blush-100 hover:text-white transition">{{ $page->title }}</a></li>
                    @empty
                        <li><span class="text-gray-400">{{ __('ui.components.footer.coming_soon') }}</span></li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h5 class="font-bold text-sm mb-4 uppercase tracking-widest">{{ __('site.footer_contact') }}</h5>
                <ul class="space-y-2 text-sm text-blush-100">
                    <li>{{ __('ui.components.footer.email') }} <a href="mailto:info@aksesoris.com" class="hover:text-white">-</a></li>
                    <li>{{ __('ui.components.footer.phone') }} <a href="tel:+62" class="hover:text-white">+62 -</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-700 pt-8 mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-blush-100">
                <p>&copy; {{ date('Y') }} Aksesoris. {{ __('site.copyright') }}</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">{{ __('site.social_instagram') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('site.social_facebook') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('site.social_tiktok') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>
