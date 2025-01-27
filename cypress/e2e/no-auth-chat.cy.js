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

describe('Trainer Chat Functionality', () => {
  beforeEach(() => {
    // Login as a trainer
    cy.visit('http://127.0.0.1:8000/login');
    cy.get('input[name="email"]').type('trainer@example.com');
    cy.get('input[name="password"]').type('password123');
    cy.get('button[type="submit"]').click();

    // Wait for dashboard to load
    cy.url().should('include', '/trainer/dashboard');
  });

  it('should send and receive messages between trainer and user', () => {
    // Navigate to chat section
    cy.get('[data-testid="chat-section"]').should('be.visible');
    cy.get('[data-testid="chat-list"]').first().click();

    // Type and send a message
    const trainerMessage = `Test trainer reply at ${new Date().toISOString()}`;
    cy.get('[data-testid="message-input"]').type(trainerMessage);
    cy.get('[data-testid="send-message-btn"]').click();

    // Verify message is sent
    cy.contains(trainerMessage).should('be.visible');

    // Check message details
    cy.get('[data-testid="chat-messages"]').within(() => {
      cy.contains(trainerMessage)
        .should('be.visible')
        .parent()
        .should('have.class', 'text-right')
        .find('small')
        .should('exist');
    });

    // Optional: Verify message is saved in the backend
    cy.request({
      method: 'GET',
      url: 'http://127.0.0.1:8000/api/chat/conversation/1', // Replace with actual user ID
      headers: {
        'Content-Type': 'application/json',
      },
    }).then((response) => {
      expect(response.status).to.eq(200);
      const messages = response.body;
      const lastMessage = messages[messages.length - 1];
      expect(lastMessage.message).to.eq(trainerMessage);
    });
  });

  it('should handle empty message input', () => {
    // Navigate to chat section
    cy.get('[data-testid="chat-section"]').should('be.visible');
    cy.get('[data-testid="chat-list"]').first().click();

    // Try to send an empty message
    cy.get('[data-testid="send-message-btn"]').click();

    // Verify no message is sent
    cy.get('[data-testid="message-input"]').should('have.value', '');
    cy.get('[data-testid="chat-messages"] > div').its('length').should('not.increase');
  });
});
