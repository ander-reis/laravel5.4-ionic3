import { Component } from '@angular/core';
import {IonicPage, LoadingController, NavController, NavParams} from 'ionic-angular';
import {PlanResourceProvider} from "../../providers/plan-resource/plan.resource";
import {Observable} from "rxjs/Observable";
import 'rxjs/add/operator/map';

/**
 * Generated class for the PlansPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
  selector: 'page-plans',
  templateUrl: 'plans.html',
})
export class PlansPage {

  plans: Observable<Array<Object>>;

  constructor(public navCtrl: NavController,
              public navParams: NavParams,
              public planResource: PlanResourceProvider,
              public loadingCtrl: LoadingController) {
  }

  ionViewDidLoad() {
    let loading = this.loadingCtrl.create({
        spinner: 'hide',
        content: 'Carregando...'
    });
    loading.present();
    this.plans = this.planResource.all()
        .map(plans => {
          loading.dismiss();
      return plans;
    });
  }
}
