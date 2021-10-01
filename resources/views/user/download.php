<div class="row">
    <div class="col-xs-12">
        <?php
        if (array_key_exists('alert', $data))
            echo $data['alert'];
        ?>
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                </div>
                <strong>Product List</strong>
            </div>
            <div class="card-body">
                <?php if (empty($data['download-list'])) { ?>
                    <div class="fh">
                        <div class="fh-m p-y-md">
                            <p class="text-center">There are no downloads available in your account.</p>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="table-flip-scroll">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Version</th>
                                    <th>Last Update</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['download-list'] as $row) { ?>
                                    <tr>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['version']; ?></td>
                                        <td><?php echo $row['updated']; ?></td>
                                        <td>
                                            <div class="text-center">
                                                <form id="product-download" method="post">
                                                    <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>" />
                                                    <input type="hidden" name="ref" value="<?php echo $row['ref']; ?>" />
                                                    <button class="btn btn-success btn-sm btn-labeled" type="submit">
                                                        <span class="btn-label">
                                                            <span class="icon icon-download icon-lg icon-fw"></span>
                                                        </span>
                                                        DOWNLOAD
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>