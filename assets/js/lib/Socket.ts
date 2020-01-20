const version = require('../../../package.json').apiVersion;


export class Socket {
  private backendUrl: string = `${window.location.host}/wp-json/jettison/${version}/socket/`;
  private connection: WebSocket;

  private connect(): void {

  }

  private create(): WebSocket {
    return new WebSocket(`ws://${this.backendUrl}`, ['soap']);
  }

  constructor() {
    this.connection = this.create();
    this.connect();
  }

  onopen(): void {
    this.connection.send('Ping');
  }

  onerror(e: ErrorEvent): void {
    console.error('WebSocket Error: ' + e);
  }

  onmessage(e: {}): void {
    console.log('WebSocket: Recevied ' + e);
  }
}