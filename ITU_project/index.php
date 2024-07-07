<!DOCTYPE html>
<!-- 
    @author xkanko01
    @author xvorob02
    @author xbabus01
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div id="login" v-clock>
        <div class="login">
            <form>
                <p>Login:</p>
                <input type="text" id="loginID" name="loginID" required placeholder="Přihlašovací jméno" v-model="loginID">
                <p>Password:</p>
                <input type="password" id="password" name="password" required placeholder="Heslo" v-model="password">
                <div class="remember-me">
                    <label for="rememberMe">Pokud nemáš účet tak můžeš procházet předměty</label>
                </div>
                <div class="log-in">
                    <button v-on:click="fetchUserInfo">Log-in</button>
                </div>
            </form>
                <div class="guest">
                    <button v-on:click="gotoAnnotations"> Pokračovat bez přihlášení</button>
                </div>
                <div v-if="errorMessage" class="error-message">
                    {{ errorMessage }}
                </div>
        </div>  
    </div>
     
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        let login = Vue.createApp({
            data: function() {
                return {
                    loginID: 'xkanko01',
                    password: 'kanko',
                    errorMessage: '',
                }
            },
            methods: {
                fetchUserInfo() {
                    if (this.loginID == '' || this.password == '') {
                        this.errorMessage = 'Nevyplněné přihlašovací informace!'
                        return
                    }
                    const postData = new URLSearchParams();
                    postData.append('request', 'login');
                    postData.append('loginID', this.loginID);
                    postData.append('password', this.password);

                    fetch('be.php', {
                        method: 'POST',
                        body: postData,
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then((data) => {
                            if(data.resCode == '0') {
                                window.location.href = `student-details.php`;
                            } else {
                                this.errorMessage = 'Nesrávné přihlašovací informace!'
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching user info', error);
                        });
                },
                gotoAnnotations() {
                    window.location.href = `anotacion.html`;
                },
                checkSession(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'getUserRights');
                    fetch('be.php', {
                        method: 'POST',
                        body: postData,
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then((resp) => {
                            if(resp.resCode == '0') {
                                window.location.href = "student-details.php";
                            } else {
                                console.log('Not logged in');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching user info', error);
                        });
                },
            },
            mounted(){
                this.checkSession();
            }
        }) 
        login.mount('#login')
    </script>
</body>
</html>
