import {Component} from '@angular/core';
import {IonicPage, NavController} from 'ionic-angular';
import {Auth} from "../../decorators/auth.decorator";
import {Test} from "../../components/test/test";
import {AuthHttp} from "angular2-jwt";
import 'rxjs/add/operator/toPromise';

// import {Http} from "@angular/http";


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

    constructor(public navCtrl: NavController, public authHttp: AuthHttp) {
        // para teste token erro redirecionamento login
        // constructor(public navCtrl: NavController, public authHttp: Http) {
    }

    ionViewDidLoad() {
        /*
        this.authHttp.get('http://localhost:8000/api/user')
            .toPromise()
            .then(() => {
                console.log('primeira');
            });


        //teste troca de token automatico
        setInterval(() => {
            this.authHttp.get('http://localhost:8000/api/user')
                .toPromise()
                .then(() => {
                    console.log('primeira');
                });
            this.authHttp.get('http://localhost:8000/api/user')
                .toPromise()
                .then(() => {
                    console.log('segunda');
                });
            this.authHttp.get('http://localhost:8000/api/user')
                .toPromise()
                .then(() => {
                    console.log('terceira');
                });
        }, 60*1000+1);
        */
    }

    goToTest() {
        this.navCtrl.push(Test, {
            'id': 10,
            'name': 'Anderson'
        })
    }
}
