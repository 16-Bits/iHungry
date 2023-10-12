<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="styles.css">
    <script src="index.js"></script>
  </head>
  <body>
    <div id="header">
        <div id="leftheader" style="width: 40%; float:left"><h1>Incoming Orders</h1></div>
        <div id="rightheader" style="width: 60%; float:right"><img src="https://i.imgur.com/0DGYzt5.jpeg"></div>
    </div>
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

    $getOrdersNumQuery = 'SELECT *
    FROM orders';


    $result = $pdo->query($getOrdersNumQuery);
    echo '<div class="container2">';
    while ($row = $result->fetch()) {
      /*
      echo $row['OrderID'] . '<br>';
      echo $row['OrderName'] . '<br>';
      echo $row['OrderTelNum'] . '<br>';
      echo $row['OrderComments'] . '<br>';
      */
      echo '<div class="float-container">

      <div class="float-child">

        <div class="leftCard">
          <div><strong class="cardTitle">' . $row['OrderID'] . ':</strong></div>';


      $getOrdersInfoQuery = 'SELECT MenuName, MenuItemQty
      FROM menuitem, orders, menuorderitem AS MOI
      WHERE MOI.OrderID = ' . $row['OrderID'] . '
      AND orders.OrderID = ' . $row['OrderID'] . '
      AND MOI.MenuID = menuitem.MenuID';
      $result2 = $pdo->query($getOrdersInfoQuery);
      while ($row2 = $result2->fetch()) {
        //echo '<li>' . $row2['MenuName'] . ' x' . $row2['MenuItemQty'] .'</li>';
        echo '
        <ul>
        <li>
          ' . $row2['MenuName'] . ' x' . $row2['MenuItemQty'] . '
        </li>
        </ul>';
      }
      echo '
      </div><!--end of lCard-->
        
      </div><!--end of floatChild1-->

      <div class="float-child">
        <div class="rightCard">
          <ul>
            <li>
              <strong>Name:</strong>
              <span>' . $row['OrderName'] . '</span>
            </li>
            <li>
              <strong>Telephone #:</strong>
              <span>' . $row['OrderTelNum'] . '</span>
            </li>
            <li>
              <strong>Comments:</strong>
              <span>' . $row['OrderComments'] . '</span>
            </li>

              <input id="button" name="' . $row['OrderID'] . '" type="submit" 
              onclick="' . 'javascript:location.href=\'delete.php?OrderID='. $row['OrderID'] .'\'"
              value="Delete" />

          </ul>
          
        </div><!--end of rCard-->

      </div><!--end of floatChild2-->
    </div><!--end of floatContainer-->
    ';
      /*
      if ($_SERVER['REQUEST_METHOD'] == "GET" and isset($_GET['1670220459'])) {
        $deleteOrderQuery = 'DELETE FROM orders WHERE OrderID = ' . $row['OrderID'];
        $pdo->query($deleteOrderQuery);
        header("Location: incomingOrders.php");
      }
      */
    }
    echo '</div>';

    ?>
    </div>
  </body>
</html>