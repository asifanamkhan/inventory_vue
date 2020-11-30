class appStorage {

    storeToken(token){
        localStorage.setItem('token',token);
    }

    storeUser(user){
        localStorage.setItem('user',user);
    }

    store(token,user){
        localStorage.setItem('token',token);
        localStorage.setItem('user',user);
    }
    clear(){
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }

    getToken(){
        localStorage.getItem('token');
    }

    getUser(){
        localStorage.getItem('user');
    }

}

export default appStorage = new appStorage();

