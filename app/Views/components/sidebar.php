<!-- Mobile Overlay Backdrop -->
<div x-show="sidebarOpen" 
     style="display: none;"
     class="fixed inset-0 z-20 transition-opacity bg-gray-900/40 backdrop-blur-sm lg:hidden"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"></div>

<!-- Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col bg-white border-r border-gray-100 shadow-2xl lg:shadow-none transition-transform duration-300 ease-in-out lg:translate-x-0">
    
    <!-- Logo Area -->
    <div class="flex items-center justify-center h-16 border-b border-gray-50 px-6">
        <svg class="w-8 h-8 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        <span class="text-2xl font-bold tracking-tight text-gray-800">Tahfidz<span class="text-primary">Qu</span></span>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">
        <!-- Dashboard -->
        <a href="<?= base_url('dashboard') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-primary bg-emerald-50 transition-colors group">
            <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>

        <div class="pt-4 pb-2">
            <span class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akademik</span>
        </div>

        <!-- Data Santri -->
        <a href="<?= base_url('santri') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Data Santri
        </a>

        <!-- Halaqoh & Hafalan -->
        <a href="<?= base_url('mutabaah') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            Mutabaah Hafalan
        </a>

        <div class="pt-4 pb-2">
            <span class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administrasi</span>
        </div>

        <!-- Keuangan -->
        <a href="<?= base_url('keuangan') ?>" class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors group">
            <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Kas & Keuangan
        </a>
    </div>

    <!-- User Mini Profile at bottom (optional/extra wow) -->
    <div class="p-4 border-t border-gray-50 bg-gray-50/50">
        <div class="flex items-center px-2">
            <div class="flex-shrink-0">
                <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </span>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">Admin Pusat</p>
                <a href="<?= base_url('logout') ?>" class="text-xs font-medium text-gray-500 hover:text-red-500 transition-colors">Sign Out</a>
            </div>
        </div>
    </div>
</aside>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #e5e7eb;
        border-radius: 20px;
    }
</style>
