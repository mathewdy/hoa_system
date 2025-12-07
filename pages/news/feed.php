<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM news_feed ORDER BY date_created DESC";
$result = mysqli_query($conn, $sql);
$pageTitle = 'News Feed';
ob_start();

$role = $_SESSION['role'];
?>

  <div class="space-y-6">
    <?php 
    if($role == 2 || $role == 3 ){
    ?>
            <button onclick="openModal()" 
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Create Post
        </button>
            <?php

    }

    ?>
    <?php 
    while($row = mysqli_fetch_assoc($result)):

        ?>

        <div class="p-4 border-b flex items-center justify-end">
                 <!-- Edit/Delete buttons -->
                    <?php //if($user_id['user_id'] === $row['created_by']): ?>
                            <div class="flex space-x-2">
                                <a href="edit.php?id=<?= $row['id'] ?>" 
                                  class="text-teal-600 hover:text-teal-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="delete.php?id=<?= $row['id'] ?>" 
                                  onclick="return confirm('Are you sure you want to delete this post?');"
                                  class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </a>
                            </div>
                    <?php //endif; ?>
            </div>

  
      <div class="bg-white rounded-lg shadow overflow-hidden">
            
            <div class="p-4">
                <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($row['post_title']) ?></h3>
                <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($row['description'])) ?></p>

                <!-- Images -->
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <?php 
                        $images = !empty($row['post_images']) ? explode(",", $row['post_images']) : [];
                        foreach($images as $img):
                            if(!empty($img)):
                    ?>
                        <img src="../../uploads/images/<?= htmlspecialchars($img) ?>" 
                              alt="<?= htmlspecialchars($row['post_title']) ?>" 
                              class="rounded-lg w-full h-48 object-cover">
                    <?php 
                            endif;
                        endforeach;
                    ?>

                   
                </div>

                <?php if(!empty($row['project_file'])): ?>
                    <a href="../../uploads/files/<?= htmlspecialchars($row['project_file']) ?>" target="_blank" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                        <i class="fas fa-file-pdf mr-2"></i> View Project Details (PDF)
                    </a>
                <?php endif; ?>
            </div>
      </div>
      <?php endwhile; ?>
  </div>
</div>
  <!-- Modal Background -->
<div id="createPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-2xl rounded-xl shadow-lg p-6">

        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-xl font-semibold">Create News Feed Post</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>

        <!-- FORM -->
        <form action="../../Query/create-news-feed.php" method="POST" enctype="multipart/form-data" class="mt-4">

            <div class="mb-4">
                <label class="block font-medium mb-1">Post Title:</label>
                <input type="text" name="post_title" 
                    class="w-full border rounded-lg px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Description:</label>
                <textarea name="description" rows="4" 
                    class="w-full border rounded-lg px-3 py-2" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Post Images (Multiple):</label>

                <!-- MULTIPLE IMAGES -->
                <input type="file" name="post_images[]" id="post_images" 
                    class="w-full border rounded-lg px-3 py-2"
                    accept="image/*" multiple>

                <div id="image_preview_container" class="flex flex-wrap gap-3 mt-3"></div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Project File (PDF Only):</label>

                <!-- PDF ONLY -->
                <input type="file" name="project_details" id="project_details"
                    class="w-full border rounded-lg px-3 py-2"
                    accept="application/pdf">

                <div id="file_preview" 
                    class="mt-2 font-semibold text-gray-700 hidden"></div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Cancel
                </button>

                <button type="submit" name="create_post"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Submit Post
                </button>
            </div>

        </form>
    </div>
</div>


  
<script>
function openModal() {
    document.getElementById("createPostModal").classList.remove("hidden");
}

function closeModal() {
    document.getElementById("createPostModal").classList.add("hidden");
}

document.getElementById('post_images').addEventListener('change', function(event) {
    let container = document.getElementById('image_preview_container');
    container.innerHTML = ""; 

    Array.from(event.target.files).forEach(file => {
        let reader = new FileReader();
        reader.onload = function(e) {
            let img = document.createElement("img");
            img.src = e.target.result;
            img.classList = "w-24 h-24 object-cover rounded-lg border";
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});

document.getElementById('project_details').addEventListener('change', function(event) {
    let file = event.target.files[0];
    let preview = document.getElementById('file_preview');

    if (file && file.type === "application/pdf") {
        preview.textContent = "PDF Selected: " + file.name;
        preview.classList.remove("hidden");
    } else {
        preview.textContent = "Invalid file. PDF only!";
        preview.classList.remove("hidden");
    }
});
</script>
<?php
$content = ob_get_clean();

$pageScripts = '
';

require_once BASE_PATH . '/pages/layout.php';
?>