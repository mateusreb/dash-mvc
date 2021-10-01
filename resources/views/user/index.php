<div class="row gutter-xs">
  <div class="col-md-6 col-lg-3 col-lg-push-0">
    <div class="card bg-primary">
      <div class="card-body">
        <div class="media">
          <div class="media-middle media-left">
            <span class="sq-48">
              <span class="icon icon-gamepad"></span>
            </span>
          </div>
          <div class="media-middle media-body">
            <h6 class="media-heading">Subscriptions</h6>
            <h3 class="media-heading">
              <span class="fw-l"><?php echo $data['user-counts']['subscriptions']; ?></span>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3 col-lg-push-0">
    <div class="card bg-primary">
      <div class="card-body">
        <div class="media">
          <div class="media-middle media-left">
            <span class="sq-48">
              <span class="bg-primary icon icon-key"></span>
            </span>
          </div>
          <div class="media-middle media-body">
            <h6 class="media-heading">Available Resets</h6>
            <h3 class="media-heading">
              <span class="fw-l"><?php echo $data['user-counts']['resets']; ?></span>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3 col-lg-push-0">
    <div class="card bg-primary">
      <div class="card-body">
        <div class="media">
          <div class="media-middle media-left">
            <span class="sq-48">
              <span class="bg-primary icon icon-shopping-cart"></span>
            </span>
          </div>
          <div class="media-middle media-body">
            <h6 class="media-heading">Purchases</h6>
            <h3 class="media-heading">
              <span class="fw-l"><?php echo $data['user-counts']['transactions']; ?></span>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3 col-lg-push-0">
    <div class="card bg-primary">
      <div class="card-body">
        <div class="media">
          <div class="media-middle media-left">
            <span class="sq-48">
              <span class="bg-primary icon icon-user-secret"></span>
            </span>
          </div>
          <div class="media-middle media-body">
            <h6 class="media-heading">Connections</h6>
            <h3 class="media-heading">
              <span class="fw-l"><?php echo $data['user-counts']['connections']; ?></span>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row gutter-xs">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <div class="card-actions">
          <button type="button" class="card-action card-toggler" title="Collapse"></button>
          <button type="button" class="card-action card-remove" title="Remove"></button>
        </div>
        <strong>Your Subscriptions</strong>
      </div>
      <div class="card-body" data-toggle="match-height">
        <?php if (empty($data['user-subscriptions'])) { ?>
          <div class="fh">
            <div class="fh-m p-y-md">
              <p class="text-center">You do not currently have active licenses.</p>
            </div>
          </div>
        <?php } else { ?>
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Expire</th>
                <th>Status</th>
                <th>Version</th>
                <th class="text-center">Download</th>
              </tr>
            </thead>
            <tbody>              
              <?php foreach ($data['user-subscriptions'] as $row) { ?>
                <tr>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['expiration_date']; ?></td>
                  <td><?php echo $row['status'] == 'OK' ? '<span class="label label-success">Online</span>' : '<span class="label label-danger">Banned</span>'; ?></td>
                  <td><?php echo $row['version']; ?></td>                  
                  <td class="text-center">
                    <?php if($row['status'] == 'OK'){ ?>
                    <a href="/download/">
                      <button class="btn btn-success btn-sm btn-labeled btn-xs" type="button">
                        <span class="btn-label">
                          <span class="icon icon-download icon-lg icon-fw"></span>
                        </span>
                        Download
                      </button>
                    </a>
                    <?php } else { ?>
                      <span class="label label-danger">Not available</span>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        <?php } ?>
      </div>
    </div>
  </div>
</div>