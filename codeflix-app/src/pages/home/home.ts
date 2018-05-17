import { Component } from '@angular/core';
import { IonicPage, NavController } from 'ionic-angular';
import {Auth} from "../../decorators/auth.decorator";
import {Test} from "../../components/test/test";

/**
 * Generated class for the HomePage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

@Auth()
@IonicPage()
@Component({
  selector: 'page-home',
  templateUrl: 'home.html',
})
export class HomePage {

    constructor(public navCtrl: NavController) {

    }

    goToTest(){
        this.navCtrl.push(Test, {
            'id': 10,
            'name': 'Anderson'
        })
    }
}
