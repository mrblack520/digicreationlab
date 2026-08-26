(() => {
  const modal = document.getElementById('leadModal');
  if (!modal) return;

  const open = () => {
    modal.hidden = false;
    document.body.classList.add('modal-open');
  };

  const close = () => {
    modal.hidden = true;
    document.body.classList.remove('modal-open');
  };

  modal.querySelectorAll('[data-close-modal]').forEach((el) => {
    el.addEventListener('click', close);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !modal.hidden) close();
  });

  window.setTimeout(open, 450);
})();
