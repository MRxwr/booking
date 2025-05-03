// Enhanced UI interactions for booking system
document.addEventListener('DOMContentLoaded', function() {
    // Apply animation classes when elements enter the viewport
    function animateOnScroll() {
        const elementsToAnimate = document.querySelectorAll('.serviceBLk, .successInfoSection, .form-group, .socialMediaBar, .themeInput');
        
        // Create observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                    observer.unobserve(entry.target); // Only animate once
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe each element
        elementsToAnimate.forEach(element => {
            observer.observe(element);
        });
    }

    // Add smooth hover effects to buttons and interactive elements
    function enhanceInteractions() {
        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mousedown', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Enhance service selection
        document.querySelectorAll('.serviceBLk').forEach(service => {
            service.addEventListener('click', function() {
                this.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.classList.remove('animate__animated', 'animate__pulse');
                }, 700);
            });
        });
    }

    // Support dark mode toggle if implemented
    function setupDarkModeSupport() {
        // Check if system prefers dark mode
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark-mode-support');
        }
        
        // Listen for changes in color scheme preference
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
            if (event.matches) {
                document.documentElement.classList.add('dark-mode-support');
            } else {
                document.documentElement.classList.remove('dark-mode-support');
            }
        });
    }

    // Focus states for improved accessibility
    function enhanceAccessibility() {
        // Focus styles for interactive elements
        const focusableElements = document.querySelectorAll('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
        
        focusableElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.style.outline = '2px solid var(--primary-color-light)';
                this.style.outlineOffset = '2px';
            });
            
            element.addEventListener('blur', function() {
                this.style.outline = 'none';
            });
        });
    }

    // Add staggered animation to the success/failure details
    function animateInfoSections() {
        const sections = document.querySelectorAll('.successInfoSection');
        
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, 100 * index); // Stagger effect
        });
    }

    // Handle mobile menu improvements
    function enhanceMobileExperience() {
        // Make sure mobile forms are better sized
        const isMobile = window.innerWidth < 768;
        
        if (isMobile) {
            // Improve touch targets for mobile
            document.querySelectorAll('.themeInput, .serviceBLk').forEach(element => {
                element.style.minHeight = '44px'; // Minimum recommended touch target size
            });
            
            // Smooth scroll to form on service selection
            document.querySelectorAll('.serviceBLk').forEach(service => {
                service.addEventListener('click', function() {
                    // Smooth scroll to the date/time area after selecting a service
                    const dateSection = document.querySelector('input[name="date"]');
                    if (dateSection) {
                        setTimeout(() => {
                            dateSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }
                });
            });
        }
    }

    // Run all enhancements
    animateOnScroll();
    enhanceInteractions();
    setupDarkModeSupport();
    enhanceAccessibility();
    
    // Run these after a slight delay to ensure elements are ready
    setTimeout(() => {
        animateInfoSections();
        enhanceMobileExperience();
    }, 100);

    // Re-run certain functions on resize
    window.addEventListener('resize', enhanceMobileExperience);
});