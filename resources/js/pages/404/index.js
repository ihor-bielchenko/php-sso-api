import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';

new Base().call(e => {
	new Header();
	new SliderIndex({
		background: new Background({ manually: true })
	});
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});