<?php
function showToast($message, $type = 'success') {
    $bgColor = match($type) {
        'success' => 'bg-green-500',
        'error' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        default => 'bg-blue-500'
    };
    ?>
    <div id="toast" class="fixed top-4 right-4 z-50 <?= $bgColor ?> text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-y-0 opacity-100">
        <?= htmlspecialchars($message) ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast');
            if (toast) {
                setTimeout(() => {
                    toast.style.transform = 'translateY(-100%)';
                    toast.style.opacity = '0';
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            }
        });
    </script>
    <?php
}
?> 