<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <table border="1px" align="center" cellpadding="1px" cellspacing="1px">
    <thead>
      <tr>
        <th colspan="12">
            <?php echo "Transaction Code: ".$trans_code; ?><br>
            <?php echo "Transaction Type: ".$trans_type_name; ?><br>
            <?php echo "Company To: ".$trans_company_name; ?><br>
            <?php echo "Transaction Date: ".$trans_date_added; ?><br>
            <?php echo "Subject: ".$trans_subject; ?>
          </th>
      </tr>
      <tr>
        <th colspan="12">
          <center>
            <h3>
              <?php 
              if($trans_typeid == 1){
              echo "<h2>TRANSMITTAL SLIP</h2>";
              }
              elseif($trans_typeid == 2){
              echo "<h2>DELIVERY RECEIPT</h2>";
              }
              ?>
            </h3>
        </center></th>
      </tr>
      <tr>
        <th colspan="12"><center>List of Items</center></th>
      </tr>
      <tr>
        <th>Transaction ID</th>
        <th>Transaction Item</th>
        <th>Quantity</th>
        <th>Internal Warranty</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach($transitems as $transitem){  
      ?>
      <tr>
        <td><?php echo $trans_code; ?></td>
        <td><?php echo $transitem['item_id']; ?></td>
        <td><?php echo $transitem['quantity']; ?></td>
        <td><?php echo $transitem['internal_warranty']; ?></td>
      </tr>
      <?php
      }
      ?>
      <tr>
        <td colspan="12"><hr></td>
      </tr>
      <tr>
        <td align="right" colspan="12">
          <?php echo "Received By: ".$trans_fullname; ?><br>
          <?php echo "Date Received: ".$trans_sreceived_date; ?>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>