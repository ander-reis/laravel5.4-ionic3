import { Component } from '@angular/core';
import {ActionSheetController, IonicPage, NavController, NavParams, ToastController} from 'ionic-angular';
//import {VideoResourceProvider} from "../../providers/video-resource/video.resource";
import {FormControl} from "@angular/forms";
import "rxjs/add/operator/debounceTime";
import {VideoFactory} from "../../providers/video-resource/video.factory";
import {VideoDownload} from "../../providers/video-resource/video-download";
import {VideoAdapter} from "../../providers/video-resource/video.adapter";
import {Auth} from "../../decorators/auth.decorator";
import {AppConfigProvider} from "../../providers/app-config/app-config";

/**
 * Generated class for the HomeSubscriberPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@Auth()
@IonicPage()
@Component({
  selector: 'page-home-subscriber',
  templateUrl: 'home-subscriber.html',
})
export class HomeSubscriberPage {

    videos = {
        data: []
    };
    page = 1;
    canMoreVideos = true;
    canShowSearchBar = false;
    search = '';
    formSearchControl = new FormControl();
    videoAdapter: VideoAdapter;

    constructor(public navCtrl: NavController,
                public navParams: NavParams,
                public actionSheetCtrl: ActionSheetController,
                public videoFactory: VideoFactory,
                public videoDownload: VideoDownload,
                public toastCtrl: ToastController,
                public appConfig: AppConfigProvider) {
        this.videoAdapter = this.videoFactory.get();
    }

    getVideos() {
        return this.videoAdapter.latest(this.page, this.search);
    }

    ionViewDidLoad() {
        this.searchVideos();
        this.getVideos()
            .subscribe((videos) => {
                this.videos = videos;
            });
    }

    searchVideos() {
        this.formSearchControl
            .valueChanges
            .debounceTime(1000)
            .subscribe(() => {

                if (this.search == '' && !this.search) {
                    return;
                }

                this.reset();

                this.getVideos()
                    .subscribe((videos) => {
                        this.videos = videos;
                    });
            });
    }

    doRefresh(refresher) {
        this.reset();

        this.getVideos()
            .subscribe((videos) => {
                this.videos = videos;
                refresher.complete();
            }, () => refresher.complete());
    }

    doInfinite(infiniteScroll) {
        this.page++;
        this.getVideos()
            .subscribe((videos) => {
                //videos.data e videos.meta
                this.videos.data = this.videos.data.concat(videos.data);
                if (videos.data.length == 0) {
                    this.canMoreVideos = false;
                }
                infiniteScroll.complete();
            }, () => infiniteScroll.complete());
    }

    reset() {
        this.page = 1;
        this.canMoreVideos = true;
    }

    presentActionsheet(videoId) {
        let actionSheet = this.actionSheetCtrl.create({
            title: 'Opções',
            buttons: [
                {
                    text: 'Enviar para download',
                    role: 'destructive',
                    handler: () => {
                        this.addVideo(videoId, actionSheet);
                        return false;
                    }
                },
                {
                    text: 'Cancelar',
                    role: 'cancel',
                    handler: () => {
                        console.log('cancelou');
                    }
                }
            ]
        });
        actionSheet.present();
    }

    addVideo(videoId, actionSheet){
        this.videoDownload
            .addVideo(videoId)
            .subscribe(
                () => actionSheet.dismiss(),
                () => {
                    actionSheet.dismiss();

                    let toast = this.toastCtrl.create({
                        message: 'Não foi possível idetificar o vídeo',
                        duration: 3000,
                        position: 'top',
                        cssClass: 'toast-login-error'
                    });

                    toast.present();
                }
            );
    }
}
