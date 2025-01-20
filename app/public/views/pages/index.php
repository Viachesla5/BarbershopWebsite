<?php require(__DIR__ . "/../partials/header.php"); ?>

<!-- Hero Section with Background Image -->
<div class="relative w-full h-[500px]">
    <!-- Background image -->
    <img 
        src="https://images.unsplash.com/photo-1737157998574-2a75f0c52a09?q=80&w=1924&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
        alt="Hair Salon Background" 
        class="absolute inset-0 w-full h-full object-cover"
    >

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    <!-- Hero text -->
    <div class="relative z-10 flex items-center justify-center h-full text-center">
        <div class="text-white">
            <h1 class="text-5xl font-bold mb-4">Welcome to Our Hair Salon</h1>
            <p class="text-xl">
                Where style meets comfort. Let our experts transform your look.
            </p>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-4">About Our Salon</h2>
    <p class="text-gray-700 leading-relaxed mb-6">
        Discover the best hair treatments and styling in town. Our professional
        staff is trained in the latest trends and techniques to give you a 
        personalized experience. Whether you're looking for a simple trim or 
        a bold new look, we've got you covered!
    </p>

    <div class="flex flex-col md:flex-row items-center md:space-x-4">
        <div class="md:w-1/2 mb-4 md:mb-0">
            <h3 class="text-xl font-semibold mb-2">Services We Offer</h3>
            <ul class="list-disc ml-5 text-gray-700">
                <li>Haircuts &amp; Trims</li>
                <li>Coloring &amp; Highlights</li>
                <li>Styling &amp; Updos</li>
                <li>Keratin &amp; Smoothing Treatments</li>
                <li>Special Occasion Makeovers</li>
            </ul>
        </div>
        <div class="md:w-1/2">
            <h3 class="text-xl font-semibold mb-2">Why Choose Us?</h3>
            <p class="text-gray-700">
                Our salon combines a warm, welcoming atmosphere with skilled 
                professionals who are passionate about making you look and feel your best.
            </p>
        </div>
    </div>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>