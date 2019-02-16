<main class="page-wrapper" ng-controller="LoginController">

    <section class="page-container">

        <article>

            <figure>
                <img class="login-logo" src="<?php echo base_url(); ?>assets/img/login-logo.png" alt="loginlogo" />

                <form action="" method="" name="logins">
                    <figure class="login-form-section">
                        <label for="email-login"><i class="login-input-logo fas fa-envelope"></i></label>
                        <input class="login-input" type="email" placeholder="Email">
                    </figure>

                    <figure class="login-form-section">
                        <label for="password-login"><i class="login-input-logo fas fa-lock"></i></label>
                        <input class="login-input" type="password" placeholder="Password">
                    </figure>

                    <button class="login-login-btn" type="submit" ng-click="login();">LOG IN</button>
                    <a class="login-register-btn" href="#" ng-click="toRegister();">Register here</a>
                </form>
            </figure>

        </article>

    </section>

</main>
