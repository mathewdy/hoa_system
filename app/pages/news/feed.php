<?php
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/config.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/connection/connection.php');
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/session.php');
  $id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/page-icon.php'); ?>
  <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/styles.php'); ?>
</head>

<body>
  <div class="h-screen flex bg-gray-50">
    <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/sidebar.php'); ?>
    <div class="flex flex-col flex-1">
      <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/header.php'); ?>
      <main class="flex-1 p-6 overflow-y-auto">
            <div class="space-y-6">
              <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                  <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-3" />
                    <div>
                      <div class="font-semibold">Maria Santos</div>
                      <div class="text-xs text-gray-500">
                        Admin • April 10, 2023 at 2:30 PM
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <h3 class="text-lg font-semibold mb-2">House Repaint Project</h3>
                  <p class="text-gray-700 mb-4">
                    I'm planning to repaint the exterior of my house from white to light blue. The paint color (Sky Blue #4287f5) has been selected from the approved HOA color palette. The project will be completed by ABC Painting Services.
                  </p>
                  <div class="grid grid-cols-2 gap-2 mb-4">
                    <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="House Before" class="rounded-lg w-full h-48 object-cover" />
                    <img src="https://images.unsplash.com/photo-1560170412-0f438cfe5ed1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Paint Color" class="rounded-lg w-full h-48 object-cover" />
                  </div>
                  <div class="mt-4">
                    <a href="Project_Details.pdf" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                      <i class="fas fa-file-pdf mr-2"></i> View Project Details (PDF)
                    </a>
                  </div>
                </div>
              </div>
    
              <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                  <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-3" />
                    <div>
                      <div class="font-semibold">Maria Santos</div>
                      <div class="text-xs text-gray-500">
                        Admin • May 05, 2023 at 10:15 AM
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <h3 class="text-lg font-semibold mb-2">Fence Installation</h3>
                  <p class="text-gray-700 mb-4">
                    I'm planning to install a 6-foot wooden fence around the backyard. The fence will be made of cedar wood with a natural finish. The project will be completed by XYZ Fencing Company.
                  </p>
                  <div class="grid grid-cols-2 gap-2 mb-4">
                    <img src="https://images.unsplash.com/photo-1595514535415-dae8970c1333?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Fence Example" class="rounded-lg w-full h-48 object-cover" />
                    <img src="https://images.unsplash.com/photo-1628624747186-a941c476b7ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Backyard" class="rounded-lg w-full h-48 object-cover" />
                  </div>
                  <div class="mt-4">
                    <a href="Project_Details.pdf" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                      <i class="fas fa-file-pdf mr-2"></i> View Project Details (PDF)
                    </a>
                  </div>
                </div>
              </div>
    
              <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                  <div class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Profile" class="w-10 h-10 rounded-full mr-3" />
                    <div>
                      <div class="font-semibold">Kendall Jenner</div>
                      <div class="text-xs text-gray-500">
                          Secretary • June 15, 2023 at 3:45 PM
                      </div>
                    </div>
                  </div>
                </div>
                <div class="p-4">
                  <h3 class="text-lg font-semibold mb-2">Community Garden Enhancement</h3>
                  <p class="text-gray-700 mb-4">
                    The HOA board has approved the enhancement of our community garden area. We'll be adding new raised beds, installing a drip irrigation system, and creating designated composting areas. This project aims to promote sustainable living and community engagement among residents.
                  </p>
                  <div class="grid grid-cols-2 gap-2 mb-4">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Community Garden" class="rounded-lg w-full h-48 object-cover" />
                    <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Garden Design" class="rounded-lg w-full h-48 object-cover" />
                  </div>
                  <div class="mt-4">
                    <a href="Garden_Enhancement_Details.pdf" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                      <i class="fas fa-file-pdf mr-2"></i> View Project Details (PDF)
                    </a>
                  </div>
                </div>
              </div>
    
              <div class="text-center mt-6">
                <button class="bg-white border border-gray-300 text-gray-700 font-medium py-2 px-4 rounded hover:bg-gray-50">
                  Load More Projects
                </button>
              </div>
            </div>
          </main>
        </div>
      </div>
    
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Dropdown Toggle Functionality
          const dropdownToggle = document.getElementById("paymentDropdownToggle");
          const dropdown = document.getElementById("paymentDropdown");
          const chevron = dropdownToggle.querySelector(".fa-chevron-down");
    
          dropdownToggle.addEventListener("click", function () {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            dropdown.classList.toggle("hidden");
            chevron.classList.toggle("rotate-180");
            this.setAttribute('aria-expanded', !isExpanded);
          });
    
          // Expand dropdown if on View Payments or Payment History page
          const currentPath = window.location.pathname.split('/').pop();
          if (currentPath === 'homeowner-payment.html' || currentPath === 'homeowner-history.html') {
            dropdown.classList.remove("hidden");
            chevron.classList.add("rotate-180");
            dropdownToggle.setAttribute('aria-expanded', 'true');
          }
    
          // Sidebar Navigation Highlighting
          const sidebarLinks = document.querySelectorAll('nav a');
          sidebarLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPath) {
              link.classList.add('bg-teal-900');
            }
    
            link.addEventListener('mouseenter', function() {
              if (!link.classList.contains('bg-teal-900')) {
                link.classList.add('bg-teal-700');
              }
            });
    
            link.addEventListener('mouseleave', function() {
              if (!link.classList.contains('bg-teal-900')) {
                link.classList.remove('bg-teal-700');
              }
            });
    
            link.addEventListener('click', function(e) {
              if (href === currentPath) {
                e.preventDefault();
              }
              sidebarLinks.forEach(l => l.classList.remove('bg-teal-900'));
              link.classList.add('bg-teal-900');
            });
          });
        });
      </script>
        <?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/includes/scripts.php'); ?>
  <?php echo '<script src="'. BASE_PATH .'/assets/js/users/board-members/fetch.js"></script>'; ?>
</body>
</html>
