<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant</title>
    <script src="index.js"></script>
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
  <div id="header">
      <div id="leftheader" style="width: 40%; float:left"><h1>Menu</h1></div>
      <div id="rightheader" style="width: 60%; float:right"><img src="https://i.imgur.com/0DGYzt5.jpeg"></div>
  </div>
    <div class="tab">
        <button class="tablinks" onclick="openMenu(event,'Food')">Food</button>
        <button class="tablinks" onclick="openMenu(event,'Drink')">Drink</button>
        <button class="tablinks" onclick="openMenu(event,'Dessert')">Dessert</button>
      </div>
	
  </body>

  <form method='post' id="sub">

    <div id = "Food" class="tabcontent container">
        <h2 > 
          <span >Food Items:</span>
          <span class="priceLabel">Price ($):</span>
        </h2>
      <span></span>

    <?php
    session_start();
    //echo ("<h3>DEBUG: PHP loaded<h3>");
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
    function printResult($result)
    {
        while ($row = $result->fetch()) {
            echo '<h3>';
            echo '<span>' . $row['MenuName'] . '</span>';
            echo '<label id="top" class="costLabel">$' . $row['MenuPrice'];
            echo ' <input name="' . $row['MenuID'] . '" class="input-group-field" type="number" value="0">
        
            </label>
            
            </h3>';
            echo $row['MenuDesc'] . '<hr>';
        }
    }

    $foodQuery = "SELECT * from MenuItem where MenuID between 100 and 199 order by MenuID";
    $result = $pdo->query($foodQuery);
    printResult($result);

    echo '</div><div id="Drink" class="tabcontent container">
        <h2>
        <span>Drink Items:</span>
        <span class="priceLabel">Price ($):</span>
        </h2>
        <span></span>';

    $foodQuery = "SELECT * from MenuItem where MenuID between 200 and 299 order by MenuID";
    $result = $pdo->query($foodQuery);
    printResult($result);

    echo '</div><div id="Dessert" class="tabcontent container">
        <h2>
        <span>Dessert Items:<span>
        <span class="priceLabel">Price ($):</span>
        </h2>
        <span></span>';
    $foodQuery = "SELECT * from MenuItem where MenuID between 300 and 399 order by MenuID";
    $result = $pdo->query($foodQuery);
    printResult($result);
    echo '</div>
    <div class="bottomDiv">
      <input id="button" name="checkoutbutton" type="submit" value="Order Checkout" />
    </div>';


    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['checkoutbutton'])) {
        $createOrderQuery = 'insert into Orders (OrderID) values (' . $currOrderID . ')';
        $pdo->query($createOrderQuery);

        $iterQuery = "SELECT MenuID from MenuItem order by MenuID";
        $result = $pdo->query($iterQuery);
        while ($row = $result->fetch()) {
            $currMenuID = $row['MenuID'];
            $currMenuQty = $_POST[$currMenuID];
            if ($currMenuQty > 0) {
                $createOrderItemQuery = 'insert into menuorderitem (OrderID, MenuItemQty, MenuID) values (' . $currOrderID . ',' . $currMenuQty . ',' . $currMenuID . ')';
                //echo $createOrderItemQuery . '<br>';
                $pdo->query($createOrderItemQuery);
            }

        }

        echo '<input name="orderID" value=' . $currOrderID . '/>';
        header("Location: orderinfo.php", true, 307);
        exit();
    }

    /*
    
    */


    $pdo = null;
    ?>

</form>


</html> 