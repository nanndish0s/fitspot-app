describe('Service Booking Flow', () => {
  // Generate unique user details
  const userName = `User ${Math.floor(Math.random() * 10000)}`;
  const userEmail = `user${Math.floor(Math.random() * 10000)}@example.com`;

  it('should register as a user, book a service, and see confirmation', () => {
    // Step 1: Register as a User
    cy.visit('http://127.0.0.1:8000/register', { 
      timeout: 10000,
      onBeforeLoad: (win) => {
        win.sessionStorage.clear()
        win.localStorage.clear()
      }
    }); 

    // Wait for page to load completely
    cy.get('input[name="name"]', { timeout: 10000 }).should('be.visible');
    
    cy.get('input[name="name"]').type(userName, { delay: 50 }); // Fill Name with unique value
    cy.get('input[name="email"]').type(userEmail, { delay: 50 }); // Fill Email with unique value
    cy.get('select[name="role"]').select('User'); // Select Role
    cy.get('input[name="password"]').type('Password123', { delay: 50 }); // Fill Password
    cy.get('input[name="password_confirmation"]').type('Password123', { delay: 50 }); // Confirm Password
    
    // Intercept registration submission
    cy.intercept('POST', '**/register').as('userRegistration');
    cy.get('button[type="submit"]').click(); // Submit Registration
    
    // Wait for registration with extended timeout
    cy.wait('@userRegistration', { timeout: 15000 });
    
    cy.url().should('eq', 'http://127.0.0.1:8000/dashboard', { timeout: 10000 }); // Verify redirection to dashboard

    // Step 2: Navigate to Services Page
    cy.get('nav').contains('Services', { timeout: 10000 }).click(); // Click "Services" in the navbar
    cy.url().should('include', '/services', { timeout: 10000 }); // Verify navigation to services page

    // Wait for services to load
    cy.get('div[class*="bg-white/90"]', { timeout: 15000 }).should('have.length.gt', 0);

    // Step 3: Select and Book a Service
    cy.get('div[class*="bg-white/90"]').first().within(() => {
      cy.contains('Book Now', { timeout: 10000 }).click({ force: true }); // Click "Book Now" for the first service
    }); // Select first service card

    // Verify navigation to booking page with more flexible matching
    cy.url().should('match', /\/book\/service\/\d+/, { timeout: 15000 });
    
    // Step 4: Fill the Booking Form
    // Use Flatpickr to set the date and time
    cy.get('#session_date_display', { timeout: 15000 }).then(($input) => {
      // Trigger Flatpickr to open
      cy.wrap($input).click();
      
      // Select a specific date
      cy.get('.flatpickr-calendar').should('be.visible');
      
      // Select a date 5 days from now
      cy.get('.flatpickr-day:not(.disabled)').contains('20').click({ force: true });

      // Select a time (morning slot around 9:00)
      cy.get('.flatpickr-time .flatpickr-hour').type('09', { force: true });
      cy.get('.flatpickr-time .flatpickr-minute').type('00', { force: true });

      // Close the time picker
      cy.get('.flatpickr-calendar').type('{esc}', { force: true });
    });

    // Verify the hidden input has been populated with full date and time
    cy.get('#session_date').invoke('val').then((value) => {
      // Validate the value manually
      expect(value).to.match(/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/);
      cy.log('Selected date and time:', value);
    });

    // Fill additional form fields
    cy.get('textarea[name="notes"]').type(`Looking forward to this session, ${userName}!`, { delay: 50 });

    // Wait for Stripe payment element to be fully loaded
    cy.get('#payment-element', { timeout: 15000 }).should('be.visible');

    // Simulate Stripe payment input using JavaScript
    cy.window().then((win) => {
      // Get the Stripe elements
      const stripe = win.Stripe;
      const elements = stripe.elements({
        mode: 'payment',
        amount: 1000, // Assuming 10.00 in cents
        currency: 'usd'
      });

      // Create payment element
      const paymentElement = elements.create('payment');
      
      // Mount the payment element
      paymentElement.mount('#payment-element');

      // Simulate filling payment details
      paymentElement.update({
        billingDetails: {
          name: userName,
          email: `${userName}@example.com`
        }
      });
    });

    // Simulate card details input 
    cy.get('#payment-element iframe').then(($iframe) => {
      const body = $iframe.contents().find('body');
      
      // Try multiple selectors for card number input
      const cardNumberSelectors = [
        'input[placeholder="Card number"]',
        'input[name="cardnumber"]',
        'input[data-elements-stable-field="cardNumber"]'
      ];

      cardNumberSelectors.forEach(selector => {
        cy.wrap(body)
          .find(selector)
          .then($input => {
            if ($input.length) {
              cy.wrap($input)
                .should('be.visible')
                .type('4242 4242 4242 4242', { delay: 50, force: true });
              return false; // Stop iterating
            }
          });
      });

      // Similar approach for expiry and CVC
      const expirySelectors = [
        'input[placeholder="MM / YY"]',
        'input[name="exp-date"]',
        'input[data-elements-stable-field="cardExpiry"]'
      ];

      expirySelectors.forEach(selector => {
        cy.wrap(body)
          .find(selector)
          .then($input => {
            if ($input.length) {
              cy.wrap($input)
                .should('be.visible')
                .type('03/25', { delay: 50, force: true });
              return false;
            }
          });
      });

      const cvcSelectors = [
        'input[placeholder="CVC"]',
        'input[name="cvc"]',
        'input[data-elements-stable-field="cardCvc"]'
      ];

      cvcSelectors.forEach(selector => {
        cy.wrap(body)
          .find(selector)
          .then($input => {
            if ($input.length) {
              cy.wrap($input)
                .should('be.visible')
                .type('135', { delay: 50, force: true });
              return false;
            }
          });
      });
    });

    // Optional: Add a small wait to ensure payment details are processed
    cy.wait(1000);

    // Intercept booking submission
    cy.intercept('POST', '**/bookings').as('bookingSubmission');

    // Submit booking
    cy.get('#submit-button').contains('Book Session').click();

    // Wait for booking submission
    cy.wait('@bookingSubmission', { timeout: 15000 }).then((intercept) => {
      expect(intercept.response.statusCode).to.be.oneOf([200, 201, 302]);
    });

    // Verify booking confirmation with more flexible routing
    cy.url().should('satisfy', (url) => 
      url.includes('/booking/confirmation') || 
      url.includes('/bookings/') || 
      url.includes('/confirmation')
    , { timeout: 15000 });

    // Verify confirmation details
    cy.contains('Booking Confirmation', { timeout: 10000 }).should('exist');
    cy.contains('20').should('exist'); // Verify selected date is shown
    cy.contains(userName).should('exist'); // Verify user name is shown in confirmation
  });
});
