import { Injectable } from '@angular/core';
import 'rxjs/add/operator/map';
import {AuthHttp} from "angular2-jwt";
import {Observable} from "rxjs/Observable";
import {Env} from "../../models/env";

declare var ENV: Env;

/*
  Generated class for the PaymentResourceProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class PaymentResourceProvider {

  constructor(public authHttp: AuthHttp) {

  }

  get(planId: number): Observable<Object>{
      console.log(this.authHttp
          .post(`${ENV.API_URL}/plans/${planId}/payments`, {})
          .map(response => response.json()));

      return this.authHttp
          .post(`${ENV.API_URL}/plans/${planId}/payments`, {})
          .map(response => response.json());
  }

  doPayment(planId: number, paymentId: string, payerId: string): Observable<Object>{
      return this.authHttp
          .patch(`${ENV.API_URL}/plans/${planId}/payments`, {
              payment_id: paymentId,
              payer_id: payerId
          })
          .map(response => response.json());
  }
}
