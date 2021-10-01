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
            <?php
            $msg = implode('|', array('sandbox_448eddb847aa19a1', '7.00', 'USD', '1234', 'aa36a61cde96d4e684238916422fb846'));
            $api_sig = md5($msg);
            ?>
            <div class="card-body">
                <div class="demo-form-wrapper">
                    <form name="payssion_hosted_payment" method="post" action="https://sandbox.payssion.com/checkout/sandbox_448eddb847aa19a1">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                <div class="row gutter-xs">
                                    <?php                                   
                                    if (array_key_exists('alert', $data))
                                        echo $data['alert'];
                                    ?>
                                    <div class="col-xs-12 col-xs-offset-0">
                                        <div class="form-group">
                                            <label for="amount" class="control-label">Select Product Days</label>
                                            <select id="amount" class="custom-select" name="amount">
                                                <?php foreach ($data['product-info'] as $row) { ?>
                                                    <option value="<?php echo $row['price_id']; ?>"><?php echo $row['length'] . " Days VIP ". $data['product_name'] . " For US $" . number_format($row['cost'], 2, '.', ','); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="api_sig" value="<?php echo $api_sig; ?>">
                                <input type="hidden" name="order_id" value="1234">
                                <input type="hidden" name="payer_email" value="<?php echo $data['buy-info']['email']; ?>">
                                <input type="hidden" name="description" value="30 Days VIP PBLA">
                                <input type="hidden" name="currency" value="USD">
                                <input type="hidden" name="payer_name" value="<?php echo $data['buy-info']['username']; ?>">
                                <div class="form-group">
                                    <button class="btn btn-info btn-block" type="submit">Buy With Payssion</button>
                                </div>
                                <div class="text-center">
                                    <a class="label label-info label-pill" href="/purchase">
                                        <span>Go Back </span>
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
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                    <button type="button" class="card-action card-reload" title="Reload"></button>
                    <button type="button" class="card-action card-remove" title="Remove"></button>
                </div>
                <strong>Paymentwall</strong>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
</div>