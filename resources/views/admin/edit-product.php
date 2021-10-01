<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <div class="demo-form-wrapper">
      <form id="demo-form-wizard-1" method="post" action="/manage-products/update">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="row gutter-xs">
              <?php
              if (array_key_exists('alert', $data))
                echo $data['alert'];
              ?>
              <div class="col-xs-8">
                <div class="form-group">
                  <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>">
                  <input type="hidden" name="product_id" value="<?php echo $data['product-info']['product_id']; ?>">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" class="form-control" type="text" name="name" value="<?php echo $data['product-info']['name']; ?>">
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
                <div class="form-group">
                  <label for="version" class="control-label">Version</label>
                  <input id="version" class="form-control" type="text" name="version" value="<?php echo $data['product-info']['version']; ?>">
                </div>
              </div>
              <div class="col-xs-6 col-xs-offset-0">
                <div class="form-group">
                  <label for="status" class="control-label">Status</label>
                  <select id="status" class="custom-select" name="status">
                    <option value="" selected="selected">Select a status</option>
                    <option value="Online" <?php echo ($data['product-info']['status'] == 'Online' ? 'selected' : ''); ?>>Online</option>
                    <option value="Offline" <?php echo ($data['product-info']['status'] == 'Offline' ? 'selected' : ''); ?>>Offline</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-5 col-xs-offset-1">
                <div class="form-group">
                  <label for="update-date" class="control-label">Update Date</label>
                  <div class="input-with-icon">
                    <input id="update-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="update-date" value="<?php echo date("m/d/Y", strtotime($data['product-info']['updated'])); ?>">
                    <span class="icon icon-calendar input-icon"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">              
              <div class="form-group">
                <label for="hash" class="control-label">Hash</label>
                <input id="hash" class="form-control" type="text" name="hash" value="<?php echo $data['product-info']['hash']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="description" class="control-label">Description</label>
              <input id="description" class="form-control" type="text" name="description" value="<?php echo $data['product-info']['description']; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-success btn-block" type="submit">Save</button>
            </div>
            <div class="text-center">
              <a class="label label-info label-pill" href="/manage-products">
                <span>← Go Back </span>
                </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>