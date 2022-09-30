<!-- <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button>
<button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Open modal for @getbootstrap</button> -->

<div class="modal fade" id="addFacilityForm" tabindex="-1" aria-labelledby="addFacilityFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFacilityFormModalLabel">Add Facility</h5>
        <button type="button" class="btn-close" id="register-node-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <!-- <div class="mb-1 col">
              <label for="coordinator-name" class="col-form-label">Coordinator Name:</label>
              <input type="text" class="form-control" id="coordinator-name" required>       
              <p id="nameError"></p>     
            </div> -->
            <div class="mb-1 col">
              <label for="fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="fac-name" required>
              <div id="fac-name-suggest" class="autocomplete-items"></div>       
              <p id="nameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="fac-address" class="col-form-label">Address:</label>
              <input type="text" class="form-control" id="fac-address" >   
              <div id="fac-addr-suggest" class="autocomplete-items"></div>
              <p id="addrError"></p>           
            </div>
            <!-- <div class="mb-1 col">
              <label for="MAC" class="col-form-label">MAC:</label>
              <input type="text" class="form-control" id="MAC" required>
              <p id="macError"></p>
            </div> -->
          </div>
          <!-- <div class="row">
            <div class="mb-1 col">
              <label for="cluster-id" class="col-form-label">Cluster Id:</label>
              <input type="text" class="form-control" id="cluster-id" required>
              <p id="clusterError"></p>
            </div>
            <div class="mb-1 col">
              <label for="address-node" class="col-form-label">Address:</label>
              <input type="text" class="form-control" id="address-node" >              
            </div>
          </div> -->
          <div class="row">
            <div class="mb-1 col">
              <label for="fac-latitude" class="col-form-label">Latitude:</label>
              <input type="text" class="form-control" id="fac-latitude" >
              <p id="latError"></p>
            </div>
            <div class="mb-1 col">
              <label for="fac-longitude" class="col-form-label">Longitude:</label>
              <input type="text" class="form-control" id="fac-longitude" >
              <p id="lonError"></p>
            </div>
          </div>
          
          <!-- <div class="mb-1">
            <label for="description" class="col-form-label">Description:</label>
            <textarea class="form-control" id="description" rows="3"></textarea>
          </div> -->
          <div class="mb-1">
            <label for="fac-image-link" class="col-form-label">Image Link:</label>
            <textarea class="form-control" id="fac-image-link" rows="3"></textarea>
            <p id="imgLinkError"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="register-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addFacility()" id="register-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateFacilityForm" tabindex="-1" aria-labelledby="updateFacilityFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateFacilityFormModalLabel">Update Facility</h5>
        <button type="button" class="btn-close" id="update-fac-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="update-fac-name" required>
              <div id="update-fac-name-suggest" class="autocomplete-items"></div>       
              <p id="updateNameError"></p>     
            </div>
            <div class="mb-1 col">
              <label for="update-fac-address" class="col-form-label">Address:</label>
              <input type="text" class="form-control" id="update-fac-address" >   
              <div id="update-fac-addr-suggest" class="autocomplete-items"></div>
              <p id="updateAddrError"></p>           
            </div>
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-fac-latitude" class="col-form-label">Latitude:</label>
              <input type="text" class="form-control" id="update-fac-latitude" >
              <p id="updateLatError"></p>
            </div>
            <div class="mb-1 col">
              <label for="update-fac-longitude" class="col-form-label">Longitude:</label>
              <input type="text" class="form-control" id="update-fac-longitude" >
              <p id="updateLonError"></p>
            </div>
          </div>
          <div class="mb-1">
            <label for="update-fac-image-link" class="col-form-label">Image Link:</label>
            <textarea class="form-control" id="update-fac-image-link" rows="3"></textarea>
            <p id="updateImgLinkError"></p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="update-fac-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateFacility()" id="update-fac-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteFacilityForm" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="delete-fac-x-btn"></button>
      </div>
      <div class="modal-body">
        <p id="deleteFacilityFormBody">Are you sure, you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="delete-fac-close-btn">Close</button>
        <button type="button" class="btn btn-primary" onclick="deleteFacility()" id="delete-fac-submit-btn">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="nameSuggestedModalSm" tabindex="-1" aria-labelledby="nameSuggestedModalSmLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      
      <div class="modal-body">
        <div class="list-group" id="suggest-list-name">
            <button type="button" class="list-group-item list-group-item-action active" aria-current="true">
                The current button
            </button>
            <button type="button" class="list-group-item list-group-item-action">A second button item</button>
            <button type="button" class="list-group-item list-group-item-action">A third button item</button>
            <button type="button" class="list-group-item list-group-item-action">A fourth button item</button>
            <button type="button" class="list-group-item list-group-item-action" disabled="">A disabled button item</button>
        </div>
        </div>
    </div>
  </div>
</div> -->

<!-- <div class="modal fade" id="nameSuggestedModal" tabindex="-1" aria-labelledby="nameSuggestedModalSmLabel" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
        <div class="list-group" id="suggest-list-addr">
            
        </div>
      </div>
    </div>
  </div>
</div> -->