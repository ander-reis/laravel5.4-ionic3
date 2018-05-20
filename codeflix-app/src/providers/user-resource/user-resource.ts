import { Injectable } from '@angular/core';
import {Http, RequestOptions, Headers} from '@angular/http';
import 'rxjs/add/operator/toPromise';
import {Env} from "../../models/env";

declare var ENV:Env;

/*
  Generated class for the UserResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class UserResourceProvider {

  constructor(public http: Http) {
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

}
