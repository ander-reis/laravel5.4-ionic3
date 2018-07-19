import {Injectable} from '@angular/core';
import {Storage} from "@ionic/storage";
import {File} from "@ionic-native/file";

/*
  Generated class for the AppConfigProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class AppConfigProvider {

    private off: boolean;
    private appOffKey = 'app_off';
    private baseFilePath = '/storage/sdcard1';
    private appFileFolder = 'codeflix';

    constructor(public storage: Storage,
                public file: File) {
    }

    async load() {
        let off = await this.storage.get(this.appOffKey);
        this.off = off;

        try{
            await this.file.resolveDirectoryUrl(`file://${this.baseFilePath}`)
        } catch (e){
            this.baseFilePath = this.file.externalApplicationStorageDirectory;
            console.log(e);
        }

//        console.log(this.baseFilePath);
//        console.log(this.off);
        return Promise.resolve(null);
    }

    getOff(): boolean {
        return this.off;
    }

    setOff(off: boolean): Promise<any> {
        this.off = off;
        return this.storage.set(this.appOffKey, off);
    }

    getAppFilePath(){
        return `${this.baseFilePath}/${this.appFileFolder}`;
    }
}
