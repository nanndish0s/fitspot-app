describe('Edit Trainer Service', () => {
  before(() => {
    // Log in as the trainer
    cy.visit('http://127.0.0.1:8000/login'); // Adjust the login page URL if necessary
    cy.get('input[name="email"]').type('dhaanish@gmail.com');
    cy.get('input[name="password"]').type('123456789');
    cy.get('button[type="submit"]').click();

    // Verify login success
    cy.url().should('include', '/dashboard'); // Ensure redirection to a page containing '/dashboard'

    // Click the Dashboard button in the navbar
    cy.get('nav').contains('Dashboard').click(); // Adjust selector/text if needed

    // Verify that the dashboard page loads
    cy.url().should('eq', 'http://127.0.0.1:8000/trainer/dashboard'); // Ensure final dashboard URL
  });

  it('Edits a trainer service successfully', () => {
    // Navigate to "Your Services" section
    cy.contains('Your Services').scrollIntoView(); 

    // Click the edit button for a service
    cy.get('[data-cy="edit-service-button"]').first().click({ force: true }); 

    // Wait for the modal to be visible
    cy.get('#editServiceModal').should('be.visible');

    // Update the service details with more specific selectors and force option
    cy.get('#edit_service_name').clear({ force: true }).type('Updated Service Title', { force: true });
    cy.get('#edit_description').clear({ force: true }).type('Updated Service Description', { force: true });
    cy.get('#edit_price').clear({ force: true }).type('100', { force: true }); 
    cy.get('#edit_location').select('kandy', { force: true }); 

    // Optional: Upload a new service image
    cy.get('#edit_service_image').attachFile('service.jpg', { force: true });

    // Save the changes
    cy.get('button[data-cy="save-changes"]').click({ force: true }); 

    // Wait for any potential AJAX/page reload
    cy.wait(2000);
  });
});
