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

            <button class="dashboard-logout-btn" type="button" ng-click="logout();">LOG OUT</button>
            <a ng-show="lists.length == 0" href="#" ng-click="createList();"><i class="fas fa-plus"></i></a>

            <figure class="dashboard-list" ng-repeat="x in lists">
                <ul class="dashboard-list-container">
                    <li class="dashboard-list-upper-content">
                        <a href="#" class="dashboard-delete-list-btn" ng-click="deleteList(x.id);"><i class="fas fa-minus"></i></a>
                        <a href="#" class="dashboard-add-list-btn" ng-click="createList();"><i class="fas fa-plus"></i></a>
                        <p class="dashboard-list-title" ng-blur="updateListTitle(x, $event);" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" ng-bind="x.name" contenteditable="true"></p>
                    </li>

                    <li>
                        <button></button>
                        <button></button>
                    </li>

                    <li class="dashboard-list-lower-content" ng-repeat="q in x.content">
                        <input class="dashboard-list-checkbox" type="checkbox" ng-click="acceptListItem(q, $event);" ng-if="q.done == 1" checked>
                        <input class="dashboard-list-checkbox" type="checkbox" ng-click="acceptListItem(q, $event);" ng-if="q.done == 0">
                        <p class="dashboard-list-item" ng-class="{'dashboard-list-item-done' : q.done == 1}" ng-blur="updateListItem(q, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="q.name"></p>
                        <a href="#" class="dashboard-delete-item-btn" ng-click="deleteListItem(q.id, q.list_id);"><i class="fas fa-minus"></i></a>
                    </li>

                    <li class="dashboard-add-item-btn" ng-click="createListItem(x.id)" contenteditable="false"><i class="fas fa-plus"></i></li>
                </ul>
            </figure>

        </article>

    </section>

</main>
