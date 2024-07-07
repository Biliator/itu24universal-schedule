<!DOCTYPE html>
<!-- 
    @author xkanko01
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="draft-schedule.css">
</head>
<body>
    <div class="page" id="app" v-cloak>
        <?php require_once('sidebar.php'); ?>
        <section class = "right-side">
            <button class="registration-button" @click="register" >
                <a href="#">{{registerButton}}</a>
            </button>
                <div class="table-container-registration">
                    <h3>Zimní semestr</h3>
                    <table border="0">
                        <thead>
                            <tr>
                                <th width="100">Zkratka</th>
                                <th width="270">Název</th>
                                <th width="5">Kr.</th>
                                <th width="70">Fak.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="subject in subjects" :key="subject.zkratka">
                                <td @click="goToClassDetails(subject.zkratka)">{{ subject.zkratka }}</td>
                                <td @click="goToClassDetails(subject.zkratka)">{{ subject.nazev }}</td>
                                <td @click="goToClassDetails(subject.zkratka)">{{ subject.kredity }}</td>
                                <td @click="goToClassDetails(subject.zkratka)">{{ subject.fakulta }}</td>
                                <td class="last-column">
                                    <input 
                                    type="checkbox" 
                                    v-model="subject.enroll" 
                                    @change="handleEnrollChange(subject)"
                                    :checked="subject.is_registered === 1">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </section>
    </div>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script>
        let app = Vue.createApp({
            data: function() {
                return {
                    subjects: [],
                    checkedRows: [],
                    uncheckedRows: [],
                    SideBarLook: [],
                    registerButton: "Registrovat"
                };
            },
            methods: {
                loadSubjects() {
                    const postData = new URLSearchParams();
                    postData.append('request', 'getCurrentClasses');
                    postData.append('rocnik', '2');
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
                            console.log(resp)
                            if(resp.resCode === '0') {
                                this.checkedRows = resp.data.filter(subject => subject.is_registered === 1);
                                this.subjects = resp.data;
                            } else {
                                console.error('Error fetching subjects!');
                            }
                        })
                        .catch((error, resp) => {
                            console.error('Error fetching subjects', error.message);
                        });
                },
                goToClassDetails(zkratka) {
                    console.log(zkratka)
                    window.location.href = `class-details.html?zkratka=${zkratka}`;
                },
                register() {
                    this.registerButton = "Registrování...";
                    const postData = new URLSearchParams();
                    this.uncheckedRows = this.subjects.filter(subject => !subject.enroll);
                    postData.append('uncheckedRows', JSON.stringify(this.uncheckedRows));
                    postData.append('request', 'register');
                    postData.append('login', 'xkanko00');
                    postData.append('checkedRows', JSON.stringify(this.checkedRows));
                    console.log(this.checkedRows)
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
                            console.log(resp)
                            if(resp.resCode === '0') {
                                this.registerButton = "Registrován!";
                                setTimeout(() => {
                                this.registerButton = "Registrovat";
                                }, 3000);
                            } else {
                                console.error('Error fetching subjects!');
                            }
                        })
                        .catch((error, resp) => {
                            console.error('Error fetching subjects', error.message);
                        });
                },
                handleEnrollChange(subject) {
                    console.log(`Enroll ${subject.zkratka}: ${subject.enroll}`);
                    const index = this.checkedRows.findIndex(row => row.zkratka === subject.zkratka);

                    if (subject.enroll && index === -1) {
                        this.checkedRows.push(subject);
                    } else if (!subject.enroll && index !== -1) {
                        this.checkedRows.splice(index, 1);
                    }
                },
                fetchUserInfo(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'SideBarLook');

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
                            this.SideBarLook = resp.SideBarLook;
                        } else {
                            console.error('Error fetching user info');
                        }
                    })
                    .catch((error) => {
                        console.error('Error fetching user info', error);
                    });
                },
                logout(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'logout');
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
                        // Update the user information based on the API response
                        if(resp.resCode == '0') {
                            window.location.href = "index.php";
                        } else {
                            console.error('Error logging out');
                        }
                    })
                    .catch((error) => {
                        console.error('Error logging out', error);
                    });
                },
            },
            mounted() {
                this.fetchUserInfo();
                this.loadSubjects();
            },
        }).mount('#app')
    </script>
</body>
</html>
