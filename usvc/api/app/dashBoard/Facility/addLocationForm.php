

<div class="modal fade" id="addLocationForm" tabindex="-1" aria-labelledby="addLocationFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLocationFormModalLabel">Add Location</h5>
        <button type="button" class="btn-close" id="add-location-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="add-loc-name" class="col-form-label">Location Name:</label>
              <input type="text" class="form-control" id="add-loc-name" required>
              <div id="add-loc-name-suggest" class="autocomplete-items"></div>       
              <p id="addLocNameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="add-loc-fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="add-loc-fac-name" >   
              <div id="add-loc-fac-suggest" class="autocomplete-items"></div>
              <p id="addLocFacNameError"></p>           
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="add-loc-supervisor" class="col-form-label">Supervisor:</label>
              <input type="text" class="form-control" id="add-loc-supervisor" >
              <div id="add-loc-supervisor-suggest" class="autocomplete-items"></div>
              <p id="addLocSupervisorError"></p>
            </div>
            <div class="mb-1 col">
              <label for="add-loc-cleaner" class="col-form-label">Cleaner:</label>
              <input type="text" class="form-control" id="add-loc-cleaner" >
              <div id="add-loc-cleaner-suggest" class="autocomplete-items"></div>
              <p id="addLocCleanerError"></p>
            </div>
          </div>
          <div class="mb-1">
            <label for="add-loc-image-link" class="col-form-label">Image Link:</label>
            <textarea class="form-control" id="add-loc-image-link" rows="3"></textarea>
            <p id="addLocImgLinkError"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="add-loc-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addLocation()" id="add-loc-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateLocationForm" tabindex="-1" aria-labelledby="updateLocationFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateLocationFormModalLabel">Update Location</h5>
        <button type="button" class="btn-close" id="update-loc-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-loc-name" class="col-form-label">Location Name:</label>
              <input type="text" class="form-control" id="update-loc-name" required>     
              <p id="updateLocNameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="update-loc-fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="update-loc-fac-name" >   
              <div id="update-loc-fac-name-suggest" class="autocomplete-items"></div>
              <p id="updateLocFacNameError"></p>           
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-loc-supervisor" class="col-form-label">Supervisor:</label>
              <input type="text" class="form-control" id="update-loc-supervisor" >
              <div id="update-loc-supervisor-suggest" class="autocomplete-items"></div>
              <p id="updateLocSupervisorError"></p>
            </div>
            <div class="mb-1 col">
              <label for="update-loc-cleaner" class="col-form-label">Cleaner:</label>
              <input type="text" class="form-control" id="update-loc-cleaner" >
              <div id="update-loc-cleaner-suggest" class="autocomplete-items"></div>
              <p id="updateLocClanerError"></p>
            </div>
          </div>
          <div class="mb-1">
            <label for="update-loc-image-link" class="col-form-label">Image Link:</label>
            <textarea class="form-control" id="update-loc-image-link" rows="3"></textarea>
            <p id="updateLocImgLinkError"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="update-loc-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateLocation()" id="update-loc-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteLocationForm" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="delete-loc-x-btn"></button>
      </div>
      <div class="modal-body">
        <p id="deleteLocationFormBody">Are you sure, you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="delete-loc-close-btn">Close</button>
        <button type="button" class="btn btn-primary" onclick="deleteLocation()" id="delete-loc-submit-btn">Yes</button>
      </div>
    </div>
  </div>
</div>
