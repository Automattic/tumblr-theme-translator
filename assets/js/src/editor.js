import { createHooks } from '@wordpress/hooks';
import domReady from '@wordpress/dom-ready';

window.tumblr3_scaffold = window.tumblr3_scaffold || {};
window.tumblr3_scaffold.hooks = createHooks();

domReady( () => {
	window.tumblr3_scaffold.hooks.doAction( 'editor.ready' );
} );
