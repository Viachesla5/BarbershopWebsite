<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Add New Hairdresser</h1>

    <form action="/hairdressers/create" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="w-full border border-gray-300 rounded px-3 py-2" 
                required
            >
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="name">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="w-full border border-gray-300 rounded px-3 py-2" 
                required
            >
        </div>

        <!-- PASSWORD -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full border border-gray-300 rounded px-3 py-2" 
                required
            >
        </div>

        <!-- PHONE NUMBER -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- ADDRESS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="address">Address</label>
            <input 
                type="text" 
                name="address" 
                id="address" 
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- PROFILE PICTURE (if handling uploads, you'll need ENCTYPE="multipart/form-data" and a file input) -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profile_picture">Profile Picture (optional)</label>
            <input 
                type="text" 
                name="profile_picture" 
                id="profile_picture" 
                class="w-full border border-gray-300 rounded px-3 py-2"
                placeholder="e.g. hairdresser1.png"
            >
        </div>

        <!-- SPECIALIZATION -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="specialization">Specialization</label>
            <input 
                type="text" 
                name="specialization" 
                id="specialization"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Create
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>