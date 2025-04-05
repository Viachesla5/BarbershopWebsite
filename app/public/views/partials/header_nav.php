<!-- Modern Navigation Bar with Dark Theme -->
<nav class="bg-dark-100 border-b border-dark-300 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and primary nav -->
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-white text-xl font-bold flex items-center space-x-2">
                        <img src="/assets/images/barbershop_logo.png" alt="Barbershop Logo" class="h-16 w-auto">
                        <span>Hairsalon</span>
                    </a>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" onclick="toggleMobileMenu()" class="text-gray-300 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="/admin" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Admin Panel</a>
                    <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                    <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/appointments" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">Appointments</a>
                    <a href="/hairdressers" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">View Hairdressers</a>
                    <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php elseif (!empty($_SESSION['user_id'])): ?>
                    <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Profile</a>
                    <a href="/appointments/calendar" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">My Appointments</a>
                    <a href="/hairdressers" class="text-gray-300 hover:text-white hover:bg-dark-300 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">View Hairdressers</a>
                    <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                <?php else: ?>
                    <a href="/login" class="bg-dark-accent hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Login</a>
                    <a href="/register" class="text-gray-300 hover:text-white border border-gray-500 hover:border-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobileMenu" class="hidden sm:hidden bg-dark-100 border-t border-dark-300">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="/admin" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">Admin Panel</a>
                <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white block px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php elseif (!empty($_SESSION['hairdresser_id'])): ?>
                <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/appointments" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">Appointments</a>
                <a href="/hairdressers" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">Hairdressers</a>
                <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white block px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php elseif (!empty($_SESSION['user_id'])): ?>
                <a href="/profile" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">My Profile</a>
                <a href="/appointments/calendar" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">Appointments</a>
                <a href="/hairdressers" class="text-gray-300 hover:text-white hover:bg-dark-300 block px-3 py-2 rounded-md text-base font-medium">View Hairdressers</a>
                <a href="/logout" class="bg-red-600 hover:bg-red-700 text-white block px-3 py-2 rounded-md text-base font-medium">Logout</a>
            <?php else: ?>
                <a href="/login" class="bg-dark-accent hover:bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium">Login</a>
                <a href="/register" class="text-gray-300 hover:text-white border border-gray-500 hover:border-white block px-3 py-2 rounded-md text-base font-medium">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('hidden');
}
</script>