<script type="text/javascript">
  window.print();
</script>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <table align="center" cellpadding="1px" cellspacing="1px" width="100%">
    <thead>
      <tr>
         <td colspan="12" align="center">
          <?=  $this->Html->image('ubiveloxiconpng.png', ['alt' => 'Ubivelox', 'width'=>'200px']); ?>
          <center>
            <small>
              Unit 7D Strata 100 Building, Emerald Avenue,
              Ortigas Center, Pasig City, Metro Manila
              Philippines 1605<br>
              Tel No: +63 (02) 954 2719<br>
              Email: ubivelox@gmail.com<br>
              <!--
              Facebook: Ubivelox Philippines Inc.<br>
              Twittter: @ubiveloxph
              -->
            </small>
          </center>
         </td>
      </tr>
      <tr>
        <td colspan="12"><hr></td>
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
        <td colspan="12">
            <?php echo "<strong>Transaction Code:</strong> ".$trans_code; ?><br>
            <?php echo "<strong>Transaction Type:</strong> ".$trans_type_name; ?><br>
            <?php echo "<strong>Company To:</strong> ".$trans_company_name; ?><br>
            <?php echo "<strong>Transaction Date:</strong> ".$trans_date_added; ?><br>
            <?php echo "<strong>Subject:</strong> ".$trans_subject; ?>
        </td>
      </tr>
      <tr>
        <td colspan="12"><hr></td>
      </tr>
      <tr>
        <th colspan="12"><center>List of Items</center></th>
      </tr>
      <tr>
        <td colspan="12"><hr></td>
      </tr>
      <tr align="center">
        <th>Transaction Item</th>
        <th>Serial Number</th>
        <th>Quantity</th>
        <th>Internal Warranty</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach($transitems as $transitem){  

        $items = $this->connection->execute("SELECT * FROM items WHERE id=".$transitem['item_id']);
        $row_itm = $items->fetch('assoc');
        $itemname = $row_itm['item_name'];
        $serial = $row_itm['serial_no'];
      ?>
      <tr align="center">
        <td><?php echo $itemname; ?></td>
        <td><?php echo $serial; ?></td>
        <td><?php echo $transitem['total_quantity']; ?></td>
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
          <?php echo "<strong>Received By:</strong><br> ".$trans_fullname; ?><br><br>
          <?php echo "<strong>Date Received:</strong><br> ".$trans_sreceived_date; ?>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>