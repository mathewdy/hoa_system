function showToast(type, message) {
  const icons = {
    success: 'ri-checkbox-circle-line text-green-500',
    error: 'ri-error-warning-line text-red-500',
    info: 'ri-information-line text-blue-500'
  };

  const bg = type === 'error' ? 'bg-red-100' : type === 'success' ? 'bg-green-100' : 'bg-blue-100';

  const $toast = $(`
    <div class="flex items-center w-full max-w-xs p-4 text-gray-700 ${bg} rounded-lg shadow transition transform">
      <i class="${icons[type]} text-xl mr-2"></i>
      <div class="text-sm font-medium flex-1">${message}</div>
      <button type="button" class="ml-3 text-gray-500 hover:text-gray-700" onclick="$(this).parent().fadeOut(200, function(){ $(this).remove(); })">
        <i class="ri-close-line"></i>
      </button>
    </div>
  `);

  $('#toast-container').append($toast);
  setTimeout(() => {
    $toast.fadeOut(300, function() { 
      $(this).remove()
    });
  }, 4000);
  
}