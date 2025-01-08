describe('Book a Service Flow', () => {
    beforeEach(() => {
      // Start with a fresh database state if needed
      cy.visit('http://127.0.0.1:8000/register'); // Adjust if the registration page URL is different
    });
  
    it('Registers and books a service session', () => {
      // Step 1: Register as a user
      cy.get('input[name="name"]').type('Test User'); // Replace with actual name input selector
      cy.get('input[name="email"]').type('testuser@example.com'); // Replace with actual email input selector
      cy.get('input[name="password"]').type('password123'); // Replace with actual password input selector
      cy.get('input[name="password_confirmation"]').type('password123'); // Replace with actual confirmation selector
      cy.get('select[name="role"]').select('User'); // Replace with actual role dropdown selector
      cy.get('button[type="submit"]').click(); // Replace with the actual registration button selector
  
      // Step 2: Redirects to dashboard
      cy.url().should('eq', 'http://127.0.0.1:8000/dashboard');
      cy.contains('Welcome').should('be.visible'); // Validate user is logged in and redirected
  
      // Step 3: Navigate to Services page
      cy.get('nav').contains('Services').click(); // Adjust if the "Services" button selector is different
  
      // Step 4: Book a session
      cy.url().should('include', '/services'); // Verify URL
      cy.contains('Book Now').first().click(); // Click the first "Book Now" button. Adjust selector if needed
  
      // Step 5: Fill the booking/payment form
      cy.url().should('include', '/booking'); // Verify URL
      cy.get('input[name="date"]').type('2024-12-20'); // Replace with the actual selector
      cy.get('input[name="time"]').type('14:00'); // Replace with the actual selector
      cy.get('input[name="card_number"]').type('4242424242424242'); // Replace with the actual selector
      cy.get('input[name="expiration_date"]').type('12/25'); // Replace with the actual selector
      cy.get('input[name="security_code"]').type('123'); // Replace with the actual selector
      cy.get('select[name="country"]').select('Sri Lanka'); // Replace with the actual selector
      cy.get('textarea[name="notes"]').type('Looking forward to the session!'); // Replace with the actual selector
  
      // Step 6: Submit booking
      cy.get('button').contains('Book Session').click(); // Adjust selector if needed
  
      // Step 7: Verify booking confirmation
      cy.url().should('include', '/confirmation'); // Adjust to the actual confirmation URL
      cy.contains('Thank you for booking!').should('be.visible'); // Validate booking confirmation message
    });
  });
  