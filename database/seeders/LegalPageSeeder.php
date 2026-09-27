<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LegalPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legalPages = [
            [
                'slug' => 'terms',
                'title' => 'Terms & Conditions',
                'content' => '<h2>Terms & Conditions</h2><p>Welcome to Aksesoris Custom Design. These terms and conditions outline the rules and regulations for the use of our website.</p><h3>License</h3><p>Unless otherwise stated, Aksesoris and its licensors own the intellectual property rights for all material on the website. All intellectual property rights are reserved.</p><h3>User Content</h3><p>In these website terms and conditions, "User Content" shall mean any audio, video, text, images, or other material you choose to display on the website. By displaying User Content, you grant Aksesoris a non-exclusive, worldwide, irrevocable license to use, reproduce, adapt, publish, and distribute it in any media.</p><h3>Limitations</h3><p>In no event shall Aksesoris, nor any of its officers, directors, and employees, be held liable for anything arising out of or in any way connected with your use of this website whether such liability is under contract, tort, or otherwise.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'privacy',
                'title' => 'Privacy Policy',
                'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. This privacy policy explains how we collect, use, disclose, and safeguard your information.</p><h3>Information We Collect</h3><p>We may collect information about you in a variety of ways. The information we may collect on the site includes:</p><ul><li>Personal Data: name, email address, phone number, address</li><li>Payment Information: handled securely by our payment processor (Midtrans)</li><li>Usage Data: how you interact with our website</li></ul><h3>Use of Data</h3><p>Aksesoris uses the collected data for various purposes such as:</p><ul><li>To provide and maintain our service</li><li>To notify you about changes to our service</li><li>To allow you to participate in interactive features of our service</li><li>To provide customer support</li></ul><h3>Data Security</h3><p>The security of your data is important to us, but remember that no method of transmission over the Internet or method of electronic storage is 100% secure.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'refund-policy',
                'title' => 'Refund & Return Policy',
                'content' => '<h2>Refund & Return Policy</h2><p>At Aksesoris, we take great pride in the quality of our custom-designed jewelry. However, we understand that sometimes items may not meet your expectations.</p><h3>Return Period</h3><p>You may return any item within 30 days of receipt. Items must be in their original condition, unworn, and with all original packaging.</p><h3>Custom Orders</h3><p>Custom-designed pieces are made specifically for you and cannot be returned once production has begun. Please ensure you approve the design before we start production.</p><h3>Refund Process</h3><p>Once we receive and inspect your return, we will process your refund within 7-10 business days. Refunds will be issued to your original payment method.</p><h3>Shipping</h3><p>You are responsible for return shipping costs unless the item was damaged or defective upon arrival.</p>',
                'is_active' => true,
            ],
            [
                'slug' => 'shipping',
                'title' => 'Shipping Policy',
                'content' => '<h2>Shipping Policy</h2><p>We are committed to delivering your jewelry safely and on time.</p><h3>Shipping Methods</h3><p>We offer several shipping options at checkout:</p><ul><li>Standard Shipping: 5-7 business days</li><li>Express Shipping: 2-3 business days</li><li>Overnight Shipping: Next business day</li></ul><h3>Processing Time</h3><p>Orders are typically processed within 1-2 business days. Custom orders may take longer depending on design complexity.</p><h3>Tracking</h3><p>Once your order ships, you will receive a tracking number via email. You can use this number to monitor your shipment.</p><h3>Delivery Confirmation</h3><p>All shipments require a signature upon delivery. If no one is available to sign, the package will be held at the carrier facility for pickup.</p>',
                'is_active' => true,
            ],
        ];

        foreach ($legalPages as $page) {
            LegalPage::create($page);
        }
    }
}

