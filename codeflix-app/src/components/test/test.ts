import { Component } from '@angular/core';
import {NavParams} from "ionic-angular";

/**
 * Generated class for the Test component.
 *
 * See https://angular.io/api/core/Component for more info on Angular
 * Components.
 */
@Component({
  selector: 'test',
  templateUrl: 'test.html'
})
export class Test {

  text: string;

  constructor(public navParams: NavParams) {
    console.log('Hello Test Component');
    this.text = `${this.navParams.get('id')} - ${this.navParams.get('name')}`;
  }

  mostrarAlert(){
    alert('HelloWorld');
  }
}
