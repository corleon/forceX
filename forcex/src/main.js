import Alpine from 'alpinejs'
import './main.css'

// Initialize Alpine.js
window.Alpine = Alpine
Alpine.start()

// ForceX Theme JavaScript
console.log('ForceX JavaScript loaded!') // Debug log

// Test if forcex_ajax is available immediately
console.log('forcex_ajax available:', typeof forcex_ajax !== 'undefined')
if (typeof forcex_ajax !== 'undefined') {
    console.log('AJAX URL:', forcex_ajax.ajax_url)
    console.log('Nonce:', forcex_ajax.nonce)
}

// Notification/Toast System
function showNotification(message, type = 'success', duration = 3000) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.forcex-notification')
    if (existingNotification) {
        existingNotification.remove()
    }
    
    // Create notification element
    const notification = document.createElement('div')
    notification.className = `forcex-notification forcex-notification-${type}`
    
    // Create icon based on type
    let iconSvg = ''
    if (type === 'success') {
        iconSvg = `<svg class="forcex-notification-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.667 5L7.5 14.167 3.333 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`
    } else if (type === 'error') {
        iconSvg = `<svg class="forcex-notification-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`
    } else {
        iconSvg = `<svg class="forcex-notification-icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 6v4m0 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`
    }
    
    notification.innerHTML = `
        <div class="forcex-notification-content">
            <div class="forcex-notification-icon-wrapper">
                ${iconSvg}
            </div>
            <span class="forcex-notification-message">${message}</span>
            <button class="forcex-notification-close" aria-label="Close">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 4L4 12M4 4l8 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    `
    
    // Add to body
    document.body.appendChild(notification)
    
    // Trigger animation
    requestAnimationFrame(() => {
        notification.classList.add('forcex-notification-show')
    })
    
    // Close button handler
    const closeBtn = notification.querySelector('.forcex-notification-close')
    closeBtn.addEventListener('click', () => {
        hideNotification(notification)
    })
    
    // Auto hide after duration
    if (duration > 0) {
        setTimeout(() => {
            hideNotification(notification)
        }, duration)
    }
    
    return notification
}

function hideNotification(notification) {
    notification.classList.remove('forcex-notification-show')
    notification.classList.add('forcex-notification-hide')
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification)
        }
    }, 300)
}

// Make it globally available
window.showNotification = showNotification
window.hideNotification = hideNotification

// Initialize cart badge visibility based on current cart count
function initializeCartBadge() {
    const cartCount = document.getElementById('cart-count')
    console.log('Initializing cart badge:', cartCount) // Debug log
    
    if (cartCount) {
        const currentCount = parseInt(cartCount.textContent) || 0
        console.log('Current cart count:', currentCount) // Debug log
        
        // Show or hide badge based on current count
        if (currentCount > 0) {
            cartCount.style.display = 'flex'
            console.log('Showing cart badge on init') // Debug log
        } else {
            cartCount.style.display = 'none'
            console.log('Hiding cart badge on init') // Debug log
        }
    } else {
        console.error('Cart count element not found during initialization!')
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - ForceX theme initialized') // Debug log
    
    // Test again after DOM is loaded
    console.log('forcex_ajax available after DOM load:', typeof forcex_ajax !== 'undefined')
    if (typeof forcex_ajax !== 'undefined') {
        console.log('AJAX URL after DOM load:', forcex_ajax.ajax_url)
        console.log('Nonce after DOM load:', forcex_ajax.nonce)
    }
    
    // Initialize cart badge visibility
    initializeCartBadge()
    
    // Debug: Add a test button to verify JavaScript is working (remove in production)
    // const testButton = document.createElement('button')
    // testButton.textContent = 'Test JS'
    // testButton.style.cssText = 'position: fixed; top: 10px; right: 10px; z-index: 9999; background: red; color: white; padding: 10px;'
    // testButton.onclick = function() {
    //     alert('JavaScript is working! AJAX available: ' + (typeof forcex_ajax !== 'undefined'))
    // }
    // document.body.appendChild(testButton)
    
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle')
    const mobileMenu = document.getElementById('mobile-menu')
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden')
        })
    }
    
    // Desktop Navigation Dropdown Management
    function manageNavigationDropdown() {
        // Only run on desktop (md and up)
        if (window.innerWidth < 768) {
            return
        }
        
        const mainNavItems = document.getElementById('main-nav-items')
        const navMoreDropdown = document.getElementById('nav-more-dropdown')
        const navMoreItems = document.getElementById('nav-more-items')
        const navMoreToggle = document.getElementById('nav-more-toggle')
        const navMoreMenu = document.getElementById('nav-more-menu')
        const navItems = mainNavItems ? Array.from(mainNavItems.querySelectorAll('.nav-item')) : []
        
        if (!mainNavItems || !navMoreDropdown || !navMoreItems || navItems.length === 0) {
            return
        }
        
        // Get available space for navigation
        const header = document.getElementById('main-header')
        const container = header ? header.querySelector('.container-custom') : null
        const logo = header ? header.querySelector('.flex-shrink-0') : null
        const rightSide = header ? header.querySelector('.flex.items-center.space-x-1') : null
        
        if (!header || !container || !logo || !rightSide) {
            return
        }
        
        const containerWidth = container.offsetWidth
        const logoWidth = logo.offsetWidth
        const rightSideWidth = rightSide.offsetWidth
        const availableWidth = containerWidth - logoWidth - rightSideWidth - 100 // 100px buffer
        
        // Reset: move all items back to main nav
        navItems.forEach(item => {
            if (item.parentElement !== mainNavItems) {
                mainNavItems.appendChild(item)
            }
        })
        navMoreItems.innerHTML = ''
        navMoreDropdown.classList.add('hidden')
        
        // Check if items overflow - measure all items first
        const navItemsArray = Array.from(navItems)
        if (navItemsArray.length === 0) return
        
        // Calculate total width needed for all items
        let totalItemsWidth = 0
        navItemsArray.forEach((item, index) => {
            const itemWidth = item.offsetWidth || item.getBoundingClientRect().width
            totalItemsWidth += itemWidth + (index > 0 ? 32 : 0) // space-x-8 = 32px
        })
        
        // Check if all items fit
        if (totalItemsWidth <= availableWidth) {
            // All items fit, no dropdown needed
            return
        }
        
        // Items don't fit - calculate how many can fit
        const moreButtonWidth = 80 // Approximate width of "MORE" button
        const moreButtonSpace = moreButtonWidth + 32 // MORE button + spacing
        
        let currentWidth = 0
        let itemsThatFit = []
        let itemsToMove = []
        
        // Try to fit as many items as possible from left to right
        for (let i = 0; i < navItemsArray.length; i++) {
            const item = navItemsArray[i]
            const itemWidth = item.offsetWidth || item.getBoundingClientRect().width
            const spacing = i > 0 ? 32 : 0
            const neededWidth = currentWidth + itemWidth + spacing
            
            // Check if this item fits (accounting for MORE button if needed)
            if (neededWidth + moreButtonSpace <= availableWidth) {
                // Item fits, keep it visible
                itemsThatFit.push(item)
                currentWidth += itemWidth + spacing
            } else {
                // Item doesn't fit, move it and all following items to dropdown
                itemsToMove = navItemsArray.slice(i)
                break
            }
        }
        
        // Move overflow items to dropdown
        if (itemsToMove.length > 0) {
            navMoreDropdown.classList.remove('hidden')
            itemsToMove.forEach(item => {
                const link = item.cloneNode(true)
                link.classList.remove('nav-item')
                link.classList.add('nav-dropdown-item')
                navMoreItems.appendChild(link)
                item.remove()
            })
        }
    }
    
    // Toggle dropdown menu
    const navMoreToggleEl = document.getElementById('nav-more-toggle')
    const navMoreMenuEl = document.getElementById('nav-more-menu')
    const navMoreDropdownEl = document.getElementById('nav-more-dropdown')
    
    if (navMoreToggleEl && navMoreMenuEl && navMoreDropdownEl) {
        navMoreToggleEl.addEventListener('click', function(e) {
            e.stopPropagation()
            navMoreMenuEl.classList.toggle('hidden')
        })
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (navMoreDropdownEl && !navMoreDropdownEl.contains(e.target)) {
                navMoreMenuEl.classList.add('hidden')
            }
        })
    }
    
    // Run on load and resize
    if (window.innerWidth >= 768) {
        // Wait for fonts to load
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => {
                setTimeout(manageNavigationDropdown, 100)
            })
        } else {
            setTimeout(manageNavigationDropdown, 300)
        }
    }
    
    let resizeTimeout
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout)
        resizeTimeout = setTimeout(manageNavigationDropdown, 150)
    })
    
    // Header scroll detection for home page - white background after scroll
    const mainHeader = document.getElementById('main-header')
    if (mainHeader) {
        // Check if we're on the home page (front page)
        const isHomePage = document.body.classList.contains('home') ||
                          document.body.classList.contains('front-page') ||
                          window.location.pathname === '/' || 
                          window.location.pathname === '/index.php' ||
                          (window.location.pathname === '' && !window.location.search)
        
        if (isHomePage) {
            function handleScroll() {
                // Get scroll position
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop
                // Threshold for when to show white background (after scrolling a bit)
                const scrollThreshold = 100 // pixels scrolled
                
                // Add white background class when scrolled past threshold
                if (scrollTop > scrollThreshold) {
                    mainHeader.classList.add('header-scrolled-bottom')
                } else {
                    mainHeader.classList.remove('header-scrolled-bottom')
                }
            }
            
            // Listen to scroll events
            window.addEventListener('scroll', handleScroll, { passive: true })
            
            // Check on initial load
            handleScroll()
        }
    }
    
    // Mini cart toggle
    const miniCartToggle = document.getElementById('mini-cart-toggle')
    const miniCart = document.getElementById('mini-cart')
    const miniCartClose = document.getElementById('mini-cart-close')
    
    if (miniCartToggle && miniCart) {
        miniCartToggle.addEventListener('click', function(e) {
            // Only prevent default if we want to show mini cart instead of going to cart page
            // For now, let it go to cart page by default
            console.log('Cart icon clicked - going to cart page!') // Debug log
            // Uncomment the lines below if you want mini cart instead of direct navigation
            // e.preventDefault()
            // miniCart.classList.toggle('closed')
            // miniCart.classList.toggle('hidden')
        })
        
        // Close mini cart with close button
        if (miniCartClose) {
            miniCartClose.addEventListener('click', function(e) {
                e.preventDefault()
                console.log('Mini cart close clicked!') // Debug log
                miniCart.classList.add('closed')
                miniCart.classList.add('hidden')
            })
        }
        
        // Close mini cart when clicking outside
        document.addEventListener('click', function(event) {
            if (!miniCart.contains(event.target) && !miniCartToggle.contains(event.target)) {
                miniCart.classList.add('closed')
                miniCart.classList.add('hidden')
            }
        })
        
        // Close mini cart with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !miniCart.classList.contains('hidden')) {
                miniCart.classList.add('closed')
                miniCart.classList.add('hidden')
            }
        })
    } else {
        console.error('Mini cart elements not found!')
        console.log('miniCartToggle:', miniCartToggle)
        console.log('miniCart:', miniCart)
    }
    
    // Email gate modal
    const emailGateModal = document.getElementById('email-gate-modal')
    const emailGateForm = document.getElementById('email-gate-form')
    const goToCheckoutBtn = document.getElementById('go-to-checkout')
    
    // Helper to decide whether to show the email gate
    function shouldGateCheckout() {
        if (typeof forcex_ajax === 'undefined') return false
        // Skip gate if user is already logged in or session has passed the gate
        if (forcex_ajax.is_logged_in) return false
        if (forcex_ajax.email_gate_passed) return false
        return true
    }
    
    // Explicit button (if present)
    if (goToCheckoutBtn) {
        goToCheckoutBtn.addEventListener('click', function(e) {
            if (!shouldGateCheckout()) return
            e.preventDefault()
            if (emailGateModal) {
                emailGateModal.classList.remove('hidden')
                document.getElementById('email-gate-email').focus()
            }
        })
    }
    
    // Generic delegation: intercept checkout link from the Cart page
    document.addEventListener('click', function(e) {
        const checkoutLink = e.target.closest('a[href*="/checkout"]')
        if (!checkoutLink) return
        // Only gate on the cart page where the modal UX is expected
        const isCartPage = window.location.pathname.indexOf('/cart') !== -1
        if (!isCartPage) return
        if (!shouldGateCheckout()) return
        e.preventDefault()
        if (emailGateModal) {
            emailGateModal.classList.remove('hidden')
            document.getElementById('email-gate-email').focus()
        }
    })
    
    if (emailGateForm) {
        emailGateForm.addEventListener('submit', function(e) {
            e.preventDefault()
            
            const email = document.getElementById('email-gate-email').value
            const submitBtn = document.getElementById('email-gate-submit')
            
            if (!email) return
            
            submitBtn.disabled = true
            submitBtn.textContent = 'Processing...'
            
            fetch(forcex_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'forcex_email_gate',
                    email: email,
                    nonce: forcex_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    emailGateModal.classList.add('hidden')
                    const payload = data.data || {}
                    console.log('Email gate response:', payload) // Debug log
                    
                    if (payload.requires_login && payload.login_url) {
                        console.log('Redirecting to login:', payload.login_url)
                        window.location.href = payload.login_url
                    } else if (payload.requires_registration && payload.registration_url) {
                        console.log('Redirecting to registration:', payload.registration_url)
                        window.location.href = payload.registration_url
                    } else {
                        console.log('Redirecting to checkout:', payload.checkout_url)
                        window.location.href = payload.checkout_url || '/checkout/'
                    }
                } else {
                    alert(data.data || 'Please enter a valid email address')
                }
            })
            .catch(error => {
                console.error('Error:', error)
                alert('Something went wrong. Please try again.')
            })
            .finally(() => {
                submitBtn.disabled = false
                submitBtn.textContent = 'CONTINUE TO CHECKOUT'
            })
        })
    }
    
    // Checkout stepper
    const stepper = document.getElementById('checkout-stepper')
    console.log('Checkout stepper found:', stepper) // Debug log
    
    if (stepper) {
        const steps = stepper.querySelectorAll('.step')
        const stepContents = document.querySelectorAll('.step-content')
        console.log('Steps in stepper:', steps.length) // Debug log
        console.log('Step contents on page:', stepContents.length) // Debug log
        
        // Track completed steps
        let completedSteps = new Set()
        let currentStep = 1
        
        // Checkout data persistence
        const CHECKOUT_STORAGE_KEY = 'forcex_checkout_data'
        
        // Load saved data from localStorage
        function loadCheckoutData() {
            try {
                const savedData = localStorage.getItem(CHECKOUT_STORAGE_KEY)
                if (savedData) {
                    const data = JSON.parse(savedData)
                    
                    // Restore form values
                    Object.keys(data).forEach(fieldName => {
                        const field = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`)
                        if (field) {
                            if (field.type === 'radio') {
                                if (field.value === data[fieldName]) {
                                    field.checked = true
                                }
                            } else {
                                field.value = data[fieldName]
                            }
                        }
                    })
                    
                    // Restore completed steps
                    if (data.completedSteps) {
                        completedSteps = new Set(data.completedSteps)
                    }
                    
                    console.log('Checkout data restored from localStorage')
                }
            } catch (error) {
                console.error('Error loading checkout data:', error)
            }
        }
        
        // Save data to localStorage
        function saveCheckoutData() {
            try {
                const formData = new FormData(document.querySelector('form.checkout'))
                const data = {}
                
                // Collect all form data
                for (let [key, value] of formData.entries()) {
                    data[key] = value
                }
                
                // Add completed steps
                data.completedSteps = Array.from(completedSteps)
                
                localStorage.setItem(CHECKOUT_STORAGE_KEY, JSON.stringify(data))
                console.log('Checkout data saved to localStorage')
            } catch (error) {
                console.error('Error saving checkout data:', error)
            }
        }
        
        // Clear saved data
        function clearCheckoutData() {
            localStorage.removeItem(CHECKOUT_STORAGE_KEY)
            console.log('Checkout data cleared from localStorage')
        }
        
        // Auto-save form data as user types
        function setupAutoSave() {
            const form = document.querySelector('form.checkout')
            if (form) {
                form.addEventListener('input', function(e) {
                    if (e.target.matches('input, select, textarea')) {
                        saveCheckoutData()
                    }
                })
                
                form.addEventListener('change', function(e) {
                    if (e.target.matches('input, select, textarea')) {
                        saveCheckoutData()
                    }
                })
            }
        }
        
        // Load data on page load
        loadCheckoutData()
        setupAutoSave()
        
        // Field error handling functions
        function showFieldError(field, message) {
            field.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500')
            field.classList.remove('border-gray-300', 'focus:ring-primary-500', 'focus:border-primary-500')
            
            // Remove existing error message
            const existingError = field.parentNode.querySelector('.field-error')
            if (existingError) {
                existingError.remove()
            }
            
            // Add error message
            const errorDiv = document.createElement('div')
            errorDiv.className = 'field-error text-red-600 text-sm mt-1'
            errorDiv.textContent = message
            field.parentNode.appendChild(errorDiv)
        }
        
        function clearFieldError(field) {
            field.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500')
            field.classList.add('border-gray-300', 'focus:ring-primary-500', 'focus:border-primary-500')
            
            const existingError = field.parentNode.querySelector('.field-error')
            if (existingError) {
                existingError.remove()
            }
        }
        
        function clearFieldErrors() {
            document.querySelectorAll('.field-error').forEach(error => error.remove())
            document.querySelectorAll('input, select, textarea').forEach(field => {
                field.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500')
                field.classList.add('border-gray-300', 'focus:ring-primary-500', 'focus:border-primary-500')
            })
        }
        
        // Enhanced validation functions with better error handling
        function validateStep1() {
            const requiredFields = [
                { name: 'billing_first_name', label: 'First Name' },
                { name: 'billing_last_name', label: 'Last Name' },
                { name: 'billing_email', label: 'Email Address' },
                { name: 'billing_phone', label: 'Phone Number' }
            ]
            
            let isValid = true
            const errors = []
            
            // Clear previous error states
            clearFieldErrors()
            
            requiredFields.forEach(field => {
                const fieldElement = document.getElementById(field.name)
                if (!fieldElement || !fieldElement.value.trim()) {
                    isValid = false
                    errors.push(`${field.label} is required`)
                    if (fieldElement) {
                        showFieldError(fieldElement, `${field.label} is required`)
                    }
                } else {
                    if (fieldElement) {
                        clearFieldError(fieldElement)
                    }
                }
            })
            
            // Email format validation
            const emailField = document.getElementById('billing_email')
            if (emailField && emailField.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
                if (!emailRegex.test(emailField.value.trim())) {
                    isValid = false
                    errors.push('Please enter a valid email address')
                    showFieldError(emailField, 'Please enter a valid email address')
                }
            }
            
            // Phone format validation
            const phoneField = document.getElementById('billing_phone')
            if (phoneField && phoneField.value.trim()) {
                const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/
                if (!phoneRegex.test(phoneField.value.replace(/[\s\-\(\)]/g, ''))) {
                    isValid = false
                    errors.push('Please enter a valid phone number')
                    showFieldError(phoneField, 'Please enter a valid phone number')
                }
            }
            
            return { isValid, errors }
        }
        
        function validateStep2() {
            const requiredFields = [
                { name: 'billing_country', label: 'Country/Region' },
                { name: 'billing_state', label: 'State' },
                { name: 'billing_city', label: 'City' },
                { name: 'billing_postcode', label: 'Postal Code' },
                { name: 'billing_address_1', label: 'Address' }
            ]
            
            let isValid = true
            const errors = []
            
            // Clear previous error states
            clearFieldErrors()
            
            requiredFields.forEach(field => {
                const fieldElement = document.getElementById(field.name)
                if (!fieldElement || !fieldElement.value.trim()) {
                    isValid = false
                    errors.push(`${field.label} is required`)
                    if (fieldElement) {
                        showFieldError(fieldElement, `${field.label} is required`)
                    }
                } else {
                    if (fieldElement) {
                        clearFieldError(fieldElement)
                    }
                }
            })
            
            // Postal code format validation
            const postcodeField = document.getElementById('billing_postcode')
            if (postcodeField && postcodeField.value.trim()) {
                const postcodeRegex = /^[A-Za-z0-9\s-]{3,10}$/
                if (!postcodeRegex.test(postcodeField.value.trim())) {
                    isValid = false
                    errors.push('Please enter a valid postal code')
                    showFieldError(postcodeField, 'Please enter a valid postal code')
                }
            }
            
            // Check if shipping method is selected (if shipping is needed)
            const shippingMethods = document.querySelectorAll('input[name^="shipping_method"]:checked')
            const needsShipping = document.getElementById('shipping-methods-container')
            
            if (needsShipping && needsShipping.querySelector('.shipping_method') && shippingMethods.length === 0) {
                isValid = false
                errors.push('Please select a shipping method')
                
                // Highlight shipping options
                const shippingOptions = document.querySelectorAll('.shipping_method')
                shippingOptions.forEach(option => {
                    const label = option.closest('label')
                    if (label) {
                        label.classList.add('border-red-500', 'bg-red-50')
                    }
                })
            } else {
                // Clear shipping option errors
                const shippingOptions = document.querySelectorAll('.shipping_method')
                shippingOptions.forEach(option => {
                    const label = option.closest('label')
                    if (label) {
                        label.classList.remove('border-red-500', 'bg-red-50')
                    }
                })
            }
            
            return { isValid, errors }
        }
        
        function validateStep3() {
            // Clear previous error states
            clearFieldErrors()
            
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')
            if (!paymentMethod) {
                // Highlight payment options
                const paymentOptions = document.querySelectorAll('input[name="payment_method"]')
                paymentOptions.forEach(option => {
                    const label = option.closest('label')
                    if (label) {
                        label.classList.add('border-red-500', 'bg-red-50')
                    }
                })
                return { isValid: false, errors: ['Please select a payment method'] }
            } else {
                // Clear payment option errors
                const paymentOptions = document.querySelectorAll('input[name="payment_method"]')
                paymentOptions.forEach(option => {
                    const label = option.closest('label')
                    if (label) {
                        label.classList.remove('border-red-500', 'bg-red-50')
                    }
                })
            }
            return { isValid: true, errors: [] }
        }
        
        // Loading state management
        function showLoadingState(button, text = 'Processing...') {
            button.disabled = true
            button.dataset.originalText = button.textContent
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ${text}
            `
        }
        
        function hideLoadingState(button) {
            button.disabled = false
            button.textContent = button.dataset.originalText || 'Continue'
            delete button.dataset.originalText
        }
        
        // Success animation
        function showSuccessAnimation(stepNumber) {
            const stepElement = document.querySelector(`[data-step="${stepNumber}"]`)
            if (stepElement) {
                stepElement.classList.add('completed')
                
                // Add success checkmark animation
                const checkmark = document.createElement('div')
                checkmark.className = 'success-checkmark'
                checkmark.innerHTML = '✓'
                stepElement.appendChild(checkmark)
                
                // Remove checkmark after animation
                setTimeout(() => {
                    if (checkmark.parentNode) {
                        checkmark.remove()
                    }
                }, 2000)
            }
        }
        
        function showStep(stepNumber) {
            console.log('showStep called with:', stepNumber) // Debug log
            console.log('Steps found:', steps.length) // Debug log
            console.log('Step contents found:', stepContents.length) // Debug log
            
            // Check if user is trying to go to a step that hasn't been completed yet
            if (stepNumber > currentStep && !completedSteps.has(stepNumber - 1)) {
                console.log('Cannot proceed to step', stepNumber, 'without completing previous steps')
                return
            }
            
            // Add smooth transition effect
            const currentContent = document.querySelector(`#step-${currentStep}`)
            const newContent = document.querySelector(`#step-${stepNumber}`)
            
            if (currentContent && newContent && currentContent !== newContent) {
                currentContent.style.opacity = '0'
                currentContent.style.transform = 'translateX(-20px)'
                
                setTimeout(() => {
                    currentContent.classList.add('hidden')
                    newContent.classList.remove('hidden')
                    newContent.style.opacity = '0'
                    newContent.style.transform = 'translateX(20px)'
                    
                    setTimeout(() => {
                        newContent.style.opacity = '1'
                        newContent.style.transform = 'translateX(0)'
                    }, 50)
                }, 150)
            } else if (newContent) {
                newContent.classList.remove('hidden')
                newContent.style.opacity = '1'
                newContent.style.transform = 'translateX(0)'
            }
            
            steps.forEach((step, index) => {
                const stepNum = index + 1
                if (completedSteps.has(stepNum)) {
                    step.classList.add('completed')
                    step.classList.remove('active', 'locked')
                    step.setAttribute('aria-current', 'false')
                } else if (stepNum === stepNumber) {
                    step.classList.add('active')
                    step.classList.remove('completed', 'locked')
                    step.setAttribute('aria-current', 'true')
                } else if (stepNum > currentStep) {
                    step.classList.add('locked')
                    step.classList.remove('active', 'completed')
                    step.setAttribute('aria-current', 'false')
                } else {
                    step.classList.remove('active', 'completed', 'locked')
                    step.setAttribute('aria-current', 'false')
                }
            })
            
            stepContents.forEach((content, index) => {
                if (index + 1 === stepNumber) {
                    content.classList.remove('hidden')
                    content.setAttribute('aria-hidden', 'false')
                } else {
                    content.classList.add('hidden')
                    content.setAttribute('aria-hidden', 'true')
                }
            })
            
            currentStep = stepNumber
            try { localStorage.setItem('forcex_checkout_current_step', String(currentStep)) } catch (e) {}
            
            // Update step title
            const stepTitles = {
                1: 'Personal information',
                2: 'Delivery',
                3: 'Payment',
                4: 'Payment successful'
            }
            const stepTitleElement = document.getElementById('step-title')
            if (stepTitleElement && stepTitles[stepNumber]) {
                stepTitleElement.textContent = stepTitles[stepNumber]
                // Hide step title on step 4 since it's shown in the content
                if (stepNumber === 4) {
                    stepTitleElement.style.display = 'none'
                } else {
                    stepTitleElement.style.display = 'block'
                }
            }
            
            // Show/hide delivery cost in summary
            const deliveryCostRow = document.getElementById('delivery-cost-row')
            if (deliveryCostRow) {
                if (stepNumber >= 2) {
                    deliveryCostRow.classList.remove('hidden')
                } else {
                    deliveryCostRow.classList.add('hidden')
                }
            }
            
            // Hide summary section on step 4 (complete) and adjust layout
            const orderSummarySection = document.getElementById('order-summary-section')
            const checkoutFormColumn = document.getElementById('checkout-form-column')
            const gridContainer = orderSummarySection?.parentElement
            
            if (stepNumber === 4) {
                if (orderSummarySection) {
                    orderSummarySection.style.display = 'none'
                }
                if (checkoutFormColumn) {
                    checkoutFormColumn.style.border = 'none'
                }
                if (gridContainer) {
                    gridContainer.className = 'grid grid-cols-1'
                }
            } else {
                if (orderSummarySection) {
                    orderSummarySection.style.display = 'block'
                }
                if (checkoutFormColumn) {
                    checkoutFormColumn.style.border = '1px solid #D9E2E7'
                }
                if (gridContainer) {
                    gridContainer.className = 'grid grid-cols-1 lg:grid-cols-2 gap-8'
                }
            }
            
            // Focus management for accessibility
            const firstInput = newContent?.querySelector('input, select, textarea')
            if (firstInput) {
                setTimeout(() => firstInput.focus(), 200)
            }
        }
        
        function showValidationErrors(errors) {
            // Remove existing error messages
            document.querySelectorAll('.validation-error').forEach(error => error.remove())
            
            if (errors.length > 0) {
                // Create error message container
                const errorContainer = document.createElement('div')
                errorContainer.className = 'validation-error bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-4'
                
                const errorList = document.createElement('ul')
                errorList.className = 'list-disc list-inside space-y-1'
                
                errors.forEach(error => {
                    const errorItem = document.createElement('li')
                    errorItem.textContent = error
                    errorList.appendChild(errorItem)
                })
                
                errorContainer.appendChild(errorList)
                
                // Insert error message at the top of current step content
                const currentStepContent = document.querySelector(`#step-${currentStep}`)
                if (currentStepContent) {
                    currentStepContent.insertBefore(errorContainer, currentStepContent.firstChild)
                }
            }
        }
        
        // Initialize step: URL step param -> localStorage -> default to 1
        // Priority: order received page > URL parameter (from email gate) > localStorage > default step 1
        const CURRENT_STEP_KEY = 'forcex_checkout_current_step'
        const urlParams = new URLSearchParams(window.location.search)
        const paramStep = parseInt(urlParams.get('step'))
        const storedStep = parseInt(localStorage.getItem(CURRENT_STEP_KEY))
        let initialStep = 1
        
        // Check if we're on order received page (checkout page with order-received endpoint)
        const isOrderReceived = window.location.href.includes('order-received') || 
                                document.querySelector('input[name="order-received"]') ||
                                (typeof wc_checkout_params !== 'undefined' && wc_checkout_params.is_checkout && urlParams.has('order-received'))
        
        if (isOrderReceived) {
            // On order received page, show step 4 (complete)
            initialStep = 4
            completedSteps.add(1)
            completedSteps.add(2)
            completedSteps.add(3)
            completedSteps.add(4)
        } else if (Number.isInteger(paramStep) && paramStep >= 1 && paramStep <= 4) {
            // URL parameter has highest priority (set by email gate modal)
            initialStep = paramStep
        } else if (Number.isInteger(storedStep) && storedStep >= 1 && storedStep <= 4) {
            initialStep = storedStep
        }
        // Removed auto-step-2 for logged-in users - new users should start at step 1
        for (let s = 1; s < initialStep; s++) {
            completedSteps.add(s)
        }
        showStep(initialStep)
        
        // Step navigation buttons with enhanced feedback
        document.getElementById('next-step-1')?.addEventListener('click', function(e) {
            e.preventDefault()
            console.log('Next step 1 clicked!') // Debug log
            
            const validation = validateStep1()
            if (validation.isValid) {
                showLoadingState(this, 'Validating...')
                
                setTimeout(() => {
                    completedSteps.add(1)
                    showSuccessAnimation(1)
                    saveCheckoutData()
                    showStep(2)
                    hideLoadingState(this)
                }, 800)
            } else {
                showValidationErrors(validation.errors)
            }
        })
        
        document.getElementById('prev-step-2')?.addEventListener('click', function(e) {
            e.preventDefault()
            console.log('Prev step 2 clicked!') // Debug log
            showStep(1)
        })
        
        document.getElementById('next-step-2')?.addEventListener('click', function(e) {
            e.preventDefault()
            console.log('Next step 2 clicked!') // Debug log
            
            const validation = validateStep2()
            if (validation.isValid) {
                showLoadingState(this, 'Validating...')
                
                setTimeout(() => {
                    completedSteps.add(2)
                    showSuccessAnimation(2)
                    saveCheckoutData()
                    showStep(3)
                    hideLoadingState(this)
                }, 800)
            } else {
                showValidationErrors(validation.errors)
            }
        })
        
        document.getElementById('prev-step-3')?.addEventListener('click', function(e) {
            e.preventDefault()
            console.log('Prev step 3 clicked!') // Debug log
            showStep(2)
        })
        
        // Pay now button validation with enhanced feedback
        document.getElementById('pay-now')?.addEventListener('click', function(e) {
            console.log('Pay now clicked!') // Debug log
            
            const validation = validateStep3()
            if (!validation.isValid) {
                e.preventDefault()
                showValidationErrors(validation.errors)
                return false
            }
            
            // Get the checkout form
            const checkoutForm = document.querySelector('form.checkout')
            if (!checkoutForm) {
                console.error('Checkout form not found!')
                e.preventDefault()
                return false
            }
            
            // Check HTML5 validation
            if (!checkoutForm.checkValidity()) {
                console.log('Form validation failed - missing required fields')
                e.preventDefault()
                checkoutForm.reportValidity()
                return false
            }
            
            // Set flag to prevent summary updates during submission
            isSubmittingForm = true
            
            // Ensure all previous steps are marked as completed
            completedSteps.add(1)
            completedSteps.add(2)
            completedSteps.add(3)
            
            // Mark step 3 as completed
            showSuccessAnimation(3)
            saveCheckoutData()
            
            // Payment method is already saved to session when user selects it (via change event)
            // No need to save again here - WooCommerce will read it from the form data on submission
            // This prevents session conflicts and nonce expiration issues
            
            // Don't trigger update_checkout before submission - it can interfere with form submission
            // The form data will be processed correctly by WooCommerce on submit
            
            // Don't prevent default - allow form to submit naturally
            // The button is type="submit" so it will submit the form
            console.log('Form is valid, submitting...')
            
            // Update button text but DON'T disable it (disabling prevents form submission)
            const originalText = this.textContent
            this.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                PROCESSING PAYMENT...
            `
            
            // Form will submit naturally - WooCommerce handles order processing and redirect
            // The button stays enabled so the form can submit
        })
        
        // Handle form submission to ensure session is valid
        const checkoutForm = document.querySelector('form.checkout')
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                // Don't prevent default - allow normal form submission
                // But ensure payment method is in the form data
                const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked')
                if (!selectedPaymentMethod) {
                    // If no payment method selected, prevent submission
                    e.preventDefault()
                    alert('Please select a payment method')
                    return false
                }
                
                // Ensure payment method value is set
                if (!selectedPaymentMethod.value) {
                    e.preventDefault()
                    alert('Please select a valid payment method')
                    return false
                }
                
                // Set flag to prevent any AJAX updates during submission
                isSubmittingForm = true
                
                // Log for debugging
                console.log('Form submitting with payment method:', selectedPaymentMethod.value)
                
                // Allow form to submit normally
                return true
            })
        }
        
        // Step navigation with keyboard support
        stepper.addEventListener('click', function(e) {
            const step = e.target.closest('.step')
            if (step) {
                const stepNumber = parseInt(step.dataset.step)
                
                // Only allow navigation to completed steps or the next available step
                if (stepNumber <= currentStep || completedSteps.has(stepNumber - 1)) {
                    showStep(stepNumber)
                } else {
                    console.log('Cannot navigate to step', stepNumber, 'without completing previous steps')
                }
            }
        })
        
        // Keyboard navigation for checkout steps
        document.addEventListener('keydown', function(e) {
            if (stepper && stepper.closest('body')) {
                if (e.key === 'ArrowLeft' && currentStep > 1) {
                    e.preventDefault()
                    showStep(currentStep - 1)
                } else if (e.key === 'ArrowRight' && currentStep < 4) {
                    e.preventDefault()
                    const validation = currentStep === 1 ? validateStep1() : 
                                    currentStep === 2 ? validateStep2() : 
                                    currentStep === 3 ? validateStep3() : { isValid: true, errors: [] }
                    
                    if (validation.isValid) {
                        showStep(currentStep + 1)
                    } else {
                        showValidationErrors(validation.errors)
                    }
                }
            }
        })
        
        // Handle payment method selection
        const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]')
        paymentMethodInputs.forEach(input => {
            input.addEventListener('change', function() {
                const selectedGatewayId = this.value
                const paymentBoxes = document.querySelectorAll('.payment_box')
                
                // Hide all payment boxes
                paymentBoxes.forEach(box => {
                    box.style.display = 'none'
                })
                
                // Show payment box for selected gateway
                const selectedPaymentBox = document.querySelector('.payment_box.payment_method_' + selectedGatewayId)
                if (selectedPaymentBox) {
                    selectedPaymentBox.style.display = 'block'
                }
                
                // Save payment method to session immediately
                if (typeof forcex_ajax !== 'undefined') {
                    fetch(forcex_ajax.ajax_url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            action: 'forcex_update_payment_method',
                            payment_method: selectedGatewayId,
                            nonce: forcex_ajax.nonce
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Only trigger update_checkout after payment method is saved
                            // This ensures the session is updated before checkout refresh
                            if (typeof jQuery !== 'undefined') {
                                jQuery('body').trigger('update_checkout')
                            }
                        } else {
                            console.error('Failed to save payment method:', data)
                            // Still trigger update_checkout as fallback
                            if (typeof jQuery !== 'undefined') {
                                jQuery('body').trigger('update_checkout')
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Payment method update error:', error)
                        // Fallback: trigger update_checkout anyway
                        if (typeof jQuery !== 'undefined') {
                            jQuery('body').trigger('update_checkout')
                        }
                    })
                } else {
                    // Fallback if AJAX not available
                    if (typeof jQuery !== 'undefined') {
                        jQuery('body').trigger('update_checkout')
                    }
                }
            })
        })
        
        // Initialize payment fields visibility on page load
        const checkedPaymentMethod = document.querySelector('input[name="payment_method"]:checked')
        if (checkedPaymentMethod) {
            checkedPaymentMethod.dispatchEvent(new Event('change'))
        }
        
        // Handle shipping method selection with debouncing to prevent race conditions
        let shippingUpdateTimeout = null
        function setupShippingMethodListeners() {
            const shippingMethodInputs = document.querySelectorAll('.shipping_method')
            shippingMethodInputs.forEach(input => {
                // Remove existing event listener by cloning
                const newInput = input.cloneNode(true)
                input.parentNode.replaceChild(newInput, input)
                
                newInput.addEventListener('change', function() {
                    // Clear any pending updates
                    if (shippingUpdateTimeout) {
                        clearTimeout(shippingUpdateTimeout)
                    }
                    
                    // Save shipping method selection
                    const shippingMethod = this.value
                    const packageIndex = this.name.match(/\[(\d+)\]/) ? this.name.match(/\[(\d+)\]/)[1] : 0
                    
                    // Store the selection to prevent it from being reset
                    lastSelectedShippingMethod = shippingMethod
                    lastSelectedPackageIndex = packageIndex
                    
                    // Debounce the update to prevent race conditions
                    shippingUpdateTimeout = setTimeout(() => {
                        // Update via AJAX to save to session
                        if (typeof forcex_ajax !== 'undefined') {
                            fetch(forcex_ajax.ajax_url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: new URLSearchParams({
                                    action: 'forcex_update_shipping_selection',
                                    shipping_method: shippingMethod,
                                    package_index: packageIndex,
                                    nonce: forcex_ajax.nonce
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok')
                                }
                                return response.json()
                            })
                            .then(data => {
                                if (data.success && data.data) {
                                    // Update summary immediately with returned data
                                    updateSummaryFromData(data.data)
                                    
                                    // Verify the selection is still correct
                                    setTimeout(() => {
                                        const shippingInput = document.querySelector(`input[name="shipping_method[${packageIndex}]"][value="${shippingMethod}"]`)
                                        if (shippingInput && !shippingInput.checked) {
                                            shippingInput.checked = true
                                            // Force update again if it was reset
                                            updateSummaryFromData(data.data)
                                        }
                                    }, 100)
                                } else {
                                    console.error('Shipping update failed:', data)
                                }
                            })
                            .catch(error => {
                                console.error('Shipping method update error:', error)
                                // On error, still try to update via WooCommerce
                                if (typeof jQuery !== 'undefined') {
                                    jQuery('body').trigger('update_checkout')
                                }
                            })
                        } else {
                            // Fallback: just trigger update_checkout
                            if (typeof jQuery !== 'undefined') {
                                jQuery('body').trigger('update_checkout')
                            }
                        }
                    }, 150) // Small delay to prevent race conditions
                })
            })
        }
        
        // Setup shipping method listeners on page load
        setupShippingMethodListeners()
        
        // Re-setup listeners after shipping methods are updated via AJAX
        if (typeof jQuery !== 'undefined') {
            jQuery('body').on('updated_checkout', function() {
                setTimeout(() => {
                    setupShippingMethodListeners()
                }, 100)
            })
        }
        
        // Store the last selected shipping method to prevent reset
        let lastSelectedShippingMethod = null
        let lastSelectedPackageIndex = null
        let isSubmittingForm = false // Flag to prevent summary updates during form submission
        
        // Listen for WooCommerce checkout update to refresh summary
        if (typeof jQuery !== 'undefined') {
            jQuery('body').on('updated_checkout', function(event, data) {
                // Don't update summary if form is being submitted
                if (isSubmittingForm) {
                    console.log('Form submission in progress, skipping summary update')
                    return
                }
                
                // Restore shipping method selection if it was reset
                if (lastSelectedShippingMethod && lastSelectedPackageIndex !== null) {
                    setTimeout(() => {
                        const shippingInput = document.querySelector(`input[name="shipping_method[${lastSelectedPackageIndex}]"][value="${lastSelectedShippingMethod}"]`)
                        if (shippingInput) {
                            if (!shippingInput.checked) {
                                shippingInput.checked = true
                                // Trigger change event to save the selection
                                shippingInput.dispatchEvent(new Event('change', { bubbles: true }))
                            }
                            // Always update totals to ensure they're correct
                            updateCheckoutSummary()
                        }
                    }, 100)
                }
                
                // Update shipping cost in summary
                if (data && data.fragments) {
                    // Update shipping total if provided
                    if (data.fragments['.woocommerce-shipping-total']) {
                        const shippingElement = document.querySelector('.woocommerce-shipping-total')
                        if (shippingElement) {
                            shippingElement.innerHTML = data.fragments['.woocommerce-shipping-total']
                        }
                    }
                    
                    // Update order total if provided
                    if (data.fragments['.woocommerce-order-total']) {
                        const totalElement = document.querySelector('.woocommerce-order-total')
                        if (totalElement) {
                            totalElement.innerHTML = data.fragments['.woocommerce-order-total']
                        }
                    }
                    
                    // Update tax if provided
                    if (data.fragments['.woocommerce-tax-total']) {
                        const taxElement = document.querySelector('.woocommerce-tax-total')
                        if (taxElement) {
                            taxElement.innerHTML = data.fragments['.woocommerce-tax-total']
                        }
                    }
                }
                
                // Manually update totals from cart after a short delay
                setTimeout(() => {
                    if (!isSubmittingForm) {
                        updateCheckoutSummary()
                    }
                }, 200)
            })
        }
        
        // Function to update summary from data object
        function updateSummaryFromData(data) {
            // Update shipping cost
            const shippingElement = document.getElementById('delivery-cost')
            if (shippingElement && data.formatted_shipping_total) {
                shippingElement.innerHTML = data.formatted_shipping_total
            }
            
            // Update tax
            const taxElement = document.getElementById('tax-amount')
            if (taxElement && data.formatted_tax_total) {
                taxElement.innerHTML = data.formatted_tax_total
            }
            
            // Update total
            const totalElement = document.getElementById('checkout-total')
            if (totalElement && data.formatted_order_total) {
                totalElement.innerHTML = data.formatted_order_total
            }
        }
        
        // Function to update checkout summary totals
        function updateCheckoutSummary() {
            if (typeof forcex_ajax === 'undefined') {
                return
            }
            
            fetch(forcex_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'forcex_get_checkout_totals',
                    nonce: forcex_ajax.nonce
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    // Update shipping cost - use innerHTML to render HTML properly
                    const shippingElement = document.getElementById('delivery-cost')
                    if (shippingElement) {
                        const shippingTotal = data.data.formatted_shipping_total || data.data.shipping_total || '—'
                        shippingElement.innerHTML = shippingTotal
                    }
                    
                    // Update tax - use innerHTML to render HTML properly
                    const taxElement = document.getElementById('tax-amount')
                    if (taxElement) {
                        const taxTotal = data.data.formatted_tax_total || data.data.tax_total || '—'
                        taxElement.innerHTML = taxTotal
                    }
                    
                    // Update total - use innerHTML to render HTML properly
                    const totalElement = document.getElementById('checkout-total')
                    if (totalElement) {
                        const orderTotal = data.data.formatted_order_total || data.data.order_total || '—'
                        totalElement.innerHTML = orderTotal
                    }
                }
            })
            .catch(error => {
                console.log('Summary update error:', error)
            })
        }
        
        // Handle address field changes to update shipping methods via WooCommerce's update_checkout
        // But preserve the selected shipping method
        const addressFields = ['billing_country', 'billing_state', 'billing_postcode', 'billing_city', 'billing_address_1']
        addressFields.forEach(fieldName => {
            const field = document.getElementById(fieldName)
            if (field) {
                field.addEventListener('change', function() {
                    // Save current shipping method before triggering update
                    const currentShippingInput = document.querySelector('.shipping_method:checked')
                    if (currentShippingInput) {
                        lastSelectedShippingMethod = currentShippingInput.value
                        lastSelectedPackageIndex = currentShippingInput.name.match(/\[(\d+)\]/) ? currentShippingInput.name.match(/\[(\d+)\]/)[1] : 0
                    }
                    
                    // Use WooCommerce's built-in update_checkout to recalculate shipping
                    if (typeof jQuery !== 'undefined') {
                        jQuery('body').trigger('update_checkout')
                    }
                })
                field.addEventListener('blur', function() {
                    // Save current shipping method before triggering update
                    const currentShippingInput = document.querySelector('.shipping_method:checked')
                    if (currentShippingInput) {
                        lastSelectedShippingMethod = currentShippingInput.value
                        lastSelectedPackageIndex = currentShippingInput.name.match(/\[(\d+)\]/) ? currentShippingInput.name.match(/\[(\d+)\]/)[1] : 0
                    }
                    
                    // Also update on blur to catch manual typing
                    if (typeof jQuery !== 'undefined') {
                        jQuery('body').trigger('update_checkout')
                    }
                })
            }
        })
        
        // Listen for WooCommerce checkout update to refresh shipping methods display
        if (typeof jQuery !== 'undefined') {
            jQuery('body').on('updated_checkout', function() {
                // Shipping methods will be updated via WooCommerce's AJAX
                // The shipping-methods-wrapper will be refreshed automatically
            })
        }
        
        // Handle coupon application
        const applyPromoBtn = document.getElementById('apply-promo')
        const promoCodeInput = document.getElementById('promo-code')
        
        if (applyPromoBtn && promoCodeInput) {
            applyPromoBtn.addEventListener('click', function(e) {
                e.preventDefault()
                const couponCode = promoCodeInput.value.trim()
                
                if (!couponCode) {
                    alert('Please enter a coupon code')
                    return
                }
                
                if (typeof forcex_ajax === 'undefined') {
                    alert('Coupon functionality is not properly configured.')
                    return
                }
                
                applyPromoBtn.disabled = true
                applyPromoBtn.textContent = 'APPLYING...'
                
                fetch(forcex_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'forcex_apply_coupon',
                        coupon_code: couponCode,
                        nonce: forcex_ajax.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload page to show updated totals
                        location.reload()
                    } else {
                        alert(data.data || 'Failed to apply coupon')
                        applyPromoBtn.disabled = false
                        applyPromoBtn.textContent = 'APPLY'
                    }
                })
                .catch(error => {
                    console.error('Coupon application error:', error)
                    alert('Network error. Please try again.')
                    applyPromoBtn.disabled = false
                    applyPromoBtn.textContent = 'APPLY'
                })
            })
            
            // Allow Enter key to apply coupon
            promoCodeInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault()
                    applyPromoBtn.click()
                }
            })
        }
        
        // Handle coupon removal
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-coupon')) {
                e.preventDefault()
                const button = e.target.closest('.remove-coupon')
                const couponCode = button.dataset.coupon
                
                if (typeof forcex_ajax === 'undefined') {
                    return
                }
                
                fetch(forcex_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'forcex_remove_coupon',
                        coupon_code: couponCode,
                        nonce: forcex_ajax.nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload()
                    }
                })
                .catch(error => {
                    console.error('Coupon removal error:', error)
                })
            }
        })
    } else {
        // Checkout stepper only exists on checkout page, so this is normal on other pages
        // console.log('Checkout stepper not found (normal on non-checkout pages)')
    }
    
    // Add to cart AJAX
    document.addEventListener('click', function(e) {
        if (e.target.matches('.add-to-cart-btn') || e.target.closest('.btn-gradient[data-product-id]')) {
            e.preventDefault()
            
            console.log('Add to cart button clicked!') // Debug log
            
            const button = e.target.matches('.add-to-cart-btn') ? e.target : e.target.closest('.btn-gradient[data-product-id]')
            const productId = button.dataset.productId
            const quantity = button.closest('.product-card').querySelector('.quantity-input')?.value || 1
            
            console.log('Product ID:', productId, 'Quantity:', quantity) // Debug log
            
            if (!productId) {
                console.error('No product ID found!')
                return
            }
            
            // Check if AJAX configuration exists
            if (typeof forcex_ajax === 'undefined') {
                console.error('forcex_ajax is not defined! Check if AJAX is properly localized.')
                showNotification('Cart functionality is not properly configured. Please refresh the page.', 'error')
                return
            }
            
            // Verify nonce is available
            if (!forcex_ajax.nonce) {
                console.error('Nonce is missing! AJAX configuration:', forcex_ajax)
                showNotification('Security token is missing. Please refresh the page and try again.', 'error')
                return
            }
            
            console.log('Sending add to cart request with nonce:', forcex_ajax.nonce ? 'Present' : 'Missing')
            
            button.disabled = true
            button.textContent = 'Adding...'
            
            const formData = new URLSearchParams({
                action: 'forcex_add_to_cart',
                product_id: productId,
                quantity: quantity,
                nonce: forcex_ajax.nonce
            })
            
            console.log('Form data:', formData.toString())
            
            fetch(forcex_ajax.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`)
                }
                return response.json()
            })
            .then(data => {
                if (data.success) {
                    console.log('Add to cart success:', data.data) // Debug log
                    
                    // Update cart count and badge visibility
                    const cartCount = document.getElementById('cart-count')
                    console.log('Cart count element found:', cartCount) // Debug log
                    
                    if (cartCount) {
                        cartCount.textContent = data.data.cart_count
                        console.log('Updated cart count to:', data.data.cart_count) // Debug log
                        
                        // Show badge when items are added
                        if (data.data.cart_count > 0) {
                            cartCount.style.display = 'flex'
                            console.log('Showing cart badge') // Debug log
                        } else {
                            cartCount.style.display = 'none'
                            console.log('Hiding cart badge') // Debug log
                        }
                    } else {
                        console.error('Cart count element not found in DOM!')
                    }
                    
                    // Show success message
                    const buttonSpan = button.querySelector('span')
                    if (buttonSpan) {
                        buttonSpan.textContent = 'Added!'
                        setTimeout(() => {
                            buttonSpan.textContent = 'PURCHASE'
                            button.disabled = false
                        }, 2000)
                    } else {
                        button.textContent = 'Added!'
                        setTimeout(() => {
                            button.textContent = 'PURCHASE'
                            button.disabled = false
                        }, 2000)
                    }
                    
                    // Show success notification
                    const productName = data.data.product_name || 'Product'
                    showNotification(`${productName} added to cart!`, 'success')
                } else {
                    console.error('Add to cart failed:', data.data)
                    showNotification(data.data || 'Failed to add product to cart', 'error')
                    const buttonSpan = button.querySelector('span')
                    if (buttonSpan) {
                        buttonSpan.textContent = 'PURCHASE'
                    } else {
                        button.textContent = 'PURCHASE'
                    }
                    button.disabled = false
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error)
                console.error('Product ID:', productId, 'Quantity:', quantity)
                showNotification('Network error. Please check your connection and try again.', 'error')
                const buttonSpan = button.querySelector('span')
                if (buttonSpan) {
                    buttonSpan.textContent = 'PURCHASE'
                } else {
                    button.textContent = 'PURCHASE'
                }
                button.disabled = false
            })
        }
    })
    
    // Function to update quantity button states
    function updateQuantityButtonStates(quantityInput) {
        const buttons = quantityInput.parentElement.querySelectorAll('.quantity-btn')
        const quantity = parseInt(quantityInput.value) || 1
        
        buttons.forEach(button => {
            const action = button.dataset.action
            const svg = button.querySelector('svg path')
            
            if (action === 'decrease') {
                if (quantity <= 1) {
                    button.classList.add('disabled')
                    button.style.backgroundColor = 'white'
                    button.style.border = '1px solid #D9E2E7'
                    if (svg) svg.setAttribute('stroke', '#96A2AF')
                } else {
                    button.classList.remove('disabled')
                    button.style.backgroundColor = 'white'
                    button.style.border = '1px solid #D9E2E7'
                    if (svg) svg.setAttribute('stroke', '#25AAE1')
                }
            } else if (action === 'increase') {
                const maxQuantity = parseInt(quantityInput.getAttribute('max')) || 10
                if (quantity >= maxQuantity) {
                    button.classList.add('disabled')
                    button.style.backgroundColor = 'white'
                    button.style.border = '1px solid #D9E2E7'
                    if (svg) svg.setAttribute('stroke', '#96A2AF')
                } else {
                    button.classList.remove('disabled')
                    button.style.backgroundColor = 'white'
                    button.style.border = '1px solid #D9E2E7'
                    if (svg) svg.setAttribute('stroke', '#25AAE1')
                }
            }
        })
    }
    
    // Initialize button states on page load
    function initializeQuantityButtons() {
        document.querySelectorAll('.quantity-input').forEach(input => {
            if (!input.dataset.cartKey) { // Only for product cards, not cart items
                updateQuantityButtonStates(input)
            }
        })
    }
    
    // Initialize on page load
    setTimeout(initializeQuantityButtons, 100)
    
    // Cart quantity update buttons and product quantity buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.quantity-btn')) {
            e.preventDefault()
            
            const button = e.target.closest('.quantity-btn')
            const action = button.dataset.action
            
            if (button.classList.contains('disabled')) {
                return // Don't execute if button is disabled
            }
            
            const cartItemKey = button.dataset.cartKey
            const quantityInput = button.parentElement.querySelector('.quantity-input')
            
            if (!quantityInput) return
            
            let currentQuantity = parseInt(quantityInput.value) || 1
            let newQuantity = currentQuantity
            
            if (action === 'increase') {
                const maxQuantity = parseInt(quantityInput.getAttribute('max')) || 10
                newQuantity = Math.min(maxQuantity, currentQuantity + 1)
            } else if (action === 'decrease') {
                newQuantity = Math.max(1, currentQuantity - 1)
            }
            
            // Update quantity immediately in UI
            quantityInput.value = newQuantity
            
            // Update button states (for product cards only)
            if (!cartItemKey) {
                updateQuantityButtonStates(quantityInput)
            }
            
            // Add visual feedback
            button.style.transform = 'scale(0.95)'
            setTimeout(() => {
                button.style.transform = 'scale(1)'
            }, 150)
            
            // Only send AJAX request if this is a cart item (has cartItemKey)
            if (cartItemKey) {
                updateCartQuantity(cartItemKey, newQuantity)
            }
        }
    })
    
    // Cart quantity input change
    document.addEventListener('change', function(e) {
        if (e.target.matches('.quantity-input')) {
            const input = e.target
            const cartItemKey = input.dataset.cartKey
            const newQuantity = parseInt(input.value) || 1
            
            // Ensure quantity is within min/max bounds
            const minQuantity = parseInt(input.getAttribute('min')) || 1
            const maxQuantity = parseInt(input.getAttribute('max')) || 10
            
            if (newQuantity < minQuantity) {
                input.value = minQuantity
                return
            }
            
            if (newQuantity > maxQuantity) {
                input.value = maxQuantity
                return
            }
            
            // Only send AJAX request if this is a cart item (has cartItemKey)
            if (cartItemKey) {
                updateCartQuantity(cartItemKey, newQuantity)
            }
        }
    })
    
    // Remove cart item
    document.addEventListener('click', function(e) {
        if (e.target.matches('.remove-cart-item') || e.target.closest('.remove-cart-item')) {
            e.preventDefault()
            
            const button = e.target.matches('.remove-cart-item') ? e.target : e.target.closest('.remove-cart-item')
            const cartItemKey = button.dataset.cartKey
            
            if (!cartItemKey) return
            
            // Remove item directly - notification will confirm success
            removeCartItem(cartItemKey)
        }
    })
    
    // Delete all cart items
    document.addEventListener('click', function(e) {
        if (e.target.matches('#delete-all-cart')) {
            e.preventDefault()
            
            // Clear cart directly - notification will confirm success
            clearCart()
        }
    })
    
    // Helper function to update cart quantity
    function updateCartQuantity(cartItemKey, quantity) {
        fetch(forcex_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'forcex_update_cart_quantity',
                cart_item_key: cartItemKey,
                quantity: quantity,
                nonce: forcex_ajax.nonce
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
            return response.json()
        })
        .then(data => {
            if (data.success) {
                // Update cart totals and count
                updateCartDisplay(data.data)
                
                // If quantity is 0, remove the item from UI
                if (quantity === 0) {
                    const cartItem = document.querySelector(`[data-cart-key="${cartItemKey}"]`).closest('.cart-item')
                    if (cartItem) {
                        cartItem.remove()
                    }
                }
            } else {
                console.error('Update cart failed:', data.data)
                showNotification(data.data || 'Failed to update cart', 'error')
                // Reload page to sync with server state
                location.reload()
            }
        })
        .catch(error => {
            console.error('AJAX Error:', error)
            showNotification('Network error. Please check your connection and try again.', 'error')
            // Reload page to sync with server state
            location.reload()
        })
    }
    
    // Helper function to remove cart item
    function removeCartItem(cartItemKey) {
        fetch(forcex_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'forcex_remove_cart_item',
                cart_item_key: cartItemKey,
                nonce: forcex_ajax.nonce
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
            return response.json()
        })
        .then(data => {
            if (data.success) {
                // Remove item from UI
                const cartItem = document.querySelector(`[data-cart-key="${cartItemKey}"]`).closest('.cart-item')
                if (cartItem) {
                    cartItem.remove()
                }
                
                // Update cart totals and count
                updateCartDisplay(data.data)
                
                // Show success notification
                showNotification('Item removed from cart', 'success')
                
                // Check if cart is empty
                if (data.data.cart_count === 0) {
                    setTimeout(() => {
                        location.reload() // Reload to show empty cart message
                    }, 1000) // Small delay to show notification
                }
            } else {
                console.error('Remove cart item failed:', data.data)
                showNotification(data.data || 'Failed to remove item from cart', 'error')
            }
        })
        .catch(error => {
            console.error('AJAX Error:', error)
            showNotification('Network error. Please check your connection and try again.', 'error')
        })
    }
    
    // Helper function to clear cart
    function clearCart() {
        fetch(forcex_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'forcex_clear_cart',
                nonce: forcex_ajax.nonce
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`)
            }
            return response.json()
        })
        .then(data => {
            if (data.success) {
                // Show success notification
                showNotification('All items removed from cart', 'success')
                // Reload page to show empty cart after a short delay
                setTimeout(() => {
                    location.reload()
                }, 1000) // Small delay to show notification
            } else {
                console.error('Clear cart failed:', data.data)
                showNotification(data.data || 'Failed to clear cart', 'error')
            }
        })
        .catch(error => {
            console.error('AJAX Error:', error)
            showNotification('Network error. Please check your connection and try again.', 'error')
        })
    }
    
    // Helper function to update cart display
    function updateCartDisplay(data) {
        // Update cart count in header
        const cartCount = document.getElementById('cart-count')
        if (cartCount) {
            cartCount.textContent = data.cart_count
            
            // Show or hide cart badge based on cart count
            if (data.cart_count > 0) {
                cartCount.style.display = 'flex'
            } else {
                cartCount.style.display = 'none'
            }
        }
        
        // Update cart totals
        const cartTotal = document.querySelector('.cart-total')
        if (cartTotal) {
            cartTotal.innerHTML = data.cart_total
        }
        
        const cartSubtotal = document.querySelector('.cart-subtotal')
        if (cartSubtotal) {
            cartSubtotal.innerHTML = data.cart_subtotal
        }
    }
    
    // Order modal
    const orderModal = document.getElementById('order-modal')
    const orderModalTriggers = document.querySelectorAll('.view-order-btn')
    const orderModalClose = document.getElementById('order-modal-close')
    const orderModalContent = document.getElementById('order-modal-content')

    function openOrderModalWith(id){
        if(!orderModal || !orderModalContent) return
        orderModalContent.innerHTML = `
            <div class="animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
            </div>`
        orderModal.classList.remove('hidden')

        if (typeof forcex_ajax === 'undefined') return
        fetch(forcex_ajax.ajax_url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action:'forcex_get_order_details', order_id:String(id), nonce: forcex_ajax.nonce })
        })
        .then(r=>r.json())
        .then(data=>{
            if(data && data.success){
                orderModalContent.innerHTML = data.data
            } else {
                orderModalContent.innerHTML = `<div class="text-red-600">Failed to load order details.</div>`
            }
        })
        .catch(()=>{
            orderModalContent.innerHTML = `<div class="text-red-600">Network error.</div>`
        })
    }

    orderModalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault()
            const orderId = this.dataset.orderId
            if(orderId){ openOrderModalWith(orderId) }
        })
    })

    if(orderModalClose && orderModal){
        orderModalClose.addEventListener('click', ()=> orderModal.classList.add('hidden'))
        orderModal.addEventListener('click', (e)=>{ if(e.target === orderModal){ orderModal.classList.add('hidden') }})
    }
    
    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal:not(.hidden)')
            modals.forEach(modal => {
                modal.classList.add('hidden')
            })
        }
    })
    
    // Focus trap for modals
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        )
        const firstElement = focusableElements[0]
        const lastElement = focusableElements[focusableElements.length - 1]
        
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        lastElement.focus()
                        e.preventDefault()
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        firstElement.focus()
                        e.preventDefault()
                    }
                }
            }
        })
    }
    
    // Apply focus trap to all modals
    document.querySelectorAll('.modal').forEach(modal => {
        trapFocus(modal)
    })
    
    // Events page filter functionality
    const eventFilterBtns = document.querySelectorAll('.event-filter-btn')
    const eventCards = document.querySelectorAll('.event-card')
    
    if (eventFilterBtns.length > 0 && eventCards.length > 0) {
        eventFilterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter
                
                // Update active button
                eventFilterBtns.forEach(b => b.classList.remove('active'))
                this.classList.add('active')
                
                // Filter event cards
                eventCards.forEach(card => {
                    const eventType = card.dataset.eventType
                    
                    if (filter === 'all' || eventType === filter) {
                        card.style.display = 'block'
                        card.style.animation = 'fadeInUp 0.6s ease-out'
                    } else {
                        card.style.display = 'none'
                    }
                })
                
                // Show "no events" message if no cards are visible
                const visibleCards = Array.from(eventCards).filter(card => card.style.display !== 'none')
                let noEventsMsg = document.querySelector('.no-events-message')
                
                if (visibleCards.length === 0) {
                    if (!noEventsMsg) {
                        noEventsMsg = document.createElement('div')
                        noEventsMsg.className = 'no-events-message col-span-full text-center py-12'
                        noEventsMsg.innerHTML = `
                            <div class="text-gray-500 text-lg">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p>No events found for this category. Try selecting a different filter.</p>
                            </div>
                        `
                        document.querySelector('.events-grid').appendChild(noEventsMsg)
                    }
                } else {
                    if (noEventsMsg) {
                        noEventsMsg.remove()
                    }
                }
            })
        })
    }
    
    // Articles & Press Releases page filter functionality
    const articleFilterBtns = document.querySelectorAll('.article-filter-btn')
    const articleCards = document.querySelectorAll('.article-card')
    
    if (articleFilterBtns.length > 0 && articleCards.length > 0) {
        articleFilterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filter = this.dataset.filter
                
                // Update active button
                articleFilterBtns.forEach(b => b.classList.remove('active'))
                this.classList.add('active')
                
                // Filter article cards
                articleCards.forEach(card => {
                    const articleType = card.dataset.articleType
                    
                    if (filter === 'all' || articleType === filter) {
                        card.style.display = 'block'
                        card.style.animation = 'fadeInUp 0.6s ease-out'
                    } else {
                        card.style.display = 'none'
                    }
                })
                
                // Show "no articles" message if no cards are visible
                const visibleCards = Array.from(articleCards).filter(card => card.style.display !== 'none')
                let noArticlesMsg = document.querySelector('.no-articles-message')
                
                if (visibleCards.length === 0) {
                    if (!noArticlesMsg) {
                        noArticlesMsg = document.createElement('div')
                        noArticlesMsg.className = 'no-articles-message col-span-full text-center py-12'
                        noArticlesMsg.innerHTML = `
                            <div class="text-gray-500 text-lg">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p>No articles found for this category. Try selecting a different filter.</p>
                            </div>
                        `
                        document.querySelector('.articles-grid').appendChild(noArticlesMsg)
                    }
                } else {
                    if (noArticlesMsg) {
                        noArticlesMsg.remove()
                    }
                }
            })
        })
    }
    
    // Hero Product Slider
    const heroSliderTrack = document.getElementById('hero-slider-track')
    const heroSliderPrev = document.getElementById('hero-slider-prev')
    const heroSliderNext = document.getElementById('hero-slider-next')
    const heroSliderCounter = document.getElementById('hero-slider-counter')
    
    if (heroSliderTrack && heroSliderPrev && heroSliderNext && heroSliderCounter) {
        let currentSlide = 0
        const slides = heroSliderTrack.querySelectorAll('.slider-slide')
        const totalSlides = slides.length
        
        // Update slider position
        function updateSlider() {
            const translateX = -currentSlide * 100
            heroSliderTrack.style.transform = `translateX(${translateX}%)`
            heroSliderCounter.textContent = `${currentSlide + 1} / ${totalSlides}`
        }
        
        // Next slide
        heroSliderNext.addEventListener('click', function() {
            currentSlide = (currentSlide + 1) % totalSlides
            updateSlider()
        })
        
        // Previous slide
        heroSliderPrev.addEventListener('click', function() {
            currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
            updateSlider()
        })
        
        // Add touch/swipe support for mobile
        const heroSlider = document.querySelector('.hero-product-slider')
        if (heroSlider) {
            let touchStartX = 0
            let touchEndX = 0
            
            heroSlider.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX
            }, { passive: true })
            
            heroSlider.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX
                handleSwipe()
            }, { passive: true })
            
            function handleSwipe() {
                const swipeThreshold = 50
                const diff = touchStartX - touchEndX
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        currentSlide = (currentSlide + 1) % totalSlides
                    } else {
                        // Swipe right - previous slide
                        currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
                    }
                    updateSlider()
                }
            }
        }
        
        // Auto-play slider (optional)
        let autoPlayInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides
            updateSlider()
        }, 5000) // Change slide every 5 seconds
        
        // Pause auto-play on hover
        const heroSlider = document.querySelector('.hero-product-slider')
        if (heroSlider) {
            heroSlider.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval)
            })
            
            heroSlider.addEventListener('mouseleave', () => {
                autoPlayInterval = setInterval(() => {
                    currentSlide = (currentSlide + 1) % totalSlides
                    updateSlider()
                }, 5000)
            })
        }
        
        // Initialize slider
        updateSlider()
    }
    
    // Reviews Slider
    const reviewsSliderTrack = document.getElementById('reviews-slider-track')
    const reviewsSliderPrev = document.getElementById('reviews-slider-prev')
    const reviewsSliderNext = document.getElementById('reviews-slider-next')
    const reviewsSliderCounter = document.getElementById('reviews-slider-counter')
    
    if (reviewsSliderTrack && reviewsSliderPrev && reviewsSliderNext && reviewsSliderCounter) {
        let currentSlide = 0
        const slides = reviewsSliderTrack.querySelectorAll('.reviews-slider-slide')
        const totalSlides = slides.length
        
        console.log('Reviews slider initialized:', {
            track: !!reviewsSliderTrack,
            prev: !!reviewsSliderPrev,
            next: !!reviewsSliderNext,
            counter: !!reviewsSliderCounter,
            slides: totalSlides
        })
        
        if (totalSlides > 0) {
            // Update slider position - transform the track directly like hero slider
            function updateReviewsSlider() {
                // Transform by moving one full slide width (100%) for each slide
                const translateX = -currentSlide * 100
                reviewsSliderTrack.style.transform = `translateX(${translateX}%)`
                reviewsSliderTrack.style.webkitTransform = `translateX(${translateX}%)`
                reviewsSliderTrack.style.msTransform = `translateX(${translateX}%)`
                // Update counter with styled spans (first number bigger)
                reviewsSliderCounter.innerHTML = `<span class="text-gray-900 text-2xl md:text-3xl font-bold">${currentSlide + 1}</span> / <span class="text-gray-500 text-lg md:text-xl">${totalSlides}</span>`
                console.log('Slider updated:', { currentSlide, translateX, totalSlides })
            }
            
            // Prevent default button behavior
            reviewsSliderPrev.type = 'button'
            reviewsSliderNext.type = 'button'
            
            // Next slide
            reviewsSliderNext.addEventListener('click', function(e) {
                e.preventDefault()
                e.stopPropagation()
                console.log('Next button clicked, currentSlide:', currentSlide)
                currentSlide = (currentSlide + 1) % totalSlides
                updateReviewsSlider()
            })
            
            // Previous slide
            reviewsSliderPrev.addEventListener('click', function(e) {
                e.preventDefault()
                e.stopPropagation()
                console.log('Prev button clicked, currentSlide:', currentSlide)
                currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
                updateReviewsSlider()
            })
            
            // Auto-play slider (optional)
            let autoPlayInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides
                updateReviewsSlider()
            }, 5000) // Change slide every 5 seconds
            
            // Pause auto-play on hover
            const reviewsSlider = document.querySelector('.reviews-slider')
            if (reviewsSlider) {
                reviewsSlider.addEventListener('mouseenter', () => {
                    clearInterval(autoPlayInterval)
                })
                
                reviewsSlider.addEventListener('mouseleave', () => {
                    autoPlayInterval = setInterval(() => {
                        currentSlide = (currentSlide + 1) % totalSlides
                        updateReviewsSlider()
                    }, 5000)
                })
                
                // Add touch/swipe support for mobile
                let touchStartX = 0
                let touchEndX = 0
                
                reviewsSlider.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX
                }, { passive: true })
                
                reviewsSlider.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX
                    handleReviewsSwipe()
                }, { passive: true })
                
                function handleReviewsSwipe() {
                    const swipeThreshold = 50
                    const diff = touchStartX - touchEndX
                    
                    if (Math.abs(diff) > swipeThreshold) {
                        if (diff > 0) {
                            // Swipe left - next slide
                            currentSlide = (currentSlide + 1) % totalSlides
                        } else {
                            // Swipe right - previous slide
                            currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1
                        }
                        updateReviewsSlider()
                    }
                }
            }
            
            // Initialize slider
            updateReviewsSlider()
        } else {
            console.warn('Reviews slider: No slides found')
        }
    } else {
        console.warn('Reviews slider: Required elements not found', {
            track: !!reviewsSliderTrack,
            prev: !!reviewsSliderPrev,
            next: !!reviewsSliderNext,
            counter: !!reviewsSliderCounter
        })
    }
    
    // Home Reviews Slider (Testimonials Section) - Handles both desktop and mobile
    const homeReviewsSliderTrackDesktop = document.getElementById('home-reviews-slider-track-desktop')
    const homeReviewsSliderTrackMobile = document.getElementById('home-reviews-slider-track')
    const homeReviewsSliderPrev = document.getElementById('home-reviews-slider-prev')
    const homeReviewsSliderNext = document.getElementById('home-reviews-slider-next')
    const homeReviewsSliderCounter = document.getElementById('home-reviews-slider-counter')
    const homeReviewsIndicators = document.getElementById('home-reviews-indicators')
    
    if ((homeReviewsSliderTrackDesktop || homeReviewsSliderTrackMobile) && homeReviewsSliderPrev && homeReviewsSliderNext && homeReviewsSliderCounter) {
        let currentSlideDesktop = 0
        let currentSlideMobile = 0
        
        // Get slides for both desktop and mobile
        const slidesDesktop = homeReviewsSliderTrackDesktop ? homeReviewsSliderTrackDesktop.querySelectorAll('.home-reviews-slide-desktop') : []
        const slidesMobile = homeReviewsSliderTrackMobile ? homeReviewsSliderTrackMobile.querySelectorAll('.home-reviews-slide') : []
        const totalSlidesDesktop = slidesDesktop.length
        const totalSlidesMobile = slidesMobile.length
        
        // Determine which slider is active based on screen size
        function isDesktopView() {
            return window.innerWidth >= 1024
        }
        
        // Get current active slider info
        function getActiveSliderInfo() {
            if (isDesktopView()) {
                return {
                    track: homeReviewsSliderTrackDesktop,
                    currentSlide: currentSlideDesktop,
                    totalSlides: totalSlidesDesktop,
                    slides: slidesDesktop
                }
            } else {
                return {
                    track: homeReviewsSliderTrackMobile,
                    currentSlide: currentSlideMobile,
                    totalSlides: totalSlidesMobile,
                    slides: slidesMobile
                }
            }
        }
        
        // Update slider position for both desktop and mobile
        function updateHomeReviewsSlider() {
            const desktopInfo = {
                track: homeReviewsSliderTrackDesktop,
                currentSlide: currentSlideDesktop,
                totalSlides: totalSlidesDesktop
            }
            const mobileInfo = {
                track: homeReviewsSliderTrackMobile,
                currentSlide: currentSlideMobile,
                totalSlides: totalSlidesMobile
            }
            
            // Update desktop slider
            if (desktopInfo.track && desktopInfo.totalSlides > 0) {
                const translateXDesktop = -desktopInfo.currentSlide * 100
                desktopInfo.track.style.transform = `translateX(${translateXDesktop}%)`
                desktopInfo.track.style.webkitTransform = `translateX(${translateXDesktop}%)`
            }
            
            // Update mobile slider
            if (mobileInfo.track && mobileInfo.totalSlides > 0) {
                const translateXMobile = -mobileInfo.currentSlide * 100
                mobileInfo.track.style.transform = `translateX(${translateXMobile}%)`
                mobileInfo.track.style.webkitTransform = `translateX(${translateXMobile}%)`
            }
            
            // Update counter based on active view
            const activeInfo = getActiveSliderInfo()
            if (activeInfo.totalSlides > 0) {
                homeReviewsSliderCounter.textContent = `${activeInfo.currentSlide + 1} / ${activeInfo.totalSlides}`
            }
            
            // Update indicators for mobile
            if (homeReviewsIndicators && !isDesktopView()) {
                const indicators = homeReviewsIndicators.querySelectorAll('.home-reviews-indicator')
                indicators.forEach((indicator, index) => {
                    if (index === currentSlideMobile) {
                        indicator.classList.add('active')
                    } else {
                        indicator.classList.remove('active')
                    }
                })
            }
        }
        
        // Initialize both sliders
        if (homeReviewsSliderTrackDesktop && totalSlidesDesktop > 0) {
            homeReviewsSliderTrackDesktop.style.transform = 'translateX(0%)'
            homeReviewsSliderTrackDesktop.style.webkitTransform = 'translateX(0%)'
        }
        if (homeReviewsSliderTrackMobile && totalSlidesMobile > 0) {
            homeReviewsSliderTrackMobile.style.transform = 'translateX(0%)'
            homeReviewsSliderTrackMobile.style.webkitTransform = 'translateX(0%)'
        }
        
        // Prevent default button behavior
        homeReviewsSliderPrev.type = 'button'
        homeReviewsSliderNext.type = 'button'
        
        // Next slide
        homeReviewsSliderNext.addEventListener('click', function(e) {
            e.preventDefault()
            e.stopPropagation()
            
            if (isDesktopView() && totalSlidesDesktop > 1) {
                currentSlideDesktop = (currentSlideDesktop + 1) % totalSlidesDesktop
            } else if (!isDesktopView() && totalSlidesMobile > 1) {
                currentSlideMobile = (currentSlideMobile + 1) % totalSlidesMobile
            }
            
            updateHomeReviewsSlider()
        })
        
        // Previous slide
        homeReviewsSliderPrev.addEventListener('click', function(e) {
            e.preventDefault()
            e.stopPropagation()
            
            if (isDesktopView() && totalSlidesDesktop > 1) {
                currentSlideDesktop = currentSlideDesktop === 0 ? totalSlidesDesktop - 1 : currentSlideDesktop - 1
            } else if (!isDesktopView() && totalSlidesMobile > 1) {
                currentSlideMobile = currentSlideMobile === 0 ? totalSlidesMobile - 1 : currentSlideMobile - 1
            }
            
            updateHomeReviewsSlider()
        })
        
        // Handle indicator clicks for mobile
        if (homeReviewsIndicators) {
            const indicators = homeReviewsIndicators.querySelectorAll('.home-reviews-indicator')
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    if (!isDesktopView() && index < totalSlidesMobile) {
                        currentSlideMobile = index
                        updateHomeReviewsSlider()
                    }
                })
            })
        }
        
        // Handle window resize
        let resizeTimeout
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout)
            resizeTimeout = setTimeout(function() {
                updateHomeReviewsSlider()
            }, 250)
        })
        
        // Add touch/swipe support for mobile
        const homeReviewsContainer = document.querySelector('.reviews-slider-container, .testimonials-section')
        if (homeReviewsContainer) {
            let touchStartX = 0
            let touchEndX = 0
            
            homeReviewsContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX
            }, { passive: true })
            
            homeReviewsContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX
                handleHomeReviewsSwipe()
            }, { passive: true })
            
            function handleHomeReviewsSwipe() {
                const swipeThreshold = 50
                const diff = touchStartX - touchEndX
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next slide
                        if (isDesktopView() && totalSlidesDesktop > 1) {
                            currentSlideDesktop = (currentSlideDesktop + 1) % totalSlidesDesktop
                        } else if (!isDesktopView() && totalSlidesMobile > 1) {
                            currentSlideMobile = (currentSlideMobile + 1) % totalSlidesMobile
                        }
                    } else {
                        // Swipe right - previous slide
                        if (isDesktopView() && totalSlidesDesktop > 1) {
                            currentSlideDesktop = currentSlideDesktop === 0 ? totalSlidesDesktop - 1 : currentSlideDesktop - 1
                        } else if (!isDesktopView() && totalSlidesMobile > 1) {
                            currentSlideMobile = currentSlideMobile === 0 ? totalSlidesMobile - 1 : currentSlideMobile - 1
                        }
                    }
                    updateHomeReviewsSlider()
                }
            }
        }
        
        // Initialize slider
        updateHomeReviewsSlider()
        
        // Disable navigation if only one slide
        const activeInfo = getActiveSliderInfo()
        if (activeInfo.totalSlides <= 1) {
            homeReviewsSliderPrev.style.opacity = '0.5'
            homeReviewsSliderNext.style.opacity = '0.5'
            homeReviewsSliderPrev.style.pointerEvents = 'none'
            homeReviewsSliderNext.style.pointerEvents = 'none'
        }
    } else {
        console.warn('Home reviews slider: Required elements not found', {
            trackDesktop: !!homeReviewsSliderTrackDesktop,
            trackMobile: !!homeReviewsSliderTrackMobile,
            prev: !!homeReviewsSliderPrev,
            next: !!homeReviewsSliderNext,
            counter: !!homeReviewsSliderCounter
        })
    }
    
    // Articles Slider
    const articlesSliderTrack = document.getElementById('articles-slider-track')
    const articlesSliderPrev = document.getElementById('articles-slider-prev')
    const articlesSliderNext = document.getElementById('articles-slider-next')
    const articlesSliderCounter = document.getElementById('articles-slider-counter')
    const articlesTotalCount = document.getElementById('articles-total-count')
    
    if (articlesSliderTrack && articlesSliderPrev && articlesSliderNext && articlesSliderCounter) {
        let currentSlide = 0
        const slides = articlesSliderTrack.querySelectorAll('.articles-slider-slide')
        const totalSlides = slides.length
        
        console.log('Articles slider initialized:', {
            track: !!articlesSliderTrack,
            prev: !!articlesSliderPrev,
            next: !!articlesSliderNext,
            counter: !!articlesSliderCounter,
            slides: totalSlides
        })
        
        if (totalSlides > 0) {
            // Determine how many cards to show per slide based on screen size
            function getCardsPerSlide() {
                return window.innerWidth >= 1024 ? 2 : 1
            }
            
            // Calculate maximum slide index based on cards per slide
            function getMaxSlideIndex() {
                const cardsPerSlide = getCardsPerSlide()
                return Math.max(0, totalSlides - cardsPerSlide)
            }
            
            // Update slider position
            function updateArticlesSlider() {
                const cardsPerSlide = getCardsPerSlide()
                const slideWidth = 100 / cardsPerSlide
                const translateX = -currentSlide * slideWidth
                
                articlesSliderTrack.style.transform = `translateX(${translateX}%)`
                articlesSliderTrack.style.webkitTransform = `translateX(${translateX}%)`
                
                // Update counter - calculate total pages based on cards per slide
                const counterNumber = articlesSliderCounter.querySelector('.articles-slider-counter-number')
                const totalCountSpan = document.getElementById('articles-total-count')
                const totalPages = Math.ceil(totalSlides / cardsPerSlide)
                
                if (counterNumber) {
                    counterNumber.textContent = currentSlide + 1
                }
                if (totalCountSpan) {
                    totalCountSpan.textContent = totalPages
                }
                
                console.log('Articles slider updated:', { currentSlide, translateX, totalSlides, cardsPerSlide })
            }
            
            // Handle window resize
            let resizeTimeout
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout)
                resizeTimeout = setTimeout(function() {
                    const maxSlide = getMaxSlideIndex()
                    if (currentSlide > maxSlide) {
                        currentSlide = maxSlide
                    }
                    updateArticlesSlider()
                }, 250)
            })
            
            // Set initial transform
            articlesSliderTrack.style.transform = 'translateX(0%)'
            articlesSliderTrack.style.webkitTransform = 'translateX(0%)'
            
            // Prevent default button behavior
            articlesSliderPrev.type = 'button'
            articlesSliderNext.type = 'button'
            
            // Next slide
            articlesSliderNext.addEventListener('click', function(e) {
                e.preventDefault()
                e.stopPropagation()
                console.log('Next button clicked, currentSlide before:', currentSlide)
                const maxSlide = getMaxSlideIndex()
                currentSlide = currentSlide >= maxSlide ? 0 : currentSlide + 1
                console.log('Next button clicked, currentSlide after:', currentSlide)
                updateArticlesSlider()
            })
            
            // Previous slide
            articlesSliderPrev.addEventListener('click', function(e) {
                e.preventDefault()
                e.stopPropagation()
                console.log('Prev button clicked, currentSlide before:', currentSlide)
                const maxSlide = getMaxSlideIndex()
                currentSlide = currentSlide === 0 ? maxSlide : currentSlide - 1
                console.log('Prev button clicked, currentSlide after:', currentSlide)
                updateArticlesSlider()
            })
            
            // Add touch/swipe support for mobile
            const articlesContainer = articlesSliderTrack.closest('section') || articlesSliderTrack.parentElement
            if (articlesContainer) {
                let touchStartX = 0
                let touchEndX = 0
                
                articlesContainer.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX
                }, { passive: true })
                
                articlesContainer.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX
                    handleArticlesSwipe()
                }, { passive: true })
                
                function handleArticlesSwipe() {
                    const swipeThreshold = 50
                    const diff = touchStartX - touchEndX
                    
                    if (Math.abs(diff) > swipeThreshold) {
                        const maxSlide = getMaxSlideIndex()
                        if (diff > 0) {
                            // Swipe left - next slide
                            currentSlide = currentSlide >= maxSlide ? 0 : currentSlide + 1
                        } else {
                            // Swipe right - previous slide
                            currentSlide = currentSlide === 0 ? maxSlide : currentSlide - 1
                        }
                        updateArticlesSlider()
                    }
                }
            }
            
            // Initialize slider
            updateArticlesSlider()
        } else if (totalSlides === 1) {
            // Only one slide, disable navigation
            articlesSliderPrev.style.opacity = '0.5'
            articlesSliderNext.style.opacity = '0.5'
            articlesSliderPrev.style.pointerEvents = 'none'
            articlesSliderNext.style.pointerEvents = 'none'
            const counterNumber = articlesSliderCounter.querySelector('.articles-slider-counter-number')
            const totalCountSpan = document.getElementById('articles-total-count')
            if (counterNumber) {
                counterNumber.textContent = '1'
            }
            if (totalCountSpan) {
                totalCountSpan.textContent = '1'
            }
        } else {
            console.warn('Articles slider: No slides found')
        }
    } else {
        console.warn('Articles slider: Required elements not found', {
            track: !!articlesSliderTrack,
            prev: !!articlesSliderPrev,
            next: !!articlesSliderNext,
            counter: !!articlesSliderCounter
        })
    }
    
    // Handle contact form submissions (Distributors, Clinic, Prescribers, Patients)
    // Exclude WooCommerce login/register forms - they need to submit normally
    const contactForms = document.querySelectorAll('.forcex-contact-form:not(.woocommerce-form-login):not(.woocommerce-form-register)')
    
    contactForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault()
            
            const formSource = form.getAttribute('data-form-source') || 'unknown'
            const submitButton = form.querySelector('button[type="submit"]')
            const messageDiv = form.querySelector('[id$="-form-message"]')
            const originalButtonText = submitButton ? submitButton.textContent : 'SUBMIT'
            
            // Disable submit button
            if (submitButton) {
                submitButton.disabled = true
                submitButton.textContent = 'SUBMITTING...'
            }
            
            // Clear previous messages
            if (messageDiv) {
                messageDiv.classList.add('hidden')
                messageDiv.textContent = ''
            }
            
            // Collect form data
            const formData = new FormData(form)
            formData.append('action', 'forcex_contact_form')
            formData.append('form_source', formSource)
            
            // Add nonce if available
            if (typeof forcex_ajax !== 'undefined' && forcex_ajax.nonce) {
                formData.append('nonce', forcex_ajax.nonce)
            }
            
            // Send AJAX request
            fetch(forcex_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false
                    submitButton.textContent = originalButtonText
                }
                
                // Show message
                if (messageDiv) {
                    messageDiv.classList.remove('hidden')
                    
                    if (data.success) {
                        messageDiv.className = 'mb-6 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200'
                        messageDiv.textContent = data.data.message || 'Thank you! Your form has been submitted successfully.'
                        
                        // Reset form on success
                        form.reset()
                    } else {
                        messageDiv.className = 'mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200'
                        messageDiv.textContent = data.data || 'There was an error submitting your form. Please try again.'
                    }
                }
            })
            .catch(error => {
                console.error('Form submission error:', error)
                
                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false
                    submitButton.textContent = originalButtonText
                }
                
                // Show error message
                if (messageDiv) {
                    messageDiv.classList.remove('hidden')
                    messageDiv.className = 'mb-6 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200'
                    messageDiv.textContent = 'There was an error submitting your form. Please try again.'
                }
            })
        })
    })
    
})
