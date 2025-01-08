describe('Chat Functionality Flow', () => {
  it('Logs in as a user, navigates to the trainer chat, and verifies chat functionality', () => {
    // Step 1: Login as a user
    cy.visit('/login');
    cy.get('input[name="email"]').type('user@gmail.com');
    cy.get('input[name="password"]').type('123456789');
    cy.get('button[type="submit"]').click();

    // Step 2: Navigate to the services page
    cy.contains('Services').click();
    cy.url().should('include', '/services');

    // Step 3: Click on the "Trainer" button or text
    cy.contains('Trainer', { timeout: 10000 })
      .should('be.visible')
      .click();

    // Step 4: Wait for the "Chat With Trainer" button and click it
    cy.get('[data-test="chat-with-trainer"]', { timeout: 10000 })
      .should('be.visible')
      .click();

    // Step 5: Verify the "Chat" page is displayed
    cy.contains('Chat', { timeout: 10000 }).should('be.visible');
  });
});
