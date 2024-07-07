<?php
/**
 * A variation of the table is used in all our components so we worked on the backend for it together
 * @author xbabus01
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Návrh rozvrhu</title>
    <link rel="stylesheet" href="draft-schedule.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <section class="center-content">
            <div class="details" v-cloak>
                <?php require_once('sidebar.php'); ?>
                <schedule v-bind:table="table" :show-plus-icon="showPlusIcon" @empty-cell-click="handleEmptyCellClick"/>
            </div>
            <section class="legend">
                <div class="legend-item">
                    <div class="legend-color" style="cursor: pointer;">
                        <input type="color" v-model="colors[0]" @change="colorChange(0)" style="width: 20px; height: 20px; padding: 0; margin: 0; border: none; border-radius: 50%; cursor: pointer;">
                    </div>
                    <div>přednáška</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="cursor: pointer;">
                        <input type="color" v-model="colors[1]" @change="colorChange(1)" style="width: 20px; height: 20px; padding: 0; margin: 0; border: none; border-radius: 50%; cursor: pointer;">
                    </div>
                    <div>democvičení</div>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="cursor: pointer;">
                        <input type="color" v-model="colors[2]" @change="colorChange(2)" style="width: 20px; height: 20px; padding: 0; margin: 0; border: none; border-radius: 50%; cursor: pointer;">
                    </div>
                    <div>cvičení</div>
                </div>
                <div class="legend-item">
                    <button @click="setDefaultColors" class="default-button">Default</button>
                </div>
                <div class="legend-item">
                    <button @click="saveColors" class="default-button">Save</button>
                </div>
                <div class="legend-item">
                    <button @click="showPlusButton" class="default-button">Přidat aktivitu</button>
                </div>
                <input type="text" id="activityName" name="activityName" style="width: 100px; height: 20px;">



            </section>
    </div>
    <script src="https://unpkg.com/vue@next"></script>
    <script>
        var vm = null
        let app = Vue.createApp({
            data() {
                return {
                    barva: '',
                    table: [],
                    SideBarLook: [],
                    colors: {
                        0: '',
                        1: '',
                        2: ''
                    },
                    selectedColorIndex: null,
                    showPlusIcon: false
                }
            },
            components: ['schedule'],
            methods: {
                handleEmptyCellClick(activity, dayIndex, rowIndex, hourIndex) {
                    console.log(`Clicked on empty cell at ${dayIndex}, ${rowIndex}, ${hourIndex}`);
                    this.getDayTime(hourIndex, dayIndex)
                },
                showPlusButton() {
                    this.showPlusIcon = !this.showPlusIcon;
                },
                colorChange(type){
                    switch(type){
                        case 0:
                            this.applyBackgroundColors(['grid-1h', 'grid-2h', 'grid-3h'], type);
                            break;
                        case 1:
                            this.applyBackgroundColors(['grid-1hcvs', 'grid-2hcvs', 'grid-3hcvs'], type);
                            break;
                        case 2:
                            this.applyBackgroundColors(['grid-1hcv', 'grid-2hcv', 'grid-3hcv'], type);
                            break;
                    }
                },
                applyBackgroundColors(classNames, type) {
                    const cols = classNames.map(className => document.getElementsByClassName(className));
                    for (let i = 0; i < cols.length; i++) {
                        for (let j = 0; j < cols[i].length; j++) {
                            cols[i][j].style.backgroundColor = this.colors[type];
                        }
                    }
                },

                setDefaultColors() {
                    this.colors = {
                        0: '#f8b500',
                        1: '#f7f7f7',
                        2: '#5c636e'
                    };

                    // Při návratu k výchozím barvám je třeba tyto barvy také aplikovat na aktivity
                    this.applyBackgroundColors(['grid-1h', 'grid-2h', 'grid-3h'], 0);
                    this.applyBackgroundColors(['grid-1hcvs', 'grid-2hcvs', 'grid-3hcvs'], 1);
                    this.applyBackgroundColors(['grid-1hcv', 'grid-2hcv', 'grid-3hcv'], 2);
                },
                saveColors() {
                    var colorArray = Object.values(this.colors);
                    var colorString = colorArray.join(',');
                    const postData = new URLSearchParams();
                    console.log('------------------')
                    console.log(this.colors);
                    console.log('------------------')
                    console.log(colorString);
                    postData.append('request', 'updateColors');
                    postData.append('barva', colorString);
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
                            
                        } else {
                            console.error('Error fetching user info');
                        }
                    })
                    .catch((error) => {
                        console.error('Error fetching user info', error);
                    });
                },
                fetchUserInfo(){
                    const postData = new URLSearchParams();
                    postData.append('request', 'getRegisteredActivities');
                    postData.append('barvy', this.colors);
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
                            this.barva = resp.barva;
                            var colorArray = this.barva.split(',');
                            this.colors = {
                                0: colorArray[0],
                                1: colorArray[1],
                                2: colorArray[2]
                            };
          
                            this.applyBackgroundColors(['grid-1h', 'grid-2h', 'grid-3h'], 0);
                            this.applyBackgroundColors(['grid-1hcvs', 'grid-2hcvs', 'grid-3hcvs'], 1);
                            this.applyBackgroundColors(['grid-1hcv', 'grid-2hcv', 'grid-3hcv'], 2);
                            console.log(this.colors)
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
            },
        })

        // side bar component
        app.component('schedule', {
            props: ['table', 'isVisible', 'showPlusIcon'],
            data() {
                return {
                    remove_activity: 0,
                    showModal: false,
                    modalActivity: null,
                    max_selected_hours: 0,
                    selected_day: 0,
                    selected_hour1: 0,
                    selected_hour2: 0,
                    selected_hour3: 0,
                    vlastni_nazev: 'nesmysl',
                    modalStyle: {
                        top: '0',
                        left: '0',
                        backgroundColor: '#FFE382',
                        position: 'absolute',
                        border: '1px solid black',
                        padding: '10px'
                    }
                };
            },
            methods: {
                
                showActivityInfo(activity, event, buttonId) {
                    this.modalActivity = activity;
                    this.calculateModalPosition(event);
                    this.showModal = true;
                    this.remove_activity = activity.id
                    this.$nextTick(() => {
                        const button = event.target.closest('.settings-button');
                        if (button) {
                            button.setAttribute('data-button-id', buttonId);
                        }
                    });
                },
                calculateModalPosition(event) {
                    const buttonRect = event.target.getBoundingClientRect();
                    this.modalStyle = {
                        ...this.modalStyle,
                        top: `${buttonRect.bottom}px`,
                        left: `${buttonRect.left}px`
                    };
                },
                hideModal() {
                    this.showModal = false;
                    this.modalActivity = null;
                    
                },
                smazat() {
                    const postData = new URLSearchParams();
                    postData.append('request', 'deleteActivity');
                    console.log(this.remove_activity)
                    postData.append('id', this.remove_activity);
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
                            vm.fetchUserInfo()
                            this.remove_activity = 0
                        } else {
                            console.error('Error fetching user info');
                        }
                    })
                    .catch((error) => {
                        console.error('Error fetching user info', error);
                    });
                },
                closeModalOutside(event) {
                    const modal = document.querySelector('.modal');
                    if (modal) {
                        const isClickInsideModal = modal.contains(event.target);
                        const isClickOnSettingsButton = event.target.closest('.settings-button[data-button-id]');
                        if (!isClickInsideModal && !isClickOnSettingsButton) {
                            this.hideModal();
                        }
                    }
                },
                handleEmptyCellClick(activity, dayIndex, rowIndex, hourIndex) {
                    console.log(`Clicked on empty cell at ${dayIndex}, ${rowIndex}, ${hourIndex}`);
                    //this.getDayTime(hourIndex, dayIndex)
                    const days = ['1', '2', '3', '4', '5'];
                    const hours = ['07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'];
                    
                    var z = hours[hourIndex- 1]
                    var den = days[dayIndex - 1]
                    
                    const activityName = document.getElementById('activityName').value;
                    const postData = new URLSearchParams();
                    postData.append('request', 'addOwnActivty');
                    postData.append('predmet', 'VA');
                    postData.append('nazev', activityName);
                    postData.append('den', den);
                    postData.append('cas', z);
                    postData.append('delka', '1');
                    postData.append('typ', '2');
                    
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
                                vm.fetchUserInfo()
                                vm.showPlusButton()
                                this.selected_day = 0
                                this.selected_hour1 = 0
                                this.selected_hour2 = 0
                                this.selected_hour3 = 0
                                this.max_selected_hours = 0
                                console.log('HURRRRRAYY!!')
                            } else {
                                console.error('Error!');
                            }
                        })
                        .catch((error) => {
                            console.error('CAUGHT Error', error);
                        });
                },
                CheckChecked(){
                            // indexies of element what was changed (user clicked on check)
                            let indexDay = -1;
                            let indexRow = -1;
                            let indexHour = -1;
                            // get indexies of this element
                            // Day
                            for (let x = 0; x < this.table.length; x++) {
                                // Hour
                                for (let y = 0; y < this.table[x].length; y++) {
                                    // Row
                                    for (let z = 0; z < this.table[x][y].length; z++) {
                                        if(this.table[x][y][z].check){
                                            if(this.table[x][y][z].lastModified && this.table[x][y][z].checked){
                                                indexDay = x;
                                                indexRow = y;
                                                indexHour = z;
                                                this.table[x][y][z].lastModified = false;
                                            }
                                            if(!this.table[x][y][z].checked){
                                                this.table[x][y][z].lastModified = true;
                                            }
                                        }
                                    }
                                }
                            }
                            // element not found (update occurs after click on 'Zobrazit aktivity')
                            if(indexRow == -1) return;
                            // start to search one element after modified element
                            x = indexDay;
                            y = indexRow;
                            z = indexHour + 1;
                            // Day
                            while(true){
                                x = x % this.table.length;
                                // Row
                                while(true){
                                    // Hour
                                    while(true){
                                        // end of searching
                                        // algoritm reached started element
                                        if(x == indexDay && y == indexRow && z == indexHour) return;
                                        // reached end of row
                                        if(z >= this.table[x][y].length) break;
                                        // activity of same element found 
                                        if( this.table[x][y][z].subject.localeCompare(this.table[indexDay][indexRow][indexHour].subject)==0
                                            &&this.table[x][y][z].class.localeCompare(this.table[indexDay][indexRow][indexHour].class)==0
                                            &&this.table[x][y][z].checked)
                                        {
                                            this.table[x][y][z].checked = false;
                                        }
                                        z++;
                                    }
                                    z=1;
                                    y++;
                                    if(y >= this.table[x].length) break;
                                }
                                y=0;
                                x++;
                            }
                        },
            },
            updated() {
                this.CheckChecked();
            },
            mounted() {
                document.addEventListener('click', this.closeModalOutside);
            },
            beforeUnmount() {
                document.removeEventListener('click', this.closeModalOutside);
            },
            
            template: `
                <section class="right-side">
                    <div v-for="(day, i) in table" :key="i" class="grid-schedule">
                        <template v-for="(activities, j) in day" :key="j">
                            <div v-for="(activity, k) in activities" :key="k" :class="activity.class">
                                <template v-if="activity.subject">
                                    <div class="activity-wrapper" style="position: relative;">
                                        <div v-if="activity.subject" class="activity-content">
                                            <button
                                                v-if="activity.check"
                                                class="settings-button"
                                                @click="showActivityInfo(activity, $event, 'settings-' + i + '-' + j + '-' + k)"
                                                ref="settingsButton"
                                            >
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <template v-if="activity.subject !== 'VA'">
                                                <div>{{activity.subject}}</div>
                                            </template>
                                            <template v-else>
                                                <div>VA</div>
                                            </template>
                                            <div v-if="activity.check" class="small">{{activity.nazev}} / {{activity.room}} / {{activity.vyucujici}}</div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else-if="k !== 0 && showPlusIcon">
                                    <i class="fas fa-plus-circle" style="color: green; font-size: 16px; cursor: pointer;" @click="handleEmptyCellClick(activity, i, j, k)"></i>
                                </template>
                            </div>
                        </template>
                    </div>
                    <div v-if="showModal" class="modal" :style="modalStyle" @click.stop="">
                        <div class="modal-content">
                            <h2>{{ modalActivity.subject }}</h2>
                            <p>Místo konání: {{ modalActivity.room }}</p>
                            <button @click="smazat">Smazat</button>
                        </div>
                    </div>
                
                </section>
            `
        })

        vm = app.mount('#app');

        // Call the method after mounting
        vm.fetchUserInfo();
    </script>

</body>
</html>