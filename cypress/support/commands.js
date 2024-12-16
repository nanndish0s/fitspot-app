// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

// Add file upload support if not already present
import 'cypress-file-upload';

// Add custom commands for trainer registration if needed
Cypress.Commands.add('registerTrainer', (userData) => {
  cy.visit('/register')
  
  cy.get('input[name="name"]').type(userData.name)
  cy.get('input[name="email"]').type(userData.email)
  cy.get('select[name="role"]').select('Trainer')
  cy.get('input[name="password"]').type(userData.password)
  cy.get('input[name="password_confirmation"]').type(userData.password)
  
  cy.get('form').submit()
})