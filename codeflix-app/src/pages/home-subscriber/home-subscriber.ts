import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import {AuthHttp} from "angular2-jwt";

/**
 * Generated class for the HomeSubscriberPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
  selector: 'page-home-subscriber',
  templateUrl: 'home-subscriber.html',
})
export class HomeSubscriberPage {

  constructor(public navCtrl: NavController, public navParams: NavParams, public http:AuthHttp) {
  }

  ionViewDidLoad() {
    this.http.get('http://localhost:8000/api/test')
        .toPromise()
        .then(() => {
            console.log('teste');
        });
  }

}
