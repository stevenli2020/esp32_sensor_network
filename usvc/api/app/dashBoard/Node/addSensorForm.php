

<div class="modal fade" id="addSensorForm" tabindex="-1" aria-labelledby="addSensorFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSensorFormModalLabel">Add Sensor</h5>
        <button type="button" class="btn-close" id="add-sensor-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="add-sensor-mac" class="col-form-label">MAC:</label>
              <input type="text" class="form-control" id="add-sensor-mac" >
              <div id="add-sensor-mac-suggest" class="autocomplete-items"></div>
              <p id="addSensorMACError"></p>
            </div>
            <div class="mb-1 col">
              <label for="add-sensor-name" class="col-form-label">Sensor Name:</label>
              <input type="text" class="form-control" id="add-sensor-name" required>
              <!-- <div id="add-sensor-name-suggest" class="autocomplete-items"></div>        -->
              <p id="addSensorNameError"></p>     
            </div>            
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="add-sensor-fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="add-sensor-fac-name" >   
              <div id="add-sensor-fac-suggest" class="autocomplete-items"></div>
              <p id="addSensorFacNameError"></p>           
            </div>
            <div class="mb-1 col">
              <label for="add-sensor-loc-name" class="col-form-label">Location Name:</label>
              <input type="text" class="form-control" id="add-sensor-loc-name" >   
              <div id="add-sensor-loc-suggest" class="autocomplete-items"></div>
              <p id="addSensorLocNameError"></p>           
            </div>
            
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="add-sensor-alert-value" class="col-form-label">Sensor Alert Value:</label>
              <input type="text" class="form-control" id="add-sensor-alert-value" >   
              <!-- <div id="add-sensor-loc-suggest" class="autocomplete-items"></div> -->
              <!-- <p id="addSensorLocNameError"></p>            -->
            </div>            
            <div class="mb-1 col">
              <label for="add-sensor-type" class="col-form-label">Please Select</label>
              <select class="form-select" id="add-sensor-type" aria-label="Default select example">
                  <option selected>Sensor Type</option>
                  <option value="a9">AIR</option>
                  <option value="03">MOTION</option>
                  <option value="0d">DISTANCE</option>
              </select>
              <p id="addSensorTypeError"></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="add-sensor-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="addSensor()" id="add-sensor-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateSensorForm" tabindex="-1" aria-labelledby="updateSensorFormLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSensorFormModalLabel">Update sensor</h5>
        <button type="button" class="btn-close" id="update-sensor-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-sensor-mac" class="col-form-label">MAC:</label>
              <input type="text" class="form-control" id="update-sensor-mac" >
              <div id="update-sensor-mac-suggest" class="autocomplete-items"></div>
              <p id="updateSensorMACError"></p>
            </div>
            <div class="mb-1 col">
              <label for="update-sensor-name" class="col-form-label">Sensor Name:</label>
              <input type="text" class="form-control" id="update-sensor-name" required>
              <!-- <div id="update-sensor-name-suggest" class="autocomplete-items"></div>        -->
              <p id="updateSensorNameError"></p>     
            </div>
            
          </div>
          <div class="row">
            <div class="mb-1 col">
              <label for="update-sensor-fac-name" class="col-form-label">Facility Name:</label>
              <input type="text" class="form-control" id="update-sensor-fac-name" >   
              <div id="update-sensor-fac-suggest" class="autocomplete-items"></div>
              <p id="updateSensorFacNameError"></p>           
            </div>
            <div class="mb-1 col">
              <label for="update-sensor-loc-name" class="col-form-label">Location Name:</label>
              <input type="text" class="form-control" id="update-sensor-loc-name" >   
              <div id="update-sensor-loc-suggest" class="autocomplete-items"></div>
              <p id="updateSensorLocNameError"></p>           
            </div>
            
          </div>
          <div class="row">   
            <div class="mb-1 col">
              <label for="update-sensor-alert-value" class="col-form-label">Sensor Alert Value:</label>
              <input type="text" class="form-control" id="update-sensor-alert-value" >   
            </div>         
            <div class="mb-1 col">
              <label for="update-sensor-type" class="col-form-label">Please Select</label>
              <select class="form-select" id="update-sensor-type" aria-label="Default select example">
                  <option selected>Sensor Type</option>
                  <option value="a9">AIR</option>
                  <option value="03">MOTION</option>
                  <option value="d3">DISTANCE</option>
              </select>
              <p id="updateSensorTypeError"></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="update-sensor-close-btn" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSensor()" id="update-sensor-submit-btn">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteSensorForm" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="delete-sensor-x-btn"></button>
      </div>
      <div class="modal-body">
        <p id="deleteSensorFormBody">Are you sure, you want to delete?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="delete-sensor-close-btn">Close</button>
        <button type="button" class="btn btn-primary" onclick="deleteSensor()" id="delete-sensor-submit-btn">Yes</button>
      </div>
    </div>
  </div>
</div>
