document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all delete buttons
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to delete this user?')) {
                return;
            }

            const userId = this.getAttribute('data-user-id');
            const userRow = this.closest('tr');

            fetch(`/api/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the user row from the table
                    userRow.remove();
                    
                    // Show success message
                    showMessage('User deleted successfully', 'success');
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred while deleting the user', 'error');
            });
        });
    });

    // Function to show messages
    function showMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        messageDiv.textContent = message;
        
        document.body.appendChild(messageDiv);
        
        // Remove message after 3 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }
}); 