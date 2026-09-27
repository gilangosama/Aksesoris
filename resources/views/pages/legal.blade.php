<x-app-layout>
    <div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="bg-blush-50 border-b border-blush-100 py-4 mb-8 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <a href="/" class="hover:text-blush-500 transition-colors">{{ __('ui.pages.legal.home') }}</a>
                    <span class="text-gray-400">/</span>
                    <span class="text-charcoal font-medium">{{ $legalPage->title }}</span>
                </div>
            </div>

            <!-- Content -->
            <article class="prose prose-lg max-w-none">
                <h1 class="text-4xl font-serif font-bold text-charcoal mb-2">{{ $legalPage->title }}</h1>
                <p class="text-sm text-gray-500 mb-8">{{ __('ui.pages.legal.last_updated') }} {{ $legalPage->updated_at->format('M d, Y') }}</p>
                
                <div class="bg-white rounded-lg">
                    {!! $legalPage->content !!}
                </div>
            </article>

            <!-- Related Pages -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-charcoal mb-4">{{ __('ui.pages.legal.other_policies') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $otherPages = \App\Models\LegalPage::where('is_active', true)
                            ->where('id', '!=', $legalPage->id)
                            ->limit(4)
                            ->get();
                    @endphp
                    @forelse($otherPages as $page)
                        <a href="{{ route('pages.legal', $page) }}" class="p-4 border border-gray-200 rounded-lg hover:border-blush-500 hover:shadow-md transition-all">
                            <h4 class="font-semibold text-charcoal hover:text-blush-600">{{ $page->title }}</h4>
                            <p class="text-sm text-gray-500 mt-1">{{ \Str::limit(strip_tags($page->content), 100) }}</p>
                        </a>
                    @empty
                        <p class="text-gray-500">{{ __('ui.pages.legal.no_other_policies_available') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
