describe('Navigate to Services Page', () => {
  it('should navigate from the homepage to the services page', () => {
    // Step 1: Visit the homepage
    cy.visit('http://127.0.0.1:8000'); // Replace with your actual homepage URL

    // Step 2: Go to the services page
    cy.contains('Services').click(); // Assuming there's a link or button with the text 'Services'

    // Step 3: Ensure the services page is loaded
    cy.url().should('include', '/services'); // Adjust the URL if needed
    cy.contains('Services').should('be.visible'); // Check if the page content is visible
  });
});
