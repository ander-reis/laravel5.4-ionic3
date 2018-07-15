import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {UserModel} from "../sqlite/user.model";
import {AuthGuard} from "./auth-guard";
import {Storage} from "@ionic/storage";
import {AppConfigProvider} from "../app-config/app-config";

/*
  Generated class for the AuthProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class AuthOffline implements AuthGuard{

    private _user = null;
    private _userSubject = new BehaviorSubject(null);
    private userKey = 'userId';

    constructor(public userModel: UserModel,
                public storage: Storage,
                public appConfig: AppConfigProvider) {
    }

    //verifica a mudança em user
    userSubject():BehaviorSubject<Object>{
        return this._userSubject;
    }

    //metodo para carregar dados do usuário
    user(): Promise<Object> {
        return this._user ? Promise.resolve(this._user) :
        this.storage.get(this.userKey)
            .then(id => {
                return this.userModel.find(id);
            })
            .then(user => {
                this._user = user;
                if(user){
                    this._user.subscription_valid = true;
                }
                this._userSubject.next(this._user);
                return user;
            });
    }

    //verifica se usuario está logado
    check(): Promise<boolean> {
        return this.user().then(user => {
            return user !== null;
        })
    }

    //metodo responsavel pelo login
    login({email, password}): Promise<Object> {
        return this.userModel.findByField('email', email)
            .then((resultset) => {
                if (!resultset.rows.length) {
                    return Promise.reject('User not found');
                }
                this._user = resultset.rows.item(0);
                this._user.subscription_valid = true;
                this._userSubject.next(this._user);
                return resultset;
            })
            .then(() => {
                return this.appConfig.setOff(true);
            })
            .then(() => {
                return this.storage.set(this.userKey, this._user.id);
            })
            .then(() => {
                return this._user;
            });
    }

    //metodo responsavel pelo logout
    logout(): Promise<any> {
        this._user = null;
        this._userSubject.next(null);
        return Promise.resolve(null);
    }
}
