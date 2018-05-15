import {Component} from '@angular/core';
import {IonicPage, MenuController, NavController, NavParams, ToastController} from 'ionic-angular';
import 'rxjs/add/operator/toPromise';
import {AuthProvider} from "../../providers/auth/auth";
import {HomePage} from "../home/home";
import {Test} from "../../components/test/test";

/**
 * Generated class for the LoginPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
    selector: 'page-login',
    templateUrl: 'login.html',
})
export class LoginPage {

    user = {
        email: 'admin@user.com',
        password: 'secret'
    };

    constructor(public navCtrl: NavController,
                public menuCtrl: MenuController,
                public toastCtrl: ToastController,
                public navParams: NavParams,
                private auth: AuthProvider) {
        this.menuCtrl.enable(false);
    }

    ionViewDidLoad() {
        console.log('ionViewDidLoad LoginPage');
    }

    login() {
        this.auth.login(this.user).then(() => {
            this.afterLogin();
        }).catch(() => {
            let toast = this.toastCtrl.create({
                message: 'Email e/ou senha inválidos.',
                duration: 3000,
                position: 'top',
                cssClass: 'toast-login-error'
            });

            toast.present();
        });
    }

    irParaHome(){
        this.navCtrl.push(Test, {id: 10, name: 'anderson'});
    }

    afterLogin() {
        this.menuCtrl.enable(true);
        this.navCtrl.push(HomePage);
    }
}
