<div class="row">
    <div class="col-xs-12">
        <?php
        if (array_key_exists('alert', $data))
            echo $data['alert'];
        ?>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2"><a href="/create-license" class="btn btn-info" role="button" aria-pressed="true">Create New License</a></div>
                    <form method="get" action="/search-license">                        
                        <div class="col-sm-2"><input class="form-control" type="text" name="search" placeholder="Search for user."></div>
                        <div class="col-sm-2"><button class="btn btn-primary btn-block" type="submit">Search</button></div>
                    </form>
                    <form method="post" action="/update-all-license">
                        <input type="hidden" name="_csrf" value="<?php echo $data['_csrf']; ?>">
                        <div class="col-sm-2"><input class="form-control" type="text" name="length" placeholder="Change expiration of all licenses."></div>
                        <div class="col-sm-2"><button name="method" value="add" class="btn btn-success btn-block" type="submit">Add Days</button></div>
                        <div class="col-sm-2"><button name="method" value="sub" class="btn btn-danger btn-block" type="submit">Sub Days</button></div>
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
                <strong>Active Subscriptions</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="demo-datatables-1_info" role="status" aria-live="polite">Showing <?php echo ($data['page-id'] - 1) * 10 + 1; ?> to <?php echo $data['page-id'] * 10; ?> of <?php echo $data['licenses-count']; ?> licenses.</div>
                    </div>
                    <table class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Acquired</th>
                                <th>Expires</th>
                                <th>Time Left</th>
                                <th>Product</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Acquired</th>
                                <th>Expires</th>
                                <th>Time Left</th>                                
                                <th>Product</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($data['licenses'] as $row) { ?>
                                <tr>
                                    <td><?php echo $row['license_id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['buy_date']; ?></td>
                                    <td><?php echo $row['expiration_date']; ?></td>                                    
                                    <td><?php echo ceil(abs(strtotime($row['expiration_date']) - time()) / 86400) . ' Day'; ?></td>
                                    <td><span class="label label-outline-info"><?php echo $row['name']; ?></span></td>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                <?php
                                $total =  $data['licenses-count'];
                                $pages =  ceil($total / 10);
                                for ($page = 1; $page <= $pages; $page++) {
                                ?>
                                <li class="paginate_button <?php echo ($data['page-id'] == $page ? 'active' : ''); ?>"><a href="/manage-licenses/<?php echo $page; ?>"><?php echo $page; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>