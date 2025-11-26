
<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
require_once $root . 'app/includes/session.php';

$pageTitle = 'Payment History';
ob_start();
?>
<div class="mt-1">
  <h3 class="text-2xl font-medium text-gray-900 mb-4"><?= $pageTitle ?></h3>
  <div class="mb-4 border-b border-default">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
      <li class="me-2" role="presentation">
        <button id="homeowners-tab" data-tabs-target="#homeowners" type="button" role="tab" aria-controls="homeowners" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Homeowners
        </button>
      </li>
      <li class="me-2" role="presentation">
        <button id="tricycle-tab" data-tabs-target="#tricycle" type="button" role="tab" aria-controls="tricycle" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Tricycle
        </button>
      </li>
      <li class="me-2" role="presentation">
        <button id="stalls-tab" data-tabs-target="#stalls" type="button" role="tab" aria-controls="stalls" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Stalls
        </button>
      </li>
      <li role="presentation">
        <button id="court-tab" data-tabs-target="#court" type="button" role="tab" aria-controls="court" aria-selected="false"
          class="inline-block p-4 border-b-2 rounded-t-lg border-transparent hover:text-teal-600 hover:border-teal-600 aria-selected:border-teal-600 aria-selected:text-teal-600">
          Court
        </button>
      </li>
    </ul>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="homeowners" role="tabpanel" aria-labelledby="homeowners-tab">
      <p>Homeowners</p>
    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="tricycle" role="tabpanel" aria-labelledby="tricycle-tab">
      <p>Tricycle</p>
    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="stalls" role="tabpanel" aria-labelledby="stalls-tab">
      <p>Stalls</p>
    </div>
  </div>
  <div id="default-tab-content">
    <div class="hidden rounded-lg" id="court" role="tabpanel" aria-labelledby="court-tab">
      <p>Court</p>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();

$pageScripts = '
  <script type="module" src="/hoa_system/ui/modules/users/get.homeowners.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>
