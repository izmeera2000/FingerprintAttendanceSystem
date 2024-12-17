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
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div>
                <div class="row gx-0">
                  <input type="hidden" id="bengkel" value="<?php echo $_SESSION['user_details']['bengkel_id'] ?>">



                  <?php

                  $user_id = $_SESSION['user_details']['id'];
                  $query = "SELECT   * FROM user_enroll WHERE user_id = '$user_id'";
                  $results = mysqli_query($db, $query);
                  while ($row = $results->fetch_assoc()) {
                    $id = $row['course_id'];
                    $sem = $row['sem_start'];
                    ?>
                    <input value="<?php echo $id ?>" id="course" type="hidden">
                    <input value="<?php echo $sem ?>" id="sem" type="hidden">

                  <?php } ?>





                  <div class="col-lg-12">
                    <div class="p-4 calender-sidebar app-calendar">
                      <div id="calendar"></div>
                    </div>
                  </div>
                </div>
                <button type="button" id="floatingButton"
                  class="btn btn-info btn-circle btn-xl position-fixed bottom-0 end-0 m-3 z-3 d-none"><i
                    class="fa fa-check"></i></button>
                <!-- #region -->

                <!-- Modal -->
                <div class="modal fade" id="verifyday" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Verify Day</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form class="d-flex justify-content-center">
                          <!-- <label for="exampleFormControlInput1">Date</label> -->
                          <input type="hidden" id="date" name="date">
                          <!-- <label for="exampleFormControlInput1">User ID</label> -->
                          <input type="hidden" id="user_id" name="user_id"
                            value="<?php echo $_SESSION['user_details']['id'] ?>">
                          <div class="btn-group" data-toggle="buttons" id="btggroupslot">




                          </div>

                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateverify">Save changes</button>
                      </div>
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
            <?php include(getcwd() . '/views/modals.php'); ?>

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

      /*=====================*/
      // Calender Event Function
      /*=====================*/
      var calendarEventClick = function (info) {
        // var eventObj = info.event;
        // console.log(info.event.end);
        if (info.event.extendedProps.slot == 'slot1') {


          $('#id').val(info.event.extendedProps.slot_id);

          var myModal = new bootstrap.Modal(document.getElementById("UpdateAttStudent"));


          myModal.show();
        }
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

      var floatingButton = document.getElementById('floatingButton');


      var myModal2 = new bootstrap.Modal(document.getElementById('verifyday'), {
        keyboard: true // Enable closing with ESC key
      });
      // Show the modal
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
        resources: getResources,
        lazyFetching: true,
        selectable: true,
        selectHelper: true,
        // height: 650,
        hiddenDays: [0, 6],
        eventClick: calendarEventClick,
        contentHeight: "auto",
        height: "auto",
        datesSet: function (info) {
          console.log('datesSet:', info.startStr); // Debug log
          if (info.view.type === 'resourceTimelineDay') {
            floatingButton.classList.remove('d-none');
          } else {
            floatingButton.classList.add('d-none');
          }
          const timestamp = new Date(info.startStr).getTime() / 1000; // Divide by 1000 for PHP time

          $('#date').val(timestamp);

        }
      });


      calendar.render();
      // $('#select_course').on('change', function () {
      //   // Refetch events based on the selected filter
      //   calendar.refetchResources();  // This will call the events function again and refresh the calendar
      // });
      // $('#select_sem').on('change', function () {
      //   // Refetch events based on the selected filter
      //   calendar.refetchResources();  // This will call the events function again and refresh the calendar
      // });


      // $('#select_subjek').on('change', function () {
      //   // Refetch events based on the selected filter
      //   var subjek = $('#select_subjek').val();

      //   console.log(subjek);
      //   calendar.refetchEvents();  // This will call the events function again and refresh the calendar
      // });




      $('#floatingButton').on('click', function () {
        // alert('Floating button clicked!');

        var date = $('#date').val();
        var user_id = $('#user_id').val();
        // var checkedSlotIds = $('#btggroupslot').find('input[type="checkbox"]:checked').map(function() {
        //     return this.id;
        // }).get(); // Convert jQuery object to array
        var bengkel = $('#select_bengkel').val();
        var course = $('#select_course').val();
        var sem = $('#select_sem').val();

        $.ajax({
          type: "POST",
          url: "fetchslot",
          data: {
            fetchslot: {
              date: date,
              user_id: user_id,
              bengkel: bengkel,
              course: course,
              sem: sem,
              // check : checkedSlotIds,

            },
          },
          success: function (response) {
            console.log(response);
            // console.log(date);
            $('#btggroupslot').html(response);
            myModal2.show();

          },
        });

        // Add your custom functionality here
      });
      $('#updateverify').on('click', function () {
        var date = $('#date').val();
        var user_id = $('#user_id').val();
        var checkedSlotIds = $('#btggroupslot').find('input[type="checkbox"]:checked').map(function () {
          return this.id;
        }).get(); // Convert jQuery object to array
        var uncheckedSlotIds = $('#btggroupslot').find('input[type="checkbox"]:not(:checked)').map(function () {
          return this.id;
        }).get(); // Convert jQuery object to array

        var bengkel = $('#bengkel').val();
        var course = $('#course').val();
        var sem = $('#sem').val();

        // Prepare FormData
        var formData = new FormData();
        formData.append('date', date);
        formData.append('user_id', user_id);
        formData.append('bengkel', bengkel);
        formData.append('course', course);
        formData.append('sem', sem);
        formData.append('check', JSON.stringify(checkedSlotIds));  // Send as JSON string
        formData.append('uncheck', JSON.stringify(uncheckedSlotIds));  // Send as JSON string

        // Check if a file is selected and append it
        var fileInput = $('#fileInput')[0].files[0];
        if (fileInput) {
          formData.append('file', fileInput);
        }

        // Perform the AJAX request with FormData
        $.ajax({
          type: "POST",
          url: "updateslot",  // Server-side endpoint to handle the request
          data: formData,
          contentType: false,  // Important to set this to false for FormData
          processData: false,  // Important to set this to false for FormData
          success: function (response) {
            console.log(response);
            // Optionally hide modal or perform other actions
            myModal2.hide();
          },
          error: function (xhr, status, error) {
            console.error("Error occurred: " + error);
          }
        });
      });



    });

    function getAllEvents(info, successCallback, failureCallback) {
      // console.log((info.startStr));
      // console.log((info.endStr));

      $.ajax({
        type: "POST",
        url: "fetchevent2",
        data: {
          fetchevent2: {
            start: info.startStr,
            end: info.endStr,
            subjek: "",
          },
        },
        success: function (response) {
          console.log(JSON.parse(response));
          // console.log(response);
          // console.log(info.startStr);
          successCallback(JSON.parse(response));
        },
      });
      // console.log((data));
      // successCallback((data));
    }
    function getResources(info, successCallback, failureCallback) {
      var bengkel = $('#bengkel').val();
      var course = $('#course').val();
      var sem = $('#sem').val();
      $.ajax({
        type: "POST",
        url: "fetchresource",
        data: {
          fetchresource: {
            start: "info.startStr",
            end: "info.endStr",
            bengkel: bengkel,
            course: course,
            sem: sem,
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