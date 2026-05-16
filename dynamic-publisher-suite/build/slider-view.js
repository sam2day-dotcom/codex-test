document.querySelectorAll('.dps-slider').forEach((slider) => {
	const track = slider.querySelector('.dps-slider__track');
	const slides = Array.from(slider.querySelectorAll('.dps-slide'));
	let index = 0;
	const speed = Number(slider.dataset.speed || 4000);
	const autoplay = slider.dataset.autoplay === 'true';

	const render = () => {
		slides.forEach((el, i) => el.classList.toggle('is-active', i === index));
	};
	slider.querySelector('.dps-slider__arrow--next')?.addEventListener('click', () => { index = (index + 1) % slides.length; render(); });
	slider.querySelector('.dps-slider__arrow--prev')?.addEventListener('click', () => { index = (index - 1 + slides.length) % slides.length; render(); });
	if (autoplay) setInterval(() => { index = (index + 1) % slides.length; render(); }, speed);
	render();
	track?.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowRight') { index = (index + 1) % slides.length; render(); }
		if (e.key === 'ArrowLeft') { index = (index - 1 + slides.length) % slides.length; render(); }
	});
});
