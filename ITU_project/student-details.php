<?php
/**
 * A variation of the table is used in all our components so we worked on the backend for it together
 * @author xvorob02
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="draft-schedule.css">
</head>
<body>
    <section class="center-content">
        <div class="details"  id="edit" v-cloak>
            <?php require_once('sidebar.php');?>
            <section class = "persona">
                <h1>Osobní informace</h1>
                <div class="personal-info">
                    <div class="user-info">
                        <img src="images/person.jpg" alt="Profilová fotka">
                    </div>
                    <div class="student-info">
                        <h2>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="name">
                            <span v-else>{{ name }}</span>
                        </div>
                        </h2>
                        <p>
                        </p>
                        <strong>Email: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="email">
                            <span v-else>{{ email }}</span>
                        </div>
                        </p>
                        <strong>Rok narozeni: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="birthday">
                            <span v-else>{{ birthday }}</span>
                        </div>
                        </p>
                        <strong>Tel. cislo: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="tel">
                            <span v-else>{{ tel }}</span>
                        </div>
                        </p>
                        <strong>Heslo: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="passwd">
                            <span v-else>*****</span>
                        </div>
                        </p>
                    </div>
                </div>
                <div class="error-message" v-if="errorMessage">
                    {{ errorMessage }}
                </div>  
                <div class="edit-button" @click="toggleEdit" v-if="!showSaveCancelButtons">
                    Upravit údaje
                </div>   
                <div class="edit-button" @click="saveEdit" v-if="showSaveCancelButtons">
                    Uložit
                </div>             
                <div class="edit-button" @click="cancelEdit" v-if="showSaveCancelButtons">
                    Zrušit
                </div> 
            </section>                    
        </div>
    </section>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        let edit = Vue.createApp({
            data: function() {
                return {
                    errorMessage: null,
                    osobni_cislo: '',
                    originalName: '',
                    originalEmail: '',
                    originalBirthday: '',
                    originalTel: '',
                    name: '',
                    email: '',
                    passwd: '',
                    birthday: '',
                    tel: '',
                    isEditable: false,
                    showSaveCancelButtons: false,
                    showRegistrations: false,
                    showPersonalRequirements: false,
                    showActivityRequirements: false,
                    showManageUsers: false,
                    showManageCourses: false,
                    showManageRooms: false,
                    SideBarLook: []
                }
            },
            computed: {
                buttonText() {
                    return this.isEditable ? 'Zavřít úpravy' : 'Upravit údaje';
                },
            },
            methods: {
                checkLoggedIn(){
                    if(!document.cookie.includes("PHPSESSID")){
                        console.log("Not logged in");
                        window.location.href = "index.php";
                        return 0;
                    }
                    return 1;
                },
                adjustSidebar(){
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
                            // Update the user information based on the API response
                            if(resp.resCode == '0') {
                                switch(resp.rights){
                                    case 0: 
                                        //student
                                        this.showRegistrations = true;
                                        break;
                                    case 1: 
                                        //vyuc
                                        this.showRegistrations = this.showPersonalRequirements = true;
                                        break;
                                    case 2: 
                                        //rozvrh
                                        this.showRegistrations = this.showPersonalRequirements = this.showActivityRequirements = true;
                                        break;
                                    case 3: 
                                        //garant
                                        this.showRegistrations = this.showPersonalRequirements = this.showActivityRequirements = true;
                                        break;
                                    case 4: 
                                        //admin
                                        this.showManageCourses = this.showManageRooms = this.showManageUsers = true;
                                        break;
                                }
                            } else {
                                console.error('Error fetching user info!');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching user info', error);
                        });
                },
                toggleEdit() {
                    this.isEditable = true;
                    this.showSaveCancelButtons = true;
                },
                saveEdit() {
                    if (this.name == '' || this.email == '' || this.birthday == '' || this.tel == '') {
                        this.errorMessage = 'Nevplněné informace!'
                        return
                    }
                    this.isEditable = false;
                    this.showSaveCancelButtons = false;
                    this.originalName = this.name
                    this.originalEmail = this.email
                    this.originalBirthday = this.birthday
                    this.originalTel = this.tel

                    const postData = new URLSearchParams();
                    var nameParts = this.name.split(' ');

                    if (nameParts.length === 2) {
                        var name = nameParts[0];
                        var surname = nameParts[1];
                    } else {
                        var name = fullName;
                        var surname = '';
                    }
                    postData.append('request', 'updateProfile');
                    postData.append('osobni_cislo', this.osobni_cislo);
                    postData.append('name', name);
                    postData.append('surname', surname);
                    postData.append('email', this.email);
                    postData.append('rok_narozeni', this.birthday);
                    postData.append('tel', this.tel);
                    postData.append('passwd', this.passwd);
                    this.errorMessage = null
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
                                alert('Updated');
                            } else {
                                this.cancelEdit()
                                alert('ERROR!');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching user info', error);
                        });
                },
                cancelEdit() {
                    this.isEditable = false;
                    this.showSaveCancelButtons = false;
                    this.errorMessage = null
                    this.name = this.originalName
                    this.email = this.originalEmail
                    this.birthday = this.originalBirthday
                    this.tel = this.originalTel
                },
                fetchUserInfo() {
                    const postData = new URLSearchParams();
                    postData.append('request', 'profileDetails');
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
                                var data = resp.data
                                this.name = data[0].name + ' ' + data[0].surname;
                                this.email = data[0].email;
                                this.birthday = data[0].rok_narozeni;
                                this.tel = data[0].tel;
                                this.prava = data[0].prava;
                                this.SideBarLook = data.SideBarLook;

                                this.originalName = this.name;
                                this.originalEmail = this.email;
                                this.originalBirthday = this.birthday;
                                this.originalTel = this.tel;
                            } else {
                                console.error('Error fetching user info!');
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
                // Fetch user information when the component is mounted
                if(this.checkLoggedIn()){
                    this.adjustSidebar();
                    this.fetchUserInfo();
                };
                
            },
        })
        edit.mount('#edit')
    </script>
</body>
</html>