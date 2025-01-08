describe('Forum Post Creation', () => {
    it('should create a new post on the forum', () => {
      // Step 1: Go to the login page
      cy.visit('http://127.0.0.1:8000/login');
  
      // Step 2: Log in with credentials
      cy.get('input[name="email"]').type('user@gmail.com');
      cy.get('input[name="password"]').type('123456789');
      cy.get('button[type="submit"]').click();
  
      // Step 3: Go to the Forum Page
      cy.contains('Forum').click();
  
      // Step 4: Click on Create New Post
      cy.contains('Create New Post').click();
  
      // Step 5: Enter a Post Title
      cy.get('input[name="title"]').type('Healthy Eating Tips');
  
      // Step 6: Select "Nutrition" from the Category dropdown
      cy.get('select[name="category"]').select('Nutrition');
  
      // Step 7: Enter Post Content
      cy.get('textarea[name="content"]').type('This post will talk about various nutrition tips for a healthy lifestyle.');
  
      // Step 8: Click on Create Post (make sure to use the correct button selector)
      cy.contains('Create Post').click();  // Using text-based selector for Create Post button
  
      // Ensure the post was successfully created (Check for success message or redirection)
      cy.url().should('include', '/forum');
      cy.contains('Healthy Eating Tips').should('be.visible');
    });
  });
  