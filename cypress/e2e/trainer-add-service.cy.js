describe('Trainer Workflow: Create Profile and Add Service', () => {
  it('should register, create a profile, and add a service', () => {
    // Step 1: Register as a Trainer
    cy.visit('http://127.0.0.1:8000/register'); // Navigate to registration page
    
    cy.get('input[name="name"]').type('John Doe'); // Fill Name
    const email = `trainer${Math.floor(Math.random() * 10000)}@example.com`;
    cy.get('input[name="email"]').type(email); // Fill Email
    cy.get('select[name="role"]').select('Trainer'); // Select Role
    cy.get('input[name="password"]').type('Password123'); // Fill Password
    cy.get('input[name="password_confirmation"]').type('Password123'); // Confirm Password
    cy.get('button[type="submit"]').click(); // Submit Registration
    
    cy.url().should('eq', 'http://127.0.0.1:8000/trainer/dashboard'); // Verify redirection to dashboard

    // Step 2: Create Trainer Profile
    cy.contains('Create Trainer Profile').click(); // Click "Create Trainer Profile" button
    cy.url().should('eq', 'http://127.0.0.1:8000/trainers/create'); // Verify redirection to create profile page
    
    // Debug file upload
    cy.get('input[name="profile_picture"]', { includeShadowDom: true }).then(($input) => {
      // Force file input to be visible
      cy.wrap($input).invoke('show');
      
      // Attach file
      cy.get('input[name="profile_picture"]')
        .attachFile('profile.jpg')
        .then(($el) => {
          cy.log('File attached:', $el);
        });
    });

    // Verify file preview is updated
    cy.get('#preview').should('have.attr', 'src').and('not.contain', 'default-avatar.png');

    // Fill other form fields
    cy.get('input[name="specialization"]').type('Strength Training'); // Fill Specialization
    cy.get('textarea[name="bio"]').type('Certified personal trainer with 5 years of experience.'); // Fill Bio

    // Detailed intercept and logging
    cy.intercept({
      method: 'POST',
      url: '**/trainers'  // Updated to match Laravel route
    }).as('profileSubmit');

    // Submit form
    cy.get('button[type="submit"]').click();

    // Wait and log any network activity
    cy.wait('@profileSubmit', { timeout: 15000 }).then((intercept) => {
      cy.log('Intercept details:', {
        method: intercept.request.method,
        url: intercept.request.url,
        body: intercept.request.body,
        response: intercept.response
      });

      // Check response status
      expect(intercept.response.statusCode).to.be.oneOf([200, 302]);
    });

    // More flexible URL check
    cy.url().should('include', '/trainer/dashboard');

    // Step 3: Add a New Service
    cy.get('input[name="service_name"]').first().type('Personal Training Session'); // Fill Service Name
    cy.get('textarea[name="description"]').first().type('One-on-one personal training session for strength and endurance.'); // Fill Description
    cy.get('input[name="price"]').first().type('50'); // Fill Price
    cy.get('select[name="location"]').first().select('Colombo'); // Select Location
    cy.get('input[name="service_image"]').attachFile('service.jpg'); // Upload Service Image
    cy.get('button[type="submit"]').contains('Add Service').click(); // Submit New Service Form

    // Step 4: Verify Service is Added
    cy.contains('Your Services').should('exist'); // Ensure "Your Services" section exists
    cy.contains('Personal Training Session').should('exist'); // Verify service name appears
    cy.contains('One-on-one personal training session for strength and endurance.').should('exist'); // Verify description appears
  });
});
