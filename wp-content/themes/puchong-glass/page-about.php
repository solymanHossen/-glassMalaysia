<?php
/**
 * Template Name: About Page
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <!-- Hero -->
    <section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-gray-900 mb-4">
                About Puchong Glass & Aluminium
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Over 15 years of excellence in craftsmanship, precision, and customer satisfaction.
            </p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="font-serif text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Founded in 2010, Puchong Glass & Aluminium started as a small family business with a passion for precision and quality craftsmanship. What began as a dream has evolved into one of Puchong's most trusted names in glass and aluminium solutions.
                </p>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Our journey has been marked by countless successful projects, from intimate residential renovations to massive commercial installations. Every project we undertake is a reflection of our commitment to excellence.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Today, we continue to innovate and improve, bringing the latest technologies and designs to our clients while maintaining the personal touch that made us special from day one.
                </p>
            </div>
            <div class="relative rounded-2xl overflow-hidden glass h-96">
                <img src="https://placehold.co/800x600?text=Our+Story" alt="Our workshop and team" class="w-full h-full object-cover" />
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <?php
                $stats = [
                    ['value' => '500+', 'label' => 'Projects Completed', 'icon' => 'award'],
                    ['value' => '15+', 'label' => 'Years in Business', 'icon' => 'zap'],
                    ['value' => '200+', 'label' => 'Happy Clients', 'icon' => 'users'],
                    ['value' => '100%', 'label' => 'Satisfaction Rate', 'icon' => 'check-circle'],
                ];
                foreach ($stats as $stat) : ?>
                    <div class="glass p-8 rounded-xl border border-blue-200 text-center">
                        <i data-lucide="<?php echo $stat['icon']; ?>" class="w-10 h-10 text-blue-500 mx-auto mb-3"></i>
                        <div class="text-4xl font-bold text-blue-600 mb-2"><?php echo $stat['value']; ?></div>
                        <p class="text-gray-600 text-sm"><?php echo $stat['label']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-16 text-center">Our Expert Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $team = [
                    ['name' => 'Ahmad Hassan', 'role' => 'Founder & Managing Director', 'specialty' => 'Overall Strategy & Client Relations'],
                    ['name' => 'Raj Kumar', 'role' => 'Technical Director', 'specialty' => 'Design & Engineering Solutions'],
                    ['name' => 'Chen Wei', 'role' => 'Operations Manager', 'specialty' => 'Project Management & Quality Control'],
                ];
                foreach ($team as $member) : ?>
                    <div class="glass p-6 rounded-xl border border-gray-200 text-center smooth-transition hover:shadow-lg">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 mx-auto mb-4"></div>
                        <h3 class="font-semibold text-lg text-gray-900 mb-1"><?php echo $member['name']; ?></h3>
                        <p class="text-sm text-blue-600 font-medium mb-2"><?php echo $member['role']; ?></h3>
                        <p class="text-sm text-gray-600"><?php echo $member['specialty']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-16 text-center">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $values = [
                    ['title' => 'Quality First', 'desc' => 'We never compromise on quality. Every material is premium grade, and every installation is perfect.'],
                    ['title' => 'Customer Focused', 'desc' => 'Your satisfaction is our success. We listen, understand, and deliver beyond expectations.'],
                    ['title' => 'Innovation', 'desc' => 'We stay ahead of industry trends, adopting new technologies and designs to serve you better.'],
                    ['title' => 'Integrity', 'desc' => 'Honest communication, fair pricing, and transparent processes define our relationships.'],
                ];
                foreach ($values as $value) : ?>
                    <div class="p-6 rounded-xl border border-gray-200 hover:border-blue-300 smooth-transition hover:shadow-lg">
                        <h3 class="font-semibold text-gray-900 mb-2 text-lg"><?php echo $value['title']; ?></h3>
                        <p class="text-gray-600 text-sm leading-relaxed"><?php echo $value['desc']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Certifications -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="font-serif text-4xl font-bold text-gray-900 mb-16 text-center">Certifications & Awards</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $certs = [
                    ['title' => 'ISO 9001:2015', 'desc' => 'Quality Management System Certification'],
                    ['title' => 'Safety Excellence', 'desc' => 'OSHA Workplace Safety Certification'],
                    ['title' => 'Industry Leader', 'desc' => 'Best Glass Solutions Provider 2023'],
                ];
                foreach ($certs as $cert) : ?>
                    <div class="glass p-8 rounded-xl border border-gray-200 text-center">
                        <i data-lucide="award" class="w-8 h-8 text-blue-500 mx-auto mb-3"></i>
                        <h3 class="font-semibold text-gray-900 mb-1"><?php echo $cert['title']; ?></h3>
                        <p class="text-sm text-gray-600"><?php echo $cert['desc']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
