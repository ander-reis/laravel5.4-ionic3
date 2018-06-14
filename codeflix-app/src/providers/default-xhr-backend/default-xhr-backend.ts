import { Injectable } from '@angular/core';
import {BrowserXhr, Request, Response, ResponseOptions, XHRBackend, XHRConnection, XSRFStrategy} from '@angular/http';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';
import 'rxjs/add/observable/throw';
import {Observable} from "rxjs/Observable";
import {appContainer} from "../../app/app.container";
import {JwtClientProvider} from "../jwt-client/jwt-client";
import {RedirectorProvider} from "../redirector/redirector";

/*
  Generated class for the DefaultXhrBackendProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class DefaultXHRBackendProvider extends XHRBackend{

    constructor(browserXHR: BrowserXhr,
                baseResponseOptions: ResponseOptions,
                xsrfStrategy: XSRFStrategy) {
        super(browserXHR, baseResponseOptions, xsrfStrategy);
    }

   createConnection(request: Request): XHRConnection{
      let xhrConnection = super.createConnection(request);
      xhrConnection.response = xhrConnection.response.map((response) => {
        //salvar o token
          this.tokenSetter(response);
          return response;
      }).catch(responseError => {
        //verificar se o status 401 e redirecionar para o login
          this.onResponseError(responseError);
          return Observable.throw(responseError);
      });
      return xhrConnection;
   }

   tokenSetter(response: Response){
      let jwtClient = appContainer().get(JwtClientProvider);
      if(response.headers.has('Authorization')){
        let authrorization = response.headers.get('Authorization');
        let token = authrorization.replace('Bearer', '');
        jwtClient.setToken(token);
      }
   }

   onResponseError(responseError: Response){
       let redirector = appContainer().get(RedirectorProvider);
       switch (responseError.status){
           case 401:
               redirector.redirector();
               break;
           case 403:
               let data = responseError.json();
               let toHomePage = data.hasOwnProperty('error') && data.error == 'subscription_valid_not_found';
               redirector.redirector(toHomePage ? 'HomePage' : 'LoginPage');
               break;
       }

   }
}
