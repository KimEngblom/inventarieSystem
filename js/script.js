// --- State keys ---
const KEY_CURRENT = 'currentCounter';
const KEY_TOTAL   = 'totCounter';

// --- Getters/Setters ---
function getCurrent() {
  const v = parseInt(localStorage.getItem(KEY_CURRENT), 10);
  return Number.isFinite(v) ? v : 0;
}
function getTotal() {
  const v = parseInt(localStorage.getItem(KEY_TOTAL), 10);
  return Number.isFinite(v) ? v : 0;
}
function setCurrent(v) {
  localStorage.setItem(KEY_CURRENT, String(v));
}
function setTotal(v) {
  localStorage.setItem(KEY_TOTAL, String(v));
}

// --- DOM elements (may not exist on all pages) ---
const currentNumberEl   = document.getElementById('currentNumber');
const totalNumberEl     = document.getElementById('totalNumber');
const minusButton       = document.getElementById('minusButton');
const plusButton        = document.getElementById('plusButton');
const resetCounter      = document.getElementById('resetCounter');
const saveTotalCounter  = document.getElementById('saveTotalCounter');
const saveDateCounter   = document.getElementById('saveDateCounter');

// --- Render function ---
function render() {
  const current = getCurrent();
  const total   = getTotal();

  if (currentNumberEl) currentNumberEl.textContent = `Current ${current}`;
  if (totalNumberEl)   totalNumberEl.textContent   = `Total ${total}`;
  if (saveTotalCounter) saveTotalCounter.value = total;
}

// --- Init date field if present ---
(function initDateField() {
  if (!saveDateCounter) return;
  const d = new Date();
  const yyyy = d.getFullYear();
  const mm = String(d.getMonth() + 1).padStart(2, '0');
  const dd = String(d.getDate()).padStart(2, '0');
  saveDateCounter.value = `${yyyy}-${mm}-${dd}`;
})();

// --- Button listeners (only if buttons exist) ---
if (plusButton) {
  plusButton.addEventListener('click', () => {
    setCurrent(getCurrent() + 1);
    setTotal(getTotal() + 1);
    render();
  });
}
if (minusButton) {
  minusButton.addEventListener('click', () => {
    setCurrent(getCurrent() - 1);
    render();
  });
}
if (resetCounter) {
  resetCounter.addEventListener('click', () => {
    setCurrent(0);
    setTotal(0);
    render();
  });
}

// --- Initial render ---
render();

// --- Listen for changes in other tabs/pages ---
window.addEventListener('storage', (e) => {
  if (e.key === KEY_CURRENT || e.key === KEY_TOTAL) {
    render();
  }
});