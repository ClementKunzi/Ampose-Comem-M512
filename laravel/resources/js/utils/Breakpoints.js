import { reactive } from 'vue'; 

// Initially set isVisible based on the current window width

export const isDesktop = reactive({});

isDesktop.value = window.innerWidth > 1200;

// Function to update the internal state based on the current viewport width
function updateVisibilityStatus() {
    isDesktop.value = window.innerWidth > 1200;
//   ccheckout onsole.log(isDesktop.value);
}

// Function to initialize the resize event listener
export function initResizeListener() {
  // Update the state initially
  updateVisibilityStatus();

  // Listen to window resize events and update the state accordingly
//   window.addEventListener('resize', updateVisibilityStatus);
  window.onresize = updateVisibilityStatus;  
}

window.onresize = updateVisibilityStatus;

// Optional: Function to manually refresh the state
export function refreshVisibilityState() {
  updateVisibilityStatus();
}
