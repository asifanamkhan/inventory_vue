class Token {
    isValid(token) {
        const payload = this.payload(token);
        if (payload) {
            if(payload.iss === ("http://127.0.0.1:8080/api/auth/login")){
                return true;
            }
            else if (payload.iss === ("http://127.0.0.1:8080/api/auth/signup")){
                return true;
            }
        }
        else{
            return false;
        }

    }
    payload(token){
        const payload = token.split('.')[1];//. theke . kete newa
        return this.decode(payload);
    }
    decode(payload){

        return JSON.parse(atob(payload)) //data encode chilo oita decode kore value ber kora

    }
}

export default Token = new Token();