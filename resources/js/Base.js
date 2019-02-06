export default class Base {
	constructor(baseDOM) {
		this.baseDOM = {
			html: $('html'),
			body: $('body'),
			window: $(window),
			document: $(document)
		};

		this.baseDOM.document.ready(e => {
			this.initDOMElements(e);
			this.onDOMReady(e);
		});
		this.baseDOM.window.on('load', e => this.onLoaded(e));
		this.baseDOM.window.on('resize', e => this.onResized(e));
	}

	initDOMElements(e) {
	}

	onDOMReady(e) {
	}

	onLoaded(e) {
	}

	onResized(e) {
	}

	call(callback = () => {}) {
		callback(this);
	}

	setModuleProps(props = {}) {
		return this.props = props;
	}
}
