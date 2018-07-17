import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import {VideoDownload} from "../../providers/video-resource/video-download";
//import {Auth} from "../../decorators/auth.decorator";

/**
 * Generated class for the DownloadsPage page.
 *
 * See http://ionicframework.com/docs/components/#navigation for more info
 * on Ionic pages and navigation.
 */

//@Auth()
@IonicPage()
@IonicPage()
@Component({
  selector: 'page-downloads',
  templateUrl: 'downloads.html',
})
export class DownloadsPage {

  videos: Array<any>;

  constructor(public navCtrl: NavController,
              public navParams: NavParams,
              public videoDownload: VideoDownload) {
    this.videos = this.videoDownload.videos;
  }

  ionViewDidLoad() {
    //teste progress bar
    /*let count = 0;
    setInterval(() => {
        count++;
        this.progress = `${count}%`;
    }, 100);*/

    console.log('ionViewDidLoad DownloadsPage');
  }

  download(index){
    this.videoDownload.start(index);
  }

}
