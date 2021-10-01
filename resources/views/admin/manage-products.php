<div class="row">
  <div class="col-xs-12">
  <?php            
    if (array_key_exists('alert', $data))
      echo $data['alert'];
  ?>
    <div class="card">
      <div class="card-body">        
        <a href="/manage-products/create" class="btn btn-success btn-sm" role="button" aria-pressed="true">Create New Product</a>
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
        </div>
        <strong>Product List</strong>
      </div>
      <div class="card-body">
        <div class="table-flip-scroll">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Status</th>
                <th>Version</th>
                <th>Last Update</th>
                <th>Action</th>
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
                  <td>
                    <a href="/manage-products/edit/<?php echo $row['product_id']; ?>">
                      <button class="btn btn-info btn-sm btn-labeled btn-xs" type="button">
                        <span class="btn-label">
                          <span class="icon icon-pencil icon-lg icon-fw"></span>
                        </span>
                        Edit
                      </button>
                    </a>
                    <a data-toggle="modal" data-target="#modalDeleteProduct" onclick="SetInputValue('product-id', <?php echo $row['product_id']; ?>)">
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