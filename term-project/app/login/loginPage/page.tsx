
import styles from "C:/Users/alial/OneDrive/Desktop/CIS-476-Term-Project/term-project/app/styles/Login.module.css"



const call = ()=>{

    alert("I was clicked");
}
export default function Login() {
    return (
        <div className={styles.login}>
            <h4>Enter your Login information</h4>
            <br/>
            <form>
                <label htmlFor="userName"></label><br/>
                <input type="text" id="userName" placeholder="User Name" />
                <label htmlFor="pwd"></label><br/>
                <input type="password" id="pwd" placeholder="Password" />
                <button type="submit" onClick={call}>Submit</button><br/>
                <button type="button">Forgot Password</button><br/>
                <button type="button">Create Account</button><br/>
            </form>
        </div>
    );
}
