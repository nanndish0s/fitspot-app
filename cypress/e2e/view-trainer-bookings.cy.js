describe('View Trainer Bookings', () => {
    beforeEach(() => {
        // Visit the login page with the full URL
        cy.visit('http://127.0.0.1:8000/login');

        // Login with the provided credentials
        cy.get('input[name="email"]').should('be.visible').type('aqeel@gmail.com');
        cy.get('input[name="password"]').should('be.visible').type('123456789');
        cy.get('button[type="submit"]').click();

        // Wait for login to complete and redirect
        cy.url().should('include', '/dashboard');
    });

    it('should navigate to bookings via profile dropdown and verify service', () => {
        // Visit the home page
        cy.visit('http://127.0.0.1:8000');

        // Wait for the profile dropdown to be visible and click it
        cy.get('[data-cy=profile-dropdown]')
            .should('be.visible')
            .click({ force: true });

        // Wait for dropdown menu to be visible
        cy.get('.dropdown-menu')
            .should('be.visible');

        // Click on View Bookings link
        cy.get('[data-cy=view-bookings]')
            .should('be.visible')
            .click();

        // Verify we're on the bookings page
        cy.url().should('include', '/bookings');

        // Look for "New Service" in any of the booking sections
        cy.contains('New Service').should('exist');

        // Additional verification that we're on the right page
        cy.contains('h2', 'My Bookings').should('exist');
    });
});
