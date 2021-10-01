<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                </div>
                <strong>Paymentwall</strong>
            </div>
            <div class="card-body">
                <iframe src="https://api.paymentwall.com/api/subscription/?key=de07078e774b9d6c32dbbc6971d776d3&uid=<?php echo $data['buy-info']['username']; ?>&email=<?php echo $data['buy-info']['email']; ?>&history[registration_date]=<?php echo date('Y-m-d H:i:s', $data['buy-info']['register_date']); ?>&widget=p1_1" width="100%" height="600" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>