<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                    <button type="button" class="card-action card-reload" title="Reload"></button>
                    <button type="button" class="card-action card-remove" title="Remove"></button>
                </div>
                <strong>Payssion</strong>
            </div>
            <?php // live_5f4f8d1c109eb066 1eef6a02fdc2b6ff50b3051eea9ac718
            $msg = implode('|', array('live_5f4f8d1c109eb066', number_format($data['price-info']['cost'], 2, '.', ','), 'USD', $data['buy-info']['username'], '1eef6a02fdc2b6ff50b3051eea9ac718'));
            $api_sig = md5($msg);
            ?>
            <div class="card-body">
                <div class="demo-form-wrapper">
                    <form name="payssion_hosted_payment" method="post" action="https://payssion.com/checkout/live_5f4f8d1c109eb066">
                        <div class="row">
                            <div class="text-center" data-toggle="match-height">
                                <h5>Checkout</h5>
                                <p>
                                    <small class="text-muted"><?php echo $data['price-info']['length'] . " Days VIP " . $data['product-info']['name']; ?> For </small>
                                    <span class="text-danger">$<?php echo number_format($data['price-info']['cost'], 2, '.', ','); ?></span>
                                </p>                                
                            </div>
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="row gutter-xs">
                                </div>
                                <input type="hidden" name="api_sig" value="<?php echo $api_sig; ?>">
                                <input type="hidden" name="amount" value="<?php echo number_format($data['price-info']['cost'], 2, '.', ','); ?>">
                                <input type="hidden" name="order_id" value="<?php echo $data['buy-info']['username']; ?>">
                                <input type="hidden" name="payer_email" value="<?php echo $data['buy-info']['email']; ?>">
                                <input type="hidden" name="description" value="<?php echo $data['price-info']['length'] . " Days VIP " . $data['product-info']['name']; ?>">
                                <input type="hidden" name="currency" value="USD">
                                <input type="hidden" name="payer_name" value="<?php echo $data['buy-info']['username']; ?>">
                                <div class="form-group">
                                    <button class="btn btn-info btn-block" type="submit">Buy With Payssion</button>
                                    <div class="text-center">
                                        By clicking buy you agree to our <a href="https://warcheats.net/forum/index.php?threads/politicas-de-devolucion-condiciones-de-compra.1785/" class="alert-link">purchase and refund </a>policies for our site.
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="label label-primary label-pill" href="/purchase">
                                        <span>← Go Back </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>