
'use client';
import NavBar from "@/app/components/navBar";
import React from "react"
import { useState } from "react";





export default function Registerform(){

    // Used to store the usernames and passwords 
    const [registerUserName, setRegisterUserName] = useState('');
    const [registerPassword, setRegisterPassword] = useState('');


    return (
            
        <div>
            <div>
                <NavBar></NavBar>
                <br/>
            </div>
                <h1>Register:</h1>
               
                <input type="text" id="userName" placeholder="User Name" value = {registerUserName} onChange= {(e) => setRegisterUserName(e.target.value)}></input>
                <input type="text" id="pwd" placeholder="Password" value = {registerPassword} onChange= {(e) => setRegisterPassword(e.target.value)}></input>
                <button type="button" >Submit</button><br/>
                <button type="button">Forgot Password</button><br/>
                <button type="button">Create Account</button><br/>
           
            </div>


        
    )
}

