/*
'use client'; // must be used 
import executeQuery from '@/app/api/connectApi/connect';
import NavBar from "@/app/components/navBar";
import Link from 'next/link';
import { useState , useEffect, useRef} from "react";
import {useFormStatus, useFormState} from 'react-dom'



async function getUser(){
 const postData ={

 }
}
export default function LoginForm() {
    const [userName, setUserName] = useState('');
    const [password, setPassword] = useState('');
    //const [errorMessage, setErrorMessage] = useState('');

    const initialState ={
        message:null,
    }
    const {pending} = useFormStatus();
    const {state,formLoginAction} = useFormState(Mysqlserveraction,initialState);

    const handleLogin = async () => {
        try {
            const result = await executeQuery("SELECT * FROM your_table WHERE username = ? AND password = ?", [userName, password]);
            if (Array.isArray(result) && result.length > 0) {
                // Navigate to the welcome page upon successful login
                return <Link href="/app/Welcome"></Link>;
            } else {
               
            }
        } catch (error) {
            console.error("Error fetching data:", error);
            
        }
    };

    // need to create a server action nextjs
    // asynchronous server functions that can be called directly from your components
    // so can directly insert data into database with server functions
    //formLoginAction is the server function created for this
    return (
        <div>

            <div>
                <NavBar />
                <br />
            </div>
            <h1>Login:</h1>
            
            <form method ="get" action = {formLoginAction} >
                <input type="text" id="userName" placeholder="User Name" value={userName} onChange={(e) => setUserName(e.target.value)} key="username"></input>
                <input type="password" id="pwd" placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} key="password"></input>
                <button type="submit" id="submit" onClick={handleLogin}>Submit</button><br />
                <button type="button">Forgot Password</button><br />
                <button type="button">Create Account</button><br />
            
            </form>
        </div>
    );
}


/*
*/


'use client'; // must be used 
import executeQuery from '@/app/api/connectApi/connect';
import NavBar from "@/app/components/navBar";
import Link from 'next/link';
import { useState , useEffect, useRef} from "react";
import {useFormStatus, useFormState} from 'react-dom'


export default function Loginform(){
    
    
    // Used to store the usernames and passwords 
    const [userName, setUserName] = useState('');
    const [password, setPassword] = useState('');

    const query = async()=>{

       const result = await executeQuery("SELECT * FROM users WHERE username =? AND password =?",[userName,password])

       if(!result ){
        console.log("The user doesn't exist")
       }

    } 
    return (
    
        <div>
            <div>
                <NavBar></NavBar>
                <br/>
            </div>
                <h1>Login:</h1>
               
                <input type="text" id="userName" placeholder="User Name" value = {userName} onChange= {(e) => setUserName(e.target.value)}></input>
                <input type="text" id="pwd" placeholder="Password" value = {password} onChange= {(e) => setPassword(e.target.value)}></input>
                <button type="button" onClick={query} >Submit</button><br/>
                <button type="button">Forgot Password</button><br/>
                <button type="button">Create Account</button><br/>
           
            </div>


        
    )
}
