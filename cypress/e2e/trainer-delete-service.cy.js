describe('Delete Trainer Service', () => {
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

  it('Deletes a trainer service successfully', () => {
    // Navigate to "Your Services" section
    cy.contains('Your Services').scrollIntoView();

    // Click the delete button for a service
    cy.get('[data-cy="delete-service-button"]').first().click({ force: true }); // Adjust selector as needed

    // Confirm the deletion in the confirmation dialog
    cy.on('window:confirm', (text) => {
      expect(text).to.contains('Are you sure you want to delete this service?'); // Adjust confirmation text as needed
      return true; // Simulate clicking "OK"
    });

    // Wait for the service to be removed (adjust as per app behavior)
    cy.wait(2000);

    // Assert that the service is no longer listed
    cy.contains('Deleted Service Title').should('not.exist'); // Replace with the exact title of the deleted service if applicable
  });
});
