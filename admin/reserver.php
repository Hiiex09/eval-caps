<main>
    <div>
      <?php if (isset($_SESSION['username'])): ?>
        <h2>Welcome, Admin: <?= htmlspecialchars($_SESSION['username']) ?></h2>

        <!-- Display academic year or default "Not Set" message -->
        <p>Academic Year:
          <?= htmlspecialchars($_SESSION['school_year'] === "Not Set" ? "Not Set" : $_SESSION['school_year']) ?>
        </p>

        <!-- Display semester information -->
        <p>Semester:
          <?= $_SESSION['semester'] == '1' ? 'First Semester' : ($_SESSION['semester'] == '2' ? 'Second Semester' : 'Not Yet Started') ?>
        </p>

        <!-- Display status -->
        <p>Status: <?= htmlspecialchars($_SESSION['is_status']) ?></p>
      <?php else: ?>
        <p>Academic year and semester not set. Please set the active semester.</p>
      <?php endif; ?>
    </div>
  </main>





  function displayTeacher($conn)
{
  $sql = "SELECT * FROM `tblteacher`";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Table starts
    echo '

        <tbody>';

    foreach ($result as $row) {
      echo '
        <tr>
          <td class="text-center fs-6">' . htmlspecialchars($row['teacher_id']) . '</td>
          <td class="text-center fs-6">' . htmlspecialchars($row['school_id']) . '</td>
          <td class="text-center fs-6">
            <div class="avatar">
              <div class="w-20">
                <img src="../pic' . htmlspecialchars($row['image']) . '" alt="Profile" style="height:60px; width:60px;">
              </div>
            </div>
          </td>
          <td class="text-center fs-6">' . htmlspecialchars($row['fname'] . ' ' . $row['lname']) . '</td>
          <td class="text-center fs-6">' . htmlspecialchars($row['email']) . '</td>
           <td class="text-center fs-6">' . htmlspecialchars($row['year'] . '  & ' . $row['section']) . '</td>
          <td class="text-center fs-6">' . htmlspecialchars($row['department_id']) . '</td>
          <td class="text-center fs-6">' . htmlspecialchars($row['subject']) . '</td>
          <td class="text-center fs-6">
            <div class="flex flex-row justify-center items-center">
              <div class="mt-1">
                <button type="button" class="btn btn-sm mb-1 btn-dark px-4" data-bs-toggle="modal"
                        data-bs-target="#ratingsTeacher">
                        <i class="bi bi-eye fs-6 p-1"></i>View
                      </button>

                      <!-- Modal -->
                      <div class="modal modal-lg fade" id="ratingsTeacher" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row justify-content-center align-items-center">
                                <!-- Profile Section -->
                                <div class="col-12 col-md-4 col-lg-3 text-center mb-4">
                                  <img src="../Profiles User/Teacher 1.png" class="img-thumbnail" alt="Boss Thanos">
                                  <h2 class="m-2">Boss Thanos</h2>
                                  <div class="fs-5">IT Department</div>
                                </div>

                                <!-- Ratings Section -->
                                <div class="col-12 col-md-8 col-lg-4 mb-4">
                                  <h2 class="display-6">Ratings Insight</h2>
                                  <div class="mb-3">
                                    <h3 class="d-flex align-items-center">
                                      <span class="ratings-num display-6">3.5</span>
                                      <i class="bi bi-star-fill star text-warning mx-1"></i>
                                      <i class="bi bi-star-fill star text-warning mx-1"></i>
                                      <i class="bi bi-star-fill star text-warning mx-1"></i>
                                    </h3>
                                  </div>
                                  <!-- Progress bars for various ratings -->
                                  <div class="mb-3">
                                    <div class="fs-5">Teaching Quality</div>
                                    <div class="progress">
                                      <div class="progress-bar bg-success" style="width: 25%"></div>
                                    </div>
                                  </div>
                                  <div class="mb-3">
                                    <div class="fs-5">Communication & Skills</div>
                                    <div class="progress">
                                      <div class="progress-bar bg-info" style="width: 50%"></div>
                                    </div>
                                  </div>
                                  <div class="mb-3">
                                    <div class="fs-5">Classroom Management</div>
                                    <div class="progress">
                                      <div class="progress-bar bg-warning" style="width: 75%"></div>
                                    </div>
                                  </div>
                                  <div class="mb-3">
                                    <div class="fs-5">Knowledge & Expertise</div>
                                    <div class="progress">
                                      <div class="progress-bar bg-danger" style="width: 100%"></div>
                                    </div>
                                  </div>
                                  <div class="mb-3">
                                    <div class="fs-5">Student Engagement</div>
                                    <div class="progress">
                                      <div class="progress-bar bg-danger" style="width: 100%"></div>
                                    </div>
                                  </div>
                                </div>

                                <!-- Carousel Section -->
                                <div class="col-12 col-lg-5">
                                  <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                      <!-- First carousel item -->
                                      <div class="carousel-item active" data-bs-interval="3000">
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Anonymous</h5>
                                            <p class="card-text fs-6">Its undeniable that we should be together...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Anonymous</h5>
                                            <p class="card-text fs-6">One, you are like a dream come true...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Anonymous</h5>
                                            <p class="card-text fs-6">Four, repeat steps one through three...</p>
                                          </div>
                                        </div>
                                      </div>

                                      <!-- Second carousel item -->
                                      <div class="carousel-item" data-bs-interval="4000">
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">User Comment</h5>
                                            <p class="card-text fs-6">It is so incredible the way things work themselves
                                              out...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">User Comment</h5>
                                            <p class="card-text fs-6">Undesirable for us to be apart...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">User Comment</h5>
                                            <p class="card-text fs-6">One, you are like a dream come true...</p>
                                          </div>
                                        </div>
                                      </div>

                                      <!-- Third carousel item -->
                                      <div class="carousel-item" data-bs-interval="5000">
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Bruce Wayne</h5>
                                            <p class="card-text fs-6">Some quick example text to build on the card
                                              title...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Bruce Wayne</h5>
                                            <p class="card-text fs-6">Repeat steps one through three...</p>
                                          </div>
                                        </div>
                                        <div class="card m-4">
                                          <div class="card-body">
                                            <h5 class="card-title fs-6">Bruce Wayne</h5>
                                            <p class="card-text fs-6">If ever I believe my work is done...</p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- Carousel controls -->
                                    <button class="carousel-control-prev" type="button"
                                      data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                      data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="visually-hidden">Next</span>
                                    </button>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
              </div>
              <div class="mt-1">
                 <a role="button" class=" mt-1 mx-1 px-3 btn btn-sm btn-outline btn-primary text-[16px]"
                    href="../admin/update_teacher_details.php?teacher_id=' . $row['teacher_id'] . '">
                    <i class="bi bi-gear px-1 fs-6"></i>Update
                  </a> 
              </div>
              <div class="mt-1">
                  <a role="button" class="mx-1 px-3 btn btn-sm btn-danger"
                    href=""><i class="bi bi-trash px-1 fs-6"></i>Remove</a>
              </div>
            </div>
          </td>
        </tr>';
    }

    // Table ends
    echo '
        </tbody>
      </table>';
  } else {
    echo '<p class="bg-danger p-3 text-white rounded fs-5"><i class="bi bi-person-x-fill px-1 fs-5"></i>No Data found.</p>';
  }
}