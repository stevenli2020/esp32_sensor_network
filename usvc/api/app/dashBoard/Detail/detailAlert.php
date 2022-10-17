<div class="container mt-3 mb-5">
    <h3>Page alerts log</h3>
    <table class="table table-striped" id="detail-fault-table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Alert</th>
                <th scope="col">Sent to</th>
                <!-- <th scope="col">Action</th> -->
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

<div class="modal" id="detail-alert-modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alert Details</h5>
        <button type="button" class="btn-close" id="detail-alert-X-btn" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="detail-alert-modal-body">
        <!-- <p>Modal body text goes here.</p> -->
      </div>
      <div class="modal-footer" id="detail-alert-modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="detail-alert-close-btn">Close</button>
        
      </div>
    </div>
  </div>
</div>