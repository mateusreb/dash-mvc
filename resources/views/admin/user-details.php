<div class="row gutter-xs">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                    <button type="button" class="card-action card-remove" title="Remove"></button>
                  </div>
                  <strong>Transactions</strong>
                </div>
                <div class="card-body" data-toggle="match-height">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Platform</th>
                        <th>Product</th>
                        <th>Length</th>                       
                        <th>Ref</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['transactions'] as $row) { ?>
                      <tr>
                        <td><?php echo $row['buy_id']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['platform']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['length']; ?></td>
                        <td><?php echo $row['ref']; ?></td>
                        <td>
                          <span class="label label-outline-success">Active</span>
                        </td>
                      </tr>                
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <div class="card-actions">
                    <button type="button" class="card-action card-toggler" title="Collapse"></button>
                    <button type="button" class="card-action card-remove" title="Remove"></button>
                  </div>
                  <strong>Hover Table (Align: left, right, center)</strong>
                </div>
                <div class="card-body" data-toggle="match-height">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Campaign Name</th>
                        <th class="text-right">Link Clicks</th>
                        <th class="text-right">Reach</th>
                        <th class="text-center">Performance</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-left">1</td>
                        <td class="text-left">Website traffic</td>
                        <td class="text-right">11,706</td>
                        <td class="text-right">58,530</td>
                        <td class="text-center">
                          <span data-peity="line">5,3,9,6,5,9,7,3,5,2</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-left">2</td>
                        <td class="text-left">Remarketing</td>
                        <td class="text-right">15,860</td>
                        <td class="text-right">79,300</td>
                        <td class="text-center">
                          <span data-peity="line">4,9,6,7,3,1,2,5,6,8</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-left">3</td>
                        <td class="text-left">Page Likes</td>
                        <td class="text-right">11,688</td>
                        <td class="text-right">58,440</td>
                        <td class="text-center">
                          <span data-peity="line">1,2,1,6,8,9,5,4,7,3</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-left">4</td>
                        <td class="text-left">Email Signups</td>
                        <td class="text-right">13,049</td>
                        <td class="text-right">65,245</td>
                        <td class="text-center">
                          <span data-peity="line">2,7,0,4,6,1,8,5,9,3</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-left">5</td>
                        <td class="text-left">Product catalog</td>
                        <td class="text-right">18,884</td>
                        <td class="text-right">94,423</td>
                        <td class="text-center">
                          <span data-peity="line">9,4,3,1,7,8,0,2,6,5</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>