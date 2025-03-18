<!-- Modern Navigation Bar with Tailwind CSS -->
<nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and primary nav -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-white text-xl font-bold">Hairsalon</a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" onclick="toggleMobileMenu()" class="text-white hover:text-gray-200 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="/admin" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Admin Panel</a>
                    <a href="/profile" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                    <a href="/profile" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/appointments" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Appointments</a>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php elseif (!empty($_SESSION['user_id'])): ?>
                    <a href="/profile" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/appointments/calendar" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Appointments</a>
                    <a href="/hairdressers" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">View Hairdressers</a>
                    <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php else: ?>
                    <a href="/login" class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Login</a>
                    <a href="/register" class="text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium border border-white transition-colors duration-200">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="/admin" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">Admin Panel</a>
                <a href="/profile" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/logout" class="bg-red-500 hover:bg-red-600 block text-white px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                <a href="/profile" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/appointments" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">My Appointments</a>
                <a href="/logout" class="bg-red-500 hover:bg-red-600 block text-white px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php elseif (!empty($_SESSION['user_id'])): ?>
                <a href="/profile" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/appointments/calendar" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">Appointments</a>
                <a href="/hairdressers" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium">View Hairdressers</a>
                <a href="/logout" class="bg-red-500 hover:bg-red-600 block text-white px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php else: ?>
                <a href="/login" class="bg-white text-blue-600 hover:bg-gray-100 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                <a href="/register" class="text-white hover:bg-blue-700 block px-3 py-2 rounded-md text-base font-medium border border-white">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
        // Add slide down animation
        mobileMenu.style.maxHeight = '0px';
        mobileMenu.style.transition = 'max-height 0.3s ease-in-out';
        requestAnimationFrame(() => {
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
        });
    } else {
        // Add slide up animation
        mobileMenu.style.maxHeight = '0px';
        mobileMenu.addEventListener('transitionend', function handler() {
            mobileMenu.classList.add('hidden');
            mobileMenu.style.maxHeight = null;
            mobileMenu.removeEventListener('transitionend', handler);
        });
    }
}
</script>