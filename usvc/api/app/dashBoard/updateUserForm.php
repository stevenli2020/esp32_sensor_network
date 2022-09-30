<div class="modal fade" id="updateUserForm" tabindex="-1" aria-labelledby="updateUserFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateUserFormModalLabel">User Details</h5>
        <button type="button" class="btn btn-info" id="update-user-file-btn" onclick="removeReadOnly()" style="position: absolute; right:45px;"><i class="fa-solid fa-file-pen"></i></button>
        <button type="button" class="btn-close" id="update-user-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="fullname-update" class="col-form-label">Full Name:</label>
              <input type="text" class="form-control-plaintext" id="fullname-update" readonly>       
              <p id="fullNameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="username-update" class="col-form-label">Username:</label>
              <input type="text" class="form-control-plaintext" id="username-update" readonly>
              <p id="username-update-error"></p>
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="email-update" class="col-form-label">Email:</label>
              <input type="email" class="form-control-plaintext" id="email-update" readonly> 
              <p id="email-update-error"></p>             
            </div>            
            <div class="mb-1 col">
              <label for="phone-number-update" class="col-form-label">Phone Number:</label>
              <input type="text" class="form-control-plaintext" id="phone-number-update" readonly>
              <p id="phone-update-error"></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" id="modal-footer">
        <!-- <button type="button" class="btn btn-primary" onclick="updateNewUser()" id="user-update-submit-btn">Submit</button> -->
      </div>
    </div>
  </div>
</div>