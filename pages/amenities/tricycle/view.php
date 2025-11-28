<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
include_once($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php');

if (!isset($_GET['id'])) {
    die("Invalid request — Missing ID.");
}

$toda_id = intval($_GET['id']);

$sql = "SELECT * FROM toda WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $toda_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("TODA record not found.");
}

$toda = $result->fetch_assoc();

$pageTitle = 'Edit TODA';
ob_start();
?>

<div class="">
    <div class="rounded-lg shadow-sm">
        <div class="mb-5 border-b-2 border-gray-300 pb-4">
            <h3 class="text-2xl font-medium text-gray-900 leading-none">Edit TODA</h3>
            <p class="text-gray-600">Modify existing TODA information</p>
        </div>

        <form id="updateTricycleForm" class="space-y-4">
            <input type="hidden" name="toda_id" value="<?= $toda['id'] ?>">
            <div class="border-2 border-gray-200 px-8 py-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">TODA Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            TODA Name
                        </label>
                        <input 
                            type="text" 
                            name="toda_name" 
                            required 
                            value="<?= htmlspecialchars($toda['toda_name']) ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                                   focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>
                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Number of Tricycles
                        </label>
                        <input 
                            type="number" 
                            name="no_of_tricycles" 
                            min="0"
                            required
                            value="<?= htmlspecialchars($toda['no_of_tricycles']) ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                                   focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Representative
                        </label>
                        <input 
                            type="text" 
                            name="representative"
                            required
                            value="<?= htmlspecialchars($toda['representative']) ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                                   focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Contact Number
                        </label>
                        <input 
                            type="tel" 
                            name="contact_no" 
                            required 
                            pattern="09[0-9]{9}"
                            value="<?= htmlspecialchars($toda['contact_no']) ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                                   focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>
                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Contract 
                        </label>
                        <a href="<?= '../../../'.$toda['contract']?>" download="contract">
                          <i class="ri-file-download-line text-lg me-1"></i>
                          Download File
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-2 border-gray-200 px-8 py-6 rounded-lg shadow-sm">

                <h2 class="text-xl font-semibold text-gray-900 mb-6">Operation Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            Start Date
                        </label>
                        <input 
                            type="date" 
                            name="date_start" 
                            required 
                            value="<?= $toda['start_date'] ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                                   focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 items-center">
                        <label class="block text-sm font-medium text-gray-700">
                            End Date
                        </label>
                        <input 
                            type="date" 
                            name="date_end" 
                            value="<?= $toda['end_date'] ?>"
                            class="mt-1 block w-full rounded-lg border border-gray-300 shadow-sm 
                              focus:ring-teal-500 focus:border-teal-500 px-3 py-2">
                    </div>

                </div>
            </div>
            <div class="flex justify-end gap-4 pt-4">
                <a href="list.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
$pageScripts = '';
require_once BASE_PATH . '/pages/layout.php';
?>
