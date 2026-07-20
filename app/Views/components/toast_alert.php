<?php
// Mendapatkan flashdata session dari CI4
$session = session();
$success = $session->getFlashdata('success');
$error   = $session->getFlashdata('error');
$warning = $session->getFlashdata('warning');

if ($success || $error || $warning):
?>
<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 5000)"
     x-show="show"
     style="display: none;"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
     x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed bottom-4 right-4 z-[60] flex max-w-sm w-full bg-white shadow-2xl rounded-xl pointer-events-auto border border-gray-100 overflow-hidden">
    
    <!-- Accent line -->
    <div class="w-1 <?php 
        if ($success) echo 'bg-green-500';
        elseif ($error) echo 'bg-red-500';
        elseif ($warning) echo 'bg-yellow-500';
    ?>"></div>

    <div class="p-4 w-full flex items-start">
        <div class="flex-shrink-0">
            <?php if ($success): ?>
                <!-- Icon Success -->
                <div class="p-1 rounded-full bg-green-50">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            <?php elseif ($error): ?>
                <!-- Icon Error -->
                <div class="p-1 rounded-full bg-red-50">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            <?php elseif ($warning): ?>
                <!-- Icon Warning -->
                <div class="p-1 rounded-full bg-yellow-50">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="ml-3 w-0 flex-1 pt-0.5">
            <p class="text-sm font-semibold text-gray-900">
                <?php 
                    if ($success) echo 'Berhasil!';
                    if ($error) echo 'Terjadi Kesalahan!';
                    if ($warning) echo 'Perhatian!';
                ?>
            </p>
            <p class="mt-1 text-sm text-gray-500 leading-snug">
                <?= esc($success ?? $error ?? $warning) ?>
            </p>
        </div>
        
        <div class="ml-4 flex-shrink-0 flex">
            <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>
<?php endif; ?>
