<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <div class="demo-form-wrapper">
      <form id="form-update-user" novalidate>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-2">
            <div class="form-group">
              <label for="username" class="control-label">Username</label>
              <input id="username" class="form-control" type="text" name="username" value="<?php echo $data['user-info']['username']; ?>">
            </div>
            <div class="form-group">
              <label for="status" class="control-label">HWID - <?php echo ($data['user-info']['guid-status'] == 'BANNED' ? '<span class="label-outline-danger">Banned</span>' : '<span class="label-outline-success">Ok</span>'); ?></label>
              <div class="input-group">
                <input class="form-control" name= "guid" type="text" value="<?php echo $data['user-info']['guid']; ?>">
                <span class="input-group-addon">
                  <label class="custom-control custom-control-danger custom-checkbox">
                    <input class="custom-control-input" name="ban" type="checkbox" <?php echo ($data['user-info']['guid-status'] == 'BANNED' ? 'checked' : ''); ?> value="teste">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-label">Ban</span>
                  </label>
                </span>
              </div>
            </div>
            <div class="col-xs-6 col-xs-offset-0">
                <div class="form-group">
                  <label for="status" class="control-label">Status</label>
                  <select id="status" class="custom-select" name="status">
                    <option value="" selected="selected">Select a status</option>
                    <option value="Online" <?php /*echo ($data['product-info']['status'] == 'Online' ? 'selected' : '');*/ ?>>Online</option>
                    <option value="Offline" <?php /* echo ($data['product-info']['status'] == 'Offline' ? 'selected' : ''); */?>>Offline</option>
                  </select>
                </div>
              </div>
            <div class="form-group">
              <button class="btn btn-info btn-block" type="submit">Update</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>