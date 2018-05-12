
import {appContainer} from "../app/app.container";
import {AuthProvider} from "../providers/auth/auth";

export const Auth = () => {
    return (target: any) => {
        // aqui é verificado se a pessoa pode acessar a página ou não
        target.prototype.ionViewCanEnter = () => {
            let authService = appContainer.get(AuthProvider);
            return authService.check().then(isLogged => {
                if(!isLogged){
                   return false;
                }
                return true;
            });
        }
    }
};