describe('Trainer Profile Deletion', () => {
  let uniqueEmail;
  let uniquePassword;

  before(() => {
    // Generate unique email and password for each test run
    const timestamp = Date.now();
    uniqueEmail = `trainer${timestamp}@example.com`;
    uniquePassword = `Password${timestamp}`;

    // Step 1: Register as a trainer
    cy.visit('http://127.0.0.1:8000/register'); // Adjust URL if necessary

    // Fill the registration form
    cy.get('input[name="name"]').type('John Doe');
    cy.get('input[name="email"]').type(uniqueEmail);
    cy.get('select[name="role"]').select('Trainer'); // Assuming a dropdown with "Trainer" as an option
    cy.get('input[name="password"]').type(uniquePassword);
    cy.get('input[name="password_confirmation"]').type(uniquePassword);
    cy.get('button[type="submit"]').click();

    // Verify successful registration and login
    cy.url().should('include', '/dashboard'); // Adjust as needed
  });

  it('Creates, edits, and deletes the trainer profile', () => {
    // Step 2: Create Trainer Profile
    cy.contains('Create Trainer Profile').click(); // Adjust button text/selector if necessary

    // Fill the trainer profile form
    cy.get('input[name="profile_picture"]').attachFile('profile.jpg'); // Assuming file upload
    cy.get('input[name="specialization"]').type('Fitness Coach'); // Adjust name attribute if needed
    cy.get('textarea[name="bio"]').type('Passionate about helping clients achieve their fitness goals.');
    cy.get('button[type="submit"]').click(); // Submit the form
    // Step 3: Edit Profile
    cy.contains('Edit Profile').click(); // Adjust button text/selector if necessary

    // Verify Edit Profile page loads
    cy.url().should('include', '/trainer/edit'); // Adjust URL if necessary

    // Step 4: Delete Profile
    cy.contains('Delete Profile').click(); // Adjust button text/selector if necessary

    // Verify successful deletion (redirect to dashboard)
    cy.url().should('eq', 'http://127.0.0.1:8000/dashboard'); // Ensure redirection to dashboard
  });
});
