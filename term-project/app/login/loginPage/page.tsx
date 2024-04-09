
import styles from "C:/Users/alial/OneDrive/Desktop/CIS-476-Term-Project/term-project/app/styles/Login.module.css"
//import Loginform from "./loginForm";
import ModifyStudent from "./modifyStudent";

// <Loginform/>
const call = ()=>{

    alert("I was clicked");
}
export default function Login() {
    return (
        <div className={styles.login}>
            
            <ModifyStudent/>
           
        </div>
    );
}
