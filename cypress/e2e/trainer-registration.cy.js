describe('Trainer Registration Flow', () => {
  const testUser = {
    name: 'Test Trainer',
    email: `trainer_test_${Math.floor(Math.random() * 1000)}@example.com`,
    password: 'TrainerPassword123!',
    specialization: 'Strength Training',
    bio: 'Experienced fitness trainer specializing in strength and conditioning.'
  }

  it('should register a new trainer account and create profile', () => {
    // Visit the registration page
    cy.visit('/register')

    // Ensure registration form is visible
    cy.get('form').should('be.visible')

    // Fill out registration form
    cy.get('input[name="name"]')
      .should('be.visible')
      .type(testUser.name)

    cy.get('input[name="email"]')
      .should('be.visible')
      .type(testUser.email)
    
    // Select Trainer role (adjust selector based on your actual form)
    cy.get('select[name="role"]')
      .should('be.visible')
      .select('Trainer')
    
    cy.get('input[name="password"]')
      .should('be.visible')
      .type(testUser.password)

    cy.get('input[name="password_confirmation"]')
      .should('be.visible')
      .type(testUser.password)

    // Submit registration form
    cy.get('form').submit()

    // Wait and check redirection to trainer dashboard
    cy.url({ timeout: 10000 }).should('include', '/trainer/dashboard')

    // Check for "Create Trainer Profile" message or button
    cy.contains('Create Trainer Profile', { timeout: 10000 })
      .should('be.visible')
      .click()

    // Ensure profile creation form is visible
    cy.get('form').should('be.visible')

    // Fill out trainer profile form
    cy.get('input[name="specialization"]')
      .should('be.visible')
      .type(testUser.specialization)

    cy.get('textarea[name="bio"]')
      .should('be.visible')
      .type(testUser.bio)

    // Optional: Handle profile picture upload if needed
    // cy.get('input[type="file"]').attachFile('path/to/profile/pic.jpg')

    // Submit trainer profile form
    cy.get('form').submit()

    // Verify final redirection to trainer dashboard
    cy.url({ timeout: 10000 }).should('include', '/trainer/dashboard')

    // Add a basic assertion to ensure the test completes
    cy.get('body').should('exist')
  })
})
