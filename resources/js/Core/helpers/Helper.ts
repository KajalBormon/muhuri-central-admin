import axios from "axios";

export const getLanguages = async () => {
    try{
        return await axios.get(`/language-options`);
    }catch(err: any){
        return err;
    }
};

export const getFullName = (obj: any) => {
    const { first_name, last_name, name } = obj;
    return name? name : `${first_name} ${last_name}`;
};

export const getInitials = (obj: any) => {
    const { first_name, last_name, name } = obj;
    const firstNameInitial = first_name?.charAt(0)?.toUpperCase();
    const lastNameInitial = last_name?.charAt(0)?.toUpperCase();
    const nameInitial = name?.charAt(0)?.toUpperCase();
    return name? nameInitial : firstNameInitial + lastNameInitial;
}

export const getUppercase = (obj: any) => {
    const { code } = obj;
    return code.toUpperCase();
}
