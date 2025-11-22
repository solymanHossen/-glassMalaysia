<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50 flex items-center justify-center px-4">
    <div class="text-center max-w-xl mx-auto">
        <h1 class="font-serif text-9xl font-bold text-blue-100 mb-4">404</h1>
        <h2 class="font-serif text-4xl font-bold text-gray-900 mb-6">Page Not Found</h2>
        <p class="text-xl text-gray-600 mb-8">
            Oops! The page you are looking for might have been removed or is temporarily unavailable.
        </p>
        <a href="<?php echo home_url('/'); ?>" class="px-8 py-4 text-lg font-semibold smooth-transition rounded-full inline-flex items-center justify-center gap-2 bg-blue-500 text-white hover:bg-blue-600 hover:shadow-lg">
            <i data-lucide="arrow-left" class="w-5 h-5"></i> Back to Home
        </a>
    </div>
</main>

<?php get_footer(); ?>
