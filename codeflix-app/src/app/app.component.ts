import { Component, ViewChild } from '@angular/core';
// import { Component } from '@angular/core';
import { Nav, Platform } from 'ionic-angular';
// import { Platform } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { HomePage } from '../pages/home/home';
// import { ListPage } from '../pages/list/list';
import {LoginPage} from "../pages/login/login";
import {AuthProvider} from "../providers/auth/auth";
import {RedirectorProvider} from "../providers/redirector/redirector";
import {MySettingsPage} from "../pages/my-settings/my-settings";
import md5 from 'crypto-md5';
import {HomeSubscriberPage} from "../pages/home-subscriber/home-subscriber";

// import { Test } from '../components/test/test';

@Component({
  templateUrl: 'app.html'
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;

  rootPage: any = LoginPage;

  pageSubscriber: Array<{title: string, component: any}>;
  pages: Array<{title: string, component: any}>;
  user: any;
  gravatarUrl = 'https://www.gravatar.com/avatar/nouser.jpg';

  constructor(public platform: Platform,
              public statusBar: StatusBar,
              public splashScreen: SplashScreen,
              public auth: AuthProvider,
              public redirector: RedirectorProvider) {
    this.initializeApp();

    this.pageSubscriber = [
        {title: 'Assine Agora', component: HomeSubscriberPage}
    ];

    // used for an example of ngFor and navigation
    this.pages = [
      { title: 'Home', component: HomePage },
    ];

  }

  initializeApp() {
      //carrega usuario
      this.auth.userSubject().subscribe(user => {
          this.user = user;
          this.gravatar();
      });

      this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      this.statusBar.styleDefault();
      this.splashScreen.hide();
    });
  }

  //gravatar
    gravatar(){
      if(this.user){
          this.gravatarUrl = `https://www.gravatar.com/avatar/${md5(this.user.email, 'hex')}`;
      }
    }

  ngAfterViewInit(){
      //metodo redirecionamento login caso erro token
      this.redirector.config(this.nav);
  }

  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(page.component);
  }

  logout(){
      this.auth.logout().then(() => {
          this.nav.setRoot('LoginPage');
      }).catch(() => {
          this.nav.setRoot('LoginPage');
      });
  }

  goToMySettings(){
      this.nav.setRoot(MySettingsPage);
  }
}
