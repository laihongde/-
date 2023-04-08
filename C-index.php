<?php

include 'db_conn.php';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:C-login.php');
};

if (isset($_GET['logout'])) {
   unset($user_id);
   session_destroy();
   header('location:C-login.php');
};

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($select_cart) > 0) {
      $message[] = 'product already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }
};

if (isset($_POST['update_cart'])) {
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if (isset($_GET['remove'])) {
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:C-index.php');
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:C-index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- 清理緩存 -->
   <meta http-equiv="cache-control" content="no-cache">
   <meta http-equiv="pragma" content="no-cache">
   <meta http-equiv="expires" content="0">
   <title>蔬菜販賣</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style-1.css">

</head>

<body style="background: url('img/bg.jpg'<?php  "?" . time();?>);
    center center fixed no-repeat;
    background-size: cover;
    height: 100%;
    width: 100%;
    ">

   <?php

   if (isset($message)) {
      foreach ($message as $message) {
         echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
      }
   }
   ?>

   <div class="container">

      <div class="user-profile">

         <?php
         $select_user = mysqli_query($conn, "SELECT * FROM `user_info` WHERE id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($select_user) > 0) {
            $fetch_user = mysqli_fetch_assoc($select_user);
         };
         ?>

         <p> 顧客名稱 : <span><?php echo $fetch_user['name']; ?></span> </p>
         <p> 電話 : <span><?php echo $fetch_user['tel']; ?></span> </p>
         <div class="flex">
            <a href="C-login.php" class="option-btn">重新登入</a>
            <a href="home.html?logout=<?php echo $user_id; ?>" onclick="return confirm('are your sure you want to logout?');" class="delete-btn">登出</a>
         </div>

      </div>

      <div class="products">

         <h1 class="heading">產品</h1>

         <div class="box-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_product) > 0) {
               while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                  <form method="post" class="box" action="">
                     <img src="img/<?php echo $fetch_product['image'] . "?" . time(); ?>" alt="">
                     <div class="name"><?php echo $fetch_product['name']; ?></div>
                     <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                     <input type="number" min="1" name="product_quantity" value="1">
                     <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                     <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                     <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                     <input type="submit" value="加到購物車" name="add_to_cart" class="btn">
                  </form>
            <?php
               };
            };
            ?>

         </div>

      </div>

      <div class="shopping-cart">

         <h1 class="heading">購物車</h1>

         <table>
            <thead>
               <th>圖片</th>
               <th>種類</th>
               <th>單價</th>
               <th>數量</th>
               <th>總金額</th>
               <th>取消</th>
            </thead>
            <tbody>
               <?php
               $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $grand_total = 0;
               if (mysqli_num_rows($cart_query) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
               ?>
                     <tr>
                        <td><img src="img/<?php echo $fetch_cart['image'] . "?" . time(); ?>" height="100" alt=""></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>$<?php echo $fetch_cart['price']; ?>/-</td>
                        <td>
                           <form action="" method="post">
                              <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                              <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                              <input type="submit" name="update_cart" value="修改" class="option-btn">
                           </form>
                        </td>
                        <td>$<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                        <td><a href="C-index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">移除</a></td>
                     </tr>
               <?php
                     $grand_total += $sub_total;
                  }
               } else {
                  echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
               }
               ?>
               <tr class="table-bottom">
                  <td colspan="4">累計 :</td>
                  <td>$<?php echo $grand_total; ?>/-</td>
                  <td><a href="C-index.php?delete_all" onclick="return confirm('delete all from cart?');" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">刪除全部</a></td>
               </tr>
            </tbody>
         </table>

         <div class="cart-btn">
            <a href="#" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">下訂</a>
         </div>

      </div>

   </div>

</body>

</html>