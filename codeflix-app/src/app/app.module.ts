import {BrowserModule} from '@angular/platform-browser';
import {ErrorHandler, NgModule} from '@angular/core';
import {IonicApp, IonicErrorHandler, IonicModule} from 'ionic-angular';

import {MyApp} from './app.component';
import {HomePage} from '../pages/home/home';
import {ListPage} from '../pages/list/list';

import {StatusBar} from '@ionic-native/status-bar';
import {SplashScreen} from '@ionic-native/splash-screen';
import {Test} from '../components/test/test';
import {LoginPage} from "../pages/login/login";
import {Http, HttpModule, XHRBackend} from "@angular/http";
import {JwtClientProvider} from '../providers/jwt-client/jwt-client';
import {IonicStorageModule, Storage} from "@ionic/storage";
import {AuthConfig, AuthHttp, JwtHelper} from "angular2-jwt";
import {AuthProvider} from '../providers/auth/auth';
import {Env} from "../models/env";
import {DefaultXHRBackendProvider} from "../providers/default-xhr-backend/default-xhr-backend";
import {RedirectorProvider} from '../providers/redirector/redirector';
import {Facebook} from "@ionic-native/facebook";
import { UserResourceProvider } from '../providers/user-resource/user.resource';
import {MySettingsPage} from "../pages/my-settings/my-settings";
import {AddCpfPage} from "../pages/add-cpf/add-cpf";
import {HomeSubscriberPage} from "../pages/home-subscriber/home-subscriber";
import {PlansPage} from "../pages/plans/plans";
import {PaymentPage} from "../pages/payment/payment";
import {TextMaskModule} from "angular2-text-mask";
import { PlanResourceProvider } from '../providers/plan-resource/plan.resource';
import { PaymentResourceProvider } from '../providers/payment-resource/payment.resource';
import { VideoResourceProvider } from '../providers/video-resource/video.resource';
import {VideoPlayPage} from "../pages/video-play/video-play";
import {StreamingMedia} from "@ionic-native/streaming-media";
import {MomentModule} from "angular2-moment";
import 'moment/locale/pt-br';

declare var ENV: Env;

@NgModule({
    declarations: [
        MyApp,
        HomePage,
        ListPage,
        Test,
        LoginPage,
        MySettingsPage,
        AddCpfPage,
        PlansPage,
        PaymentPage,
        HomeSubscriberPage,
        VideoPlayPage
    ],
    imports: [
        HttpModule,
        BrowserModule,
        TextMaskModule,
        MomentModule,
        IonicModule.forRoot(MyApp, {}, {
            links: [
                {component: LoginPage, name: 'LoginPage', segment: 'login'},
                {component: HomePage, name: 'HomePage', segment: 'home'},
                {component: Test, name: 'TestPage', segment: 'test/:id/:name'},
                {component: MySettingsPage, name: 'HomePage', segment: 'my-settings'},
                {component: AddCpfPage, name: 'AddCpfPage', segment: 'add-cpf'},
                {component: HomeSubscriberPage, name: 'HomeSubscriberPage', segment: 'subscriber/home'},
                {component: PlansPage, name: 'PlansPage', segment: 'plans'},
                {component: PaymentPage, name: 'PaymentPage', segment: 'plan/:plan/payment'},
                {component: VideoPlayPage, name: 'VideoPlayPage', segment: 'video/:video/play'},
            ]
        }),
        IonicStorageModule.forRoot({
            driverOrder: ['localstorage']
        })
    ],
    bootstrap: [IonicApp],
    entryComponents: [
        MyApp,
        HomePage,
        ListPage,
        Test,
        LoginPage,
        MySettingsPage,
        AddCpfPage,
        PlansPage,
        PaymentPage,
        HomeSubscriberPage,
        VideoPlayPage
    ],
    providers: [
        StatusBar,
        SplashScreen,
        JwtClientProvider,
        JwtHelper,
        AuthProvider,
        RedirectorProvider,
        Facebook,
        UserResourceProvider,
        PlanResourceProvider,
        PaymentResourceProvider,
        VideoResourceProvider,
        StreamingMedia,
        {provide: ErrorHandler, useClass: IonicErrorHandler},
        {
            provide: AuthHttp,
            deps: [Http, Storage],
            useFactory(http, storage) {
                let authConfig = new AuthConfig({
                    headerPrefix: 'Bearer',
                    noJwtError: true,
                    noClientCheck: true,
                    tokenGetter: (() => storage.get(ENV.TOKEN_NAME))
                });
                return new AuthHttp(authConfig, http);
            }
        },
        {provide: XHRBackend, useClass: DefaultXHRBackendProvider},
    ]
})
export class AppModule {
}
