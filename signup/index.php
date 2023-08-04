<?php include_once('../assets/product-page-temp/product-header.php') ?>

 <!-- sign up -->
 <div class="container">
      <div class="login-form">
        <form action="">
          <h1>Sign Up</h1>
          <p>
            Please fill in this form to create an account. or
            <a href="../login">Login</a>
          </p>

          <label for="email">Email</label>
          <input type="text" placeholder="Enter Email" name="email" required />

          <label for="psw">Password</label>
          <input
            type="password"
            placeholder="Enter Password"
            name="psw"
            required
          />

          <label for="psw-repeat">Repeat Password</label>
          <input
            type="password"
            placeholder="Repeat Password"
            name="psw-repeat"
            required
          />

          <label>
            <input
              type="checkbox"
              checked="checked"
              name="remember"
              style="margin-bottom: 15px"
            />
            Remember me
          </label>

          <p>
            By creating an account you agree to our
            <a href="#">Terms & Privacy</a>.
          </p>

          <div class="buttons">
            <button type="button" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
    <?php include_once('../assets/cart-temp/cart-footer.php') ?>