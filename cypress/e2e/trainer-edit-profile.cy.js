describe('Edit Trainer Profile', () => {
  beforeEach(() => {
    // Log in as the trainer
    cy.visit('/login')
    cy.get('input[name="email"]').type('dhaanish@gmail.com')
    cy.get('input[name="password"]').type('123456789')
    cy.get('button[type="submit"]').click()

    // Navigate to trainer dashboard and click Edit Profile
    cy.visit('/trainer/dashboard')
    cy.get('[data-cy="edit-profile-button"]').click()

    // Log detailed debugging information
    cy.url().then((url) => {
      cy.log('Current URL:', url)
    })

    cy.get('body').then(($body) => {
      cy.log('Page Title:', $body.find('title').text())
      cy.log('Page HTML:', $body.html())
    })

    // Log all input and textarea elements
    cy.get('input, textarea').then(($elements) => {
      const elementInfo = $elements.map((index, el) => {
        return {
          name: el.name,
          id: el.id,
          type: el.type,
          tagName: el.tagName
        }
      }).get()
      cy.log('Form Elements:', JSON.stringify(elementInfo))
    })
  })

  it('should update trainer profile', () => {
    // Wait for the form to load
    cy.get('form').should('be.visible')

    // Dynamic selector to find input/textarea for specialization
    cy.get('input[name*="specialization"], textarea[name*="specialization"]')
      .should('exist')
      .clear()
      .type('Advanced Strength Training Specialist')
      .should('have.value', 'Advanced Strength Training Specialist')

    // Dynamic selector to find input/textarea for bio
    cy.get('input[name*="bio"], textarea[name*="bio"]')
      .should('exist')
      .clear()
      .type('Experienced fitness trainer with 10+ years of expertise in strength and conditioning.')
      .should('have.value', 'Experienced fitness trainer with 10+ years of expertise in strength and conditioning.')

    // Submit the form with more flexible selector
    cy.get('button[type="submit"]')
      .contains(/save/i)
      .click()
  })
})
