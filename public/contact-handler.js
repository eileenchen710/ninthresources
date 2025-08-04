// Contact form handler with multiple fallback options
class ContactFormHandler {
    constructor() {
        this.form = document.getElementById('contact-form');
        this.messageDiv = document.getElementById('form-message');
        this.submitBtn = this.form.querySelector('button[type="submit"]');
        this.recipientEmail = 'admin@ninthresources.com.au';
        this.fallbackEmail = 'admin@ninthresources.com.au';
        
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        // Get form data
        const formData = this.getFormData();
        
        // Validate
        const errors = this.validateForm(formData);
        if (errors.length > 0) {
            this.showMessage(errors.join('<br>'), 'error');
            return;
        }

        // Show loading state
        this.setLoadingState(true);

        // Try different methods in order
        try {
            // Method 1: Try PHP handler
            await this.tryPHPHandler(formData);
        } catch (error) {
            console.log('PHP handler failed, trying alternatives...', error);
            
            try {
                // Method 2: Try mailto (opens email client)
                this.tryMailtoFallback(formData);
            } catch (error2) {
                console.log('Mailto failed, showing manual contact info...', error2);
                
                // Method 3: Show contact information
                this.showContactFallback(formData);
            }
        }
        
        this.setLoadingState(false);
    }

    getFormData() {
        return {
            name: this.form.querySelector('input[name="username"]').value.trim(),
            email: this.form.querySelector('input[name="email"]').value.trim(),
            phone: this.form.querySelector('input[name="phone"]').value.trim(),
            subject: this.form.querySelector('input[name="subject"]').value.trim(),
            message: this.form.querySelector('textarea[name="message"]').value.trim()
        };
    }

    validateForm(formData) {
        const errors = [];
        
        if (!formData.name) errors.push('Name is required');
        if (!formData.email) errors.push('Email is required');
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            errors.push('Please enter a valid email address');
        }
        if (!formData.phone) errors.push('Phone number is required');
        if (!formData.subject) errors.push('Subject is required');
        if (!formData.message) errors.push('Message is required');
        
        return errors;
    }

    async tryPHPHandler(formData) {
        const response = await fetch('sendemail-simple.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                ...formData,
                username: formData.name,
                'submit-form': '1'
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }

        const result = await response.json();
        
        if (result.success) {
            this.showMessage(result.message, 'success');
            this.form.reset();
        } else {
            throw new Error(result.message || 'Unknown error');
        }
    }

    tryMailtoFallback(formData) {
        const subject = encodeURIComponent(`Contact Form: ${formData.subject}`);
        const body = encodeURIComponent(
            `Hello,\n\nI'm sending this message from the 9th Resources website contact form.\n\n` +
            `Name: ${formData.name}\n` +
            `Email: ${formData.email}\n` +
            `Phone: ${formData.phone}\n` +
            `Subject: ${formData.subject}\n\n` +
            `Message:\n${formData.message}\n\n` +
            `Please get back to me at your earliest convenience.\n\n` +
            `Best regards,\n${formData.name}`
        );

        const mailtoUrl = `mailto:${this.recipientEmail}?subject=${subject}&body=${body}`;
        
        // Try to open email client
        const link = document.createElement('a');
        link.href = mailtoUrl;
        link.click();

        this.showMessage(
            `Since our contact form isn't working right now, we've opened your email client with a pre-filled message. Please send it, or copy the details and email us directly at <a href="mailto:${this.recipientEmail}">${this.recipientEmail}</a>.`,
            'success'
        );
        
        // Clear form after showing message
        setTimeout(() => {
            this.form.reset();
        }, 1000);
    }

    showContactFallback(formData) {
        const contactInfo = `
            <strong>Thank you for your interest!</strong><br><br>
            Our contact form is currently experiencing technical difficulties. Please reach out to us directly:<br><br>
            📧 <strong>Email:</strong> <a href="mailto:${this.recipientEmail}">${this.recipientEmail}</a><br>
            📞 <strong>Phone:</strong> <a href="tel:0296302967">(02) 9630 2967</a><br>
            📍 <strong>Address:</strong> 164 Great Western Hwy, Westmead NSW 2145<br><br>
            <strong>Your message details:</strong><br>
            Name: ${formData.name}<br>
            Email: ${formData.email}<br>
            Phone: ${formData.phone}<br>
            Subject: ${formData.subject}<br>
            Message: ${formData.message}<br><br>
            We'll get back to you as soon as possible!
        `;

        this.showMessage(contactInfo, 'info');
    }

    showMessage(message, type) {
        const colors = {
            success: { bg: '#d4edda', color: '#155724', border: '#c3e6cb' },
            error: { bg: '#f8d7da', color: '#721c24', border: '#f5c6cb' },
            info: { bg: '#d1ecf1', color: '#0c5460', border: '#bee5eb' }
        };

        const style = colors[type] || colors.info;
        
        this.messageDiv.style.backgroundColor = style.bg;
        this.messageDiv.style.color = style.color;
        this.messageDiv.style.border = `1px solid ${style.border}`;
        this.messageDiv.innerHTML = message;
        this.messageDiv.style.display = 'block';

        // Scroll to message
        this.messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        // Auto-hide success messages after 8 seconds
        if (type === 'success') {
            setTimeout(() => {
                this.messageDiv.style.display = 'none';
            }, 8000);
        }
    }

    setLoadingState(loading) {
        this.submitBtn.disabled = loading;
        const span = this.submitBtn.querySelector('span');
        
        if (loading) {
            this.originalText = span.textContent;
            span.textContent = 'Sending...';
        } else {
            span.textContent = this.originalText || 'send a message';
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ContactFormHandler();
});

// Also handle URL parameters for non-AJAX fallbacks
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');
    
    if (status && message) {
        const handler = new ContactFormHandler();
        handler.showMessage(decodeURIComponent(message), status);
        
        // Clean URL
        if (history.replaceState) {
            history.replaceState({}, document.title, window.location.pathname);
        }
    }
});