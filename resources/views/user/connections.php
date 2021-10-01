        <div class="row">
          <div class="col-xs-12">
            <div class="card">
              <div class="card-header">
                <div class="card-actions">
                  <button type="button" class="card-action card-toggler" title="Collapse"></button>
                </div>
                <strong>Last connections</strong>
              </div>
              <div class="card-body">
                <div class="table-flip-scroll">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Ip</th>
                        <th>Platform</th>
                        <th>Status</th>
                        <th>Info</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($data['login-log'] as $row) { ?>
                        <tr>
                          <td><?php echo $row['date']; ?></td>
                          <td><?php echo $row['ip']; ?></td>
                          <td><?php echo $row['platform']; ?></td>
                          <td><span class="label label-<?php echo ($row['status'] == 'OK' ? 'success' : 'danger'); ?>"><?php echo $row['status']; ?></span></td>
                          <td><?php echo $row['info']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>