<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <div class="demo-form-wrapper">
      <form method="post" action="/update-license">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="row gutter-xs">
              <?php
              if (array_key_exists('alert', $data))
                echo $data['alert'];
              ?>
              <div class="col-xs-6">
                <div class="form-group">
                  <input type="hidden" name="_csrf" value="<?php echo $data['_csrf']; ?>">          
                  <input type="hidden" name="license-id" value="<?php echo $data['license-info']['license_id']; ?>">           
                  <label for="name" class="control-label">User</label>
                  <input id="name" class="form-control" type="text" name="name" value="<?php echo $data['license-info']['username']; ?>" readonly>
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
              <div class="form-group">
                  <label for="product-id" class="control-label">Product</label>
                  <select id="product-id" class="custom-select" name="product-id" data-rule-required="true" data-msg-required="Please select your credit card type.">
                    <?php foreach ($data['product-list'] as $row) { ?>
                    <option value="<?php echo $row['product_id']; ?>" <?php echo ($row['name'] == $data['license-info']['name'] ? 'selected' : ''); ?>><?php echo $row['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-2">
                <div class="form-group">
                  <label for="length" class="control-label">Length</label>
                  <input id="length" class="form-control" type="text" name="length" value="<?php echo ceil(abs(strtotime($data['license-info']['expiration_date']) - time()) / 86400); ?>" readonly>
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
                <div class="form-group">
                  <label for="status" class="control-label">Status</label>
                  <select id="status" class="custom-select" name="status">
                    <option value="" selected="selected">Select a status</option>
                    <option value="OK" <?php echo ($data['license-info']['status'] == 'OK' ? 'selected' : ''); ?>>Online</option>
                    <option value="BANNED" <?php echo ($data['license-info']['status'] == 'BANNED' ? 'selected' : ''); ?>>Banned</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
              <div class="form-group">
                  <label for="acquired-date" class="control-label">Acquired</label>
                  <div class="input-with-icon">
                    <input id="acquired-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="acquired-date" value="<?php echo date("m/d/Y", strtotime($data['license-info']['buy_date'])); ?>">
                    <span class="icon icon-calendar input-icon"></span>
                  </div>
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
                <div class="form-group">
                  <label for="expire-date" class="control-label">Expires</label>
                  <div class="input-with-icon">
                    <input id="expire-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="expire-date" value="<?php echo date("m/d/Y", strtotime($data['license-info']['expiration_date'])); ?>">
                    <span class="icon icon-calendar input-icon"></span>
                  </div>
                </div>
              </div>
            </div>            
            <div class="form-group">
              <button class="btn btn-success btn-block" type="submit">Save</button>
            </div>
            <div class="text-center">
              <a class="label label-primary label-pill" href="/manage-licenses">
                <span>← Go Back </span>
                </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>