(() => {
  const form = document.getElementById('auditForm');
  if (!form) return;

  const steps = Array.from(form.querySelectorAll('.audit-step'));
  const backBtn = document.getElementById('auditBack');
  const primaryBtn = document.getElementById('auditPrimary');
  const primaryLabel = document.getElementById('auditPrimaryLabel');
  const progressBar = document.getElementById('auditProgressBar');
  const stepLabel = document.getElementById('auditStepLabel');
  let current = 0;
  const lastIndex = steps.length - 1;

  const fieldForStep = (stepEl) => stepEl.querySelector('input, select, textarea');
  const fieldsForStep = (stepEl) => Array.from(stepEl.querySelectorAll('input, select, textarea'));

  const validateStep = (index) => {
    const fields = fieldsForStep(steps[index]);
    if (fields.length === 0) return true;

    for (const field of fields) {
      const optional = !field.hasAttribute('required');
      if (optional && !String(field.value || '').trim()) continue;

      if (typeof field.reportValidity === 'function') {
        if (!field.reportValidity()) return false;
      } else if (!field.checkValidity()) {
        return false;
      }
    }
    return true;
  };

  const render = () => {
    steps.forEach((step, i) => {
      step.classList.toggle('is-active', i === current);
    });

    const total = steps.length;
    const isLast = current === lastIndex;

    if (progressBar) progressBar.style.width = `${((current + 1) / total) * 100}%`;
    if (stepLabel) stepLabel.textContent = `Step ${current + 1} of ${total}`;
    if (backBtn) backBtn.hidden = current === 0;

    // One button only: Continue until last step, then Submit
    if (primaryBtn && primaryLabel) {
      primaryBtn.type = 'button';
      primaryLabel.textContent = isLast ? 'Submit' : 'Continue';
    }

    const field = fieldForStep(steps[current]);
    if (field) field.focus({ preventScroll: true });
  };

  primaryBtn?.addEventListener('click', (event) => {
    event.preventDefault();
    if (!validateStep(current)) return;

    if (current < lastIndex) {
      current += 1;
      render();
      return;
    }

    if (typeof form.requestSubmit === 'function') {
      form.requestSubmit();
    } else {
      form.submit();
    }
  });

  backBtn?.addEventListener('click', () => {
    if (current > 0) {
      current -= 1;
      render();
    }
  });

  form.addEventListener('keydown', (event) => {
    if (event.key !== 'Enter') return;
    const tag = (event.target && event.target.tagName) || '';
    if (tag === 'TEXTAREA' || tag === 'SELECT') return;

    event.preventDefault();
    primaryBtn?.click();
  });

  form.addEventListener('submit', (event) => {
    if (current !== lastIndex) {
      event.preventDefault();
      return;
    }

    for (let i = 0; i <= lastIndex; i += 1) {
      if (!validateStep(i)) {
        event.preventDefault();
        current = i;
        render();
        return;
      }
    }
  });

  render();
})();
