
<div class="modal fade" id="registerUserForm" tabindex="-1" aria-labelledby="registerUserFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerUserFormModalLabel">Add New User</h5>
        <button type="button" class="btn-close" id="register-user-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="fullname" class="col-form-label">Full Name:</label>
              <input type="text" class="form-control" id="fullname" required>       
              <p id="fullNameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="username-register" class="col-form-label">Username:</label>
              <input type="text" class="form-control" id="username-register" required>
              <p id="username-register-error"></p>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="email-register" class="col-form-label">Email:</label>
              <input type="email" class="form-control" id="email-register" > 
              <p id="email-register-error"></p>             
            </div>            
            <div class="mb-1 col">
              <label for="phone-number-register" class="col-form-label">Phone Number:</label>
              <input type="text" class="form-control" id="phone-number-register" >
              <p id="phone-register-error"></p>
            </div>
          </div>
          <div class="row">
            
            <div class="mb-1 col">
                <select class="form-select" id="userType" aria-label="Default select example">
                    <option selected>User Type</option>
                    <option value="0">STAFF</option>
                    <option value="1">Admin User</option>
                    <!-- <option value="3">Three</option> -->
                </select>
                <p id="user-type-error"></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="register-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="registerNewUser()" id="user-register-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

