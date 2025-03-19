<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Add New Hairdresser</h1>

    <form action="/hairdressers/create" method="POST" class="max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50">
        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="name">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- PASSWORD -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- PHONE NUMBER -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="phone_number">Phone Number</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <!-- ADDRESS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="address">Address</label>
            <input 
                type="text" 
                name="address" 
                id="address" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <!-- PROFILE PICTURE -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="profile_picture">Profile Picture</label>
            <input 
                type="text" 
                name="profile_picture" 
                id="profile_picture" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                placeholder="e.g. hairdresser1.png"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <!-- SPECIALIZATION -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="specialization">Specialization</label>
            <input 
                type="text" 
                name="specialization" 
                id="specialization"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Create Hairdresser
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>