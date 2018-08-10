import {Pipe} from "@angular/core";
import {DomSanitizer} from "@angular/platform-browser";

@Pipe({name: 'safeUrl'})
export class SafeUrl{

    constructor(private sanitizer: DomSanitizer){

    }

    transform(url){
        return this.sanitizer.bypassSecurityTrustResourceUrl(url);
    }
}