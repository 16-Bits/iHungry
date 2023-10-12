<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Restaurant</title>
  <link rel="stylesheet" href="orderinfostyle.css">
  <script src="index.js"></script>
</head>

<body>
  <div id="header">
    <div id="leftheader" style="width: 40%; float:left">
      <h1>Order Info</h1>
    </div>
    <div id="rightheader" style="width: 60%; float:right"><img src="https://i.imgur.com/0DGYzt5.jpeg"></div>
  </div>
<form method = 'get' id='orderinfo'>
  <div id="customerinfo" style="width: 50%; float:left">
    <legend>
      <h2>Order Information</h2>
    </legend>

    <div class="orderinfo">
      <label for="name" class="ordername">Name: <br></label>
      <input type="text" class="form-control" name="name" access="false" id="name">
      <label for="phonenum" class="formbuilder-text-label"><br><br>Phone Number:
        <br>
      </label>
      <input type="tel" class="form-control" name="phonenum" access="false" id="phonenum">
      <label for="comments" class="formbuilder-textarea-label"><br><br>Additional Comments:
        <br>
      </label>
      <textarea type="textarea" class="form-control" name="comments" access="false" id="comments"
        style="width:90%; height:100px"></textarea>
    </div>
  </div>
  <div id="orderprice" style="width: 50%; float:right">
  <?php
  $user = 'root';
  $password = 'root';
  $db = 'restaurantdb';
  $host = 'localhost';

  $currOrderID = time();
  $_SESSION['orderID'] = $currOrderID;


  try {
    $connStr = 'mysql:host=localhost;dbname=restaurantdb';
    $pdo = new PDO($connStr, $user, $password);
    //echo ("<h3>DEBUG: DB loaded<h3>");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  session_start();
  $currOrderID = $_SESSION['orderID'];
  //echo $currOrderID;

  echo '<legend>
  <h2>Order Price</h2>
  <div id="pricetable">
    <table>
      <tr>
        <th>Item</th>
        <th>Price</th>
      </tr>';

  $orderItemQuery = "SELECT MenuName, MenuPrice, MenuItemQty from MenuItem, MenuOrderItem AS MOI WHERE MOI.MenuID = MenuItem.MenuID AND MOI.OrderID = " . $currOrderID;
  $result = $pdo->query($orderItemQuery);
  $totalPrice = 0;
  while ($row = $result->fetch()) {
    $qtyPrice = $row['MenuItemQty'] * $row['MenuPrice'];
    $totalPrice = $totalPrice + $qtyPrice;
    echo '<tr><td>' . $row['MenuName'] . ' x' . $row['MenuItemQty'] . '</td><td>$' . number_format($qtyPrice, 2) . '</td></tr>';
  }
  echo '</table>
    </div>  <div id="pricetotal">
    Price total: $' . number_format($totalPrice, 2) . '
  </div></legend>';
    
  echo '</div>
  <div id="submitorder">
    <input id="button" name="finalbutton" type="submit" value="Submit Order" />
  </div>';

  if ($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['finalbutton'])) {
    //echo 'button pressed';
    $updateOrderQuery = 'UPDATE Orders
    SET OrderName = "' . $_GET['name'] . '", OrderTelNum = "' . $_GET['phonenum']  . '", OrderComments = "' . $_GET['comments']  . '"
    WHERE OrderID = ' . $currOrderID . ';';
    echo "Order Sent";
    $result = $pdo->query($updateOrderQuery);
    session_destroy();
    header("Location: incomingOrders.php");
  }
  ?>
</form>
</body>

</html>