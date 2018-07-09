import {Injectable} from '@angular/core';
import {Storage} from "@ionic/storage";

/*
  Generated class for the AppConfigProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class AppConfigProvider {

    private off: boolean;
    private appOffKey = 'app_off';

    constructor(public storage: Storage) {
    }

    load() {
        return this.storage.get(this.appOffKey).then(off => this.off = off);
    }

    getOff(): boolean {
        return this.off;
    }

    setOff(off: boolean): Promise<any> {
        this.off = off;
        return this.storage.set(this.appOffKey, off);
    }
}
