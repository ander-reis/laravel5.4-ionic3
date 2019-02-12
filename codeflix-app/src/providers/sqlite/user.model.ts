import {Injectable} from '@angular/core';
import {DBModel} from "./db-model";

/*
  Generated class for the UserModel provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class UserModel extends DBModel {

    protected table = 'users';

    save({id, name, email}): Promise<any> {
        return this.findByField('email', email)
            .then(resultset => {
                if (!resultset.rows.length) {
                    return this.insert({
                        id, name, email
                    });
                }
                return Promise.resolve(resultset);
            }).then((resultset) => {
                return resultset.rows.item(0);
            }).catch(error => console.log(error));
    }
}
