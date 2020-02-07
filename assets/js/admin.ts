import { Socket } from "./lib/index";
import { sprintf, _n, __ } from '@wordpress/i18n';

document.addEventListener('DOMContentLoaded', () => {
  console.log('Jettison Admin Loaded');
  console.log(__('Dash'));
  console.log( sprintf( _n( '%d variable walks into a bar', '%d variables walk into a bar', 4, 'jettison' ), 4));
  new Socket();
});