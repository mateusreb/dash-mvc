<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                </div>
                <strong>Product List</strong>
            </div>
            <div class="card-body">
                <?php
                if (array_key_exists('alert', $data))
                    echo $data['alert'];
                ?>
                <div class="table-flip-scroll">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Version</th>
                                <th>Last Update</th>
                                <th>Purchase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['product-list'] as $row) { ?>
                                <tr>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['version']; ?></td>
                                    <td><?php echo $row['updated']; ?></td>
                                    <td class="text-center">
                                        <a href="/purchase/select/<?php echo $row['product_id']; ?>">
                                            <button class="btn btn-success btn-sm btn-labeled" type="button">
                                                <span class="btn-label">
                                                    <span class="icon icon-shopping-cart icon-lg icon-fw"></span>
                                                </span>
                                                Buy Now
                                            </button>
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