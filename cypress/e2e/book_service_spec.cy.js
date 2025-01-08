describe('Book a Service Flow', () => {
  // Generate unique user details
  const userName = `User ${Math.floor(Math.random() * 10000)}`;
  const userEmail = `user${Math.floor(Math.random() * 10000)}@example.com`;

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/register', { 
      timeout: 10000,
      onBeforeLoad: (win) => {
        win.sessionStorage.clear()
        win.localStorage.clear()
      }
    });
  });

  it('Registers and books a service session', () => {
    // Step 1: Register as a user
    cy.get('input[name="name"]', { timeout: 10000 }).should('be.visible');
    
    cy.get('input[name="name"]').type(userName, { delay: 50 });
    cy.get('input[name="email"]').type(userEmail, { delay: 50 });
    cy.get('select[name="role"]').select('User');
    cy.get('input[name="password"]').type('Password123', { delay: 50 });
    cy.get('input[name="password_confirmation"]').type('Password123', { delay: 50 });
    
    // Intercept registration submission
    cy.intercept('POST', '**/register').as('userRegistration');
    cy.get('button[type="submit"]').click();
    
    cy.wait('@userRegistration', { timeout: 15000 });
    cy.url().should('eq', 'http://127.0.0.1:8000/dashboard', { timeout: 10000 });

    // Step 2: Navigate to Services page
    cy.get('nav').contains('Services', { timeout: 10000 }).click();
    cy.url().should('include', '/services', { timeout: 10000 });

    // Wait for services to load
    cy.get('div[class*="bg-white/90"]', { timeout: 15000 }).should('have.length.gt', 0);

    // Step 3: Book a session
    cy.get('div[class*="bg-white/90"]').first().within(() => {
      cy.contains('Book Now', { timeout: 10000 }).click({ force: true });
    });

    // Verify booking page URL with flexible matching
    cy.url().should('match', /\/book\/service\/\d+/, { timeout: 15000 });

    // Step 4: Fill booking form
    cy.get('#session_date_display', { timeout: 15000 }).click();
    cy.get('.flatpickr-calendar .flatpickr-day:not(.disabled)').first().click();

    // Select time slot
    cy.get('select[name="time_slot"]').select(0);

    // Optional: Add notes
    cy.get('textarea[name="notes"]').type('Looking forward to the session!', { delay: 50 });

    // Step 5: Payment handling (adjust based on actual payment implementation)
    cy.get('#payment-element iframe').then(($iframe) => {
      const body = $iframe.contents().find('body');
      
      // Card details input (use test card numbers)
      cy.wrap(body)
        .find('input[name="cardnumber"], input[placeholder="Card number"]')
        .type('4242424242424242', { delay: 50 });
      
      cy.wrap(body)
        .find('input[name="exp-date"], input[placeholder="MM / YY"]')
        .type('12/25', { delay: 50 });
      
      cy.wrap(body)
        .find('input[name="cvc"], input[placeholder="CVC"]')
        .type('123', { delay: 50 });
    });

    // Submit booking
    cy.intercept('POST', '**/book/service').as('bookingSubmission');
    cy.get('button[type="submit"]').contains('Book Session').click();

    // Wait and verify booking confirmation
    cy.wait('@bookingSubmission', { timeout: 15000 });
    cy.url().should('include', '/confirmation', { timeout: 10000 });
    cy.contains('Booking Confirmed', { timeout: 10000 }).should('be.visible');
  });
});