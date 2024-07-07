<!DOCTYPE html>
<!-- 
    @author xkanko01
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osobní požadavky</title>
    <link rel="stylesheet" href="draft-schedule.css">
    <style>
        .yes, .no {
            cursor: pointer;
            /*prevent text selection*/
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
        }
        /* temp, do for all? */
        .right-side {
            font-weight: normal;
            font-size: 1vw;
            float: left;
            width: 80%;
            margin-left: 17%;
            margin-top: 2%;
            margin-bottom: 1%;
            height: 100%;
        }
        .schedule-button {
            margin: 0% 19%;
            display: inline-block;
            margin-right: 10px;
            width: 12%;
            height: 25px;
        }
    </style>
</head>
<body>
    <section class="center-content">
        <div id="app" v-cloak>
            <div class="details" >
                <?php require_once('sidebar.php'); ?>
                <timegrid v-bind:table = "table"/>
            </div>
            <div>
                <span class="schedule-button" @click = "fetchUserInfo">
                    Zrušit                    
                </span>  
                <span class="schedule-button" @click = "freeRequirements">
                    Vše volné                    
                </span>
                <span class="schedule-button" @click = "storeRequirements">
                    {{saveButton}}
                </span>  
            </div>  
        </div>
    </section>

    <script src="https://unpkg.com/vue@next"></script>
    <script>
        let app = Vue.createApp({
            data() {
                return {
                    saveButton: "Uložit",
                    table: [],
                    originalTable: [],
                    SideBarLook: []
                }
            },
            components: ['timegrid'],
            methods: {
                freeRequirements(){
                    console.log(this.table);
                    for(i = 0; i < 5; i++){
                        //start at 1 to skip day label
                        for(j = 1; j < 15; j++) this.table[i][j].value = true;
                    }
                },
                storeRequirements(){
                    this.saveButton = "Ukládaní...";
                    const postData = new URLSearchParams();
                    postData.append('request', 'storePersonalRequirements');
                    postData.append('requirements', JSON.stringify(this.table))

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
                            this.originalTable = this.table;
                            this.saveButton = "Uloženo!";
                            setTimeout(() => {
                                this.saveButton = "Uložit";
                            }, 3000);
                        } else {
                            console.error('Error saving info');
                        }
                    })
                    .catch((error) => {
                        console.error('Error saving info', error);
                    });
                },
                fetchUserInfo(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'getPersonalRequirements');

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
                            this.table = resp.table;
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
                }
            },
            mounted(){
                this.fetchUserInfo();
            }
        })
        app.component('timegrid', {
            template:`
            <section class = "right-side">
                <div class="grid-schedule">
                    <div class="grid-black"></div>
                    <div class="grid-day">7:00 - 7:50</div>
                    <div class="grid-day">8:00 - 8:50</div>
                    <div class="grid-day">9:00 - 9:50</div>
                    <div class="grid-day">10:00 - 10:50</div>
                    <div class="grid-day">11:00 - 11:50</div>
                    <div class="grid-day">12:00 - 12:50</div>
                    <div class="grid-day">13:00 - 13:50</div>
                    <div class="grid-day">14:00 - 14:50</div>
                    <div class="grid-day">15:00 - 15:50</div>
                    <div class="grid-day">16:00 - 16:50</div>
                    <div class="grid-day">17:00 - 17:50</div>
                    <div class="grid-day">18:00 - 18:50</div>
                    <div class="grid-day">19:00 - 19:50</div>
                    <div class="grid-day">20:00 - 20:50</div>
                </div>

                <div class="grid-schedule" v-for="(day) in table">
                    <template v-for="(timeBlock) in day">
                        <div v-if="timeBlock.day" class="grid-day">{{timeBlock.value}}</div>
                        <yes-no v-if="!timeBlock.day" v-model = "timeBlock.value"/>
                    </template>
                </div>

            </section>
            `,
            props: ['table'],
            components: ['yes-no'],
        });
        app.component('yes-no', {
            template:`
            <div @click="yes = !yes" class="no" v-if="!yes">
                <div>✗</div>
            </div>
            <div @click="yes = !yes" class="yes" v-if="yes">
                <div>✓</div>
            </div>
            `,
            props: ['modelValue'],
            computed: {
                yes: {
                    get(){
                        return this.modelValue
                    },
                    set(value){
                        this.$emit('update:modelValue', value)
                    }
                }
            }
        });
        app.mount('#app')
    </script>


</body>
</html>