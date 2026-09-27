<x-app-layout>
<div class="min-h-screen bg-gradient-to-b from-white to-blush-50 pt-32 pb-12 flex items-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <!-- Success Container -->
        <div class="bg-white rounded-2xl border border-blush-100 p-8 sm:p-12 shadow-soft text-center">
            <!-- Success Icon -->
            <div class="mb-6 flex justify-center">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blush-400 to-rose-gold flex items-center justify-center text-white text-4xl shadow-lg">
                    ✓
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-charcoal mb-3">
                {{ __('ui.create_custom.success.design_request_submitted') }}
            </h1>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                {{ __('ui.create_custom.success.thank_you_for_submitting_your_custom_design_request_our_team') }}
            </p>

            <!-- Confirmation Details -->
            <div class="bg-blush-50 rounded-xl p-6 mb-8 text-left">
                <h3 class="font-semibold text-charcoal mb-4">{{ __('ui.create_custom.success.your_design_summary') }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">{{ __('ui.create_custom.success.jewelry_type') }}</p>
                        <p class="font-semibold text-charcoal capitalize">{{ str_replace('_', ' ', $inquiry->type) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">{{ __('ui.create_custom.success.finish') }}</p>
                        <p class="font-semibold text-charcoal capitalize">{{ $inquiry->finish }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">{{ __('ui.create_custom.success.chain_style') }}</p>
                        <p class="font-semibold text-charcoal capitalize text-xs">{{ $inquiry->chainStyle->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">{{ __('ui.create_custom.success.charm') }}</p>
                        <p class="font-semibold text-charcoal capitalize text-xs">{{ $inquiry->charm->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-1">{{ __('ui.create_custom.success.material') }}</p>
                        <p class="font-semibold text-charcoal capitalize">{{ str_replace('_', ' ', $inquiry->material) }}</p>
                    </div>
                </div>
                @if($inquiry->description)
                    <div class="mt-4 pt-4 border-t border-blush-200">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-2">{{ __('ui.create_custom.success.your_description') }}</p>
                        <p class="text-charcoal text-sm">{{ $inquiry->description }}</p>
                    </div>
                @endif
                @if($inquiry->budget)
                    <div class="mt-4">
                        <p class="text-gray-500 text-xs uppercase tracking-wide mb-2">{{ __('ui.create_custom.success.budget_2') }}</p>
                        <p class="text-charcoal font-semibold">{{ __('ui.create_custom.success.rp') }} {{ number_format($inquiry->budget, 0, ',', '.') }}</p>
                    </div>
                @endif
            </div>

            <!-- Next Steps -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-blush-100 flex items-center justify-center text-rose-gold font-bold mb-3">1</div>
                    <h4 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.review') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('ui.create_custom.success.our_team_reviews_your_design_request') }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-blush-100 flex items-center justify-center text-rose-gold font-bold mb-3">2</div>
                    <h4 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.contact') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('ui.create_custom.success.we_ll_reach_out_with_a_custom_quote') }}</p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 rounded-full bg-blush-100 flex items-center justify-center text-rose-gold font-bold mb-3">3</div>
                    <h4 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.create') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('ui.create_custom.success.your_custom_piece_comes_to_life') }}</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="px-8 py-3 rounded-full border-2 border-blush-300 text-charcoal font-semibold hover:bg-blush-50 transition-colors duration-300">
                    {{ __('ui.create_custom.success.return_to_home') }}
                </a>
            </div>

            <!-- Email Confirmation -->
            <div class="mt-8 pt-8 border-t border-blush-100">
                <p class="text-sm text-gray-600 mb-3">
                    {{ __('ui.create_custom.success.a_confirmation_email_has_been_sent_to') }} <span class="font-semibold text-charcoal">{{ auth()->user()->email }}</span>
                </p>
                <p class="text-xs text-gray-500">
                    {{ __('ui.create_custom.success.if_you_don_t_receive_an_email_within_a_few_minutes_please_ch') }}
                </p>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-12 bg-white rounded-2xl border border-blush-100 p-8 shadow-soft">
            <h2 class="text-2xl font-serif font-bold text-charcoal mb-6">{{ __('ui.create_custom.success.frequently_asked_questions') }}</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.how_long_does_the_custom_design_process_take') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('ui.create_custom.success.typically_the_entire_process_takes_2_4_weeks_from_approval_t') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.can_i_make_changes_to_my_design_after_submission') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('ui.create_custom.success.yes_our_team_will_work_with_you_to_refine_your_design_you_ca') }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-charcoal mb-2">{{ __('ui.create_custom.success.what_if_i_m_not_satisfied_with_the_quote') }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('ui.create_custom.success.we_re_flexible_our_team_can_discuss_budget_options_and_alter') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
