<!DOCTYPE html>
<!-- 
    @author xkanko01
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Návrh rozvrhu</title>
    <link rel="stylesheet" href="draft-schedule.css">
    <style>
        /* Use Flexbox for layout */
        .form-container {
            display: flex;
            flex-direction: row;
        }
    
        .form-col {
            display: flex;
            flex-direction: column;
        }
    
        .form-col label {
            margin-right: 10px;
        }
    
        .form-col input {
            width: 5vw;
            margin-right: 10px;
            flex: 1;
        }
        .clickable-row {
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .clickable-row:hover {
            background-color: #E0E2EE; /* Change the background color on hover */
        }
      </style>
</head>
<body>
<div class="main" id ="main" v-cloak>
        <div class="user">
            <?php require_once('sidebar.php');?>
            <section class = "persona">
                <div style="margin: 1%;">
                <h1>Správa Garantovaných předmětů</h1>
                
                <h2>Garantované předměty</h2>
                <table border="1" style="width: 100%; margin: 5%;">
                <thead>
                    <tr>
                        <th width="10%">Zkratka</th>
                        <th width="40%">Název</th>
                        <th width="10%">Kredity</th>
                        <th width="15%">Semestr</th>
                        <th width="15%">Fakulta</th>
                        <th width="10%">Ročník</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(course, index) in courses" :key="index" @click="fetchClassActivities(course.short)" class="clickable-row">
                       <td>{{course.short }}</td>
                       <td>{{course.name}}</td>
                       <td>{{course.credits}}</td>
                       <td>{{course.semester}}</td>
                       <td>{{course.faculty}}</td>
                       <td>{{course.year}}</td>
                    </tr>
                </tbody>
                </table>
                <h2>Správa aktivit {{selectedClass}}</h2>
                <table border="1" style="width: 100%; margin: 5%;">
                    <thead>
                        <tr>
                            <th width="20%">Nazev</th>
                            <th width="5%">Den</th>
                            <th width="10%">Cas</th>
                            <th width="10%">Trvani</th>
                            <th width="5%">Typ</th>
                            <th width="10%">Místnost</th>
                            <th width="15%">Vyučující</th>
                            <th width="25%">Požadavek</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(activity, index) in activities" :key="index" class="clickable-row">
                        <td>{{ activity.name }}</td>
                        <td>{{ activity.day }}</td>
                        <td>{{ activity.time }}</td>
                        <td>{{ activity.length }}</td>
                        <td>{{ activity.type }}</td>
                        <td>{{ activity.room }}</td>
                        <td>{{ activity.teacher }}</td>
                        <td>{{ activity.request }}</td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="showAddNew" style="padding-bottom: 20%;">
                <h2>Přidat aktivitu do {{ selectedClass }}</h2>
                <form class="form-container" @submit.prevent="newActivity">
                    <div class="form-col">
                    <label for="newName">Nazev</label>
                    <input v-model="newName" id="newName" required>
                    </div>
                    <div class="form-col">
                        <label for="newLength">Trvani</label>
                        <input v-model="newLength" id="newLength" type="number" min="0" max="24" required>
                    </div>
                    <div class="form-col">
                        <label for="newType">Typ</label>
                        <input v-model="newType" id="newType" type="number" min="0" max="3" required>
                    </div>
                    <div class="form-col">
                        <label for="newRequest">Pozadavky</label>
                        <input v-model="newRequest" id="newRequest" type="text" required>
                    </div>
                    <div class="form-col" style="align-self: self-end;">
                        <input type="submit">
                    </div>
                </form>
                </div>
            </section>
        </div>
    </div>
    

    <script src="https://unpkg.com/vue@next"></script>
    <script>
        let app = Vue.createApp({
            data() {
                return {
                    SideBarLook: [],
                    courses: [],
                    activities: [],
                    showAddNew: true,
                    selectedClass: "",
                    newName: "",
                    newLength: "",
                    newType: "",
                    newRequest: "",
                }
            },
            methods: {
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
                fetchClassActivities(classShort){
                    this.activities = {};
                    this.selectedClass = classShort;
                    const postData = new URLSearchParams();
                    postData.append('request', 'getClassActivities');
                    postData.append('class', classShort);
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
                            console.log(resp);
                            if(resp.resCode == '0') {                   
                                var data = resp["activities"];
                                for(var i = 0; data[i] != null; i++){
                                    console.log(i);
                                    this.activities[i] = {id: i, name: data[i]["nazev"], day: data[i]["den"], time: data[i]["cas"], length: data[i]["delka"], type: data[i]["typ"], room: data[i]["mistnost"], teacher: data[i]["vyucujici"], request: data[i]["pozadavek"]};
                                }

                            } else {
                                console.error('Error fetching rooms!');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching rooms', error);
                        });
                },
                fetchGarantedClasses(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'getGarantedClasses');
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
                            console.log(resp);
                            if(resp.resCode == '0') {
                                var data = resp.data1;
                                var i, j, k;
                                for(i = 0; data[i] != null; i++){
                                    this.courses[i] = {id: i, short: data[i]["zkratka"], name: data[i]["nazev"], credits: data[i]["kredity"], semester: data[i]["semestr"], faculty: data[i]["fakulta"], year: data[i]["rocnik"]};
                                }
                                j = i;
                                var data = resp.data2;
                                for(i = 0; data[i] != null; i++){
                                    this.courses[i + j] = {id: i + j, short: data[i]["zkratka"], name: data[i]["nazev"], credits: data[i]["kredity"], semester: data[i]["semestr"], faculty: data[i]["fakulta"], year: data[i]["rocnik"]};
                                }
                                k = j;
                                for(i = 0; data[i] != null; i++){
                                    this.courses[i + k] = {id: i + k, short: data[i]["zkratka"], name: data[i]["nazev"], credits: data[i]["kredity"], semester: data[i]["semestr"], faculty: data[i]["fakulta"], year: data[i]["rocnik"]};
                                }
                            } else {
                                console.error('Error fetching rooms!');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching rooms', error);
                        });
                },
                newActivity(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'addActivity');
                    postData.append('class', this.selectedClass);
                    postData.append('name', this.newName);
                    postData.append('length', this.newLength);
                    postData.append('type', this.newType);
                    postData.append('requests', this.newRequest);
                    
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
                            console.log(resp);
                            if(resp.resCode == '0') {
                                this.fetchClassActivities(this.selectedClass);                                
                            } else {
                                console.error('Error!');
                            }
                        })
                        .catch((error) => {
                            console.error('CAUGHT Error', error);
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
            mounted(){
                this.fetchUserInfo();
                this.fetchGarantedClasses();
            }
        })
        app.mount('#main')
    </script>

</body>
</html>