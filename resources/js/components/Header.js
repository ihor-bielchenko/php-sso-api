import Base from '../Base.js';

export default class Header extends Base {
	onDOMReady(e) {
		this.parallax();
	}

	parallax() {
		var controller = new ScrollMagic.Controller({globalSceneOptions: {
		 	triggerHook: "onEnter", 
		 	duration: "300%"}
		});

		new ScrollMagic.Scene({triggerElement: '.header__container'})
			.setTween('.header__container > div', { y: '30%', ease: Linear.easeNone })
			.addTo(controller);
	}
}