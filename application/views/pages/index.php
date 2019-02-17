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

        <article ng-if="loggedIn == true && adminPage == false">

            <button class="dashboard-admin-btn" type="button" ng-if="user.role_id == 1" ng-click="toAdmin();">ADMIN PAGE</button>
            <button class="dashboard-logout-btn" type="button" ng-click="logout();">LOG OUT</button>
            <a ng-show="lists.length == 0" href="#" ng-click="createList();"><i class="fas fa-plus"></i></a>

            <figure class="dashboard-list" ng-repeat="x in lists track by $index">
                <ul class="dashboard-list-container">
                    <li class="dashboard-list-upper-content">
                        <a href="#" class="dashboard-delete-list-btn" ng-click="deleteList(x.id);"><i class="fas fa-minus"></i></a>
                        <a href="#" class="dashboard-add-list-btn" ng-click="createList();"><i class="fas fa-plus"></i></a>
                        <p class="dashboard-list-title" ng-blur="updateListTitle(x, $event);" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" ng-bind="x.name" contenteditable="true"></p>
                        <button class="dashboard-list-complete-btn" ng-click="filterDone($index);">DONE</button>
                        <button class="dashboard-list-time-btn" ng-click="filterTime($index);">TIME</button>
                    </li>

                    <li class="dashboard-list-lower-content" ng-repeat="q in x.content | orderBy : typeFilter[$index] : reverseFilter[$index]">
                        <input class="dashboard-list-checkbox" type="checkbox" ng-click="acceptListItem(q, $event);" ng-if="q.done == 1" checked>
                        <input class="dashboard-list-checkbox" type="checkbox" ng-click="acceptListItem(q, $event);" ng-if="q.done == 0">
                        <p class="dashboard-list-time" ng-class="{'dashboard-list-item-done' : q.done == 1}">(<span ng-blur="updateListItemTime(q, $event);" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true">{{ q.duration }}</span> min)</p>
                        <p class="dashboard-list-item" ng-class="{'dashboard-list-item-done' : q.done == 1}" ng-blur="updateListItem(q, $event)" onkeydown="if(event.keyCode==13){ $(this).blur(); return false;}" contenteditable="true" ng-bind="q.name"></p>
                        <a href="#" class="dashboard-delete-item-btn" ng-click="deleteListItem(q.id, q.list_id);"><i class="fas fa-minus"></i></a>
                    </li>

                    <li class="dashboard-add-item-btn" ng-click="createListItem(x.id)" contenteditable="false"><i class="fas fa-plus"></i></li>
                </ul>
            </figure>

        </article>

        <article ng-if="loggedIn == true && user.role_id == 1 && adminPage == true">

            <button class="dashboard-dashboard-btn" type="button" ng-click="toDashboard();">DASHBOARD</button>
            <button class="dashboard-logout-btn" type="button" ng-click="logout();">LOG OUT</button>

            <figure class="admin-list">
                <ul class="admin-user-container">
                    <li class="admin-user-upper-content">
                        <p>All Users</p>
                    </li>

                    <li class="admin-user-middle-content" ng-repeat="x in users">
                        <input class="admin-user-checkbox" type="checkbox" ng-click="adminToggle(x);" ng-if="x.role_id == 1" checked>
                        <input class="admin-user-checkbox" type="checkbox" ng-click="adminToggle(x);" ng-if="x.role_id == 2">
                        <p class="admin-user-username" ng-bind="x.username" ng-click="showUserList(x.id);"></p>
                    </li>
                </ul>
            </figure>

        </article>

    </section>

</main>
