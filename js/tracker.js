function renderTracker(element) {
  let url = element.dataset.url,
    template = `
      <span class="rounded text-white d-block py-2 font-sm">
        <a class="text-decoration-none link text-white font-sm" href="../">Home</a> / ${url}
      </span>
  `;
  element.innerHTML = template;
}

const trackerEl = document.querySelector('[data-role=tracker]');
renderTracker(trackerEl);
