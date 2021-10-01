<div class="row">
  <div class="col-lg-10 col-lg-offset-1">
    <?php
    if (array_key_exists('alert', $data))
      echo $data['alert'];
    ?>
    <div class="card">
      <div class="card-header">
        <strong>Token Information</strong>
      </div>
      <div class="card-body">
        <?php if (empty($data['token-information']['guid_id'])) { ?>
          <div class="fh">
            <div class="fh-m p-y-md">
              <p class="text-center">Your hwid has not yet been registered.</p>
            </div>
          </div>
        <?php } else { ?>
          <div class="table-flip-scroll">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>PC Name</th>
                  <th>Last Reset</th>
                  <th>Available</th>
                  <th>Token</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $data['token-information']['pc_name']; ?></td>
                  <td><?php echo $data['token-information']['reset_date']; ?></td>
                  <td><?php echo $data['token-information']['reset_availability']; ?></td>
                  <td><?php echo $data['token-information']['guid']; ?></td>
                  <td><?php echo !$data['token-information']['status'] ? '<span class="label label-success">Ok</span>' : '<span class="label label-danger">Banned</span>'; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php if (!empty($data['token-information']['guid'])) { ?>
  <div class="row">
    <div class="col-lg-8 col-lg-offset-2">
      <div class="demo-form-wrapper">
        <form id="reset-token" method="post">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <div class="form-group">
                <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>" />
                <?php if (strtotime($data['token-information']['reset_availability']) < time()) { ?>
                  <button class="btn btn-success btn-block" type="submit">Reset Token</button>
                <?php } else { ?>
                  <button class="btn btn-warning btn-block" type="submit" disabled>Reset Not Available</button>
                <?php } ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
<?php } ?>
