<div class = "left-bar">
    <!-- 
        @author xvorob02
    -->
    <div class="user-info">
        <img class = "side-bar-img" src="images/person.jpg" alt="Profilová fotka">
    </div>
    <div style="margin: 1%; text-align: right">
        <button @click="logout"> Odhlásit </button>
    </div>
    <button class="custom_button" v-if="SideBarLook.personal_informations">
        <img class = "button-img" src="images/user.png" alt="person" >
        <a href="student-details.php">Osobní informace</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.individual_schedule">
        <img class = "button-img" src="images/calendar-days.png" alt="calendar-days" >
        <a href="schedule.php">Individuální rozvrh</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.subjects_anotaions">
        <img class = "button-img" src="images/list.png" alt="list" >
        <a href="anotacion.html">Anotace předmětů</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.subject_regitration">
        <img class = "button-img" src="images/list-check.png" alt="list-check" >
        <a href="class-registration.php">Registrace předmětů</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.draft_schedule">
        <img class = "button-img" src="images/calendar-pen.png" alt="calendar-pen" >
        <a href="draft-schedule.html">Návrh rozvrhu</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.personal_request">
        <img class = "button-img" src="images/clock.png" alt="clock" >
        <a href="personal-requirements.php">Osobní požadavky</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.activity_request">
        <img class = "button-img" src="images/credit-card.png" alt="credit-card" >
        <a href="activity-requirements.php">Požadavky aktivit</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.manage_user">
        <img class = "button-img" src="images/users.png" alt="users" >
        <a href="manage-users.html">Spravovat uživatele</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.manage_rooms">
        <img class = "button-img" src="images/users.png" alt="users" >
        <a href="manage-rooms.html">Spravovat místnosti</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.manage_schedule">
        <img class = "button-img" src="images/calendar-pen.png" alt="calendar-pen" >
        <a href="manage-schedule.php">Spravovat rozvrh</a>
    </button>
    <button class="custom_button" v-if="SideBarLook.manage_classes">
        <img class = "button-img" src="images/calendar-pen.png" alt="calendar-pen" >
        <a href="manage-courses.html">Spravovat předměty</a>
    </button>
</div>