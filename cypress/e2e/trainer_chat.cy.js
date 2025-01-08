describe('Chat with Trainer', () => {
  it('should allow the user to chat with a trainer', () => {
    // Step 1: Go to the login page
    cy.visit('http://127.0.0.1:8000/login');
    
    // Step 2: Log in with provided credentials
    cy.get('input[name="email"]').type('user@gmail.com');
    cy.get('input[name="password"]').type('123456789');
    cy.get('button[type="submit"]').click();

    // Step 3: Go to the services page
    cy.contains('Services').click();

    // Step 4: Click on "Trainer"
    cy.contains('Trainer').click();

    // Step 4: Wait for the "Chat With Trainer" button and click it
    cy.get('[data-test="chat-with-trainer"]', { timeout: 10000 })
    .should('be.visible')
    .click();

    // Step 6: Wait for the popup to appear (check the popup's container or modal selector)
    cy.get('.chat-popup', { timeout: 10000 }) // Increase the timeout to 10 seconds
      .should('be.visible');  // Adjust this selector to match the popup's class or id

    // Step 7: Interact with the message box inside the popup
    cy.get('textarea[name="message"]').should('be.visible').type('Hello, I need help with training.');

    // Step 8: Ensure the Send button exists and click on it (adjust the selector as needed)
    cy.get('button[type="submit"]').contains('Send').click();

    // Step 9: Ensure the message is sent successfully (can check for new message in chat)
    cy.contains('Hello, I need help with training.').should('be.visible');
  });
});
