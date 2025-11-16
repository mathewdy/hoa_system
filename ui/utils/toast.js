export function showToast({ 
  message = '', 
  type = 'success', 
  duration = 3000, 
  position = 'top-right' 
}) {
  const existingToast = document.querySelector('.toast-notification');
  if (existingToast) existingToast.remove();

  const toast = document.createElement('div');
  toast.className = `toast-notification fixed z-50 text-white px-4 py-3 rounded shadow-lg 
    transition-opacity duration-300 
    ${type === 'success' ? 'bg-green-600' : 
      type === 'error' ? 'bg-red-600' : 
      type === 'warning' ? 'bg-yellow-500' : 'bg-blue-600'}
    ${getPositionClass(position)}`;

  toast.innerHTML = `
    <div class="flex items-center gap-2">
      <i class="ri-${getIcon(type)} text-lg"></i>
      <span>${message}</span>
    </div>
  `;

  document.body.appendChild(toast);

  setTimeout(() => (toast.style.opacity = '1'), 50);

  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => toast.remove(), 300);
  }, duration);
}

function getPositionClass(position) {
  switch (position) {
    case 'top-left': return 'top-5 left-5';
    case 'top-right': return 'top-5 right-5';
    case 'bottom-left': return 'bottom-5 left-5';
    case 'bottom-right': return 'bottom-5 right-5';
    default: return 'top-5 right-5';
  }
}

function getIcon(type) {
  switch (type) {
    case 'success': return 'checkbox-circle-fill';
    case 'error': return 'error-warning-fill';
    case 'warning': return 'alert-fill';
    default: return 'information-fill';
  }
}
