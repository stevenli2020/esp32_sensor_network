<div class="container mt-3 mb-5">
    <h3>Fault Tracking</h3>
    <table class="table table-striped" id="fac-fault-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Location</th>
                <th scope="col">Category</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td><span style="color: green;"><i class="fa-solid fa-circle-check"></i></span> Done</td>
                <td><span style="color: green;"><i class="fa-solid fa-circle-check"></i></span> Done</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td><span style="color: #fcba03;"><i class="fa-solid fa-arrow-trend-up"></i></span> Ongoing</td>
                <td><span style="color: #fcba03;"><i class="fa-solid fa-arrow-trend-up"></i></span> Ongoing</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
                <td><span style="color: #fcba03;"><i class="fa-solid fa-arrow-trend-up"></i></span> Ongoing</td>
                <td><span style="color: #fcba03;"><i class="fa-solid fa-arrow-trend-up"></i></span> Ongoing</td>
            </tr>             -->
    </tbody>
    </table>
</div>

<div class="modal" id="fac-alert-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" id="fac-alert-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="fac-alert-modal-body">
        <!-- <p>Modal body text goes here.</p> -->
      </div>
      <div class="modal-footer" id="fac-alert-modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="fac-alert-close-btn">Close</button>
        <!-- <button type="button" onclick="facAck()" class="btn btn-primary">Acknowledge</button> -->
      </div>
    </div>
  </div>
</div>