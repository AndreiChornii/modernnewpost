        <form class="auth" action="/login" method="POST">
            <fieldset>
                <legend>Login</legend>
                <p><?= $error ? $error : '' ?></p>
                <div class="auth__row">
                    <label for="username">User name</label>
                    <input name="login" class="auth__text" type="text" id="username">
                </div>
                
                <div class="auth__row">
                    <label for="useremail">User email</label>
                    <input name="email" class="auth__text" type="text" id="useremail">
                </div>
                
                <div class="auth__row">
                    <button type="submit" id="sendbtn" class="auth__btn">Login</button>
                </div>
            </fieldset>
        </form>