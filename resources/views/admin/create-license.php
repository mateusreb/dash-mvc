<div class="row">
  <div class="col-lg-8 col-lg-offset-2">
    <div class="demo-form-wrapper">
      <form method="post" action="/create-license">
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
                  <label for="name" class="control-label">User</label>
                  <input id="name" class="form-control" type="text" name="name" value="">
                </div>
              </div>
              <div class="col-xs-4 col-xs-offset-0">
                <div class="form-group">
                  <label for="product-id" class="control-label">Product</label>
                  <select id="product-id" class="custom-select" name="product-id" data-rule-required="true" data-msg-required="Please select your credit card type.">
                    <?php foreach ($data['product-list'] as $row) { ?>
                      <option value="<?php echo $row['product_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-2">
                <div class="form-group">
                  <label for="name" class="control-label">Length</label>
                  <input id="length" class="form-control" type="text" name="length" value="0" readonly>
                </div>
              </div>
              <div class="col-xs-6 col-xs-offset-0">
                <div class="form-group">
                  <label for="acquired-date" class="control-label">Acquired</label>
                  <div class="input-with-icon">
                    <input id="acquired-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="acquired-date" value="<?php echo date("m/d/Y", time()); ?>">
                    <span class="icon icon-calendar input-icon"></span>
                  </div>
                </div>
              </div>
              <div class="col-xs-6 col-xs-offset-0">
                <div class="form-group">
                  <label for="expire-date" class="control-label">Expires</label>
                  <div class="input-with-icon">
                    <input id="expire-date" class="form-control" type="text" data-provide="datepicker" data-date-today-highlight="true" name="expire-date" value="<?php echo date("m/d/Y", time()); ?>">
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
                <span>Go Back </span>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>