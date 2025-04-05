<?php require(__DIR__ . "/../partials/header.php"); ?>

<!-- Hero Section -->
<div class="relative min-h-[600px] flex items-center justify-center">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img 
            src="/assets/images/barbershop.png" 
            alt="Barbershop Interior" 
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-gray-900/70"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 text-white drop-shadow-lg">
            Welcome to Our Barbershop
        </h1>
        <p class="text-xl text-gray-200 max-w-3xl mx-auto mb-4 drop-shadow-lg">
            Experience top-notch styling in a modern, comfortable setting.
            Our expert barbers are here to help you look and feel your best.
        </p>
        <p class="text-lg text-blue-300 font-semibold mb-10 drop-shadow-lg italic">
            Open 24/7* - Because bad hair doesn't take a break! 
            <span class="text-sm text-gray-300">*By appointment only</span>
        </p>
        <a 
            href="/appointments/calendar" 
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full text-xl font-semibold transition-all transform hover:scale-105 shadow-lg hover:shadow-xl">
            Book an Appointment
        </a>
    </div>
</div>

<!-- Services Section -->
<div class="bg-gray-800 text-gray-100 py-12">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold mb-6 text-center">Our Services</h2>
    <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
      <div class="md:w-1/3 bg-gray-700 p-6 rounded shadow hover:shadow-xl transition-shadow">
        <h3 class="text-xl font-semibold mb-2">Classic Cuts</h3>
        <p class="text-gray-300">
          A timeless look for every gentleman. Whether you want a trim or a full restyle, we've got you covered.
        </p>
      </div>
      <div class="md:w-1/3 bg-gray-700 p-6 rounded shadow hover:shadow-xl transition-shadow">
        <h3 class="text-xl font-semibold mb-2">Beard Grooming</h3>
        <p class="text-gray-300">
          Shape, trim, or sculpt your beard. Let our experts craft the perfect beard style to complement your look.
        </p>
      </div>
      <div class="md:w-1/3 bg-gray-700 p-6 rounded shadow hover:shadow-xl transition-shadow">
        <h3 class="text-xl font-semibold mb-2">Special Treatments</h3>
        <p class="text-gray-300">
          Indulge in keratin, scalp treatments, and other premium services for a luxurious experience.
        </p>
      </div>
    </div>
  </div>
</div>

<!-- Hairdressers / Barbers Section -->
<div class="bg-gray-900 text-gray-100 py-12">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold mb-6 text-center">Meet Our Barbers</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php foreach ($hairdressers as $hairdresser): ?>
        <div class="bg-gray-800 p-6 rounded shadow hover:shadow-xl transition-shadow text-center">
          <img 
            src="<?= htmlspecialchars($hairdresser['profile_picture'] ?? '/assets/images/default-profile.png'); ?>" 
            alt="<?= htmlspecialchars($hairdresser['name']); ?>" 
            class="mx-auto rounded-full w-32 h-32 object-cover mb-4"
          >
          <h3 class="text-xl font-semibold"><?= htmlspecialchars($hairdresser['name']); ?></h3>
          <p class="text-blue-400"><?= htmlspecialchars($hairdresser['specialization'] ?? 'General Styling'); ?></p>
          <a href="/hairdressers/<?= htmlspecialchars($hairdresser['id']); ?>" class="mt-4 inline-block text-blue-400 hover:text-blue-300">
            View Profile
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Footer text or CTA -->
<div class="bg-gray-800 text-gray-200 py-8 text-center">
  <p class="mb-2">Ready for a new look?</p>
  <a href="/appointments/calendar" class="text-blue-400 hover:text-blue-300">Book your appointment today!</a>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>