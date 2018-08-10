import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import {Observable} from "rxjs/Observable";
import {StreamingMedia, StreamingVideoOptions} from "@ionic-native/streaming-media";
import {VideoFactory} from "../../providers/video-resource/video.factory";
import {AppConfigProvider} from "../../providers/app-config/app-config";

/**
 * Generated class for the VideoPlayPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */
@IonicPage()
@Component({
  selector: 'page-video-play',
  templateUrl: 'video-play.html',
})
export class VideoPlayPage {

  videoId;
  video: Observable<any>;
  videoAdapter;

  constructor(
      public navCtrl: NavController,
      public navParams: NavParams,
      public videoFactory: VideoFactory,
      public appConfig: AppConfigProvider,
      public streamingMedia: StreamingMedia
  ) {
      this.videoAdapter = this.videoFactory.get();
    this.videoId = this.navParams.get('video');
  }

  ionViewDidLoad() {
    this.video = this.videoAdapter.get(this.videoId);
  }

    play() {
        this.video.subscribe((video) => {
            let options: StreamingVideoOptions = {
                errorCallback: (e) => {
                    console.log(e)
                },
                orientation: 'landscape'
            }
            this.streamingMedia.playVideo(video.file_url, options);
        })
    }
}
