<?php
/**
 * Hero Section Template Part
 * Can be customized per page using parameters
 */

$title = isset($args['title']) ? $args['title'] : get_the_title();
$subtitle = isset($args['subtitle']) ? $args['subtitle'] : '';
$show_breadcrumb = isset($args['breadcrumb']) ? $args['breadcrumb'] : true;
?>

<section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-20 right-10 w-96 h-96 bg-blue-400 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10">
        <?php if ($show_breadcrumb) : ?>
            <nav class="mb-8 text-sm">
                <ol class="flex items-center gap-2 text-gray-600">
                    <li><a href="<?php echo home_url('/'); ?>" class="hover:text-blue-600 smooth-transition">Home</a></li>
                    <li><i data-lucide="chevron-right" class="w-4 h-4"></i></li>
                    <li class="text-gray-900 font-medium"><?php echo esc_html($title); ?></li>
                </ol>
            </nav>
        <?php endif; ?>

        <div class="text-center">
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-6 animate-fade-in">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($subtitle) : ?>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto animate-fade-in" style="animation-delay: 0.2s;">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>
