<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  
  <div class=" container mx-auto flex justify-between items-center">
    <div>
      <form method="POST" enctype="multipart/form-data">
       <div class="
        flex justify-center 
        items-center border p-4 mt-20">
          <div class="mx-20 h-[250px] w-[250px] border text-center">
            <label>Image Preview</label>
            <img src="#" alt="">
          </div>
          <div>
          <div class="flex justify-between items-center gap-4">
              <div class="text-2xl">
                <label>School ID</label>
              </div>
              <div>
                <input type="text"
                class="border">
              </div>
            </div>
            <div class="flex justify-between items-center gap-4">
              <div>
                <label>First Name</label>
              </div>
              <div>
                <input type="text"
                class="border">
              </div>
            </div>
            <div class="flex justify-between items-center gap-4">
              <div>
                <label>Last Name</label>
              </div>
              <div>
                <input type="text"
                class="border">
              </div>
            </div>
            <div class="flex justify-between items-center gap-4">
              <div>
                <label>Email</label>
              </div>
              <div>
                <input type="email"
                class="border">
              </div>
            </div>
            <div class="flex justify-between items-center gap-4">
              <div>
                <label>Password</label>
              </div>
              <div>
                <input type="password"
                class="border">
              </div>
            </div>
          </div>
         
       </div>
      </form>
      
    </div>
  </div>
</body>
</html>