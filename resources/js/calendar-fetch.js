document.addEventListener('DOMContentLoaded', () => {
  const ENDPOINT    = '/app/controller/calendarcontroller.php';
  const DEBOUNCE_MS = 300;
  const MAX_RETRIES = 1;

  let debounceTimer = null;
  let currentYear   = new Date().getFullYear();
  let currentMonth  = new Date().getMonth() + 1;

  const skeleton = document.querySelector('[data-skeleton]');
  const content  = document.querySelector('[data-content]');
  const title    = document.querySelector('[data-cal-title]');
  const todayEl  = document.querySelector('[data-cal-today]');
  const grid     = document.querySelector('.cal__grid');

  function showSkeleton() {

  }

  function showContent() {

  }

  function renderCalendar(data) {
    const { year, month, month_name, days_in_month, first_dow, today, today_month, today_year } = data;

    title.textContent   = month_name + ' ' + year;
    todayEl.textContent = 'Today · ' + today;

    // remove only day cells
    grid.querySelectorAll('.cal__day').forEach(el => el.remove());

    // offset blanks
    for (let i = 0; i < first_dow; i++) {
      const el = document.createElement('div');
      el.className = 'cal__day is-muted';
      grid.appendChild(el);
    }

    // day cells
    const isCurrent = month === today_month && year === today_year;
    for (let d = 1; d <= days_in_month; d++) {
      const el = document.createElement('div');
      el.className = 'cal__day' + (isCurrent && d === today ? ' is-today' : '');
      el.textContent = d;
      grid.appendChild(el);
    }

    showContent();
  }

  async function loadMonth(year, month, attempt) {
    attempt = attempt || 0;
    showSkeleton();

    try {
      const res  = await fetch(ENDPOINT + '?year=' + year + '&month=' + month, { credentials: 'same-origin' });
      if (res.status === 429) { showContent(); return; }
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const json = await res.json();
      if (!json.success) { showContent(); return; }
      renderCalendar(json.data);
    } catch (err) {
      if (attempt < MAX_RETRIES) {
        setTimeout(() => loadMonth(year, month, attempt + 1), 500);
        return;
      }
      showContent();
      console.error('[Calendar]', err);
    }
  }

  function navigate(delta) {
    currentMonth += delta;
    if (currentMonth > 12) { currentMonth = 1;  currentYear++; }
    if (currentMonth < 1)  { currentMonth = 12; currentYear--; }
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => loadMonth(currentYear, currentMonth), DEBOUNCE_MS);
  }

  window.CalendarWidget = { navigate };

  loadMonth(currentYear, currentMonth);
});