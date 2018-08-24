import { NgModule } from '@angular/core';
import {IonicPageModule } from 'ionic-angular';
import { UserRegisterPage } from './user-register';

@NgModule({
  declarations: [
    UserRegisterPage,
  ],
  imports: [
    IonicPageModule.forChild(UserRegisterPage),
  ],
  exports: [
    UserRegisterPage
  ]
})
export class UserRegisterPageModule {}
