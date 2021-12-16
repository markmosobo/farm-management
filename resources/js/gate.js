export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.role === 'admin';
    }

    isUser(){
        return this.user.role === 'user';
    }

    isFarmer(){
        return this.user.role === 'farmer';
    }

    isAdminOrFarmer(){
        if(this.user.role === 'admin' || this.user.role === 'farmer'){
            return true;
        }
    }

    isFarmerOrUser(){
        if(this.user.role === 'farmer' || this.user.role === 'user'){
            return true;
        }
    }

}