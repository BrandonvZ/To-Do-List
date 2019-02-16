<main class="page-wrapper" ng-controller="LoginController">

    <section class="page-container">

        <article>

            <figure ng-if="loggedIn == false && registerIn == false">
                <img class="login-logo" src="<?php echo base_url(); ?>assets/img/login-logo.png" alt="loginlogo" />

                <form action="" method="" name="logins">
                    <figure class="login-form-section">
                        <label for="email-login"><i class="login-input-logo fas fa-envelope"></i></label>
                        <input class="login-input" type="email" placeholder="Email" ng-model="login.email">
                    </figure>

                    <figure class="login-form-section">
                        <label for="password-login"><i class="login-input-logo fas fa-lock"></i></label>
                        <input class="login-input" type="password" placeholder="Password" ng-model="login.password">
                    </figure>

                    <button class="login-login-btn" type="button" ng-click="login();">LOG IN</button>
                    <a class="login-register-btn" href="#" ng-click="toRegister();">Register here</a>
                </form>
            </figure>

            <figure ng-if="loggedIn == false && registerIn == true">
                <img class="login-logo" src="<?php echo base_url(); ?>assets/img/login-logo.png" alt="loginlogo" />

                <form action="" method="" name="registers">
                    <figure class="login-form-section">
                        <label for="email-login"><i class="login-input-logo fas fa-envelope"></i></label>
                        <input class="login-input" type="email" placeholder="Email" ng-model="register.email">
                    </figure>

                    <figure class="login-form-section">
                        <label for="password-login"><i class="login-input-logo fas fa-lock"></i></label>
                        <input class="login-input" type="password" placeholder="Password" ng-model="register.password">
                    </figure>

                    <button class="login-login-btn" type="button" ng-click="register();">REGISTER</button>
                    <a class="login-register-btn" href="#" ng-click="toLogin();">Go back</a>
                </form>
            </figure>

        </article>

        <article ng-if="loggedIn == true">

            <figure>


            </figure>

        </article>

    </section>

</main>
