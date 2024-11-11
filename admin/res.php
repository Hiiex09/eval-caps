<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <img src="../admin/Images/view.svg" alt="School ID"
    class="w-8 h-8 px-2 rounded-md py-1 bg-green-900 top-1 left-8">
  <img src="../admin/Images/update.svg" alt="School ID"
    class="w-8 h-8 px-2 rounded-md py-1 bg-blue-900 top-1 left-8">
  <img src="../admin/Images/delete.svg" alt="School ID"
    class="w-8 h-8 px-2 rounded-md py-1 bg-red-900 top-1 left-8">
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Table</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <aside>
    <div class="
    fixed bottom-0 left-0 top-0 z-50 w-[200px] 
    sm:w-[200px] lg:w-[250px] flex 
    flex-col justify-between items-center border shadow">
      <div class="w-full">
        <div class="
        w-full p-2 mb-2 text-center text-2xl hover:text-white  
        hover:bg-[#161D6F] rounded-sm border cursor-pointer">
          <a href="../admin_dashboard.php" class="rounded-sm ">Dashboard</a>
        </div>
        <div class=" gap-4 flex flex-col justify-between items-center w-full">
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="../views/student_table.php" class="text-[18px]">Manage Student</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 2</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 3</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 4</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 5</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 6</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 7</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 8</a>
            </div>
          </div>
          <div class="
          hover:bg-[#161D6F] 
          hover:text-white p-1 cursor-pointer
          w-full rounded-sm">
            <div class="text-center">
              <a href="#" class="text-[18px]">Sample 9</a>
            </div>
          </div>
        </div>
      </div>
      <div class="mb-8">
        <div class="flex flex-col justify-center items-center gap-2">
          <div class="h-10 w-10 rounded-full border-2 border-black bg-blue-900"></div>
          <div class="text-xl font-semibold">Logout</div>
        </div>
      </div>
    </div>
  </aside>

  <main class="container mx-[260px] 
    fixed bottom-0 top-0 z-10 p-2 m-2 w-[1420px] 
    border">
    <div class="container-full p-4">
      <div class="mb-3 flex justify-center items-center 
        p-2 border w-[180px] cursor-pointer 
        rounded-md hover:bg-blue-900 hover:text-white
        shadow  modal-button">
        <div>
          <img
            src="../Images/img-user/add-student.svg"
            alt="add-student"
            class="w-8 h-8 svg-image">
        </div>
        <div class="text-sm mx-1 mt-2 font-semibold 
          text-center">
          ADD STUDENT
        </div>
      </div>
      <div
        class="fixed top-16
          z-50 
          p-5 w-3/5 h-4/6 
          bg-slate-900
          rounded-md
          mx-60
          hidden
          js-modal">
        <div class="absolute top-5 right-5 cursor-pointer js-close">
          <img
            src="../Images/close.svg"
            alt="close"
            class="w-8 h-8">
        </div>
        <div>
          <div class="m-1">
            <h1 class="text-white text-2xl font-semibold">Add Student</h1>
          </div>
          <div class="flex justify-evenly items-center">
            <form>
              <div class="grid grid-cols-3 gap-6">
                <div class="mt-4">
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <h1 class="text-white text-2xl">Image Preview</h1>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/image.svg" alt="School ID"
                          class="w-8 h-8">
                      </span>
                    </div>

                  </div>
                  <div>
                    <img id="image-preview"
                      src="../Profiles User/Student.png"
                      alt="Image Preview"
                      class="w-64 h-64 object-cover 
                      mt-4 rounded-md">
                  </div>
                  <div class="mt-7">
                    <label for="upload-image"
                      class="px-20 py-3  bg-white 
                        rounded cursor-pointer shadow relative">
                      Upload Image
                      <img src="../Images/img-btn.svg" alt="School ID"
                        class="w-8 h-8 absolute top-2 left-4">
                    </label>

                    <input
                      type="file"
                      id="upload-image"
                      class="hidden w-full"
                      accept="image/*"
                      onchange="previewImage(event)"
                      required>
                  </div>
                </div>
                <div class="mt-10">
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">School ID</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/id.svg" alt="School ID"
                          class="w-8 h-8">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="text"
                      placeholder="School ID"
                      class="px-2 py-3 w-full border-s-8 
                      border-blue-900 rounded-md text-sm"
                      required>
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">First Name</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/user.svg" alt="School ID"
                          class="w-7 h-7">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="text"
                      placeholder="First Name"
                      class="px-2 py-3 w-full border-s-8 border-blue-900 rounded-md text-sm"
                      required>
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Last Name</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/user.svg" alt="School ID"
                          class="w-7 h-7">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="text"
                      placeholder="Last Name"
                      class="px-2 py-3 w-full border-s-8 border-blue-900 rounded-md text-sm"
                      required>
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Email</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/email.svg" alt="School ID"
                          class="w-7 h-7">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="email"
                      placeholder="Email"
                      class="px-2 py-3 w-full border-s-8 border-blue-900 rounded-md text-sm"
                      required>
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Password</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/password.svg" alt="School ID"
                          class="w-7 h-7">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="password"
                      placeholder="Password"
                      class="px-2 py-3 w-full border-s-8 border-blue-900 rounded-md text-sm"
                      required>
                  </div>
                </div>
                <div class="mt-9">
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Year</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/number.svg" alt="School ID"
                          class="w-9 h-9">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="text"
                      placeholder="Year"
                      class="px-2 py-2 border-s-8 border-blue-900 w-full rounded-md text-lg">
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Section</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/section.svg" alt="School ID"
                          class="w-9 h-9">
                      </span>
                    </div>
                  </div>
                  <div>
                    <input
                      type="text"
                      placeholder="Section"
                      class="px-2 py-2 border-s-8 border-blue-900 w-full  rounded-md text-lg">
                  </div>
                  <div class="m-1 flex justify-between items-center">
                    <div>
                      <label class="text-white text-lg">Department</label>
                    </div>
                    <div>
                      <span>
                        <img src="../Images/department.svg" alt="School ID"
                          class="w-7 h-7">
                      </span>
                    </div>
                  </div>
                  <div>
                    <select name="" class="w-full px-1 py-2 border-s-8 border-blue-900 rounded-md text-sm text">
                      <option value="Sample 1">Sample 1</option>
                      <option value="Sample 2">Sample 2</option>
                      <option value="Sample 3">Sample 3</option>
                      <option value="Sample 5">Sample 4</option>
                      <option value="Sample 6">Sample 7</option>
                    </select>
                  </div>
                  <div class="mt-16">
                    <button type="submit"
                      class="px-8 py-2 w-full text-lg text-white
                         bg-blue-600 rounded-md mb-1 relative hover:border-s-4 border-white">
                      Submit
                      <img src="../Images/send.svg" alt="School ID"
                        class="w-7 h-7 absolute top-2 left-16">
                    </button>
                    <div type="submit"
                      class="px-8 py-2 w-full text-lg text-center cursor-pointer text-white
                         bg-red-800 rounded-md relative hover:bg-red-500 hover:border-s-4 js-close">
                      Cancel
                      <img src="../Images/cancel.svg" alt="School ID"
                        class="w-7 h-7 absolute top-2 left-16">
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
      <div class="p-1 mb-4">
        <h1 class="text-3xl">Student Table</h1>
        <hr class="border-2 border-black w-48 rounded-md">
      </div>
      <table class="table-auto w-full border shadow">
        <thead class="border bg-blue-900">
          <tr>
            <th class="px-4 py-2 text-start">School_ID</th>
            <th class="px-4 py-2 text-start">Student_ID</th>
            <th class="px-4 py-2 text-start">Profile</th>
            <th class="px-4 py-2 text-start">First Name</th>
            <th class="px-4 py-2 text-start">Last Name</th>
            <th class="px-4 py-2 text-start">Subject</th>
            <th class="px-4 py-2 text-start">Section & Year</th>
            <th class="px-4 py-2 text-start">Is_Regular</th>
            <th class="px-4 py-2 text-start">Is_Counting</th>
            <th class="px-4 py-2 text-start">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">
              <div>
                <img src="../Profiles User/Student.png" alt="student-image"
                  class="h-12 w-12 rounded-sm">
              </div>
            </td>
            <td class="px-4 py-2 text-center border">Juan</td>
            <td class="px-4 py-2 text-center border">Dela Cruz</td>
            <td class="px-4 py-2 text-center border">Data Structures & Algorithm</td>
            <td class="px-4 py-2 text-center border">Section 1 - 1st Year</td>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">6</td>
            <td class="px-4 py-2 text-center border h-[40px] w-[200px]">
              <div class="text-center">
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-blue-900 text-white rounded-sm">
                    <img src="../Images/view.svg" alt="School ID"
                      class="w-6 h-6 absolute top-1 left-8">
                  </button>
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-green-900 text-white rounded-sm">Update</button>
                  <img src="../Images/update.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-red-900  text-white rounded-sm">Delete</button>
                  <img src="../Images/delete.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="px-4 py-2 text-center border">2</td>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">
              <div>
                <img src="../Profiles User/Student.png" alt="student-image"
                  class="h-12 w-12 rounded-sm">
              </div>
            </td>
            <td class="px-4 py-2 text-center border">Juan</td>
            <td class="px-4 py-2 text-center border">Dela Cruz</td>
            <td class="px-4 py-2 text-center border">Data Structures & Algorithm</td>
            <td class="px-4 py-2 text-center border">Section 1 - 1st Year</td>
            <td class="px-4 py-2 text-center border">0</td>
            <td class="px-4 py-2 text-center border">7</td>
            <td class="px-4 py-2 text-center border">
              <div class="text-center">
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-blue-900 text-white rounded-sm">View</button>
                  <img src="../Images/view.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-green-900 text-white rounded-sm">Update</button>
                  <img src="../Images/update.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-red-900  text-white rounded-sm">Delete</button>
                  <img src="../Images/delete.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="px-4 py-2 text-center border">3</td>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">
              <div>
                <img src="../Profiles User/Student.png" alt="student-image"
                  class="h-12 w-12 rounded-sm">
              </div>
            </td>
            <td class="px-4 py-2 text-center border">Juan</td>
            <td class="px-4 py-2 text-center border">Dela Cruz</td>
            <td class="px-4 py-2 text-center border">Data Structures & Algorithm</td>
            <td class="px-4 py-2 text-center border">Section 1 - 1st Year</td>
            <td class="px-4 py-2 text-center border">1</td>
            <td class="px-4 py-2 text-center border">8</td>
            <td class="px-4 py-2 text-center border">
              <div class="text-center">
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-blue-900 text-white rounded-sm">View</button>
                  <img src="../Images/view.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-green-900 text-white rounded-sm">Update</button>
                  <img src="../Images/update.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
                <div class="w-full mt-1 relative">
                  <button class="w-full px-2 py-1 hover:rounded-lg bg-red-900  text-white rounded-sm">Delete</button>
                  <img src="../Images/delete.svg" alt="School ID"
                    class="w-6 h-6 absolute top-1 left-8">
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>



  <script>
    const modalBtn = document.querySelector('.modal-button');
    const btnClose = document.querySelectorAll('.js-close');
    const modal = document.querySelector('.js-modal');


    modalBtn.addEventListener('click', () => {
      modal.classList.remove('hidden'); // Diri ig click nato makita ang modal
    });

    btnClose.forEach((button) => {
      button.addEventListener('click', () => {
        modal.classList.add('hidden'); // Nya diri mawala ang modal
      });
    });



    function previewImage(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('image-preview');

      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          preview.src = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = ""; // Clear the preview if no file is selected
      }
    }
  </script>
</body>

</html>