import Base from '../../Base.js';

import Header from '../../components/Header';
import FormRegister from '../../components/FormRegister';
// import Background from '../../components/Background';
// import SliderIndex from '../../components/SliderIndex';
// import Footer from '../../components/Footer';
// import DialogCallback from '../../components/DialogCallback';

new Base().call(e => {
	new Header();
	new FormRegister();
	// new SliderIndex({
	// 	background: new Background({ manually: true })
	// });
	// new Footer({ 
	// 	dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	// });
});