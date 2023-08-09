<?php
 $name = $_POST['name'];
 $number = $_POST['number'];
 $email = $_POST['email'];
 $method = $_POST['method'];
 $flat = $_POST['flat'];
 $street = $_POST['street'];
 $city = $_POST['city'];
 $county = $_POST['county'];
 $pin_code = $_POST['pin_code'];
include_once('../assets/product-page-temp/product-header.php');
?>

<div class="container4">
    <section class="checkout-form">
        <div class='modal-overlay'>
            <div class='modal-dialog'>
                <div class='message-container'>
                    <h3>Thank you for shopping!</h3>
                    <div class='order-detail'>
                        <span><?php echo $total_product; ?></span>
                        <span class='total'> total: KES <?php echo $grand_total; ?>/- </span>
                    </div>
                    <div class='customer-details'>
                        <p>your name: <span><?php echo $name; ?></span></p>
                        <p>your number: <span><?php echo $number; ?></span></p>
                        <p>your email: <span><?php echo $email; ?></span></p>
                        <p>your address: <span><?php echo $flat.", ".$street.", ".$city.", ".$county.", ".$pin_code; ?></span></p>
                        <p>your payment mode: <span><?php echo $method; ?></span></p>
                        <p>(*pay when product arrives*)</p>
                    </div>
                    <a href='../user-profile' class='btn'>Track Order</a>
                    <a href='../products' class='btn'>Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
include_once('../assets/cart-temp/cart-footer.php');
?>
