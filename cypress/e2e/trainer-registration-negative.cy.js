http://127.0.0.1:8000/dashboarddescribe('Trainer Registration Negative Scenarios', () => {
  // Test invalid email registration
  it('should prevent registration with invalid email', () => {
    cy.visit('/register')

    cy.get('input[name="name"]').type('Invalid Trainer')
    cy.get('input[name="email"]').type('invalid-email')
    cy.get('select[name="role"]').select('Trainer')
    cy.get('input[name="password"]').type('Password123!')
    cy.get('input[name="password_confirmation"]').type('Password123!')

    cy.get('form').submit()

    // Check for email validation error
    cy.get('.error-message')
      .should('be.visible')
      .and('contain', 'Invalid email format')
  })

  // Test password mismatch
  it('should prevent registration with mismatched passwords', () => {
    cy.visit('/register')

    cy.get('input[name="name"]').type('Password Test Trainer')
    cy.get('input[name="email"]').type(`trainer_test_${Math.floor(Math.random() * 1000)}@example.com`)
    cy.get('select[name="role"]').select('Trainer')
    cy.get('input[name="password"]').type('Password123!')
    cy.get('input[name="password_confirmation"]').type('DifferentPassword456!')

    cy.get('form').submit()

    // Check for password mismatch error
    cy.get('.error-message')
      .should('be.visible')
      .and('contain', 'Passwords do not match')
  })

  // Test duplicate email registration
  it('should prevent registration with existing email', () => {
    // Assumes a test user already exists in the system
    const existingEmail = 'existing_trainer@example.com'

    cy.visit('/register')

    cy.get('input[name="name"]').type('Duplicate Email Trainer')
    cy.get('input[name="email"]').type(existingEmail)
    cy.get('select[name="role"]').select('Trainer')
    cy.get('input[name="password"]').type('Password123!')
    cy.get('input[name="password_confirmation"]').type('Password123!')

    cy.get('form').submit()

    // Check for duplicate email error
    cy.get('.error-message')
      .should('be.visible')
      .and('contain', 'Email already exists')
  })

  // Test incomplete profile creation
  it('should prevent incomplete trainer profile creation', () => {
    // First, register a new trainer
    const testUser = {
      name: 'Incomplete Profile Trainer',
      email: `trainer_test_${Math.floor(Math.random() * 1000)}@example.com`,
      password: 'Password123!'
    }

    cy.visit('/register')

    cy.get('input[name="name"]').type(testUser.name)
    cy.get('input[name="email"]').type(testUser.email)
    cy.get('select[name="role"]').select('Trainer')
    cy.get('input[name="password"]').type(testUser.password)
    cy.get('input[name="password_confirmation"]').type(testUser.password)

    cy.get('form').submit()

    // Navigate to profile creation
    cy.contains('Create Trainer Profile').click()

    // Submit without filling required fields
    cy.get('form').submit()

    // Check for validation errors
    cy.get('.error-message')
      .should('be.visible')
      .and('contain', 'Please fill all required fields')
  })
})
