<div class="row gutter-xs">
  <div class="col-xs-12">
  <?php            
    if (array_key_exists('alert', $data))
      echo $data['alert'];
  ?>
    <div class="card">
      <div class="card-header">
        <div class="card-actions">
          <button type="button" class="card-action card-toggler" title="Collapse"></button>
          <button type="button" class="card-action card-reload" title="Reload"></button>
          <button type="button" class="card-action card-remove" title="Remove"></button>
        </div>
        <strong>Users VIP</strong>
      </div>
      <div class="card-body">
        <table id="demo-datatables-2" class="table table-striped table-nowrap dataTable" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Ip</th>
              <th>Buys</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Ip</th>
              <th>Buys</th>
              <th>Action</th>
             </tr>
          </tfoot>
          <tbody>
          <?php foreach ($data['users-vip'] as $row) { ?>
                <tr>
                <td><?php echo $row['user_id']; ?></td>
                  <td><?php echo $row['username']; ?></td>
                  <td><?php echo $row['ip']; ?></td>
                  <td><?php echo $row['buys']; ?></td>
                  <td>
                  <a href="/manage-users/details/<?php echo $row['user_id']; ?>" data-toggle="tooltip" data-placement="top" title="Details <?php echo $row['username']; ?>">
                      <i class="btn btn-success btn-icon sq-20 icon icon-plus"></i>
                    </a>
                    <a href="/manage-users/edit/<?php echo $row['user_id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit <?php echo $row['username']; ?>">
                      <i class="btn btn-info btn-icon sq-20 icon icon-pencil"></i>
                    </a>
                    <a data-toggle="modal" data-target="#modalDeleteUser" onclick="SetInputValue('user-id', <?php echo $row['user_id']; ?>)">
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