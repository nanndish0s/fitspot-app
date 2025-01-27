describe('Forum Post Delete Flow', () => {
    it('should login, navigate to the forum page, read a post, and delete it', () => {
      // Step 1: Visit the login page
      cy.visit('http://127.0.0.1:8000/login'); // Replace with your login page URL
  
      // Step 2: Enter login credentials and submit
      cy.get('input[name="email"]').type('user@gmail.com'); // Adjust the selector as needed
      cy.get('input[name="password"]').type('123456789'); // Adjust the selector as needed
      cy.get('button[type="submit"]').click(); // Submit the form
  
      // Step 3: Navigate to the forum page
      cy.contains('Forum').click(); // Adjust the selector if necessary to match the Forum link/button
  
      // Step 4: Ensure the forum page is loaded
      cy.url().should('include', '/forum'); // Adjust the URL to match the forum page
      cy.contains('Forum').should('be.visible'); // Ensure the page content is visible
  
      // Step 5: Click on "Read More" for a post
      cy.contains('Read More').first().click(); // Assuming the button/text is 'Read More'
  
      // Step 6: Click the delete button
      cy.contains('Delete').click(); // Adjust the selector if needed
  
      // Step 7: Verify it redirects back to the forum page
      cy.url().should('include', '/forum'); // Ensure redirection to the forum page
    });
  });
  