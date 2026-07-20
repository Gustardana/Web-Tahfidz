<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Manajemen Rumah TahfidzQu' ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (via CDN for Rapid Development) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#10B981', // Emerald 500
                        primaryDark: '#047857', // Emerald 700
                    }
                }
            }
        }
    </script>
    <!-- Alpine JS for interactivity (Sidebar Toggle, Modal, Toast) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- Global Notification Component -->
    <?= view('components/toast_alert') ?>

    <!-- Sidebar Component -->
    <?= view('components/sidebar') ?>

    <!-- Main Wrapper (pushed right on desktop) -->
    <div class="flex flex-col min-h-screen transition-all duration-300 lg:ml-64">
        
        <!-- Navbar Component -->
        <?= view('components/navbar') ?>

        <!-- Main Content Area -->
        <main class="flex-grow p-4 md:p-6 lg:p-8 w-full max-w-7xl mx-auto">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Footer Component -->
        <?= view('components/footer') ?>
    </div>

</body>
</html>
