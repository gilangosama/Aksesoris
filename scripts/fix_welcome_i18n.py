from pathlib import Path

path = Path('resources/views/welcome.blade.php')
text = path.read_text(encoding='utf-8')
replacements = {
    "<title>{{ __('ui.welcome.1989_studio') }}</title>": '<title>1989 Studio</title>',
    "@property --tw-ring-offset-width{syntax:\"<length>{{ __('ui.welcome.inherits_false_initial_value_0_property_tw_ring_offset_color') }}": '@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}',
    "{{ __('ui.welcome.gallery') }}": 'Gallery',
    "{{ __('ui.welcome.our_collection') }}": 'Our Collection',
    "{{ __('ui.welcome.view_details') }}": 'View Details →',
    "{{ __('ui.welcome.shop_look') }}": 'Shop the Look',
    "{{ __('ui.welcome.view_all_collections') }}": 'View All Collections',
    "{{ __('ui.welcome.collection') }}": 'Collection',
    "{{ __('ui.welcome.shop_pearl_collection') }}": 'Shop Pearl Collection ✨',
    "{{ __('ui.welcome.client_love') }}": 'Client Love',
    "{{ __('ui.welcome.loved_by_our_clients') }}": 'Loved by Our Clients',
    "{{ __('ui.welcome.the_most_exquisite_engagement_ring_i_ve_ever_seen_the_crafts') }}": 'The most exquisite engagement ring I’ve ever seen. The craftsmanship is flawless.',
    "{{ __('ui.welcome.sarah_johnson') }}": 'Sarah Johnson',
    "{{ __('ui.welcome.verified_buyer') }}": 'Verified Buyer',
    "{{ __('ui.welcome.i_commissioned_a_custom_piece_and_it_exceeded_all_my_expecta') }}": 'I commissioned a custom piece and it exceeded all my expectations.',
    "{{ __('ui.welcome.emily_davis') }}": 'Emily Davis',
    "{{ __('ui.welcome.the_quality_is_unmatched_i_ve_owned_fine_jewelry_for_years_a') }}": 'The quality is unmatched. I’ve owned fine jewelry for years and this is the best.',
    "{{ __('ui.welcome.jessica_martinez') }}": 'Jessica Martinez',
    "{{ __('ui.welcome.handmade_jewelry_and_custom_accessories_for_the_modern_woman') }}": 'Handmade jewelry and custom accessories for the modern woman.',
    "{{ __('ui.welcome.collections') }}": 'Collections',
    "{{ __('ui.welcome.eternal_bonds') }}": 'Eternal Bonds',
    "{{ __('ui.welcome.rose_whispers') }}": 'Rose Whispers',
    "{{ __('ui.welcome.bespoke_designs') }}": 'Bespoke Designs',
    "{{ __('ui.welcome.company') }}": 'Company',
    "{{ __('ui.welcome.about_us') }}": 'About Us',
    "{{ __('ui.welcome.contact') }}": 'Contact',
    "{{ __('ui.welcome.careers') }}": 'Careers',
    "{{ __('ui.welcome.connect') }}": 'Connect',
    "{{ __('ui.welcome.instagram') }}": 'Instagram',
    "{{ __('ui.welcome.pinterest') }}": 'Pinterest',
    "{{ __('ui.welcome.newsletter') }}": 'Newsletter',
    "{{ __('ui.welcome.2026_1989_studio_all_rights_reserved_crafted_with_and_love') }}": '© 2026 1989.Studio. All rights reserved. Crafted with ✨ and love.',
}

for old, new in replacements.items():
    if old in text:
        text = text.replace(old, new)
    else:
        print('MISSING:', old)

path.write_text(text, encoding='utf-8')
print('finished replacements')
