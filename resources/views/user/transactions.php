<?php
  $total_length = 0;
  $total_amount = 0;
?>
<div class="row gutter-xs">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-actions">
          <button type="button" class="card-action card-toggler" title="Collapse"></button>
          <button type="button" class="card-action card-reload" title="Reload"></button>
          <button type="button" class="card-action card-remove" title="Remove"></button>
        </div>
        <strong>Transactions</strong>
      </div>
      <div class="card-body">
        <table class="table table-hover table-bordered table-striped">
          <thead>
            <tr>
              <th rowspan="2" class="text-left">Transaction</th>
              <th rowspan="2" class="text-left">Product</th>
              <th rowspan="2" class="text-left">Status</th>
              <th rowspan="2" class="text-left">Date</th>
              <th rowspan="2" class="text-left">Platform</th>
              <th colspan="3" class="text-center">Financial Cost</th>
            </tr>
            <tr>
              <th class="text-right">Length</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php             
            foreach ($data['user-transactions'] as $row) 
            { 
              $total_length += $row['length'];
              $total_amount += $row['amount'];
          ?>
            <tr>
              <td class="text-left"><?php echo $row['ref']; ?></td>
              <td class="text-left"><?php echo $row['name']; ?></td>  
              <td class="text-left"><?php echo $row['type'] == '0' ? '<span class="label label-success">Confirmed</span>' : '<span class="label label-danger">Chargeback</span>'; ?></td>             
              <td class="text-left"><?php echo $row['date']; ?></td>
              <td class="text-left"><?php echo $row['platform']; ?></td>
              <td class="text-right"><?php echo $row['length']; ?></td>
              <td class="text-right"><?php echo number_format($row['amount'], 2, ',', '.'); ?></td>
            </tr>
          <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-right" colspan="5">Total:</th>
              <th class="text-right"><?php echo $total_length; ?></th>
              <th class="text-right"><?php echo $total_amount; ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>