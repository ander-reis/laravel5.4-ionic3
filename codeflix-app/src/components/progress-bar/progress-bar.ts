import {Component, Input, OnInit} from '@angular/core';

/**
 * Generated class for the ProgressBarComponent component.
 *
 * See https://angular.io/docs/ts/latest/api/core/index/ComponentMetadata-class.html
 * for more info on Angular Components.
 */
@Component({
    selector: 'progress-bar',
    templateUrl: 'progress-bar.html'
})
export class ProgressBarComponent implements OnInit {

    @Input('color') color: string;
    @Input('progress') progress: string;

    constructor() {
        console.log('Hello ProgressBarComponent Component');
        //this.color = 'danger';
        //this.progress = '60%';
    }

    ngOnInit(): void {
        if(!this.color){
            this.color = 'primary';
        }
    }
}
