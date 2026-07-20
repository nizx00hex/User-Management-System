// Confirm delete action
document.querySelectorAll('.btn-danger[href*="delete.php"]').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 500);
    });
}, 5000);

// Form validation
document.querySelectorAll('.user-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const password = this.querySelector('input[name="password"]');
        const email = this.querySelector('input[name="email"]');
        const username = this.querySelector('input[name="username"]');
        
        // Validate email
        if (email && email.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                alert('Please enter a valid email address');
                e.preventDefault();
                return false;
            }
        }
        
        // Validate username (alphanumeric and underscore only)
        if (username && username.value) {
            const usernameRegex = /^[a-zA-Z0-9_]{3,50}$/;
            if (!usernameRegex.test(username.value)) {
                alert('Username must be 3-50 characters and contain only letters, numbers, and underscores');
                e.preventDefault();
                return false;
            }
        }
        
        // Validate password strength (if set)
        if (password && password.value && password.value.length > 0) {
            if (password.value.length < 8) {
                alert('Password must be at least 8 characters long');
                e.preventDefault();
                return false;
            }
        }
    });
});

// Search with enter key
document.querySelector('.search-input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        this.closest('form').submit();
    }
});

// Status toggle confirmation
document.querySelectorAll('[href*="status.php"]').forEach(link => {
    link.addEventListener('click', function(e) {
        const isActive = this.textContent.trim() === 'Block';
        const confirmMsg = isActive ? 
            'Are you sure you want to block this user?' : 
            'Are you sure you want to activate this user?';
        if (!confirm(confirmMsg)) {
            e.preventDefault();
        }
    });
});