/**
 * Numeric Input Validation
 * Ensures that specific input fields only accept numeric characters
 */

$(document).ready(function() {
    
    // Function to restrict input to numbers only
    function restrictToNumbers(selector) {
        $(document).on('input keypress paste', selector, function(e) {
            const input = $(this);
            let value = input.val();

            // Handle keypress event
            if (e.type === 'keypress') {
                const charCode = e.which || e.keyCode;

                // Allow: backspace, delete, tab, escape, enter
                if ([8, 9, 27, 13, 46].indexOf(charCode) !== -1 ||
                    // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                    (charCode === 65 && e.ctrlKey === true) ||
                    (charCode === 67 && e.ctrlKey === true) ||
                    (charCode === 86 && e.ctrlKey === true) ||
                    (charCode === 88 && e.ctrlKey === true) ||
                    (charCode === 90 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (charCode >= 35 && charCode <= 40)) {
                    return;
                }

                // Ensure that it is a number and stop the keypress
                if ((charCode < 48 || charCode > 57)) {
                    e.preventDefault();
                    return false;
                }
            }

            // Handle input and paste events
            if (e.type === 'input' || e.type === 'paste') {
                // Remove any non-numeric characters - only numbers allowed
                value = value.replace(/[^\d]/g, '');
                input.val(value);
            }
        });
    }
    
    // Apply numeric validation to specific fields

    // Identity Number fields (NIM, Employee ID) - numbers only
    restrictToNumbers('input[name="identity_number"]');
    restrictToNumbers('#identity_number');

    // Telegram Chat ID fields - numbers only
    restrictToNumbers('input[name="telegram_chat_id"]');
    restrictToNumbers('#telegram_chat_id');

    // Phone Number fields - numbers only
    restrictToNumbers('input[name="phone_number"]');
    restrictToNumbers('#phone_number');
    restrictToNumbers('input[type="tel"]');
    
    // Add visual feedback for numeric-only fields
    function addNumericFieldStyling() {
        const numericFields = [
            'input[name="identity_number"]',
            'input[name="telegram_chat_id"]',
            'input[name="phone_number"]',
            'input[type="tel"]'
        ];

        numericFields.forEach(selector => {
            $(selector).each(function() {
                const input = $(this);

                // Add a small indicator that this field is numeric-only
                if (!input.siblings('.numeric-indicator').length) {
                    const indicator = $('<small class="numeric-indicator text-muted" style="font-size: 0.75em;">Numbers only</small>');

                    // Always insert after the input (at the bottom of form-group)
                    input.after(indicator);
                }
            });
        });
    }
    
    // Apply styling when document is ready
    addNumericFieldStyling();
    
    // Re-apply styling when new content is loaded (for modals, AJAX content)
    $(document).on('DOMNodeInserted', function() {
        setTimeout(addNumericFieldStyling, 100);
    });
    
    // Handle dynamic content loading (modern approach)
    if (window.MutationObserver) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    setTimeout(addNumericFieldStyling, 100);
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Show subtle feedback without changing layout
    function showNumericFeedback(input) {
        // Add red border temporarily
        input.addClass('border-danger');

        // Show tooltip-style feedback
        if (!input.siblings('.numeric-feedback').length) {
            const feedback = $('<small class="numeric-feedback text-danger" style="position: absolute; z-index: 1000; background: white; padding: 2px 6px; border: 1px solid #dc3545; border-radius: 3px; font-size: 0.75em; margin-top: -5px; margin-left: 5px;">Numbers only</small>');
            input.after(feedback);

            // Auto-remove feedback after 2 seconds
            setTimeout(() => {
                feedback.fadeOut(200, function() {
                    $(this).remove();
                });
                input.removeClass('border-danger');
            }, 2000);
        }
    }
    
    // Enhanced validation with subtle feedback
    $(document).on('keypress', 'input[name="identity_number"], input[name="telegram_chat_id"], input[name="phone_number"], input[type="tel"]', function(e) {
        const charCode = e.which || e.keyCode;

        // If it's not a number and not a control key
        if ((charCode < 48 || charCode > 57) && ![8, 9, 27, 13, 46, 35, 36, 37, 38, 39, 40].includes(charCode)) {
            showNumericFeedback($(this));
        }
    });
    
    console.log('Numeric input validation initialized successfully');
});
