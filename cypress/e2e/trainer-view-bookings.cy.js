describe('Trainer View Bookings', () => {
    beforeEach(() => {
        // Visit the login page with the full URL
        cy.visit('http://127.0.0.1:8000/login');

        // Login with trainer credentials
        cy.get('input[name="email"]').should('be.visible').type('dhaanish@gmail.com');
        cy.get('input[name="password"]').should('be.visible').type('123456789');
        cy.get('button[type="submit"]').click();

        // Wait for login to complete and redirect to dashboard
        cy.url().should('include', '/dashboard');
    });

    it('should view trainer bookings', () => {
        // Directly visit the trainer bookings page
        cy.visit('http://127.0.0.1:8000/trainer/bookings');

        // Verify we're on the trainer bookings page
        cy.url().should('include', '/trainer/bookings');

        // Verify the page title
        cy.contains('h2', 'Manage Bookings').should('exist');

        // Check if there are any bookings or display the "no bookings" message
        cy.get('body').then($body => {
            if ($body.find('.grid-cols-1').length > 0) {
                // If bookings exist, verify the grid is visible
                cy.get('.grid-cols-1').should('be.visible');
                // Verify booking sections exist for Pending, Confirmed, and Cancelled bookings
                cy.contains('h3', 'Pending Bookings').should('exist');
                cy.contains('h3', 'Confirmed Bookings').should('exist');
                cy.contains('h3', 'Cancelled Bookings').should('exist');
            } else {
                // If no bookings, verify the empty message
                cy.contains('p', "You don't have any bookings yet").should('be.visible');
                // Ensure booking sections do not exist if there are no bookings
                cy.contains('h3', 'Pending Bookings').should('not.exist');
                cy.contains('h3', 'Confirmed Bookings').should('not.exist');
                cy.contains('h3', 'Cancelled Bookings').should('not.exist');
            }
        });

        // Verify the back to dashboard link exists
        cy.contains('a', 'Back to Dashboard').should('exist');
    });
});
