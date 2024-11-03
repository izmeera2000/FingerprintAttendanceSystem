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
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-5 align-self-center">
            <h4 class="page-title">Dashboard</h4>
          </div>
          <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="index.html#">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Dashboard
                  </li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- End Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div>
                <div class="row gx-0">
                  <div class="col-lg-12">
                    <div class="p-4 calender-sidebar app-calendar">
                      <div id="calendar"></div>
                    </div>
                  </div>
                </div>

                <?php
                // $todaysDate = date("Y-m-d");
                // $query = "SELECT a.*, b.email FROM `attendance` a INNER JOIN user b ON b.id=a.user_id WHERE (DATE(masa_mula)='$todaysDate')";
                // $results = mysqli_query($db, $query);
                // $masa_tamat = date("Y-m-d H:i:s", strtotime("today 18:00"));
                // $now = date("Y-m-d H:i:s", strtotime("now"));
                

                // while ($row = $results->fetch_assoc()) {
                
                //   $masa_keluar = strtotime("+15 minutes", strtotime($row['masa_mula']));
                

                //   var_dump($row);
                
                //   if ($row['event_status'] == 0) {
                //     if ($row['masa_tamat'] == "" && ($masa_keluar < $now)) {
                //       sendmail($row['email'], "Lambat", "Anda Lambat masuk kelas");
                

                //     }
                //   } else {
                //     if ($row['masa_tamat'] == "" && ($masa_tamat < $now)) {
                //       sendmail($row['email'], "anda x kelaur lagi", "gpa 4.3");
                
                //     }
                //   }
                // }
                
                ?>
              </div>
            </div>
            <!-- BEGIN MODAL -->
            <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">
                      Add / Edit Event
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="">
                          <label class="form-label">Event Title</label>
                          <input id="event-title" type="text" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-12 mt-4">
                        <div><label class="form-label">Event Color</label></div>
                        <div class="d-flex">
                          <div class="n-chk">
                            <div class="form-check form-check-primary form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Danger"
                                id="modalDanger" />
                              <label class="form-check-label" for="modalDanger">Danger</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-warning form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Success"
                                id="modalSuccess" />
                              <label class="form-check-label" for="modalSuccess">Success</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-success form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Primary"
                                id="modalPrimary" />
                              <label class="form-check-label" for="modalPrimary">Primary</label>
                            </div>
                          </div>
                          <div class="n-chk">
                            <div class="form-check form-check-danger form-check-inline">
                              <input class="form-check-input" type="radio" name="event-level" value="Warning"
                                id="modalWarning" />
                              <label class="form-check-label" for="modalWarning">Warning</label>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter Start Date</label>
                          <input id="event-start-date" type="text" class="form-control" />
                        </div>
                      </div>

                      <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter End Date</label>
                          <input id="event-end-date" type="text" class="form-control" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
                      Update changes
                    </button>
                    <button type="button" class="btn btn-primary btn-add-event">
                      Add Event
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- END MODAL -->
          </div>
        </div>
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
      var calendarEl = document.querySelector("#calendar");
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
      var calendarSelect = function (info) {
        getModalAddBtnEl.style.display = "block";
        getModalUpdateBtnEl.style.display = "none";
        myModal.show();
        getModalStartDateEl.value = info.startStr;
        getModalEndDateEl.value = info.endStr;
      };
      /*=====================*/
      // Calendar AddEvent fn.
      /*=====================*/
      var calendarAddEvent = function () {
        var currentDate = new Date();
        var dd = String(currentDate.getDate()).padStart(2, "0");
        var mm = String(currentDate.getMonth() + 1).padStart(2, "0"); //January is 0!
        var yyyy = currentDate.getFullYear();
        var combineDate = `${yyyy}-${mm}-${dd}T00:00:00`;
        getModalAddBtnEl.style.display = "block";
        getModalUpdateBtnEl.style.display = "none";
        myModal.show();
        getModalStartDateEl.value = combineDate;
      };

      /*=====================*/
      // Calender Event Function
      /*=====================*/
      var calendarEventClick = function (info) {
        // var eventObj = info.event;
        console.log(info.event.start);
        console.log(info.event.end);
        // if (eventObj.url) {
        //   window.open(eventObj.url);

        //   info.jsEvent.preventDefault();
        // } else {
        //   var getModalEventId = eventObj._def.publicId;
        //   var getModalEventLevel = eventObj._def.extendedProps["calendar"];
        //   var getModalCheckedRadioBtnEl = document.querySelector(
        //     `input[value="${getModalEventLevel}"]`
        //   );

        //   getModalTitleEl.value = eventObj.title;
        //   getModalCheckedRadioBtnEl.checked = true;
        //   getModalUpdateBtnEl.setAttribute(
        //     "data-fc-event-public-id",
        //     getModalEventId
        //   );
        //   getModalAddBtnEl.style.display = "none";
        //   getModalUpdateBtnEl.style.display = "block";
        //   myModal.show();
        // }
      };

      /*=====================*/
      // Active Calender
      /*=====================*/
      var calendar = new FullCalendar.Calendar(calendarEl, {
        selectable: true,
        // height: checkWidowWidth() ? 900 : 1052,
        initialView: "resourceTimeline",
        hiddenDays: [ 0,6 ],
        // initialDate: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
        headerToolbar: calendarHeaderToolbar,
        // events: calendarEventsList,
        // select: calendarSelect,
        unselect: function () {
          console.log("unselected");
        },
        // customButtons: {
        //   addEventButton: {
        //     text: "Add Event",
        //     click: calendarAddEvent,
        //   },
        // },
        slotMinTime: "08:00:00", // Start of the day
        slotMaxTime: "18:00:00", // Start of the day
        slotDuration: "01:00:00",
        nowIndicator: true,
        events: getAllEvents,
        resources: getResources,
        lazyFetching: true,
        selectable: true,
        selectHelper: true,
        // height: 650,
        eventClick: calendarEventClick,
        contentHeight: "auto",
        height: "auto",
        // eventClassNames: function ({ event: calendarEvent }) {
        //   const getColorValue =
        //     calendarsEvents[calendarEvent._def.extendedProps.calendar];
        //   return ["event-fc-color fc-bg-" + getColorValue];
        // },

        // eventClick: calendarEventClick,
        // windowResize: function (arg) {
        //   if (checkWidowWidth()) {
        //     calendar.changeView("listWeek");
        //     calendar.setOption("height", 900);
        //   } else {
        //     calendar.changeView("dayGridMonth");
        //     calendar.setOption("height", 1052);
        //   }
        // },
      });

      /*=====================*/
      // Update Calender Event
      /*=====================*/
      getModalUpdateBtnEl.addEventListener("click", function () {
        var getPublicID = this.dataset.fcEventPublicId;
        var getTitleUpdatedValue = getModalTitleEl.value;
        var getEvent = calendar.getEventById(getPublicID);
        var getModalUpdatedCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        var getModalUpdatedCheckedRadioBtnValue =
          getModalUpdatedCheckedRadioBtnEl !== null
            ? getModalUpdatedCheckedRadioBtnEl.value
            : "";

        getEvent.setProp("title", getTitleUpdatedValue);
        getEvent.setExtendedProp("calendar", getModalUpdatedCheckedRadioBtnValue);
        myModal.hide();
      });
      /*=====================*/
      // Add Calender Event
      /*=====================*/
      getModalAddBtnEl.addEventListener("click", function () {
        var getModalCheckedRadioBtnEl = document.querySelector(
          'input[name="event-level"]:checked'
        );

        var getTitleValue = getModalTitleEl.value;
        var setModalStartDateValue = getModalStartDateEl.value;
        var setModalEndDateValue = getModalEndDateEl.value;
        var getModalCheckedRadioBtnValue =
          getModalCheckedRadioBtnEl !== null ? getModalCheckedRadioBtnEl.value : "";

        calendar.addEvent({
          id: 12,
          title: getTitleValue,
          start: setModalStartDateValue,
          end: setModalEndDateValue,
          allDay: true,
          extendedProps: { calendar: getModalCheckedRadioBtnValue },
        });
        myModal.hide();
      });
      /*=====================*/
      // Calendar Init
      /*=====================*/
      calendar.render();
      // var myModal = new bootstrap.Modal(document.getElementById("eventModal"));
      // var modalToggle = document.querySelector(".fc-addEventButton-button ");
      // document
      //   .getElementById("eventModal")
      //   .addEventListener("hidden.bs.modal", function (event) {
      //     getModalTitleEl.value = "";
      //     getModalStartDateEl.value = "";
      //     getModalEndDateEl.value = "";
      //     var getModalIfCheckedRadioBtnEl = document.querySelector(
      //       'input[name="event-level"]:checked'
      //     );
      //     if (getModalIfCheckedRadioBtnEl !== null) {
      //       getModalIfCheckedRadioBtnEl.checked = false;
      //     }
      //   });
    });

    function getAllEvents(info, successCallback, failureCallback) {
      // console.log((info.startStr));
      // console.log((info.endStr));

      $.ajax({
        type: "POST",
        url: "fetchevent",
        data: {
          fetchevent: {
            start: info.startStr,
            end: info.endStr,
          },
        },
        success: function (response) {
          console.log(JSON.parse(response));

          successCallback(JSON.parse(response));
        },
      });
      // console.log((data));
      // successCallback((data));
    }
    function getResources(info, successCallback, failureCallback) {
      $.ajax({
        type: "POST",
        url: "fetchresource",
        data: {
          fetchresource: {
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