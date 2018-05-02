import { Injectable } from '@angular/core';
import {Http, Response} from '@angular/http';
import 'rxjs/add/operator/map';
import {JwtCredentials} from "../../models/jwt-credentials";
import {Storage} from "@ionic/storage";

/*
  Generated class for the JwtClientProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class JwtClientProvider {

  private _token = null;

  constructor(public http: Http, public storage: Storage) {
    console.log('Hello JwtClientProvider Provider');
  }

  accessToken(jwtCredentials: JwtCredentials): Promise<string>{
      return this.http.post('http://localhost:8000/api/access_token', jwtCredentials)
          .toPromise()
          .then((response: Response) => {
              let token = response.json().token;
              this._token = token;
              this.storage.set('token', this._token);
              this.storage.get('token').then((token) => {
                console.log(token);
              });
              return token;
      });
  }
}
