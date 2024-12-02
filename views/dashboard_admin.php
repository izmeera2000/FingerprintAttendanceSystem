<?php include(getcwd() . '/admin/server.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<?php include(getcwd() . '/views/head.php'); ?>


<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <?php include(getcwd() . '/views/preloader.php'); ?>

  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <?php include(getcwd() . '/views/topbar.php'); ?>

    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <?php include(getcwd() . '/views/leftbar.php'); ?>

    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <?php
      renderBreadcrumb($pagetitle, $breadcrumbs); // Use the global breadcrumbs variable
      ?>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-title">Time Table
              </div>

              <div class="row gx-0">
                <div class="col-lg-12">
                  <div class="p-4 calender-sidebar app-calendar">
                    <div class="d-none" id="user_id"><?php echo $_SESSION['user_details']['id'] ?></div>
                    <div id="calendar2"></div>
                  </div>
                </div>
              </div>
            </div>



          </div>

        </div>

        <!-- ============================================================== -->
        <!-- Sales chart -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Email campaign chart -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Ravenue - page-view-bounce rate -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Ravenue - page-view-bounce rate -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Recent comment and chats -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Container fluid  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <?php include(getcwd() . '/views/footer.php'); ?>

      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- customizer Panel -->
  <!-- ============================================================== -->

  <div class="chat-windows"></div>
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <?php include(getcwd() . '/views/script.php'); ?>
  <script>



    /*========Calender Js=========*/
    /*==========================*/

    document.addEventListener("DOMContentLoaded", function () {
      /*=================*/
      //  Calender Date variable
      /*=================*/
      // var newDate = new Date();
      // function getDynamicMonth() {
      //   getMonthValue = newDate.getMonth();
      //   _getUpdatedMonthValue = getMonthValue + 1;
      //   if (_getUpdatedMonthValue < 10) {
      //     return `0${_getUpdatedMonthValue}`;
      //   } else {
      //     return `${_getUpdatedMonthValue}`;
      //   }
      // }
      /*=================*/
      // Calender Modal Elements
      /*=================*/
      var getModalTitleEl = document.querySelector("#event-title");
      var getModalStartDateEl = document.querySelector("#event-start-date");
      var getModalEndDateEl = document.querySelector("#event-end-date");
      var getModalAddBtnEl = document.querySelector(".btn-add-event");
      var getModalUpdateBtnEl = document.querySelector(".btn-update-event");
      var calendarsEvents = {
        Danger: "danger",
        Success: "success",
        Primary: "primary",
        Warning: "warning",
      };
      /*=====================*/
      // Calendar Elements and options
      /*=====================*/
      var calendarEl = document.querySelector("#calendar2");
      var checkWidowWidth = function () {
        if (window.innerWidth <= 1199) {
          return true;
        } else {
          return false;
        }
      };
      var calendarHeaderToolbar = {
        left: "prev next",
        center: "title",
        right: "resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth",
      };
      // var calendarEventsList = [
      //   {
      //     id: 1,
      //     title: "Event Conf.",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
      //     extendedProps: { calendar: "Danger" },
      //   },
      //   {
      //     id: 2,
      //     title: "Seminar #4",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
      //     end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
      //     extendedProps: { calendar: "Success" },
      //   },
      //   {
      //     groupId: "999",
      //     id: 3,
      //     title: "Meeting #5",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
      //     extendedProps: { calendar: "Primary" },
      //   },
      //   {
      //     groupId: "999",
      //     id: 4,
      //     title: "Submission #1",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
      //     extendedProps: { calendar: "Warning" },
      //   },
      //   {
      //     id: 5,
      //     title: "Seminar #6",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
      //     end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
      //     extendedProps: { calendar: "Danger" },
      //   },
      //   {
      //     id: 6,
      //     title: "Meeting 3",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T10:30:00`,
      //     end: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:30:00`,
      //     extendedProps: { calendar: "Success" },
      //   },
      //   {
      //     id: 7,
      //     title: "Meetup #",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:00:00`,
      //     extendedProps: { calendar: "Primary" },
      //   },
      //   {
      //     id: 8,
      //     title: "Submission",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T14:30:00`,
      //     extendedProps: { calendar: "Warning" },
      //   },
      //   {
      //     id: 9,
      //     title: "Attend event",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-13T07:00:00`,
      //     extendedProps: { calendar: "Success" },
      //   },
      //   {
      //     id: 10,
      //     title: "Project submission #2",
      //     start: `${newDate.getFullYear()}-${getDynamicMonth()}-28`,
      //     extendedProps: { calendar: "Primary" },
      //   },
      // ];
      /*=====================*/
      // Calendar Select fn.
      /*=====================*/
      // var calendarSelect = function (info) {
      //   getModalAddBtnEl.style.display = "block";
      //   getModalUpdateBtnEl.style.display = "none";
      //   myModal.show();
      //   getModalStartDateEl.value = info.startStr;
      //   getModalEndDateEl.value = info.endStr;
      // };
      /*=====================*/
      // Calendar AddEvent fn.
      /*=====================*/
      // var calendarAddEvent = function () {
      //   var currentDate = new Date();
      //   var dd = String(currentDate.getDate()).padStart(2, "0");
      //   var mm = String(currentDate.getMonth() + 1).padStart(2, "0"); //January is 0!
      //   var yyyy = currentDate.getFullYear();
      //   var combineDate = `${yyyy}-${mm}-${dd}T00:00:00`;
      //   getModalAddBtnEl.style.display = "block";
      //   getModalUpdateBtnEl.style.display = "none";
      //   myModal.show();
      //   getModalStartDateEl.value = combineDate;
      // };

      /*=====================*/
      // Calender Event Function
      /*=====================*/

      /*=====================*/
      // Active Calender
      /*=====================*/
      var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        // height: checkWidowWidth() ? 900 : 1052,
        initialView: "resourceTimelineDay",
        // initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
        headerToolbar: calendarHeaderToolbar,
        // events: calendarEventsList,
        // select: calendarSelect,
        unselect: function () {
          console.log("unselected");
        },
        // slotDuration: '00:30:00',
        // customButtons: {
        //   addEventButton: {
        //     text: "Add Event",
        //     click: calendarAddEvent,
        //   },
        // },
        slotMinTime: "08:00:00", // Start of the day
        slotMaxTime: "17:00:00", // Start of the day
        slotDuration: "00:30:00",
        nowIndicator: true,
        events: getAllEvents,
        resourceAreaColumns: [
          {
            field: 'title',
            headerContent: 'Day'
          },
          
        ],
        resources: getResources,
        lazyFetching: true,
        selectable: true,
        selectHelper: true,
        // height: 650,
        hiddenDays: [0, 6],
        // eventClick: calendarEventClick,
        contentHeight: "auto",
        height: "auto",

      });


      calendar.render();

    });

    function getAllEvents(info, successCallback, failureCallback) {
      // console.log((info.startStr));
      // console.log((info.endStr));
      var user_id = document.getElementById('user_id').innerHTML;
      $.ajax({
        type: "POST",
        url: "fetchevent3",
        data: {
          fetchevent3: {
            start: info.startStr,
            end: info.endStr,
            user_id: user_id,
          },
        },
        success: function (response) {
          console.log(JSON.parse(response));
          // console.log(info.startStr);
          successCallback(JSON.parse(response));
        },
      });
      // console.log((data));
      // successCallback((data));
    }
    function getResources(info, successCallback, failureCallback) {
      $.ajax({
        type: "POST",
        url: "fetchresource2",
        data: {
          fetchresource2: {
            start: "info.startStr",
            end: "info.endStr",
          },
        },
        success: function (response) {
          console.log(JSON.parse(response));

          successCallback(JSON.parse(response));
        },
      });
    }
  </script>
</body>

</html>