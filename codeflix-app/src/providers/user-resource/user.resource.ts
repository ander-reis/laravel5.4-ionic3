import { Injectable } from '@angular/core';
import {Http, RequestOptions, Headers} from '@angular/http';
import 'rxjs/add/operator/toPromise';
import 'rxjs/add/operator/map';
import {Env} from "../../models/env";
import {AuthHttp} from 'angular2-jwt';
import {Observable} from "rxjs/Observable";
import {JwtClientProvider} from "../jwt-client/jwt-client";

declare var ENV:Env;

/*
  Generated class for the UserResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class UserResourceProvider {

  constructor(public http: Http, public authHttp: AuthHttp, public jwtClient: JwtClientProvider) {
    console.log('Hello UserResourceProvider Provider');
  }

  register(accessToken:string):Promise<string>{
    let headers = new Headers();
    headers.set('Authorization', `Bearer ${accessToken}`);
    return this.http
        .post(`${ENV.API_URL}/register`, {}, new RequestOptions({headers}))
        .toPromise()
        .then(response => response.json().token);
  }

  create(user): Promise<string>{
    return this.http.post(`${ENV.API_URL}/register`, Object.assign(user, {type: 2}))
        .toPromise()
        .then(response => {
          let token = response.json().token;
          return this.jwtClient.setToken(token);
        });
  }

  updatePassword({password, password_confirmation}):Promise<Object>{
    return this.authHttp
        .patch(`${ENV.API_URL}/user/settings`, {password, password_confirmation})
        .toPromise()
        .then(response => response.json().user);
  }

  addCpf(cpf:string):Promise<Object>{
    return this.authHttp.patch(`${ENV.API_URL}/user/cpf`, {cpf})
        .toPromise()
        .then(response => response.json().user);
  }

  get():Observable<Object>{
      return this.authHttp.get(`${ENV.API_URL}/user`)
          .map(response => response.json().user);
  }
}
