<!DOCTYPE html>
<!-- 
    @author xbabus01
-->
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
            <section class = "persona">
                <h1>Osobní informace</h1>
                <div class="personal-info">
                    <div class="student-info">
                        <h2>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="name">
                            <span>{{ name }}</span>
                        </div>
                        </h2>
                        <p>
                        </p>
                        <strong>Email: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <input v-if="isEditable" v-model="email">
                            <span>{{ email }}</span>
                        </div>
                        </p>
                        <strong>Rok narozeni: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <span>{{ birthday }}</span>
                        </div>
                        </p>
                        <strong>Tel. cislo: </strong>
                        <div :contenteditable="isEditable" class="editme">
                            <span> {{ tel }}</span>
                        </div>
                        </p>
                    </div>
                </div> 
            </section>   
            <div class="details" >
                <timegrid v-bind:table = "table"/>
            </div>                 
        </div>
    </section>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        let edit = Vue.createApp({
            data: function() {
                return {
                    userId: '',
                    osobni_cislo: '',
                    name: '',
                    email: '',
                    passwd: '',
                    birthday: '',
                    tel: '',
                    requirements: '',
                    isEditable: false,
                    table: [],
                    originalTable: [],
                }
            },
            components: ['timegrid'],
            computed: {
                buttonText() {
                    return this.isEditable ? 'Zavřít úpravy' : 'Upravit údaje';
                },
            },
            methods: {
                fetchUserInfo() {
                    const urlSearchParams = new URLSearchParams(window.location.search);
                    const userId = urlSearchParams.get('zkratka');
                    this.userId = userId
                    const postData = new URLSearchParams();
                    postData.append('request', 'otherProfileDetails');
                    postData.append('user_id', userId);
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
                                this.requirements = data[0].requirements;
                                console.log(this.requirements)
                                this.getTable();
                            } else {
                                console.error('Error fetching user info!');
                            }
                        })
                        .catch((error) => {
                            console.error('Error fetching user info', error);
                        });
                },
                freeRequirements(){
                    console.log(this.table);
                    for(i = 0; i < 5; i++){
                        //start at 1 to skip day label
                        for(j = 0; j < 15; j++) this.table[i][j].value = true;
                    }
                },
                getTable(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'getOtherPersonalRequirements');
                    postData.append('requirements', this.requirements)
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
                            this.table = resp.table;
                        } else {
                            console.error('Error fetching user info');
                        }
                    })
                    .catch((error) => {
                        console.error('Error fetching user info', error);
                    });
                },
            },
            mounted() {
                    this.fetchUserInfo();

                
            },
        })
        edit.component('timegrid', {
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
        edit.component('yes-no', {
            template:`
            <div class="no" v-if="!yes">
                <div>✗</div>
            </div>
            <div class="yes" v-if="yes">
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
        edit.mount('#edit')
    </script>
</body>
</html>