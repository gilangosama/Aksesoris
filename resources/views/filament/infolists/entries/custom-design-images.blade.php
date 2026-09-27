@php
$record = $getRecord();
$inquiry = $record?->designInquiry ?: $getState();

if (! function_exists('normalize_design_position')) {
    function normalize_design_position($value)
    {
        if (is_null($value)) {
            return 50;
        }

        $value = (int) $value;

        // Support legacy pixel stored values (0-500) and percentage values (0-100)
        if ($value > 100) {
            return min(100, max(0, round($value / 5)));
        }

        return min(100, max(0, $value));
    }
}
@endphp

<div class="space-y-6 py-2">
    @if (!$inquiry)
        <div class="text-sm text-gray-500 italic">{{ __('ui.profile.filament.no_custom_design_information_attached') }}</div>
    @else
        <!-- Live design render (chain + charms) -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold">{{ __('ui.profile.filament.live_design_render_from_data') }}</h3>
                <button id="download-live-design-btn" class="text-sm text-blue-600 hover:text-blue-800" type="button">{{ __('ui.profile.filament.download_live_preview_png') }}</button>
            </div>

            <div id="design-live-preview" style="position: relative; width: 100%; max-width: 450px; aspect-ratio: 1; background: linear-gradient(135deg, #fff5f8 0%, #fce4ec 100%); border: 2px solid #e5b5ca; border-radius: 8px; overflow: visible; padding: 0; margin: 0 auto;">
                @php
                    $chainImage = $inquiry->chainStyle?->image;
                    if ($chainImage && !filter_var($chainImage, FILTER_VALIDATE_URL)) {
                        $chainImage = asset('storage/' . ltrim($chainImage, '/'));
                    }
                @endphp

                @if($chainImage)
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 1; pointer-events: none;">
                        <img src="{{ $chainImage }}" alt="{{ $inquiry->chainStyle?->name ?? 'Chain' }}" style="max-width: 384px; max-height: 384px; width: auto; height: auto; object-fit: contain;" />
                    </div>
                @endif

                @forelse($inquiry->charmDesignItems as $item)
                    @php
                        $charm = $item->charm;
                        $x = normalize_design_position($item->charm_position_x ?? 50);
                        $y = normalize_design_position($item->charm_position_y ?? 50);
                        $charmImage = $charm?->image ?? null;
                        if ($charmImage && !filter_var($charmImage, FILTER_VALIDATE_URL)) {
                            $charmImage = asset('storage/' . ltrim($charmImage, '/'));
                        }
                    @endphp
                    <div style="position: absolute; left: {{ $x }}%; top: {{ $y }}%; transform: translate(-50%, -50%); width: 80px; height: 80px; z-index: 10; display: flex; align-items: center; justify-content: center;">
                        @if($charmImage)
                            <img src="{{ $charmImage }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="{{ $charm?->name ?? 'Charm' }}" />
                        @else
                            <span style="font-size: 2rem;">⭐</span>
                        @endif
                    </div>
                @empty
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #999; font-size: 14px;">No charms for this design</div>
                @endforelse
            </div>
        </div>

        <script>
            async function ensureHtml2Canvas() {
                if (typeof html2canvas !== 'undefined') {
                    return html2canvas;
                }
                return new Promise((resolve, reject) => {
                    const script = document.createElement('script');
                    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                    script.onload = () => resolve(window.html2canvas);
                    script.onerror = reject;
                    document.head.appendChild(script);
                });
            }

            document.getElementById('download-live-design-btn').addEventListener('click', async () => {
                try {
                    const html2canvas = await ensureHtml2Canvas();
                    const element = document.getElementById('design-live-preview');
                    if (!element) return;

                    const rect = element.getBoundingClientRect();
                    const size = Math.min(rect.width, rect.height);
                    const canvas = await html2canvas(element, {
                        backgroundColor: '#fff',
                        useCORS: true,
                        allowTaint: true,
                        scale: ,
                        width: size,
                        height: size,
                    });

                    const dataUrl = canvas.toDataURL('image/png');
                    const link = document.createElement('a');
                    link.href = dataUrl;
                    link.download = 'custom-design-preview.png';
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                } catch (error) {
                    console.error('Failed to generate live preview download', error);
                    alert('Unable to capture live design preview for download at the moment. Please refresh and try again.');
                }
            });
        </script>

        <!-- Additional Design Details -->
        <div class="pt-4 border-t border-gray-200">
            <h3 class="text-sm font-semibold mb-2">{{ __('ui.profile.filament.design_details') }}</h3>
            <dl class="space-y-1 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-600">{{ __('ui.profile.filament.type') }}</dt>
                    <dd class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $inquiry->type) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">{{ __('ui.profile.filament.finish') }}</dt>
                    <dd class="font-medium text-gray-900 capitalize">{{ $inquiry->finish }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">{{ __('ui.profile.filament.chain_style') }}</dt>
                    <dd class="font-medium text-gray-900">{{ $inquiry->chainStyle?->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-600">{{ __('ui.profile.filament.charms') }}</dt>
                    <dd class="font-medium text-gray-900">{{ $inquiry->charms?->count() ?? 0 }}</dd>
                </div>
            </dl>
        </div>
    @endif
</div>
