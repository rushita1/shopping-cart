<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');

    $mysqli = new mysqli("localhost", "root", "", "shopping_cart");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    };

    $products = '[];';

    if($_POST) {// this is a post, process the order

       $fname = "rushita";

      $select_fname = "SELECT id from customer WHERE first_name=\"$fname\"";

      $customer_result = $mysqli->query($select_fname);

      $customer = $customer_result->fetch_assoc();

        $cId = $customer['id'];

        


      $insert_purchase = "INSERT INTO purchase(customer_id, order_date) values($cId,NOW())";

      if(! $mysqli->query($insert_purchase)){
        echo "Database error";
      }
      $purchase_id = $mysqli->insert_id;

      $cart = json_decode($_POST["cart_data"], true);

      print_r($cart);

      foreach($cart as $key => $item){


        $select_product = "SELECT id FROM product WHERE name=\"$key\"";
        echo $select_product;

        if(! $product_results = $mysqli->query($select_product)){
            echo "have a problem";
        }

        $product = $product_results->fetch_assoc();

        $product_id = $product['id'];

        $insert_line_item = "INSERT INTO line_item (product_id, quantity, purchase_id)".
          "VALUES ($product_id, $item, $purchase_id)";

          echo $insert_line_item;
          $mysqli->query($insert_line_item);

      }

      echo "purchase ID: $purchase_id<br>";

    } else { //this is a get, just display a products
      $products = '[';
      $get_products_query = "SELECT * FROM product";

      $results = $mysqli->query($get_products_query);
    
      while ($row = $results->fetch_assoc()) {
      
    // echo ("product: " . $row['name'] . '<br>');
      $products .= "{sku: \"{$row['sku']}\", name:\"{$row['name']}\", category:\"{$row['category']}\"}";
        }
          $products .= '];';
  // echo $products;


    }
    
    // echo $mysqli->host_info . "\n";
    
?>


<!DOCTYPE html> 
<html>

<head>
  <title></title>
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="handlebars-v1.3.0.js"></script>
  <script type="text/javascript" src="default_products.js"></script>
  <script src="brad.js"></script>
  <link rel="stylesheet" href="one.css">

  <script type="text/javascript">
var default_products = <?php echo $products; ?>

  </script>
   
</head>

<body>
  <div id="main">   

    <header>
    <div id="strapline">

<!-- 
    <a href="/" class="logo"><i class="fa fa-cutlery"></i></a> -->
      <button id="icon-cart" href="/" ><i class="fa fa-shopping-cart"></i></button>

      
      </div><!--close strapline-->  
     <nav>
      <div id="menubar">
          <ul id="nav">
            <li class="current"><a href="index.html">Home</a></li>
            <li><a href="ourwork.html">Our Work</a></li>
            <li><a href="testimonials.html">Testimonials</a></li>
          
            <li><a href="contact.html">Contact Us</a></li>
          </ul>
        </div><!--close menubar-->  
      </nav>



      </header>  

   <main>

    <div class="bought"> Cart <br><button class="removeAll"> Remove All</button>
    <ul class="cart"></ul>

    </div>





      <div class="main-content">
  <h3>main content</h3>





  <!--  handlebar -->



  <div class="masterCat">

  <script id="catalog" type="text/x-hendalbars-template">
  {{#each this}}
    <div class="Products">
    
      <div class="{{name}}">
        <img class="view" src={{thumbnail}} alt="item">
        <div class="name">{{name}}</div>
        <div class="sku">{{sku}}</div>
        <div class="description">Description: {{description}}</div>
        <div class="price">${{price}}</div>
        <button class="addItem">Add to Cart</button>
      </div>
      </div>
    {{/each}}

      


  </script>
  </div>
              
  </main>
       
</div>


        <footer>
    <a href="index.html">Home</a> | <a href="ourwork.html">Our Work</a> | <a href="contact.html">Contact</a><br/><br/>
    <a href="http://fotogrph.com">Images</a> 
    </footer> 




<div class="customerInfo">
    <form action="" method="POST">
      <input type="hidden" name="cart_data" id="cart_data" value="default">
      <button type="submit">place order</button>
    </form>
</div>  

</body>
</html>
        

     



