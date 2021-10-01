<div class="row">
    <div class="col-xs-12">
        <?php
        if (array_key_exists('alert', $data))
            echo $data['alert'];
        ?>        
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
                <strong>Active Subscriptions</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="demo-datatables-1_info" role="status" aria-live="polite">Showing 1 to <?php echo $data['licenses-count']; ?> licenses.</div>
                    </div>
                    <table class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Acquired</th>
                                <th>Expires</th>
                                <th>Length</th>
                                <th>Product</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Acquired</th>
                                <th>Expires</th>
                                <th>Length</th>
                                <th>Product</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($data['licenses'] as $row) { ?>
                                <tr>
                                    <td><?php echo $row['license_id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['buy_date']; ?></td>
                                    <td><?php echo $row['expiration_date']; ?></td>
                                    <td><?php echo ceil(abs(strtotime($row['expiration_date']) - time()) / 86400); ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                        <a href="/edit-license/<?php echo $row['license_id']; ?>">
                                            <i class="btn btn-info btn-icon sq-20 icon icon-pencil"></i>
                                        </a>
                                        <a data-toggle="modal" data-target="#modalDeleteLicense" onclick="SetInputValue('license-id', <?php echo $row['license_id']; ?>)">
                                            <i class="btn btn-danger btn-icon sq-20 icon icon-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>               
            </div>
        </div>
    </div>
</div>