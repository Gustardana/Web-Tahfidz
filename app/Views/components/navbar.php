<header class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        
        <!-- Mobile Sidebar Toggle -->
        <div class="flex items-center lg:hidden">
            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary/50 rounded-md p-1 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <span class="ml-3 text-lg font-bold text-gray-800 tracking-tight">TahfidzQu</span>
        </div>

        <!-- Desktop Title/Breadcrumb -->
        <div class="hidden lg:flex items-center text-sm text-gray-500">
            <span class="hover:text-primary cursor-pointer transition-colors">Dashboard</span>
            <span class="mx-2 text-gray-300">/</span>
            <span class="font-medium text-gray-800"><?= $title ?? 'Overview' ?></span>
        </div>

        <!-- User Profile Dropdown -->
        <div class="flex items-center ml-auto">
            <div class="relative" x-data="{ userMenu: false }">
                <button @click="userMenu = !userMenu" @click.away="userMenu = false" class="flex items-center focus:outline-none group">
                    <?php if(session()->get('foto_profil') && file_exists(FCPATH . 'uploads/profile/' . session()->get('foto_profil'))): ?>
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-primary/20 group-hover:border-primary transition-colors" src="<?= base_url('uploads/profile/' . session()->get('foto_profil')) ?>" alt="User avatar">
                    <?php else: ?>
                        <img class="w-9 h-9 rounded-full object-cover border-2 border-primary/20 group-hover:border-primary transition-colors" src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama_lengkap') ?? 'Admin') ?>&background=10B981&color=fff" alt="User avatar">
                    <?php endif; ?>
                    <div class="hidden sm:flex flex-col items-start ml-3">
                        <span class="text-sm font-semibold text-gray-700 leading-tight"><?= esc(session()->get('nama_lengkap') ?? 'Admin Pusat') ?></span>
                        <span class="text-xs text-gray-500 capitalize"><?= esc(session()->get('role') ?? 'Administrator') ?></span>
                    </div>
                    <svg class="w-4 h-4 ml-2 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div x-show="userMenu" 
                     style="display: none;"
                     x-transition:enter="transition ease-out duration-100" 
                     x-transition:enter-start="transform opacity-0 scale-95" 
                     x-transition:enter-end="transform opacity-100 scale-100" 
                     x-transition:leave="transition ease-in duration-75" 
                     x-transition:leave-start="transform opacity-100 scale-100" 
                     x-transition:leave-end="transform opacity-0 scale-95" 
                     class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-lg py-2 ring-1 ring-black ring-opacity-5 focus:outline-none">
                    
                    <div class="px-4 py-2 border-b border-gray-50 sm:hidden">
                        <p class="text-sm font-semibold text-gray-800">Admin Pusat</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>

                    <a href="<?= base_url('profile') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-primary transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Saya
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-primary transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <a href="<?= base_url('logout') ?>" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
