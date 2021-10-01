<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <form name="select_plan" method="post" action="/purchase/finish">
            <div id="tab-2" class="tab-pane">
                <h4 class="text-center m-y-md">
                    <span>Choose your personal plan</span>
                </h4>
                <div class="row">
                <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>" />
                    <?php foreach ($data['product-info'] as $row) { ?>
                        <div class="col-xs-12 col-sm-4">                            
                            <div class="pricing-card">
                                <div class="pricing-card-header bg-primary">
                                    <h4 class="m-y-sm"><?php echo $data['product_name'] . " VIP #" . $row['length']; ?></h4>
                                </div>
                                <div class="pricing-card-body">
                                    <h2 class="pricing-card-price">
                                        <span class="pricing-card-currency">$</span><?php echo number_format($row['cost'], 2, '.', ','); ?>
                                        <span class="pricing-card-unit">USD</span>
                                    </h2>
                                    <ul class="pricing-card-details">
                                        <li><?php echo $row['length'] . " Days"; ?></li>
                                        <li>100% Undetectable</li>
                                        <li>Updated</li>
                                    </ul>
                                    <label class="custom-control custom-control-primary custom-radio">
                                        <input class="custom-control-input" type="radio" name="plan" value="<?php echo $row['price_id']; ?>">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-label">Choose this</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-success btn-pill btn-next" type="submit">Continue</button>
                </div>
            </div>
        </form>
    </div>
</div>

