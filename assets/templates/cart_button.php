<style>
    /* Add custom styles for the floating cart button */
    .float-cart {
        position: fixed;
        bottom: 20px; /* Adjust the distance from the bottom as needed */
        right: 20px; /* Adjust the distance from the right as needed */
    }

    .float-cart a {
        background-color: #007BFF; /* Customize the background color */
        color: #fff; /* Customize the text color */
        border-radius: 50%;
        text-align: center;
        width: 50px; /* Adjust the button size as needed */
        height: 50px; /* Adjust the button size as needed */
        line-height: 50px;
        font-size: 24px;
        display: block;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .float-cart a:hover {
        background-color: #0056b3; /* Customize the background color on hover */
    }

    /* Add custom styles for the cart count */
    .float-cart .cart-count {
        position: absolute;
        top: 0;
        right: 0;
        background-color: red; /* Customize the background color of the count */
        color: #fff; /* Customize the text color of the count */
        border-radius: 50%;
        width: 20px; /* Adjust the count badge size as needed */
        height: 20px; /* Adjust the count badge size as needed */
        font-size: 14px;
        line-height: 20px;
    }
</style>

<div class="float-cart">
    <a href="../cart" class="float" >
        <i class="fa fa-shopping-cart my-float"></i>
        <span class="cart-count"><?php echo $cartCount; ?></span>
    </a>
</div>
