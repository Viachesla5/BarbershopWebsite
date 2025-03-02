<?php require(__DIR__ . "/../partials/header.php"); ?>

<!-- Hero Section -->
<div class="relative bg-gray-900 text-white">
  <div class="container mx-auto px-4 py-20 text-center">
    <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to Our Barbershop</h1>
    <p class="text-gray-300 max-w-2xl mx-auto mb-8">
      Experience top-notch styling in a modern, comfortable setting.
      Our expert barbers are here to help you look and feel your best.
    </p>
    <a 
      href="/appointments/calendar" 
      class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full text-lg font-semibold transition-all">
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
          A timeless look for every gentleman. Whether you want a trim or a full restyle, we’ve got you covered.
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

    <!-- Example dynamic content: Loop over hairdressers -->
    <!-- For demonstration, we'll hardcode 3 placeholders -->
    <?php 
      // If you have real data, something like:
      // $hairdressers = [
      //   ['name' => 'John Doe', 'specialization' => 'Classic Cuts'],
      //   ['name' => 'Jane Smith', 'specialization' => 'Beard Grooming'],
      //   ['name' => 'Mike Taylor', 'specialization' => 'Modern Styles'],
      // ];
    ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Barber Card 1 -->
      <div class="bg-gray-800 p-6 rounded shadow hover:shadow-xl transition-shadow text-center">
        <img 
          src="https://images.unsplash.com/photo-1514997138229-2f6a6d523932?ixlib=rb-4.0.3&q=80&w=400&h=400&fit=crop&crop=faces" 
          alt="John Doe" 
          class="mx-auto rounded-full w-32 h-32 object-cover mb-4"
        >
        <h3 class="text-xl font-semibold">John Doe</h3>
        <p class="text-blue-400">Classic Cuts</p>
      </div>

      <!-- Barber Card 2 -->
      <div class="bg-gray-800 p-6 rounded shadow hover:shadow-xl transition-shadow text-center">
        <img 
          src="https://images.unsplash.com/photo-1625948599483-a093f2a87f65?ixlib=rb-4.0.3&q=80&w=400&h=400&fit=crop&crop=faces" 
          alt="Jane Smith" 
          class="mx-auto rounded-full w-32 h-32 object-cover mb-4"
        >
        <h3 class="text-xl font-semibold">Jane Smith</h3>
        <p class="text-blue-400">Beard Grooming</p>
      </div>

      <!-- Barber Card 3 -->
      <div class="bg-gray-800 p-6 rounded shadow hover:shadow-xl transition-shadow text-center">
        <img 
          src="https://images.unsplash.com/photo-1573497019600-55413be09151?ixlib=rb-4.0.3&q=80&w=400&h=400&fit=crop&crop=faces" 
          alt="Mike Taylor" 
          class="mx-auto rounded-full w-32 h-32 object-cover mb-4"
        >
        <h3 class="text-xl font-semibold">Mike Taylor</h3>
        <p class="text-blue-400">Modern Styles</p>
      </div>
    </div>
  </div>
</div>

<!-- Footer text or CTA -->
<div class="bg-gray-800 text-gray-200 py-8 text-center">
  <p class="mb-2">Ready for a new look?</p>
  <a 
    href="/appointments/calendar" 
    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full text-lg font-semibold transition-all">
    Book Now
  </a>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>