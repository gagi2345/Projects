document.addEventListener("click", (e) => {
  const btn = e.target.closest(".stepBtn");
  if (!btn) return;

  const wrapper = btn.closest(".stepper");
  const input = wrapper.querySelector('input[type="number"]');

  const dir = Number(btn.dataset.dir);
  if (dir > 0) input.stepUp();
  else input.stepDown();
});



document.addEventListener("click", (e) => {
  const btn = e.target.closest(".checkBtn");
  if (!btn) return;

  const isDone = btn.classList.toggle("done"); 
  btn.setAttribute("aria-pressed", isDone);

  btn.textContent = isDone ? " OBAVLJENA VJEŽBA" : "NIJE OBAVLJENA VJEŽBA";
});
