import {Injectable} from '@angular/core';
import {Subject} from "rxjs/Subject";
import {NavController} from "ionic-angular";

/*
  Generated class for the RedirectorProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class RedirectorProvider {

    subject = new Subject();

    config(navCtrl: NavController, link = 'LoginPage'){
        this.subject.subscribe(() => {
            setTimeout(() => {
                navCtrl.setRoot(link);
            });
        });
    }

    redirector(){
        this.subject.next();
    }
}
