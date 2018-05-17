
import {appContainer} from "../app/app.container";
import {AuthProvider} from "../providers/auth/auth";
import {Nav} from "ionic-angular";
import {LoginPage} from "../pages/login/login";

export const Auth = () => {
    return (target: any) => {
        // aqui é verificado se a pessoa pode acessar a página ou não
        target.prototype.ionViewCanEnter = function() {
            let property = Object.keys(this).find(value => this[value] instanceof Nav);
            if(typeof property === "undefined"){
                setTimeout(() => {
                    throw new TypeError('Auth decorator needs NavController instance');
                });
                return false;
            }

            let authService = appContainer().get(AuthProvider);
            return authService.check().then(isLogged => {
                if(!isLogged){
                    setTimeout(() => {
                        let navCtrl = this[property];
                        navCtrl.setRoot(LoginPage);
                    });
                   return false;
                }
                return true;
            });
        }
    }
};