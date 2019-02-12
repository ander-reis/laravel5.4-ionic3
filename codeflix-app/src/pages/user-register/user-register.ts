import {Component} from '@angular/core';
import {IonicPage, MenuController, NavController, ToastController} from 'ionic-angular';
import {UserResourceProvider} from "../../providers/user-resource/user.resource";

/**
 * Generated class for the UserRegisterPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
    selector: 'page-user-register',
    templateUrl: 'user-register.html',
})
export class UserRegisterPage {

    user = {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    };

    constructor(
        public navCtrl: NavController,
        public menuCtrl: MenuController,
        public toastCtrl: ToastController,
        public userResource: UserResourceProvider
    ) {
        this.menuCtrl.enable(false);
    }

    register() {
        this.userResource.create(this.user)
            .then(() => {
                this.menuCtrl.enable(true);
                this.navCtrl.setRoot('HomePage');
            })
            .catch(() => {
                let toast = this.toastCtrl.create({
                    message: 'Dados Inválidos',
                    duration: 3000,
                    position: 'top',
                    cssClass: 'toast-reverse'
                });
                toast.present();
            })
    }

}
