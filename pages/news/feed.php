<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM news_feed ORDER BY date_created DESC";
$result = mysqli_query($conn, $sql);
$pageTitle = 'Homeowners';
ob_start();
?>

<div class="space-y-6">
      <?php while($row = mysqli_fetch_assoc($result)): ?>
      <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
            </div>
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

<?php
$content = ob_get_clean();

$pageScripts = '
';

require_once BASE_PATH . '/pages/layout.php';
?>