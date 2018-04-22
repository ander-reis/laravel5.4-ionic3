import { Component } from '@angular/core';
import { NavController } from 'ionic-angular';
import { Test } from "../../components/test/test";

@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {

  constructor(public navCtrl: NavController) {

  }

  goToTest(){
    this.navCtrl.push(Test, {
      'id': 10,
        'name': 'Anderson'
    });
  }

}
