<?php
/*
Template Name: Design System
*/

get_header(); ?>

<!-- Design System Showcase Page -->
<section class="py-20 bg-white">
    <div class="container-custom">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Design System</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Our comprehensive design system featuring buttons, typography, colors, and UI components with consistent styling and modern interactions.
            </p>
        </div>
        
        <!-- Typography Overview -->
        <div class="mb-20">
            <h2 class="title-h2 mb-8">Typography</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div>
                        <div class="title-h1">H1 – Heading 1</div>
                        <p class="body-22-dark mt-2">Responsive clamp to max 64px, weight 400.</p>
                    </div>
                    <div>
                        <div class="title-h2">H2 – Heading 2</div>
                        <p class="body-22-dark mt-2">Responsive clamp to max 52px, weight 400.</p>
                    </div>
                    <div>
                        <div class="title-h3">H3 – Heading 3</div>
                        <p class="body-22-dark mt-2">Responsive clamp to max 28px, weight 400.</p>
                    </div>
                </div>
                <div class="space-y-6 bg-gray-50 rounded-2xl p-8">
                    <div class="bg-dark p-6 rounded-2xl">
                        <div class="title-h2 title-white mb-2">White Title Example</div>
                        <p class="body-28 title-white/80">Use <code>.title-white</code> when placing titles on dark backgrounds.</p>
                    </div>
                    <div>
                        <p class="body-28">Body text 28px, color #748394. This size is great for hero subtitles and marketing copy.</p>
                    </div>
                    <div>
                        <p class="body-22-dark">Body text 22px, color #283440, weight 400. Use for general content and descriptions.</p>
                    </div>
                    <div>
                        <p class="body-18">Body text 18px (1.125rem), color #748394, weight 400. Perfect for smaller content blocks and captions.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Types Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-20">
            <!-- Gradient Button -->
            <div class="text-center">
                <div class="bg-gray-50 rounded-2xl p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gradient Button</h3>
                    <p class="text-gray-600 mb-6">Primary action buttons with blue gradient background</p>
                    <button class="btn-gradient">
                        EXPLORE PRODUCTS
                    </button>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900">Usage Examples:</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Call-to-action buttons</li>
                        <li>• Primary navigation</li>
                        <li>• Purchase actions</li>
                        <li>• Form submissions</li>
                    </ul>
                </div>
            </div>
            
            <!-- Darker Gradient Button -->
            <div class="text-center">
                <div class="bg-gray-50 rounded-2xl p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Darker Gradient</h3>
                    <p class="text-gray-600 mb-6">Secondary actions with dark gradient background</p>
                    <button class="btn-gradient-dark">
                        SEE MORE
                    </button>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900">Usage Examples:</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Secondary actions</li>
                        <li>• Read more links</li>
                        <li>• Alternative CTAs</li>
                        <li>• Modal triggers</li>
                    </ul>
                </div>
            </div>
            
            <!-- White Button -->
            <div class="text-center">
                <div class="bg-gray-50 rounded-2xl p-8 mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">White Button</h3>
                    <p class="text-gray-600 mb-6">Tertiary actions with white background</p>
                    <button class="btn-white">
                        LEARN MORE
                    </button>
                </div>
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900">Usage Examples:</h4>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Tertiary actions</li>
                        <li>• Information links</li>
                        <li>• Light backgrounds</li>
                        <li>• Subtle interactions</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Interactive Examples -->
        <div class="bg-gray-50 rounded-2xl p-12 mb-20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Interactive Examples</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Hover States -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Hover States</h3>
                    <div class="space-y-4">
                        <button class="btn-gradient w-full">
                            HOVER ME
                        </button>
                        <button class="btn-gradient-dark w-full">
                            HOVER ME
                        </button>
                        <button class="btn-white w-full">
                            HOVER ME
                        </button>
                    </div>
                </div>
                
                <!-- Different Sizes -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Button Sizes</h3>
                    <div class="space-y-4">
                        <button class="btn-gradient text-sm px-6 py-3">
                            SMALL
                        </button>
                        <button class="btn-gradient">
                            MEDIUM
                        </button>
                        <button class="btn-gradient text-lg px-10 py-5">
                            LARGE
                        </button>
                    </div>
                </div>
                
                <!-- Different Text -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Text Variations</h3>
                    <div class="space-y-4">
                        <button class="btn-gradient">
                            GET STARTED
                        </button>
                        <button class="btn-gradient-dark">
                            READ MORE
                        </button>
                        <button class="btn-white">
                            CONTACT US
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Technical Specifications -->
        <div class="bg-white border border-gray-200 rounded-2xl p-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Technical Specifications</h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Shape Specifications -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Button Shape</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Top-left radius:</span>
                                <span class="font-mono text-sm">32px</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Top-right radius:</span>
                                <span class="font-mono text-sm">4px</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bottom-right radius:</span>
                                <span class="font-mono text-sm">32px</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bottom-left radius:</span>
                                <span class="font-mono text-sm">4px</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Color Specifications -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Color Schemes</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded" style="background: linear-gradient(135deg, #25AAE1 0%, #004F8C 100%);"></div>
                            <div>
                                <div class="font-semibold text-gray-900">Gradient Button</div>
                                <div class="text-sm text-gray-600">#25AAE1 → #004F8C</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded" style="background: linear-gradient(135deg, #0D3452 0%, #1A1A1A 100%);"></div>
                            <div>
                                <div class="font-semibold text-gray-900">Darker Gradient</div>
                                <div class="text-sm text-gray-600">#0D3452 → #1A1A1A</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-8 h-8 rounded border border-gray-300" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);"></div>
                            <div>
                                <div class="font-semibold text-gray-900">White Button</div>
                                <div class="text-sm text-gray-600">#ffffff → #f8f9fa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CSS Classes Reference -->
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">CSS Classes Reference</h2>
            
            <div class="bg-gray-900 rounded-2xl p-8 overflow-x-auto">
                <pre class="text-green-400 text-sm"><code>/* Base button class - includes shape and common styles */
.btn-base

/* Button type classes */
.btn-gradient          /* Blue gradient button */
.btn-gradient-dark     /* Dark gradient button */
.btn-white            /* White button */

/* Legacy compatibility classes */
.btn-primary          /* Maps to .btn-gradient */
.btn-secondary        /* Maps to .btn-gradient-dark */
.btn-outline          /* Maps to .btn-white */

/* Usage examples */
&lt;button class="btn-gradient"&gt;EXPLORE PRODUCTS&lt;/button&gt;
&lt;a href="#" class="btn-gradient-dark"&gt;SEE MORE&lt;/a&gt;
&lt;button class="btn-white"&gt;LEARN MORE&lt;/button&gt;</code></pre>
            </div>
        </div>
        
        <!-- Back to Home -->
        <div class="text-center mt-16">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-gradient">
                BACK TO HOME
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
