import {Injectable} from "@angular/core";
import {AuthProvider} from "./auth";
import {AuthOffline} from "./auth-offline";
import {AppConfigProvider} from "../app-config/app-config";
import {AuthGuard} from "./auth-guard";

@Injectable()
export class AuthFactory {


    constructor(public auth: AuthProvider,
                public authOffline: AuthOffline,
                public appConfig: AppConfigProvider) {
    }

    get(): AuthGuard {
        return this.appConfig.getOff() ? this.authOffline : this.auth;
    }
}
