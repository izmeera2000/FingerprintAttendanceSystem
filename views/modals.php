<?php if ($request == 'attendance/slotview') { ?>
  <div class="modal fade" id="UpdateAttendance" tabindex="-1" aria-labelledby="UpdateAttendanceLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h5 class="modal-title" id="UpdateAttendanceLabel">
            Attendance
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="">
                <label class="form-label">Tarikh</label>
                <input id="event-tarikh" type="text" class="form-control" readonly />
              </div>
            </div>
            <div class="col-md-6">
              <div class="">
                <label class="form-label">Masa</label>
                <input id="event-masa" type="text" class="form-control" readonly />
              </div>
            </div>
            <div class="col-md-12">
              <div class="">
                <label class="form-label">Status</label>
                <input id="event-status" type="text" class="form-control" readonly />
              </div>
            </div>

            <div class="col-md-12" id="event-reason">
              <div class="">
                <label class="form-label">Sebab</label>
                <input type="text" class="form-control" readonly />
              </div>
            </div>

            <div class="col-md-12" id="event-proof">
              <div class="">
                <label class="form-label">bukti</label>
                <a href="asdasdsa">bukti</a>
              </div>
            </div>


            <!-- <div class="col-md-12 mt-4">
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
                      </div> -->
            <!-- 
                      <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter Start Date</label>
                          <input id="event-start-date" type="text" class="form-control" />
                        </div>
                      </div> -->

            <!-- <div class="col-md-12 d-none">
                        <div class="">
                          <label class="form-label">Enter End Date</label>
                          <input id="event-end-date" type="text" class="form-control" />
                        </div>
                      </div> -->

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
<?php }
?>





<?php if ($request == 'class/create') { ?>
  <div class="modal fade" id="CreateClassModal" tabindex="-1" aria-labelledby="CreateClassModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="CreateClassModalLabel">
              Create Class
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Location</label>
                  <input type="text" class="form-control" name="location" />
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="">
                  <label class="form-label">FP Device Masuk</label>
                  <!-- <input type="text" class="form-control" /> -->
                  <select class="form-control" name="fpin">
                    <option value="NULL" selected>Not Yet</option>
                    <?php

                    $query = "SELECT * FROM fp_device a WHERE entrance='1'";
                    $results = mysqli_query($db, $query);

                    while ($row = $results->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nama'] ?></option>

                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-12  mt-2">
                <div class="">
                  <label class="form-label">FP Device Keluar</label>
                  <select class="form-control" name="fpout">
                    <option value="NULL" selected>Not Yet</option>
                    <?php

                    $query = "SELECT * FROM fp_device a WHERE entrance='0'";
                    $results = mysqli_query($db, $query);

                    while ($row = $results->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nama'] ?></option>

                      <?php

                    }
                    ?>
                  </select>
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <!-- <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
          Update changes
        </button> -->
            <button type="submit" class="btn btn-primary btn-add-event" name="class_createf">
              Create
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <div class="modal fade" id="EditClassModal" tabindex="-1" aria-labelledby="EditClassModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="EditClassModalLabel">
              Create Class
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control" name="id" id="id" />

              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" id="nama" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Location</label>
                  <input type="text" class="form-control" name="location" id="location" />
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="">
                  <label class="form-label">FP Device Masuk</label>
                  <!-- <input type="text" class="form-control" /> -->
                  <select class="form-control" name="fpin" id="fpin">
                    <option value="NULL">Not Yet</option>
                    <?php

                    $query = "SELECT * FROM fp_device a WHERE entrance='1'";
                    $results = mysqli_query($db, $query);

                    while ($row = $results->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nama'] ?></option>

                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="col-md-12  mt-2">
                <div class="">
                  <label class="form-label">FP Device Keluar</label>
                  <select class="form-control" name="fpout" id="fpout">
                    <option value="NULL">Not Yet</option>
                    <?php

                    $query = "SELECT * FROM fp_device a WHERE entrance='0'";
                    $results = mysqli_query($db, $query);

                    while ($row = $results->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id'] ?>"><?php echo $row['nama'] ?></option>

                      <?php

                    }
                    ?>
                  </select>
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-danger" name="class_deletef">
              Delete
            </button>
            <button type="submit" class="btn btn-primary btn-add-event" name="class_editf">
              Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php }
?>



<?php if ($request == 'fp/create') { ?>
  <div class="modal fade" id="CreateFpModal" tabindex="-1" aria-labelledby="CreateFpModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="CreateFpModalLabel">
              Create FP Device
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" />
                </div>
              </div>
              <!-- <div class="col-md-6">
              <div class="">
                <label class="form-label">Type</label>
                <input type="text" class="form-control" name="location" />
              </div>
            </div> -->
              <div class="col-md-12 mt-2">
                <div class="">
                  <label class="form-label">FP Device Masuk</label>
                  <!-- <input type="text" class="form-control" /> -->
                  <select class="form-control" name="type">
                    <option value="0" selected>Exit</option>
                    <option value="1">Entrance</option>

                  </select>
                </div>
              </div>




            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <!-- <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
          Update changes
        </button> -->
            <button type="submit" class="btn btn-primary btn-add-event" name="fp_createf">
              Create
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <div class="modal fade" id="EditFpModal" tabindex="-1" aria-labelledby="EditFpModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="EditFpModalLabel">
              Edit FP Device
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control" name="id" id="id" />

              <div class="col-md-6">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" id="nama" />
                </div>
              </div>
              <div class="col-md-12 mt-2">
                <div class="">
                  <label class="form-label">FP Device Masuk</label>
                  <!-- <input type="text" class="form-control" /> -->
                  <select class="form-control" name="type" id="type">
                    <option value="0">Exit</option>
                    <option value="1">Entrance</option>

                  </select>
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-danger" name="fp_deletef">
              Delete
            </button>
            <button type="submit" class="btn btn-primary btn-add-event" name="fp_editf">
              Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php }
?>


<?php if ($request == 'subjek/create') { ?>


  <div class="modal fade" id="CreateSubjekModal" tabindex="-1" aria-labelledby="CreateSubjekModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="CreateSubjekModalLabel">
              Create Subjek
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" />
                </div>
              </div>

              <div class="col-md-12 mt-2">
                <div class="">
                  <label class="form-label">Kod</label>
                  <input type="text" class="form-control" name="kod" />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <!-- <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
          Update changes
        </button> -->
            <button type="submit" class="btn btn-primary btn-add-event" name="subjek_createf">
              Create
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="EditSubjekModal" tabindex="-1" aria-labelledby="EditSubjekModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title" id="EditSubjekModalLabel">
              Edit FP Device
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" class="form-control" name="id" id="id" />

              <div class="col-md-12">
                <div class="">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="nama" id="nama" />
                </div>
              </div>
              <div class="col-md-12 mt-2">
              <div class="">
                  <label class="form-label">Kod</label>
                  <input type="text" class="form-control" name="kod" id="kod" />
                </div>
              </div>


            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-danger" name="subjek_deletef">
              Delete
            </button>
            <button type="submit" class="btn btn-primary btn-add-event" name="subjek_editf">
              Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>



<?php }
?>




<?php if ($request == 'course/create') { ?>


<div class="modal fade" id="CreateCourseModal" tabindex="-1" aria-labelledby="CreateCourseModalLabel"
  aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h5 class="modal-title" id="CreateCourseModalLabel">
            Create Course
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" />
              </div>
            </div>
<!-- 
            <div class="col-md-6 mt-2">
              <div class="">
                <label class="form-label">Tarikh Mula</label>
                <input type="date" class="form-control" name="mula" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="">
                <label class="form-label">Tarikh Tamat</label>
                <input type="date" class="form-control" name="tamat" />
              </div>
            </div> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">
            Close
          </button>
          <!-- <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">
        Update changes
      </button> -->
          <button type="submit" class="btn btn-primary btn-add-event" name="course_createf">
            Create
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="EditCourseModal" tabindex="-1" aria-labelledby="EditCourseModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
    <form method="POST">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h5 class="modal-title" id="EditCourseModalLabel">
            Edit FP Device
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" class="form-control" name="id" id="id" />

            <div class="col-md-12">
              <div class="">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" id="nama" />
              </div>
            </div>
            <!-- <div class="col-md-6 mt-2">
              <div class="">
                <label class="form-label">Tarikh Mula</label>
                <input type="date" class="form-control" name="mula" id="mula"/>
              </div>
            </div>
            <div class="col-md-6">
              <div class="">
                <label class="form-label">Tarikh Tamat</label>
                <input type="date" class="form-control" name="tamat" id="tamat"/>
              </div>
            </div> -->


          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-bs-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-danger" name="course_deletef">
            Delete
          </button>
          <button type="submit" class="btn btn-primary btn-add-event" name="course_editf">
            Save Changes
          </button>
        </div>
      </div>
    </form>
  </div>
</div>





<?php }
?>