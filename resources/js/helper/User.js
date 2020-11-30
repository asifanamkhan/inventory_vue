import Token from './Token';
import appStorage from './appStorage';
class User {
    responseAfterLogin(response){
       const access_token = response.data.access_token;
       const user_name = response.data.name;

       if(Token.isValid(access_token)){
            appStorage.store(access_token,user_name)
       }
       else {
           return false;
       }
    }

    hasToken(){
        const storeToken = localStorage.getItem('token');
        if(storeToken){
            return Token.isValid(storeToken) ? true : false;
        }
        return false;
    }

    loggedIn(){
        return this.hasToken();
    }

    logout(){
        appStorage.clear();
    }

    name(){
        if(this.loggedIn){
            localStorage.getItem('user');
        }
    }

    id(){
        if(this.loggedIn){
           const payload = Token.payload(localStorage.getItem('token'));
            return payload.sub;
        }
        return false;
    }
}

export default User = new User();